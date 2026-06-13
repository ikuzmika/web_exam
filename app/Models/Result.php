<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'pair_id',
        'track_id',
        'result_status_id',
        'recorded_by_user_id',
        'points'
    ];

    public function pair()
    {
        return $this->belongsTo(Pair::class, 'pair_id');
    }

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function resultStatus()
    {
        return $this->belongsTo(ResultStatus::class, 'result_status_id');
    }

    public function recordedByUser()
    {
        return $this->belongsTo(User::class, 'recorded_by_user_id');
    }
}
