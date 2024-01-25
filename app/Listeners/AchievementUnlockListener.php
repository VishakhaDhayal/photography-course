<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\User;
use FirstCommentWritten;
use FirstLessonWatched;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class AchievementUnlockListener
{
    /**
     * Create the event listener.
     */
    use InteractsWithQueue;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LessonWatched|CommentWritten $event): void
    {
        $user = $event->user;

        $lessonsWatchedCount = $user->watched()->count();
        $commentsWrittenCount = $user->comments()->count();

        $achievementConfig = [
            'lesson' => [
                1 => FirstLessonWatched::class,
            ],
            'comment' => [
                1 => FirstCommentWritten::class,
            ],
        ];

        foreach ($achievementConfig['lesson'] as $condition => $achievementType) {
            if ($lessonsWatchedCount >= $condition && !$user->hasAchievement($achievementType)) {
                $this->unlockAchievement($user, $achievementType);
            }
        }

        foreach ($achievementConfig['comment'] as $condition => $achievementType) {
            if ($commentsWrittenCount >= $condition && !$user->hasAchievement($achievementType)) {
                $this->unlockAchievement($user, $achievementType);
            }
        }
    }

    /**
     * Unlock the related achievement for user.
     *
     * @param User $user
     * @param string $achievementType
     *
     * @return void
     */
    private function unlockAchievement(User $user, string $achievementType): void
    {
        $achievement = app($achievementType);
        $achievement->unlock($user);
    }

}
