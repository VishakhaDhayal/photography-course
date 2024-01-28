<?php

namespace App\Achievements\Lesson;
use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Achievements\Achievement;

class FirstLessonWatched implements Achievement
{

    /**
     * Unlock the First Lesson Watched achievement for user.
     *
     * @param User $user
     * @return void
     */
   public function unlock(User $user):void
   {
       if (!$user->hasAchievement('lessons_watched_1')) {
           $user->achievements()->create([
               'name' => 'First Lesson Watched',
               'slug' => 'lessons_watched_1',
           ]);

           info('firstlessonwatched', [
               'Achievements' => $user->achievements->pluck('name')->toArray(),
           ]);

           event(new AchievementUnlocked('First Lesson Watched', $user));
       }
   }
}
