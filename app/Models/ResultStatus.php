<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultStatus extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function results()
    {
        return $this->hasMany(Result::class, 'result_status_id');
    }
}
