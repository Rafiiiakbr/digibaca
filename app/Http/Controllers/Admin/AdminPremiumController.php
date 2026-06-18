<?php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Payment;
 
class AdminPremiumController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user')->latest()->paginate(15);
        return view('admin.premium.index', compact('payments'));
    }
 
    public function confirm(Payment $payment)
    {
        $payment->confirm();
        return back()->with('success', 'Pembayaran dikonfirmasi & akun premium diaktifkan.');
    }
 
    public function reject(Payment $payment)
    {
        $payment->reject(request('catatan'));
        return back()->with('success', 'Pembayaran ditolak.');
    }
}