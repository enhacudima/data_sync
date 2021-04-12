<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    
    //
    protected $table = 'options';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $fillable = [
        'type','status',
    ];

}
