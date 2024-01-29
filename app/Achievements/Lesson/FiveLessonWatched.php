<?php

namespace App\Achievements\Lesson;
use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Achievements\Achievement;

class FiveLessonWatched implements Achievement
{

    /**
     * Unlock the Five Lesson Watched achievement for user.
     *
     * @param User $user
     * @return void
     */
    public function unlock(User $user):void
    {
        if (!$user->hasAchievement('lessons_watched_5')) {
            $user->achievements()->create([
                'name' => '5 Lessons Watched',
                'slug' => 'lessons_watched_5',
            ]);

            info('lessons_watched_5', [
                'Achievements' => $user,
            ]);

            event(new AchievementUnlocked('5 Lesson Watched', $user));
        }
    }
}
