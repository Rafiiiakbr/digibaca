<?php
namespace Database\Seeders;
 
use App\Models\Category;
use Illuminate\Database\Seeder;
 
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Fiksi',           'icon' => 'bi-book-half',       'deskripsi' => 'Novel, cerita rekaan, dan karya imajinatif.'],
            ['nama_kategori' => 'Non-Fiksi',        'icon' => 'bi-journal-text',    'deskripsi' => 'Buku berdasarkan fakta dan kejadian nyata.'],
            ['nama_kategori' => 'Sains & Teknologi','icon' => 'bi-cpu',             'deskripsi' => 'Pengetahuan ilmiah, teknologi, dan inovasi.'],
            ['nama_kategori' => 'Bisnis & Ekonomi', 'icon' => 'bi-graph-up-arrow',  'deskripsi' => 'Manajemen, kewirausahaan, dan keuangan.'],
            ['nama_kategori' => 'Sejarah',          'icon' => 'bi-bank',            'deskripsi' => 'Peristiwa dan tokoh sejarah dunia maupun lokal.'],
            ['nama_kategori' => 'Pengembangan Diri','icon' => 'bi-person-check',    'deskripsi' => 'Motivasi, produktivitas, dan psikologi praktis.'],
            ['nama_kategori' => 'Anak & Remaja',    'icon' => 'bi-emoji-smile',     'deskripsi' => 'Buku ramah untuk pembaca muda.'],
            ['nama_kategori' => 'Horor & Thriller', 'icon' => 'bi-moon-stars',      'deskripsi' => 'Cerita seram, misteri, dan menegangkan. (18+)'],
            ['nama_kategori' => 'Komik & Grafis',   'icon' => 'bi-palette',         'deskripsi' => 'Cerita bergambar dan novel grafis.'],
            ['nama_kategori' => 'Agama & Spiritual', 'icon' => 'bi-stars',          'deskripsi' => 'Buku keagamaan dan spiritualitas.'],
        ];
 
        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}