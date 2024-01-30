<?php

namespace App\Listeners;

use App\Achievements\Comment\FirstCommentWritten;
use App\Achievements\Comment\FiveCommentsWritten;
use App\Achievements\Comment\TenCommentsWritten;
use App\Achievements\Comment\ThreeCommentsWritten;
use App\Achievements\Comment\TwentyCommentsWritten;
use App\Achievements\Lesson\FiftyLessonsWatched;
use App\Achievements\Lesson\FirstLessonWatched;
use App\Achievements\Lesson\FiveLessonWatched;
use App\Achievements\Lesson\TenLessonsWatched;
use App\Achievements\Lesson\TwentyFiveLessonsWatched;
use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class EventsListener
{
    /**
     * Create the event listener.
     */
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    protected function getAchievementConfig(): array
    {
        return [
            'lessons' => [
                1 => FirstLessonWatched::class,
                5 => FiveLessonWatched::class,
                10 => TenLessonsWatched::class,
                25 => TwentyFiveLessonsWatched::class,
                50 => FiftyLessonsWatched::class
            ],
            'comments' => [
                1 => FirstCommentWritten::class,
                3 => ThreeCommentsWritten::class,
                5 => FiveCommentsWritten::class,
                10 => TenCommentsWritten::class,
                20 => TwentyCommentsWritten::class
            ],
        ];
    }

    /**
     * Handle the event.
     */
    public function handle(LessonWatched|CommentWritten|AchievementUnlocked $event): void
    {
        $user = $event->user;

        $lessonsWatchedCount = $user->watched()->count();
        info('LessonWatched event catched',[
            'lessonCount'=>$lessonsWatchedCount,
            'user'=>$user
        ]);

        $commentsWrittenCount = $user->comments()->count();
        info('commentsWrittenCount',[
            'commentsCount'=>$commentsWrittenCount,
            'user'=>$user
        ]);

        if ($event instanceof LessonWatched) {
            info('Lessonwatched event');
            $this->handleAchievements($user, $lessonsWatchedCount, 'lessons');
        }elseif ($event instanceof CommentWritten){
            info('CommentWritten event');
            $this->handleAchievements($user, $commentsWrittenCount, 'comments');
        }
    }

    /**
     * Handle Achievements for  user.
     *
     * @param User $user
     * @param int $count
     * @param string $type
     *
     * @return void
     */
    private function handleAchievements(User $user, int $count, string $type): void
    {
        $config = $this->getAchievementConfig()[$type];

        foreach ($config as $condition => $achievementType) {
            $achievementSlug = sprintf('%s_watched_%d', $type, $condition);
            //condition 1
            //count 0
            if ($count === 0 && !$user->hasAchievement($achievementSlug)) {
                info('Condition pass for count 0', [
                    'Achievements' => $achievementSlug,
                    'count' => $count,
                    'condition' => $condition
                ]);
                $this->unlockAchievement($user, $achievementType);
            } elseif ($count >= $condition && !$user->hasAchievement($achievementSlug)) {
                info('Condition pass for count greater than', [
                    'Achievements' => $user->hasAchievement($achievementSlug),
                    'count' => $count,
                    'AchievementSlug' => $achievementSlug,
                    'condition' => $condition
                ]);
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

        $achievementsCount = $user->achievements()->count();

        info('AchievementsCount', [
            'Achievements' => $achievementsCount,
        ]);
    }
}
