<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'created_by_user_id',
        'name',
        'description',
        'email'
    ];

    public function organizers()
    {
        return $this->belongsToMany(Organizer::class, 'organizer_sponsor')
            ->withPivot('contribution_type', 'contribution_amount')
            ->withTimestamps();
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
