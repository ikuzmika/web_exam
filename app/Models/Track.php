<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = [
        'competition_id',
        'difficulty_level_id',
        'created_by_user_id',
        'name'
    ];

    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }

    public function difficultyLevel()
    {
        return $this->belongsTo(DifficultyLevel::class, 'difficulty_level_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'track_id');
    }

}
