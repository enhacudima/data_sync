<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SyncMealAllergies extends Model
{
    protected $table = 'sync_meal_allergies';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=true;



        public function allergiesUsers()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    
        public function allergiesSync()
    {
        return $this->belongsTo('App\Allergies','allergies_id','id');
    }

        public function allergiesIngredients()
    {
        return $this->belongsTo('App\Ingredients','ingredients_id','id');
    }
}
