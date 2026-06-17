<?php
namespace Database\Factories;
 
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
 
class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id'         => User::factory()->author(),
            'kategori_id'       => Category::factory(),
            'judul'             => fake()->sentence(3),
            'isbn'              => fake()->unique()->isbn13(),
            'deskripsi'         => fake()->paragraph(5),
            'cover'             => null,
            'file_buku'         => 'sample.pdf',
            'format'            => fake()->randomElement(['pdf', 'epub']),
            'genre'             => fake()->randomElement(['Drama', 'Romance', 'Horor', 'Edukasi', 'Sejarah']),
            'penerbit'          => fake()->company(),
            'tahun_terbit'      => fake()->year(),
            'jumlah_halaman'    => fake()->numberBetween(80, 500),
            'jenis_akses'       => fake()->randomElement(['gratis', 'premium']),
            'minimal_usia'      => fake()->randomElement([0, 0, 0, 17, 18]),
            'status_verifikasi' => 'verified',
            'views'             => fake()->numberBetween(0, 10000),
        ];
    }
 
    public function pending(): static
    {
        return $this->state(fn () => ['status_verifikasi' => 'pending']);
    }
 
    public function premium(): static
    {
        return $this->state(fn () => ['jenis_akses' => 'premium']);
    }
 
    public function adultOnly(): static
    {
        return $this->state(fn () => ['minimal_usia' => 18]);
    }
}