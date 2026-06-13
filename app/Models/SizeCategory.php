<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeCategory extends Model
{
    protected $fillable = [
        'name'
    ];

    public function dog()
    {
        return $this->hasMany(Dog::class, 'size_category_id');
    }
}
