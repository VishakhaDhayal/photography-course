<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        $unlockedAchievements = $user->achievements->pluck('name')->toArray();

        $allAchievements = Achievement::pluck('name')->toArray();

        $nextAvailableAchievements = array_diff($allAchievements, $unlockedAchievements);

        $currentBadge = $user->badge ? $user->badge->name : 'No Badge';

        $nextBadge = $user->getNextBadge();

        $remainingToUnlockNextBadge = $nextBadge ?
            max(0, $nextBadge->min_achievements_required - $user->achievements->count()) : 0;

        $response = [
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge ? $nextBadge->name : 'No Next Badge',
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
        ];

        return response()->json($response);
    }
}
