<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CV extends Model
{

    //
    protected $table = 'cv';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $fillable = [
        'user_id', 'title', 'summary','experience','picture','key','status',
    ];


        public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

        public function picture()
    {
        return $this->belongsTo('App\Files','picture','id');
    }

    public function cvExperiences()
    {
        return $this->hasMany('App\CVExperience','user_id','user_id');
    }
        public function cvSchool()
    {
        return $this->hasMany('App\CVSchool','user_id','user_id');
    }
}
