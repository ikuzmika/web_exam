<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'handler_id',
        'size_category_id',
        'created_by_user_id',
        'name',
        'description'
    ];

    public function handler()
    {
        return $this->belongsTo(Handler::class, 'handler_id');
    }

    public function sizeCategory()
    {
        return $this->belongsTo(SizeCategory::class, 'size_category_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function pair()
    {
        return $this->hasOne(Pair::class, 'dog_id');
    }


}
