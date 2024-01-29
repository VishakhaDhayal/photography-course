<?php

namespace App\Achievements\Comment;
use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Achievements\Achievement;

class TenCommentsWritten implements Achievement{

    /**
     * Unlock the First Comment Written achievement for user.
     *
     * @param User $user
     * @return void
     */
    public function unlock(User $user): void
    {
        if (!$user->hasAchievement('comments_written_10')) {
            $user->achievements()->create([
                'name' => '10 Comments Written',
                'slug' => 'comments_written_10',
            ]);
            info('comments_written_10', [
                'Achievements' => $user,
            ]);
            event(new AchievementUnlocked('10 Comments Written', $user));
        }
    }
}
