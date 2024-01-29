<?php


namespace App\Achievements\Lesson;

use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Achievements\Achievement;

class TenLessonsWatched implements Achievement
{

    /**
     * Unlock the Five Lesson Watched achievement for user.
     *
     * @param User $user
     * @return void
     */
    public function unlock(User $user): void
    {
        if (!$user->hasAchievement('lessons_watched_10')) {
            $user->achievements()->create([
                'name' => 'Ten Lessons Watched',
                'slug' => 'lessons_watched_10',
            ]);

            info('lessons_watched_10', [
                'Achievements' => $user,
            ]);

            event(new AchievementUnlocked('Ten Lessons Watched', $user));
        }
    }
}
