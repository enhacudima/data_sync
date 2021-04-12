<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=true;



        public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    
}
