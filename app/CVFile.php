<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CVFile extends Model
{
    
    //
    protected $table = 'cv_file';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $guarded =array();


        public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function file_type()
    {
        return $this->belongsTo('App\CVFileType','type','id');
    }

    
    public function files()
    {
        return $this->belongsTo('App\Files','file_id','id');
    }
}
