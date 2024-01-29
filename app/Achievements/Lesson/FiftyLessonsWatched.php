<?php


namespace App\Achievements\Lesson;

use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Achievements\Achievement;

class FiftyLessonsWatched implements Achievement
{

    /**
     * Unlock the Five Lesson Watched achievement for user.
     *
     * @param User $user
     * @return void
     */
    public function unlock(User $user): void
    {
        if (!$user->hasAchievement('lessons_watched_50')) {
            $user->achievements()->create([
                'name' => '50 Lessons Watched',
                'slug' => 'lessons_watched_50',
            ]);

            info('lessons_watched_50', [
                'Achievements' => $user,
            ]);

            event(new AchievementUnlocked('50 Lessons Watched', $user));
        }
    }
}
