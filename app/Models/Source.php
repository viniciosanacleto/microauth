<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Source extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'token'
    ];
    protected static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model['token'] = bin2hex(random_bytes(64));
        });
    }
}
