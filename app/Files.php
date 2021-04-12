<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    
    //
    protected $table = 'files';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $fillable = [
        'table', 'mime_type', 'path','source_id','user_id','key','status','name',
    ];


        public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
