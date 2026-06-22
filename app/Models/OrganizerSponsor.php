<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizerSponsor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organizer_id',
        'sponsor_id',
        'contribution_type',
        'contribution_amount',
    ];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}
