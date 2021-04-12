<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CVContacts extends Model
{
    
    //
    protected $table = 'cv_contact';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $guarded =array();


        public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }


    
}
