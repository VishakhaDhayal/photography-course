<?php

namespace App\Achievements\Comment;
use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Achievements\Achievement;

class TenCommentsWritten implements Achievement
{
    private const ACHIEVEMENT_NAME = '10 Comments Written';
    private const ACHIEVEMENT_SLUG = 'comments_written_10';


    /**
     * Unlock the First Comment Written achievement for user.
     *
     * @param User $user
     * @return void
     */
    public function unlock(User $user): void
    {
        if (!$user->hasAchievement(self::ACHIEVEMENT_SLUG)) {
            $user->achievements()->create([
                'name' => self::ACHIEVEMENT_NAME,
                'slug' => self::ACHIEVEMENT_SLUG,
            ]);
            info(self::ACHIEVEMENT_SLUG, [
                'Achievements' => $user,
            ]);
            event(new AchievementUnlocked(self::ACHIEVEMENT_NAME, $user));
        }
    }
}
