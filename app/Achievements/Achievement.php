<?php

namespace App\Achievements;
use App\Models\User;

/**
 * Interface for Achievements.
 */
interface Achievement
{
    /**
     * Unlock the achievement for the specified user.
     *
     * @param User $user
     * @return void
     */
    public function unlock(User $user): void;
}
