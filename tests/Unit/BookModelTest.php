<?php
namespace Tests\Unit;
 
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
 
class BookModelTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_free_book_is_accessible_to_anyone(): void
    {
        $book = Book::factory()->create(['jenis_akses' => 'gratis', 'minimal_usia' => 0]);
        $user = User::factory()->create(['tanggal_lahir' => now()->subYears(20)->format('Y-m-d')]);
 
        $this->assertTrue($book->isAccessible($user));
    }
 
    public function test_premium_book_inaccessible_to_free_user(): void
    {
        $book = Book::factory()->create(['jenis_akses' => 'premium', 'minimal_usia' => 0]);
        $user = User::factory()->create(['status_premium' => false]);
 
        $this->assertFalse($book->isAccessible($user));
    }
 
    public function test_premium_book_accessible_to_premium_user(): void
    {
        $book = Book::factory()->create(['jenis_akses' => 'premium', 'minimal_usia' => 0]);
        $user = User::factory()->create(['status_premium' => true, 'tanggal_lahir' => now()->subYears(20)->format('Y-m-d')]);
 
        $this->assertTrue($book->isAccessible($user));
    }
 
    public function test_age_restricted_book_blocks_underage_user(): void
    {
        $book = Book::factory()->create(['jenis_akses' => 'gratis', 'minimal_usia' => 18]);
        $user = User::factory()->create(['tanggal_lahir' => now()->subYears(15)->format('Y-m-d')]);
 
        $this->assertFalse($book->isAccessible($user));
    }
 
    public function test_admin_can_access_any_book(): void
    {
        $book  = Book::factory()->create(['jenis_akses' => 'premium', 'minimal_usia' => 18]);
        $admin = User::factory()->create(['role' => 'admin', 'tanggal_lahir' => now()->subYears(15)->format('Y-m-d')]);
 
        $this->assertTrue($book->isAccessible($admin));
    }
 
    public function test_increment_views(): void
    {
        $book = Book::factory()->create(['views' => 10]);
        $book->incrementViews();
 
        $this->assertEquals(11, $book->refresh()->views);
    }
}