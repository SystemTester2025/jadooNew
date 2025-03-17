<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@a.a',
            'password' => bcrypt('123'),
            'is_admin' => true,
        ]);

        // Run our seeders
        $this->call([
            PagesSeeder::class,
            ServicesSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}
