<?php
namespace Tests\Unit;
 
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
 
class UserModelTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_get_age_calculates_correctly(): void
    {
        $user = User::factory()->create(['tanggal_lahir' => now()->subYears(20)->format('Y-m-d')]);
        $this->assertEquals(20, $user->getAge());
    }
 
    public function test_role_helper_methods(): void
    {
        $admin  = User::factory()->create(['role' => 'admin']);
        $author = User::factory()->create(['role' => 'author']);
        $reader = User::factory()->create(['role' => 'reader']);
 
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isReader());
 
        $this->assertTrue($author->isAuthor());
        $this->assertFalse($author->isAdmin());
 
        $this->assertTrue($reader->isReader());
        $this->assertFalse($reader->isAuthor());
    }
 
    public function test_is_premium_helper(): void
    {
        $premiumUser = User::factory()->create(['status_premium' => true]);
        $freeUser    = User::factory()->create(['status_premium' => false]);
 
        $this->assertTrue($premiumUser->isPremium());
        $this->assertFalse($freeUser->isPremium());
    }
}