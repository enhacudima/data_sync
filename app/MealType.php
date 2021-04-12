<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MealType extends Model
{
    
    //
    protected $table = 'type_meal';

    public $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable = [
        'type','status',
    ];

}
