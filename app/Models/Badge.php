<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'min_achievements_required','max_achievements_required'];

    /**
     * Define the relationship with users through the badges_users pivot table.
     *
     */
    public function users()
    {
        return $this->hasMany(User::class,'badge_id');
    }
}
