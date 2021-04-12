<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryStates extends Model
{
    protected $table = 'uvw_ccountry_code';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=false;
}
