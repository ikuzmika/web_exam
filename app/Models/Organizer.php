<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'contact_number',
        'venue',
    ];

    public function sponsors(){
        return $this->belongsToMany(Sponsor::class)
            ->withPivot('contribution_type', 'contribution_amount')
            ->withTimestamps();
    }

    public function competitions(){
        return $this->hasMany(Competition::class, 'organizer_id');
    }
}
