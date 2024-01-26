<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchivementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements=[
            [
                'name'=>'First Lesson Watched',
                'slug'=>'first_lesson_watched',
            ],
            [
                'name'=>'5 Lessons Watched',
                'slug'=>'5_lessons_watched',
            ],
            [
                'name'=>'10 Lessons Watched',
                'slug'=>'10_lessons_watched',
            ],
            [
                'name'=>'25 Lessons Watched',
                'slug'=>'25_lessons_watched',
            ],
            [
                'name'=>'50 Lessons Watched',
                'slug'=>'50_lessons_watched',
            ],
            [
                'name'=>'First Comment Written',
                'slug'=>'first_comment_written',
            ],
            [
                'name'=>'3 Comments Written',
                'slug'=>'3_comments_written',
            ],
            [
                'name'=>'5 Comments Written',
                'slug'=>'5_comments_written',
            ],
            [
                'name'=>'10 Comments Written',
                'slug'=>'10_comments_written',
            ],
            [
                'name'=>'20 Comments Written',
                'slug'=>'20_comments_written',
            ],
        ];

        foreach ($achievements as $achievement) {
            DB::table('achievements')->insert($achievement);
        }
    }
}
