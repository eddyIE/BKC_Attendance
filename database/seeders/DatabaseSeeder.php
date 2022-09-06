<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

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
        User::factory()->count(5)->create();
        Student::factory()->count(40)->create();
        Major::factory()->count(9)->create();
        Subject::factory()->count(16)->create();
    }
}
