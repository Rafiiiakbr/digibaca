<?php
namespace Database\Factories;
 
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
 
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama'           => fake()->name(),
            'email'          => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'       => Hash::make('password'),
            'role'           => fake()->randomElement(['reader', 'author']),
            'tanggal_lahir'  => fake()->dateTimeBetween('-60 years', '-13 years')->format('Y-m-d'),
            'status_premium' => fake()->boolean(20),
            'remember_token' => null,
        ];
    }
 
    public function admin(): static
    {
        return $this->state(fn () => ['role' => 'admin']);
    }
 
    public function author(): static
    {
        return $this->state(fn () => ['role' => 'author']);
    }
 
    public function reader(): static
    {
        return $this->state(fn () => ['role' => 'reader']);
    }
 
    public function premium(): static
    {
        return $this->state(fn () => ['status_premium' => true]);
    }
}