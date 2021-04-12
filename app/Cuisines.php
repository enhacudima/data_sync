<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuisines extends Model
{
    
    //
    protected $table = 'cuisines';

    public $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable = [
        'name',
    ];

    
        public function pictureCuisines()
    {
        return $this->belongsTo('App\Files','file_id','id');
    }

}
