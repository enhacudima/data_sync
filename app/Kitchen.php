<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    
    //
    protected $table = 'kitchen_details';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $fillable = [
        'type_stove', 'type_power_source', 'back_up_gererator','grill_available','user_id','key','status',
    ];


        public function userKitchen()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
