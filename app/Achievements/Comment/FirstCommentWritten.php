<?php

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
        if (!$user->hasAchievement('first_comment_written')) {
            $user->achievements()->create([
                'name' => 'First Comment Written',
                'slug' => 'first_comment_written',
            ]);
        }
    }
}
