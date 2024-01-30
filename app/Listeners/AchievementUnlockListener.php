<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Config;

class AchievementUnlockListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AchievementUnlocked  $event
     * @return void
     */
    public function handle(AchievementUnlocked $event)
    {
        $user = $event->user;
        $this->checkBadges($user);
    }

    /**
     * Check and assign badges based on achievements count.
     *
     * @param  User  $user
     * @return void
     */
    private function checkBadges(User $user): void
    {
        $badgeCategories = Config::get('badges');

        foreach ($badgeCategories as $badgeSlug => $badgeData) {
            $this->assignBadgeIfNotExists($user, $badgeSlug, $badgeData['name']);
        }
    }

    /**
     * Assign a badge if it doesn't exist for the user.
     *
     * @param  User  $user
     * @param  string  $badgeSlug
     * @param  string  $badgeName
     * @return void
     */
    private function assignBadgeIfNotExists(User $user, string $badgeSlug, string $badgeName): void
    {
        if (!$user->hasBadge($badgeSlug)) {
            info("AssignBadgeIfNotExists for {$badgeSlug}");

            $badgeConfig = config("badges.{$badgeSlug}");

            $achievementsCount = $user->achievements()->count();
            info("AchievementsCount $achievementsCount");

            if ($achievementsCount >= $badgeConfig['min_achievements'] && $achievementsCount <= $badgeConfig['max_achievements']) {
                info("Condition pass");
                $badge = Badge::where('name', $badgeName)->first();
                info('Badge model',[
                    '$badge'=>$badge,
                    'badgeName'=>$badgeName,
                ]);

                if ($badge) {
                    info('Badge found. Associating with user...');
                    $user->badge()->associate($badge);
                    $user->save();
                    $user = $user->fresh();
                    info('Badge associated successfully.');
                    event(new BadgeUnlocked($badgeSlug, $user));
                } else {
                    info('Badge not found.');
                }
            }
        }
    }
}
