<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DifficultyLevel extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function track(){
        return $this->hasMany(Track::class, 'difficulty_level_id');
    }
}
