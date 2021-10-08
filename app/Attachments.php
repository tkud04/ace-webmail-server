<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'message_id', 'cid', 'ctype', 'filename', 'content', 'checksum', 'size'
    ];
}
