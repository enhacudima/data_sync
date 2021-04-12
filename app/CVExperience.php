<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CVExperience extends Model
{
    
    //
    protected $table = 'cv_experience';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $guarded =array();


        public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function country()
    {
        return $this->belongsTo('App\Currency','location_country','id');
    }

    
}
