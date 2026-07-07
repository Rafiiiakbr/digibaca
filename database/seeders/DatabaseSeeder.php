<?php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
 
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
<<<<<<< HEAD
        // 1. Buat Akun Uji Coba untuk Masing-masing Role
        $admin = User::create([
            'nama' => 'Akun Admin',
            'email' => 'admin@readon.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'tanggal_lahir' => '1995-05-10',
            'status_premium' => false,
        ]);

        $author = User::create([
            'nama' => 'Akun Penulis',
            'email' => 'author@readon.com',
            'password' => Hash::make('password123'),
            'role' => 'author',
            'tanggal_lahir' => '1992-08-20',
            'status_premium' => false,
        ]);

        $reader = User::create([
            'nama' => 'Akun Pembaca Reguler',
            'email' => 'reader@readon.com',
            'password' => Hash::make('password123'),
            'role' => 'reader',
            'tanggal_lahir' => '2005-12-15', // Usia > 17 tahun pada tahun 2026
            'status_premium' => false,
        ]);

        $readerPremium = User::create([
            'nama' => 'Akun Pembaca Premium',
            'email' => 'premium@readon.com',
            'password' => Hash::make('password123'),
            'role' => 'reader',
            'tanggal_lahir' => '2012-01-01', // Usia < 17 tahun
            'status_premium' => true,
        ]);

        // 2. Buat Data Kategori
        $categories = ['Novel & Sastra', 'Sains & Teknologi', 'Sejarah & Budaya', 'Komik & Manga', 'Pengembangan Diri'];
        foreach ($categories as $cat) {
            Category::create(['nama_kategori' => $cat]);
        }

        // 3. Buat Data Penulis Tambahan
        User::create([
            'nama' => 'Tere Liye',
            'email' => 'tereliye@readon.com',
            'password' => Hash::make('password123'),
            'role' => 'author',
            'tanggal_lahir' => '1979-05-21',
            'status_premium' => false,
        ]);

        // 4. Jalankan Book Factory untuk membuat 15 buku tiruan
        Book::factory()->count(15)->create();

        // 5. Buat Data Simulasi Pembayaran Masuk
        Payment::create([
            'user_id' => $readerPremium->id,
            'order_id' => 'SEED-PAY-PREMIUM-' . time(),
            'nominal' => 50000.00,
            'status' => 'success',
            'tanggal_bayar' => Carbon::now(),
=======
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
>>>>>>> 4e8ee55267e1902bc1fc12f65137dcef8889b2d2
        ]);
    }
}