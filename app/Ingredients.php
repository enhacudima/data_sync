<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    
    //
    protected $table = 'ingredients';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $guarded =array();

}
