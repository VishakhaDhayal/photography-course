<?php

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
       if (!$user->hasAchievement('first_lesson_watched')) {
           $user->achievements()->create([
               'name' => 'First Lesson Watched',
               'slug' => 'first_lesson_watched',
           ]);
       }
   }
}
