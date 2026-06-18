<?php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
 
class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();
        if ($request->filled('role')) $query->where('role', $request->role);
        if ($request->filled('q')) {
            $query->where(fn($q) => $q->where('nama', 'like', "%{$request->q}%")
                ->orWhere('email', 'like', "%{$request->q}%"));
        }
        $users = $query->paginate(15);
        return view('admin.users.index', compact('users'));
    }
 
    public function togglePremium(User $user)
    {
        $user->update(['status_premium' => !$user->status_premium]);
        $status = $user->status_premium ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Status premium user berhasil {$status}.");
    }
 
    public function destroy(User $user)
    {
        if ($user->isAdmin()) abort(403, 'Admin tidak dapat dihapus.');
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}