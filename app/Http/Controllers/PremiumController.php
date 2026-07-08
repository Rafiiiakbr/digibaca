<?php
namespace App\Http\Controllers;
 
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class PremiumController extends Controller
{
    public function upgrade()
    {
        $user = Auth::user();
        if ($user->isPremium()) {
            return redirect()->route('reader.dashboard')->with('info', 'Anda sudah premium!');
        }
 
        $pendingPayment = $user->payments()->where('status', 'pending')->first();
        return view('premium.upgrade', compact('user', 'pendingPayment'));
    }
 
    public function pay(Request $request)
    {
        $request->validate([
            'metode'          => ['required', 'string'],
            'bukti_transfer'  => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);
 
        $user = Auth::user();
 
        // Check usia
        if ($user->getAge() < 0) {
            return back()->with('error', 'Tanggal lahir belum diisi. Lengkapi profil terlebih dahulu.');
        }
 
        $buktiPath = $request->file('bukti_transfer')->store('payments', 'public');
 
        Payment::create([
            'user_id'         => $user->id,
            'nominal'         => 100000,
            'status'          => 'pending',
            'metode'          => $request->metode,
            'kode_pembayaran' => Payment::generateKodePembayaran(),
            'bukti_transfer'  => basename($buktiPath),
        ]);
 
        return redirect()->route('premium.upgrade')
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu konfirmasi admin.');
    }
}