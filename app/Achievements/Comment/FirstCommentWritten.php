<?php

namespace App\Achievements\Comment;
use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Achievements\Achievement;

class FirstCommentWritten implements Achievement{

    /**
     * Unlock the First Comment Written achievement for user.
     *
     * @param User $user
     * @return void
     */
    public function unlock(User $user): void
    {
        if (!$user->hasAchievement('comments_written_1')) {
            $user->achievements()->create([
                'name' => 'First Comment Written',
                'slug' => 'comments_written_1',
            ]);
            info('lessons_watched_5', [
                'Achievements' => $user,
            ]);
            event(new AchievementUnlocked('First Comment Written', $user));
        }
    }
}
