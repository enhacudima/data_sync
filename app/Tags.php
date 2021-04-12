<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    
    //
    protected $table = 'tags';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $fillable = [
        'tags_type_id', 'name',
    ];


        public function type()
    {
        return $this->belongsTo('App\TagsType','tags_type_id','id');
    }
}
