<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Note;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReaderController extends Controller
{
    /**
     * Dashboard pembaca — buku terbaru, rekomendasi, bookmark & catatan terakhir.
     */
    public function dashboard()
    {
        $userId = Auth::id();

        // 1. Buku terbaru yang sudah diverifikasi admin
        $data['buku_terbaru'] = Book::where('status_verifikasi', 'verified')
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // 2. Rekomendasi acak buku terverifikasi
        $data['buku_rekomendasi'] = Book::where('status_verifikasi', 'verified')
            ->with('category')
            ->inRandomOrder()
            ->take(4)
            ->get();

        // 3. Bookmark terakhir milik user
        $data['last_bookmarks'] = Bookmark::where('user_id', $userId)
            ->with('book')
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        // 4. Catatan terakhir milik user
        $data['last_notes'] = Note::where('user_id', $userId)
            ->with('book')
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        return view('reader.dashboard', $data);
    }

    /**
     * Halaman pembaca buku (PDF/ePub viewer).
     * Middleware check.premium sudah melindungi akses ke buku premium.
     */
    public function read($id)
    {
        $book = Book::where('status_verifikasi', 'verified')->findOrFail($id);
        $user = Auth::user();

        // Cek batas usia minimal menggunakan accessor umur dari User model
        if ($book->minimal_usia > 0 && $user->umur < $book->minimal_usia) {
            return redirect()->route('reader.dashboard')
                ->with('error', "Buku ini hanya untuk pembaca usia {$book->minimal_usia} tahun ke atas.");
        }

        // Ambil posisi bookmark terakhir user untuk buku ini
        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        $lastPage = $bookmark ? $bookmark->halaman : 1;

        // Tentukan view berdasarkan format buku
        $view = $book->format === 'epub' ? 'reader.epub_reader' : 'reader.pdf_reader';

        return view($view, compact('book', 'lastPage'));
    }

    /**
     * Halaman info & penawaran upgrade ke Premium.
     */
    public function premiumPage()
    {
        $user = Auth::user();

        // Riwayat pembayaran user
        $payments = Payment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reader.premium', compact('user', 'payments'));
    }

    /**
     * Proses pembayaran / checkout premium menggunakan Midtrans Snap.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'paket' => 'required|in:1_bulan,3_bulan,12_bulan',
        ]);

        $harga = match ($request->paket) {
            '1_bulan'   => 29000,
            '3_bulan'   => 79000,
            '12_bulan'  => 249000,
        };

        $orderId = 'SUB-' . Auth::id() . '-' . time();

        // 1. Buat record transaksi awal (status: pending)
        $payment = Payment::create([
            'user_id'       => Auth::id(),
            'order_id'      => $orderId,
            'nominal'       => $harga,
            'status'        => 'pending',
            'tanggal_bayar' => null,
        ]);

        // 2. Request snap token ke API Midtrans
        $serverKey = config('midtrans.server_key');
        $isProduction = config('midtrans.is_production');
        $endpoint = $isProduction 
            ? 'https://app.midtrans.com/snap/v1/transactions' 
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->acceptJson()
                ->post($endpoint, [
                    'transaction_details' => [
                        'order_id'     => $orderId,
                        'gross_amount' => $harga,
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->nama,
                        'email'      => Auth::user()->email,
                    ],
                    'item_details' => [
                        [
                            'id'       => $request->paket,
                            'price'    => $harga,
                            'quantity' => 1,
                            'name'     => 'Langganan Premium Paket ' . str_replace('_', ' ', $request->paket),
                        ]
                    ]
                ]);

            if ($response->failed()) {
                Log::error('Midtrans API Request Failed', ['body' => $response->body()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal terhubung ke server pembayaran.'
                ], 500);
            }

            $snapToken = $response->json()['token'] ?? null;

            if (!$snapToken) {
                Log::error('Midtrans did not return a token', ['response' => $response->json()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat token transaksi.'
                ], 500);
            }

            // Simpan snap token ke record pembayaran
            $payment->update(['snap_token' => $snapToken]);

            return response()->json([
                'success'    => true,
                'snap_token' => $snapToken,
                'order_id'   => $orderId,
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Checkout Exception', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.'
            ], 500);
        }
    }

    /**
     * Webhook Notification dari Midtrans untuk merubah status pembayaran secara asinkron.
     */
    public function notification(Request $request)
    {
        Log::info('Midtrans Webhook Received', $request->all());

        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $requestSignature = $request->signature_key;

        // Validasi signature key untuk keamanan (pastikan request asli dari Midtrans)
        $serverKey = config('midtrans.server_key');
        $signature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signature !== $requestSignature) {
            Log::warning('Midtrans Webhook Invalid Signature', [
                'expected' => $signature,
                'received' => $requestSignature
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment record not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $paymentType = $request->payment_type;

        if ($transactionStatus == 'capture') {
            if ($request->fraud_status == 'challenge') {
                $payment->update(['status' => 'pending']);
            } else {
                $payment->update([
                    'status'        => 'success',
                    'payment_type'  => $paymentType,
                    'tanggal_bayar' => now()
                ]);
                
                // Aktifkan premium user
                $user = User::find($payment->user_id);
                if ($user) {
                    $user->update(['status_premium' => true]);
                }
            }
        } elseif ($transactionStatus == 'settlement') {
            $payment->update([
                'status'        => 'success',
                'payment_type'  => $paymentType,
                'tanggal_bayar' => now()
            ]);

            // Aktifkan premium user
            $user = User::find($payment->user_id);
            if ($user) {
                $user->update(['status_premium' => true]);
            }
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $payment->update(['status' => 'failed']);
        } elseif ($transactionStatus == 'pending') {
            $payment->update(['status' => 'pending']);
        }

        return response()->json(['message' => 'Notification processed successfully']);
    }
}