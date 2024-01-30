<?php

namespace App\Achievements\Lesson;
use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Achievements\Achievement;

class FirstLessonWatched implements Achievement
{
    private const ACHIEVEMENT_NAME = '1 Lessons Watched';
    private const ACHIEVEMENT_SLUG = 'lessons_watched_1';

    /**
     * Unlock the First Lesson Watched achievement for user.
     *
     * @param User $user
     * @return void
     */
   public function unlock(User $user):void
   {
       if (!$user->hasAchievement(self::ACHIEVEMENT_SLUG)) {
           $user->achievements()->create([
               'name' => self::ACHIEVEMENT_NAME,
               'slug' => self::ACHIEVEMENT_SLUG,
           ]);

           info(self::ACHIEVEMENT_SLUG, [
               'Achievements' => $user->achievements->pluck('name')->toArray(),
           ]);

           event(new AchievementUnlocked(self::ACHIEVEMENT_NAME, $user));
       }
   }
}
