<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allergies extends Model
{
    protected $table = 'allergies';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=false;



        public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    
}
