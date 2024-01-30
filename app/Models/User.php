<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Achievement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }
    public function writtenComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_user')->withTimestamps();
    }

    /*
     * If user has specific achievement
    * @param string $achievementSlug
    * @return bool
    */
    public function hasAchievement(string $achievementSlug): bool
    {
        return $this->achievements()->where('slug', $achievementSlug)->exists();
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')->withTimestamps();
    }

    public function hasBadge(string $badgeName): bool
    {
        return $this->badge()->where('name', $badgeName)->exists();
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class,'badge_id');
    }

    public function getNextBadge()
    {
        return Badge::where('min_achievements_required', '>', $this->achievements->count())
            ->orderBy('min_achievements_required')
            ->first();
    }
}

