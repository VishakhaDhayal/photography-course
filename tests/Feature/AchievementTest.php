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

    /**
     * Test unlocking achievements when lessons are watched.
     *
     * @dataProvider lessonWatchedDataProvider
     */

    public function testUnlockAchievementsOnLessonWatched(array $lessonCounts)
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();

        foreach ($lessonCounts as $count) {
            $this->attachLessonsAndFireEvents($user, $lesson, $count, 'lessons_watched');
        }
    }

    /**
     * Data provider for lessonWatchedDataProvider.
     */
    public static function lessonWatchedDataProvider(): array
    {
        return [
            [[1, 5, 10, 25, 50]],
        ];
    }

    /**
     * Test unlocking achievements when comments are written.
     *
     * @dataProvider commentsWrittenDataProvider
     */
    public function testUnlockAchievementsOnCommentWritten(array $commentCounts)
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        foreach ($commentCounts as $count) {
            $this->attachCommentsAndFireEvents($user, $comment, $count, 'comments_written');
        }
    }

    /**
     * Data provider for commentsWrittenDataProvider.
     */
    public static function commentsWrittenDataProvider(): array
    {
        return [
            [[1, 3, 5, 10, 20]],
        ];
    }

    /**
     * Test unlocking achievements when both lessons are watched and comments are written.
     */
    public function testUnlockAchievementsOnLessonWatchedAndCommentWritten()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $comment = Comment::factory()->create();

        $this->attachLessonsAndFireEvents($user, $lesson, 1, 'lessons_watched');
        $this->attachCommentsAndFireEvents($user, $comment, 1, 'comments_written');
    }

    /**
     * Attach lessons and fire events to unlock achievements.
     *
     * @param User $user
     * @param Lesson $lesson
     * @param int $count
     * @param string $achievementType
     */
    private function attachLessonsAndFireEvents(User $user, Lesson $lesson, int $count, string $achievementType): void
    {
        $lessons = Lesson::factory()->count($count)->create();
        $lessonIds = $lessons->pluck('id')->toArray();

        $user->lessons()->attach($lessonIds, ['watched' => true]);
        $lessonsWatchedCountAfterAttach = $user->watched()->count();

        for ($i = 0; $i < $count; $i++) {
            event(new LessonWatched($lesson, $user));
        }

        $achievementSlug = "{$achievementType}_{$count}";
        $this->assertTrue($user->hasAchievement($achievementSlug));

        $user->lessons()->detach();
    }

    /**
     * Attach comments and fire events to unlock achievements.
     *
     * @param User $user
     * @param Comment $comment
     * @param int $count
     * @param string $achievementType
     */
    private function attachCommentsAndFireEvents(User $user, Comment $comment, int $count, string $achievementType): void
    {
        $comments = Comment::factory()->count($count)->create(['user_id' => $user->id]);

        for ($i = 0; $i < $count; $i++) {
            event(new CommentWritten($comment, $user));
        }

        $achievementSlug = "{$achievementType}_{$count}";
        $this->assertTrue($user->hasAchievement($achievementSlug));

        $user->comments()->delete();
    }
}

