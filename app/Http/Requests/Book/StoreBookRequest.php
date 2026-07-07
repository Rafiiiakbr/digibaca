<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:20', 'unique:books,isbn'],
            'kategori_id' => ['required', 'exists:categories,id'],
            'genre' => ['required', 'string', 'max:100'],
            'deskripsi' => ['required', 'string', 'min:50'],
            'penerbit' => ['nullable', 'string', 'max:150'],
            'tahun_terbit' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'bahasa' => ['required', 'string'],
            'jenis_akses' => ['required', 'in:gratis,premium'],
            'minimal_usia' => ['required', 'integer', 'min:0', 'max:21'],
            'cover' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'file_buku' => ['required', 'file', 'mimes:pdf,epub', 'max:51200'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul buku wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori tidak valid.',
            'deskripsi.min' => 'Deskripsi minimal 50 karakter.',
            'cover.image' => 'Cover harus berupa gambar.',
            'cover.max' => 'Ukuran cover maksimal 2MB.',
            'file_buku.mimes' => 'File buku harus berformat PDF atau ePub.',
            'file_buku.max' => 'Ukuran file buku maksimal 50MB.',
        ];
    }
}