<?php

use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class BadgeTest extends TestCase
{

    public function testAssignBadge()
    {
        foreach (Config::get('badges') as $badgeSlug => $badgeData) {
            info("Achievements assigned for");

            $defaultBadge = Badge::factory()->make();
            $user = User::factory()->create(['badge_id' => $defaultBadge->id]);
            info("Achievements assigned for");


            $achievements = Achievement::factory()->count($badgeData['min_achievements'])->create();
            info("Achievements assigned for {$badgeSlug}: " . $badgeData['max_achievements']);

            $badge = Badge::where('name', $badgeSlug)->first();

            if (!$badge) {
                $badge = Badge::create([
                    'name' => $badgeSlug,
                    'min_achievements_required' => $badgeData['min_achievements'],
                    'max_achievements_required' => $badgeData['max_achievements'],
                ]);
            }


            $user->achievements()->attach($achievements);
            info("Achievements assigned for {$badgeSlug}: " . $achievements);

            event(new AchievementUnlocked($badgeSlug, $user));

            $this->assertTrue($user->hasBadge($badgeSlug));

            foreach (Config::get('badges') as $otherBadgeSlug => $otherBadgeData) {
                if ($otherBadgeSlug !== $badgeSlug) {
                    $this->assertFalse($user->hasBadge($otherBadgeSlug));
                }
            }
        }
    }
}
