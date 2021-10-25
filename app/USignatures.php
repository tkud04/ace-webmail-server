<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class USignatures extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'value', 'current'
    ];
}