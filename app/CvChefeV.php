<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CvChefeV extends Model
{
    
    protected $table = 'cv_chefe_v';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $guarded =array();

}
