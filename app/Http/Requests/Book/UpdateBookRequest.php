<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bookId = $this->route('book')->id ?? null;

        return [
            'judul' => ['required', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:20', 'unique:books,isbn,' . $bookId],
            'kategori_id' => ['required', 'exists:categories,id'],
            'genre' => ['required', 'string', 'max:100'],
            'deskripsi' => ['required', 'string', 'min:50'],
            'penerbit' => ['nullable', 'string', 'max:150'],
            'tahun_terbit' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'bahasa' => ['required', 'string'],
            'jenis_akses' => ['required', 'in:gratis,premium'],
            'minimal_usia' => ['required', 'integer', 'min:0', 'max:21'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'file_buku' => ['nullable', 'file', 'mimes:pdf,epub', 'max:51200'],
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