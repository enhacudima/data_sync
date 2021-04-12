<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserL extends Model
{
    protected $table = 'user_location';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=true;


        public function location()
    {
        return $this->belongsTo('App\CountryStates','location_id','id');
    }


}
