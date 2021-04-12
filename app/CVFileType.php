<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CVFileType extends Model
{
    
    //
    protected $table = 'cv_file_type';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $guarded =array();


        public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function fileType()
    {
        return $this->belongsTo('App\CVFileType','type','id');
    }

    
}
