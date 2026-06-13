<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'name',
        'description',
        'email'
    ];

    public function organizers()
    {
        return $this->belongsToMany(Organizer::class)
            ->withPivot('contribution_type', 'contribution_amount')
            ->withTimestamps();
    }
}
