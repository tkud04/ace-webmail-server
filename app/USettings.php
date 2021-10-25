<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class USettings extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'value'
    ];
}