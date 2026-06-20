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
        'title',
        'file_path'
    ];

    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }

    public function pair()
    {
        return $this->belongsTo(Pair::class, 'pair_id');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }
}
