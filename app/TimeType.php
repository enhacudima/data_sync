<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeType extends Model
{
    
    //
    protected $table = 'time_type';

    public $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable = [
        'type','status',
    ];

}
