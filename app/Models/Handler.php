<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handler extends Model
{
    protected $fillable = [
        'created_by_user_id',
        'name',
        'surname',
        'email',
        'contact_number'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function dog(){
        return $this->hasMany(Dog::class, 'handler_id');
    }
}
