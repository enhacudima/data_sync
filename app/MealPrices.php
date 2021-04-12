<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MealPrices extends Model
{
    protected $table = 'meal_prices';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=true;

        public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }


        public function priceCurrency()
    {
        return $this->belongsTo('App\Currency','currency_id','id');
    }


        public function priceMeal()
    {
        return $this->belongsTo('App\Meals','meal_id','id');
    }
        public function priceStatus()
    {
        return $this->belongsTo('App\StatusName','status','code');
    }

}
