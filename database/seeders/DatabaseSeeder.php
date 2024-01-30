<?php

namespace Database\Seeders;

use App\Models\Lesson;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $lessons = Lesson::factory()
            ->count(20)
            ->create();

        $this->call([
            BadgeTableSeeder::class,
            UserTableSeeder::class,
            AchivementsTableSeeder::class,
            UserAchievementsTableSeeder::class,
            LessonUserTableSeeder::class,
            CommentTableSeeder::class
        ]);
    }
}
