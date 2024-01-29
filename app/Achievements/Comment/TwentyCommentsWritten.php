<?php

namespace App\Achievements\Comment;
use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Achievements\Achievement;

class TwentyCommentsWritten implements Achievement{

    /**
     * Unlock the First Comment Written achievement for user.
     *
     * @param User $user
     * @return void
     */
    public function unlock(User $user): void
    {
        if (!$user->hasAchievement('comments_written_20')) {
            $user->achievements()->create([
                'name' => 'Twenty Comments Written',
                'slug' => 'comments_written_20',
            ]);
            info('comments_written_20', [
                'Achievements' => $user,
            ]);
            event(new AchievementUnlocked('Twenty Comments Written', $user));
        }
    }
}
