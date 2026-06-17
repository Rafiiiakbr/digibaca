<?php
namespace Database\Seeders;
 
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
 
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'nama'          => 'Administrator',
            'email'         => 'admin@digibaca.test',
            'password'      => Hash::make('password'),
            'role'          => 'admin',
            'tanggal_lahir' => '1990-01-01',
            'status_premium'=> true,
        ]);
 
        // Authors
        User::create([
            'nama'          => 'Andrea Hirata',
            'email'         => 'author@digibaca.test',
            'password'      => Hash::make('password'),
            'role'          => 'author',
            'tanggal_lahir' => '1982-05-12',
            'status_premium'=> false,
        ]);
 
        User::factory()->count(5)->create(['role' => 'author']);
 
        // Readers
        User::create([
            'nama'          => 'Budi Santoso',
            'email'         => 'reader@digibaca.test',
            'password'      => Hash::make('password'),
            'role'          => 'reader',
            'tanggal_lahir' => '2000-03-20',
            'status_premium'=> false,
        ]);
 
        User::create([
            'nama'          => 'Siti Aminah (Premium)',
            'email'         => 'premium@digibaca.test',
            'password'      => Hash::make('password'),
            'role'          => 'reader',
            'tanggal_lahir' => '1995-08-15',
            'status_premium'=> true,
        ]);
 
        // Reader di bawah umur (testing age verification)
        User::create([
            'nama'          => 'Andi (Minor)',
            'email'         => 'minor@digibaca.test',
            'password'      => Hash::make('password'),
            'role'          => 'reader',
            'tanggal_lahir' => now()->subYears(15)->format('Y-m-d'),
            'status_premium'=> false,
        ]);
 
        User::factory()->count(20)->create(['role' => 'reader']);
    }
}