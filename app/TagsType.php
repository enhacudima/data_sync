<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagsType extends Model
{
    
    //
    protected $table = 'tags_type';

    public $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable = [
        'tag_type',
    ];

}
