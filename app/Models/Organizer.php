<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organizer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'created_by_user_id',
        'name',
        'contact_person',
        'email',
        'contact_number',
        'venue',
    ];

    public function sponsors(){
        return $this->belongsToMany(Sponsor::class, 'sponsor_organizer')
            ->withPivot('contribution_type', 'contribution_amount')
            ->withTimestamps();
    }

    public function competitions(){
        return $this->hasMany(Competition::class, 'organizer_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
