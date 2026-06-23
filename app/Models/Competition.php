<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Competition extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organizer_id',
        'created_by_user_id',
        'judge_id',
        'title',
        'date'
    ];

    protected $casts = [
        'date' => 'datetime',
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

    public function photo()
    {
        return $this->hasMany(Photo::class, 'competition_id');
    }
}
