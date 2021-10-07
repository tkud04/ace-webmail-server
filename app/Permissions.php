<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'ptag', 'granted_by'
    ];
}
