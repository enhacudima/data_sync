<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    
    //
    protected $table = 'currency';

    public $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable = [
        'entity','currency','alphabetic_code','numeric_code','minor_unit',
    ];

}
