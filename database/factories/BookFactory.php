<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $format = $this->faker->randomElement(['pdf', 'epub']);
        
        return [
            'author_id' => User::where('role', 'author')->inRandomOrder()->first()->id ?? User::factory(),
            'kategori_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'judul' => $this->faker->sentence(3),
            'isbn' => $this->faker->isbn13(),
            'deskripsi' => $this->faker->paragraph(),
            'cover' => null, // Default kosong, bisa diisi via upload
            'file_buku' => $format === 'pdf' ? 'sample.pdf' : 'sample.epub',
            'format' => $format,
            'genre' => $this->faker->randomElement(['Fiksi', 'Sains', 'Sejarah', 'Teknologi', 'Novel']),
            'jenis_akses' => $this->faker->randomElement(['free', 'premium']),
            'minimal_usia' => $this->faker->randomElement([0, 13, 17]),
            'status_verifikasi' => $this->faker->randomElement(['pending', 'verified', 'rejected']),
        ];
    }
}