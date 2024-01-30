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
                'name'=>'1 Lessons Watched',
                'slug'=>'lessons_watched_1',
            ],
            [
                'name'=>'5 Lessons Watched',
                'slug'=>'lessons_watched_5',
            ],
            [
                'name'=>'10 Lessons Watched',
                'slug'=>'lessons_watched_10',
            ],
            [
                'name'=>'25 Lessons Watched',
                'slug'=>'lessons_watched_25',
            ],
            [
                'name'=>'50 Lessons Watched',
                'slug'=>'lessons_watched_50',
            ],
            [
                'name'=>'First Comment Written',
                'slug'=>'comments_written_1',
            ],
            [
                'name'=>'3 Comments Written',
                'slug'=>'comments_written_3',
            ],
            [
                'name'=>'5 Comments Written',
                'slug'=>'comments_written_5',
            ],
            [
                'name'=>'10 Comments Written',
                'slug'=>'comments_written_10',
            ],
            [
                'name'=>'20 Comments Written',
                'slug'=>'comments_written_20',
            ],
        ];

        foreach ($achievements as $achievement) {
            DB::table('achievements')->insert($achievement);
        }
    }
}
