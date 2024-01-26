<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class BadgeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges=[
            [
                'name'=>'Beginner',
                'achievements_required'=>0,
            ],
            [
                'name'=>'Intermediate',
                'achievements_required'=>4,
            ],
            [
                'name'=>'Advanced',
                'achievements_required'=>8,
            ],
            [
                'name'=>'Master',
                'achievements_required'=>10,
            ],
        ];

        foreach ($badges as $badge) {
            DB::table('badges')->insert($badge);
        }
    }
}
