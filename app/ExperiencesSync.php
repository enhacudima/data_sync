<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperiencesSync extends Model
{
    
    //
    protected $table = 'experiences_sync';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $fillable = [
        'experiences_sync_id', 'experiences_id','user_id'
    ];


        public function experiencesSyncUsers()
    {
        return $this->belongsTo('App\User','user_id','id');
    }


        public function experiencesSyncExperiences()
    {
        return $this->belongsTo('App\Experiences','experiences_sync_id','id');
    }
}
