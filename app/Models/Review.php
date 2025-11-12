<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id','product_key','rating','comment','verified'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
