<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    protected $fillable = [
        'dog_id',
        'created_by_user_id',
        'active_from',
        'active_until',
    ];

    public function dog()
    {
        return $this->belongsTo(Dog::class, 'dog_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'pair_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'pair_id');
    }
}
