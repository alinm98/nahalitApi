<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([

            // Blog Seeder
            BlogTableSeeder::class,

            // User Seeder
            UserTableSeeder::class,


            // Ticket Seeder
            TicketTableSeeder::class,

            // Project Seeder

            ProjectTableSeeder::class,

            // Report Seeder
            ReportTableSeeder::class

            ProjectTableSeeder::class

            CategorySeeder::class,

            OrderTableSeeder::class,

            BlogTableSeeder::class,

            ServiceSeeder::class,


        ]);
    }
}
