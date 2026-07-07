<?php
namespace Tests\Feature;
 
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
 
class BookTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_guest_can_view_verified_book_catalog(): void
    {
        Book::factory()->count(3)->create(['status_verifikasi' => 'verified']);
        Book::factory()->create(['status_verifikasi' => 'pending']);
 
        $response = $this->get('/katalog');
        $response->assertStatus(200);
        $response->assertViewHas('books', fn ($books) => $books->total() === 3);
    }
 
    public function test_unverified_book_returns_404_on_detail_page(): void
    {
        $book = Book::factory()->create(['status_verifikasi' => 'pending']);
        $response = $this->get('/buku/' . $book->id);
        $response->assertStatus(404);
    }
 
    public function test_author_can_upload_book(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
 
        $author = User::factory()->create(['role' => 'author']);
        $category = Category::factory()->create();
 
        $response = $this->actingAs($author)->post('/author/buku', [
            'judul'        => 'Buku Uji Coba',
            'kategori_id'  => $category->id,
            'genre'        => 'Edukasi',
            'deskripsi'    => str_repeat('Lorem ipsum dolor sit amet. ', 5),
            'bahasa'       => 'Indonesia',
            'jenis_akses'  => 'gratis',
            'minimal_usia' => 0,
            'cover'        => \Illuminate\Http\UploadedFile::fake()->image('cover.jpg'),
            'file_buku'    => \Illuminate\Http\UploadedFile::fake()->create('book.pdf', 1000, 'application/pdf'),
        ]);
 
        $response->assertRedirect(route('author.books.index'));
        $this->assertDatabaseHas('books', [
            'judul'             => 'Buku Uji Coba',
            'author_id'         => $author->id,
            'status_verifikasi' => 'pending',
        ]);
    }
 
    public function test_author_cannot_edit_others_book(): void
    {
        $author1 = User::factory()->create(['role' => 'author']);
        $author2 = User::factory()->create(['role' => 'author']);
        $book = Book::factory()->create(['author_id' => $author1->id]);
 
        $response = $this->actingAs($author2)->get(route('author.books.edit', $book->id));
        $response->assertStatus(403);
    }
 
    public function test_admin_can_verify_pending_book(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $book  = Book::factory()->create(['status_verifikasi' => 'pending']);
 
        $response = $this->actingAs($admin)->post(route('admin.books.verify', $book->id), [
            'action' => 'verified',
        ]);
 
        $response->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseHas('books', ['id' => $book->id, 'status_verifikasi' => 'verified']);
    }
 
    public function test_admin_can_reject_book_with_reason(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $book  = Book::factory()->create(['status_verifikasi' => 'pending']);
 
        $response = $this->actingAs($admin)->post(route('admin.books.verify', $book->id), [
            'action'           => 'rejected',
            'alasan_penolakan' => 'File tidak dapat dibuka',
        ]);
 
        $this->assertDatabaseHas('books', [
            'id'                => $book->id,
            'status_verifikasi' => 'rejected',
            'alasan_penolakan'  => 'File tidak dapat dibuka',
        ]);
    }
 
    public function test_reader_cannot_access_author_routes(): void
    {
        $reader = User::factory()->create(['role' => 'reader']);
        $response = $this->actingAs($reader)->get(route('author.dashboard'));
        $response->assertStatus(403);
    }
}