<?php
namespace Tests\Feature;
 
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
 
class PremiumTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_non_premium_user_blocked_from_premium_book(): void
    {
        $reader = User::factory()->create(['role' => 'reader', 'status_premium' => false, 'tanggal_lahir' => '2000-01-01']);
        $book   = Book::factory()->create(['jenis_akses' => 'premium', 'status_verifikasi' => 'verified']);
 
        $response = $this->actingAs($reader)->get('/baca/' . $book->id);
        $response->assertRedirect(route('premium.upgrade'));
    }
 
    public function test_premium_user_can_access_premium_book(): void
    {
        $reader = User::factory()->create(['role' => 'reader', 'status_premium' => true, 'tanggal_lahir' => '2000-01-01']);
        $book   = Book::factory()->create(['jenis_akses' => 'premium', 'status_verifikasi' => 'verified', 'minimal_usia' => 0]);
 
        $response = $this->actingAs($reader)->get('/baca/' . $book->id);
        $response->assertStatus(200);
    }
 
    public function test_underage_user_blocked_from_adult_content(): void
    {
        $minor = User::factory()->create([
            'role' => 'reader',
            'tanggal_lahir' => now()->subYears(15)->format('Y-m-d'),
        ]);
        $book = Book::factory()->create([
            'jenis_akses' => 'gratis',
            'minimal_usia' => 18,
            'status_verifikasi' => 'verified',
        ]);
 
        $response = $this->actingAs($minor)->get('/baca/' . $book->id);
        $response->assertSessionHas('error');
    }
 
    public function test_adult_user_can_access_age_restricted_content(): void
    {
        $adult = User::factory()->create([
            'role' => 'reader',
            'tanggal_lahir' => now()->subYears(25)->format('Y-m-d'),
        ]);
        $book = Book::factory()->create([
            'jenis_akses' => 'gratis',
            'minimal_usia' => 18,
            'status_verifikasi' => 'verified',
        ]);
 
        $response = $this->actingAs($adult)->get('/baca/' . $book->id);
        $response->assertStatus(200);
    }
 
    public function test_user_can_submit_payment_proof(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $reader = User::factory()->create(['role' => 'reader']);
 
        $response = $this->actingAs($reader)->post('/premium/bayar', [
            'metode'         => 'BCA',
            'bukti_transfer' => \Illuminate\Http\UploadedFile::fake()->image('bukti.jpg'),
        ]);
 
        $response->assertRedirect(route('premium.upgrade'));
        $this->assertDatabaseHas('payments', ['user_id' => $reader->id, 'status' => 'pending']);
    }
 
    public function test_admin_confirming_payment_activates_premium(): void
    {
        $admin   = User::factory()->create(['role' => 'admin']);
        $reader  = User::factory()->create(['role' => 'reader', 'status_premium' => false]);
        $payment = \App\Models\Payment::create([
            'user_id' => $reader->id,
            'nominal' => 99000,
            'status'  => 'pending',
            'metode'  => 'BCA',
        ]);
 
        $this->actingAs($admin)->post(route('admin.premium.confirm', $payment->id));
 
        $this->assertTrue($reader->refresh()->status_premium);
        $this->assertDatabaseHas('payments', ['id' => $payment->id, 'status' => 'confirmed']);
    }
}