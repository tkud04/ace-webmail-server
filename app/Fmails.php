<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fmails extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'message_id', 'message'
    ];
}
