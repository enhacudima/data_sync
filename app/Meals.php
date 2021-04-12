<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meals extends Model
{
    protected $table = 'meals';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=true;



        public function mealUser()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    
    public function mealCuisine()
    {
        return $this->belongsTo('App\Cuisines','cuisine_id','id');
    }

    	public function mealAllergies()
    {
        return $this->hasMany('App\SyncMealAllergies','meal_id','id');
    }

        public function mealtiming()
    {
        return $this->belongsTo('App\CommonTiming','common_timing_id','id');
    }

    	public function mealPrices()
    {
        return $this->hasMany('App\MealPrices','meal_id','id');
    }

        public function mealType()
    {
        return $this->belongsTo('App\MealType','type_meal_id','id');
    }

    	public function mealFiles()
    {
        return $this->hasMany('App\Files','source_id','id')->where('files.table','meals');
    }
    
    public function mealFile()
    {
        return $this->belongsTo('App\Files','id','source_id')->where('files.table','meals');
    }

    	public function mealChefs()
    {
        return $this->hasMany('App\CvChefeV','exy_id','experience_id');
    }

    public function mealTags()
    {
        return $this->hasMany('App\SyncTags','meal_id','id');
    }

    public function mealOptions()
    {
        return $this->hasMany('App\Options','meal_id','id');
    }
}
