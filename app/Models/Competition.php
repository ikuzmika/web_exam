<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = [
        'organizer_id',
        'created_by_user_id',
        'judge_id',
        'title',
        'date'
    ];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class, 'organizer_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function judge()
    {
        return $this->belongsTo(Handler::class, 'judge_id');
    }

    public function track()
    {
        return $this->hasMany(Track::class, 'competition_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'competition_id');
    }
}
