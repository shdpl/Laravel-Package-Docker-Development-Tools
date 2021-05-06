<?php

namespace Database\Seeders;

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
        $this->call([
            \EscolaLms\HeadlessH5P\Database\Seeders\ContentLibrarySeeder::class,
            \EscolaLms\Courses\Database\Seeders\CoursesSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
