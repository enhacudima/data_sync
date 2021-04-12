<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingSyncMeal extends Model
{
    protected $table = 'booking_sync_meal';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=true;



        public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    
}
