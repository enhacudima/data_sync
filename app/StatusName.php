<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusName extends Model
{
    
    //
    protected $table = 'status_name';

    public $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable = [
        'name',
    ];

}
