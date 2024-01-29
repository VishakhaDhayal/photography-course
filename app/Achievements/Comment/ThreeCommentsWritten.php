<?php

namespace App\Achievements\Comment;
use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Achievements\Achievement;

class ThreeCommentsWritten implements Achievement{

    /**
     * Unlock the First Comment Written achievement for user.
     *
     * @param User $user
     * @return void
     */
    public function unlock(User $user): void
    {
        if (!$user->hasAchievement('comments_written_3')) {
            $user->achievements()->create([
                'name' => '3 Comments Written',
                'slug' => 'comments_written_3',
            ]);
            info('comments_written_3', [
                'Achievements' => $user,
            ]);
            event(new AchievementUnlocked('3 Comments Written', $user));
        }
    }
}
