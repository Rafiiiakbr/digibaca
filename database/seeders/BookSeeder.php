<?php
namespace Database\Seeders;
 
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
 
class BookSeeder extends Seeder
{
    public function run(): void
    {
        $authors    = User::where('role', 'author')->get();
        $categories = Category::all();
 
        // Featured books with realistic Indonesian titles
        $featured = [
            ['judul' => 'Laskar Pelangi', 'genre' => 'Drama', 'kategori' => 'Fiksi', 'akses' => 'gratis', 'usia' => 0],
            ['judul' => 'Bumi Manusia', 'genre' => 'Sejarah Fiksi', 'kategori' => 'Fiksi', 'akses' => 'gratis', 'usia' => 0],
            ['judul' => 'Filosofi Teras', 'genre' => 'Self Help', 'kategori' => 'Pengembangan Diri', 'akses' => 'gratis', 'usia' => 0],
            ['judul' => 'Atomic Habits (Terjemahan)', 'genre' => 'Self Help', 'kategori' => 'Pengembangan Diri', 'akses' => 'premium', 'usia' => 0],
            ['judul' => 'Sapiens: Riwayat Singkat Umat Manusia', 'genre' => 'Sejarah', 'kategori' => 'Sejarah', 'akses' => 'premium', 'usia' => 0],
            ['judul' => 'Rich Dad Poor Dad', 'genre' => 'Finansial', 'kategori' => 'Bisnis & Ekonomi', 'akses' => 'premium', 'usia' => 0],
            ['judul' => 'Dilan: Dia Adalah Dilanku Tahun 1990', 'genre' => 'Romance', 'kategori' => 'Fiksi', 'akses' => 'gratis', 'usia' => 0],
            ['judul' => 'Pengantar Algoritma & Struktur Data', 'genre' => 'Edukasi', 'kategori' => 'Sains & Teknologi', 'akses' => 'gratis', 'usia' => 0],
            ['judul' => 'Bisikan dari Rumah Tua', 'genre' => 'Horor', 'kategori' => 'Horor & Thriller', 'akses' => 'premium', 'usia' => 18],
            ['judul' => 'Malam Tanpa Bulan', 'genre' => 'Thriller', 'kategori' => 'Horor & Thriller', 'akses' => 'premium', 'usia' => 18],
            ['judul' => 'Petualangan Si Kancil', 'genre' => 'Fabel', 'kategori' => 'Anak & Remaja', 'akses' => 'gratis', 'usia' => 0],
            ['judul' => 'Catatan Juang', 'genre' => 'Biografi', 'kategori' => 'Non-Fiksi', 'akses' => 'gratis', 'usia' => 0],
        ];
 
        foreach ($featured as $i => $data) {
            $category = $categories->firstWhere('nama_kategori', $data['kategori']);
            Book::create([
                'author_id'         => $authors->random()->id,
                'kategori_id'       => $category->id,
                'judul'             => $data['judul'],
                'isbn'              => '978-602-' . rand(100,999) . '-' . rand(100,999) . '-' . rand(1,9),
                'deskripsi'         => "Buku \"{$data['judul']}\" adalah karya menarik dalam genre {$data['genre']} yang mengangkat tema mendalam dan relevan bagi pembaca masa kini. Disusun dengan gaya bahasa yang mengalir, buku ini cocok dibaca oleh berbagai kalangan pembaca digital.",
                'cover'             => null,
                'file_buku'         => 'sample.pdf',
                'format'            => $i % 4 === 0 ? 'epub' : 'pdf',
                'genre'             => $data['genre'],
                'penerbit'          => 'Penerbit Nusantara',
                'tahun_terbit'      => rand(2015, 2024),
                'jumlah_halaman'    => rand(120, 400),
                'jenis_akses'       => $data['akses'],
                'minimal_usia'      => $data['usia'],
                'status_verifikasi' => 'verified',
                'views'             => rand(50, 5000),
            ]);
        }
 
        // Additional random pending books for admin verification testing
        foreach (range(1, 5) as $i) {
            Book::create([
                'author_id'         => $authors->random()->id,
                'kategori_id'       => $categories->random()->id,
                'judul'             => 'Buku Draft Menunggu Verifikasi ' . $i,
                'isbn'              => '978-602-' . rand(100,999) . '-' . rand(100,999) . '-' . rand(1,9),
                'deskripsi'         => 'Ini adalah buku contoh yang baru diupload dan masih menunggu proses verifikasi oleh admin sebelum tampil di katalog publik.',
                'file_buku'         => 'sample.pdf',
                'format'            => 'pdf',
                'genre'             => 'Umum',
                'jenis_akses'       => 'gratis',
                'minimal_usia'      => 0,
                'status_verifikasi' => 'pending',
            ]);
        }
    }
}