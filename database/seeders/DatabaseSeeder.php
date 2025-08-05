<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call seeders in order to maintain foreign key relationships
        $this->call([
            ParentSeeder::class,
            StudentSeeder::class,
            ClassSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
