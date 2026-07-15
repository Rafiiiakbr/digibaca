<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
 
class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        // Deteksi dinamis: gunakan views 'author.profile' jika role-nya penulis dan filenya ada.
        // Jika tidak, gunakan view bawaan 'reader.profile'
        $viewName = ($user->role === 'author' && view()->exists('author.profile')) 
            ? 'author.profile' 
            : 'reader.profile';

        return view($viewName, compact('user'));
    }
 
    public function update(Request $request)
    {
        $user = Auth::user();
 
        $request->validate([
            'nama'           => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'unique:users,email,' . $user->id],
            'tanggal_lahir'  => ['required', 'date', 'before:today'],
            'bio'            => ['nullable', 'string', 'max:500'],
            'avatar'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'password'       => ['nullable', 'min:8', 'confirmed'],
        ]);
 
        $data = $request->only('nama', 'email', 'tanggal_lahir', 'bio');
 
        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete('avatars/' . $user->avatar);
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = basename($path);
        }
 
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
 
        $user->update($data);
 
        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}