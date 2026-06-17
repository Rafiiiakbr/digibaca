<?php
namespace Tests\Feature;
 
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
 
class AuthTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_user_can_register_as_reader(): void
    {
        $response = $this->post('/register', [
            'nama'                  => 'Test Reader',
            'email'                 => 'testreader@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'reader',
            'tanggal_lahir'         => '2000-01-01',
        ]);
 
        $response->assertRedirect(route('reader.dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'testreader@example.com',
            'role'  => 'reader',
        ]);
    }
 
    public function test_user_can_register_as_author(): void
    {
        $response = $this->post('/register', [
            'nama'                  => 'Test Author',
            'email'                 => 'testauthor@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'author',
            'tanggal_lahir'         => '1990-01-01',
        ]);
 
        $response->assertRedirect(route('author.dashboard'));
        $this->assertDatabaseHas('users', ['email' => 'testauthor@example.com', 'role' => 'author']);
    }
 
    public function test_registration_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'duplicate@example.com']);
 
        $response = $this->post('/register', [
            'nama'                  => 'Duplicate User',
            'email'                 => 'duplicate@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'reader',
            'tanggal_lahir'         => '2000-01-01',
        ]);
 
        $response->assertSessionHasErrors('email');
    }
 
    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);
 
        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password123',
        ]);
 
        $this->assertAuthenticatedAs($user);
    }
 
    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);
 
        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'wrongpassword',
        ]);
 
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
 
    public function test_admin_redirected_to_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'password' => bcrypt('password')]);
 
        $response = $this->post('/login', ['email' => $admin->email, 'password' => 'password']);
        $response->assertRedirect(route('admin.dashboard'));
    }
 
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
 
        $response = $this->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}