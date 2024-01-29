<?php

namespace App\Achievements\Comment;
use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Achievements\Achievement;

class FiveCommentsWritten implements Achievement{

    /**
     * Unlock the First Comment Written achievement for user.
     *
     * @param User $user
     * @return void
     */
    public function unlock(User $user): void
    {
        if (!$user->hasAchievement('comments_written_5')) {
            $user->achievements()->create([
                'name' => '5 Comments Written',
                'slug' => 'comments_written_5',
            ]);
            info('comments_written_5', [
                'Achievements' => $user,
            ]);
            event(new AchievementUnlocked('5 Comments Written', $user));
        }
    }
}
