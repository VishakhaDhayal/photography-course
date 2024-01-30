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
                'min_achievements_required'=>0,
                'max_achievements_required'=>3,
            ],
            [
                'name'=>'Intermediate',
                'min_achievements_required'=>4,
                'max_achievements_required'=>7,
            ],
            [
                'name'=>'Advanced',
                'min_achievements_required'=>8,
                'max_achievements_required'=>9,
            ],
            [
                'name'=>'Master',
                'min_achievements_required'=>10,
                'max_achievements_required'=>50,
            ],
        ];

        foreach ($badges as $badge) {
            DB::table('badges')->insert($badge);
        }
    }
}
