<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SyncUserAllergies extends Model
{
    protected $table = 'sync_user_allergies';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=false;



        public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

}
