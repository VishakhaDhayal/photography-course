<?php


use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Lesson;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AchievementTest extends TestCase
{
    use RefreshDatabase;

/*    public function testUnlockAchievementsOnLessonWatched()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        info('Initial state', [
            'Achievements' => $user,
        ]);

        info('Initial state', [
            'Achievements' => $user->achievements->pluck('name')->toArray(),
        ]);

        event(new LessonWatched($lesson, $user));
        info('LessonWatched event fired');
        info('State after LessonWatched event', [
            'Achievements' => $user->achievements->pluck('name')->toArray(),
        ]);

        $this->assertTrue($user->hasAchievement('lessons_watched_1'));

        $this->assertFalse($user->hasAchievement('comments_written_1'));
    }*/

    /**
     * @dataProvider lessonWatchedDataProvider
     */
    public function testUnlockAchievementsOnLessonWatched($lessonCounts)
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        info('Initial state', [
            'Achievements' => $user,
        ]);

        info('Initial state', [
            'Achievements' => $user->achievements->pluck('name')->toArray(),
        ]);

        foreach ($lessonCounts as $count) {
            for ($i = 0; $i < $count; $i++) {
                event(new LessonWatched($lesson, $user));
            }
            info("State after {$count} LessonsWatched events", [
                'Achievements' => $user->achievements->pluck('name')->toArray(),
            ]);

            $achievementSlug = "lessons_watched_{$count}";
            $this->assertTrue($user->hasAchievement($achievementSlug));
            $user->achievements()->delete();
        }
    }

    public static function lessonWatchedDataProvider(): array
    {
        return [
            [[1,5,10,25, 50]],
        ];
    }


    /**
     * @dataProvider commentsWrittenDataProvider
     */

    public function testUnlockAchievementsOnCommentWritten($commentCounts)
    {
        $user = User::factory()->create();
        $lesson = Comment::factory()->create();
        info('Initial state', [
            'Achievements' => $user,
        ]);

        info('Initial state', [
            'Achievements' => $user->achievements->pluck('name')->toArray(),
        ]);

        foreach ($commentCounts as $count) {
            for ($i = 0; $i < $count; $i++) {
                event(new CommentWritten($lesson, $user));
            }
            info("State after {$count} commentCounts events", [
                'Achievements' => $user->achievements->pluck('name')->toArray(),
            ]);

            $achievementSlug = "comments_written_{$count}";
            $this->assertTrue($user->hasAchievement($achievementSlug));
            $user->achievements()->delete();
        }
    }

//    public function lessonWatchedDataProvider()
//    {
//        return [
//            [5, ['lessons_watched_1', 'lessons_watched_5']],
//            [10, ['lessons_watched_1', 'lessons_watched_5', 'lessons_watched_10']],
//            // Add more data as needed
//        ];
//    }

    public static function commentsWrittenDataProvider(): array
    {
        return [
            [[1,3,5,10,20]],
        ];
    }
}

