<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uploaded_by_user_id',
        'competition_id',
        'pair_id',
        'track_id',
        'title',
        'file_path',
        'is_approved'
    ];

    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }

    public function pair()
    {
        return $this->belongsTo(Pair::class, 'pair_id');
    }

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }
}
