<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::inRandomOrder()->take(5)->get();
        $lessons = Lesson::inRandomOrder()->take(10)->get();

        foreach ($users as $user) {
            foreach ($lessons as $lesson) {
                $user->watched()->attach($lesson, ['watched' => rand(0, 1)]);
            }
        }
    }
}
