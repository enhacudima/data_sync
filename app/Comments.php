<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    
    //
    protected $table = 'comments';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $fillable = [
        'comment', 'parent_key', 'table_name','file_id','user_id','key','source_id',
    ];

        public function fileComment()
    {
        return $this->belongsTo('App\Files','file_id','id');
    }

        public function userComment()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

        public function repliesComment()
    {
        return $this->hasMany('App\Comments', 'parent_key','key');
    }
}
