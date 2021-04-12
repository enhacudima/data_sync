<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SyncTags extends Model
{
    
    //
    protected $table = 'sync_tags';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $guarded =array();


   /* protected $fillable = [
        'tags_type_id', 'name',
    ];*/


    public function tagName()
    {
        return $this->belongsTo('App\Tags','tag_id','id');
    }
    
    public function mealTags()
    {
        return $this->belongsTo('App\Meals','meal_id','id');
    }
        
    public function chefeTags()
    {
        return $this->belongsTo('App\CV','chefe_id','user_id');
    }  

    public function cuisineID()
    {
        return $this->belongsTo('App\Cuisines','cuisine_id','id');
    }

    
    public function syncTagUser()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

}
