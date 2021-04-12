<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    //
    protected $table = 'message';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $fillable = [
        'name', 'email', 'message','key',
    ];

}
