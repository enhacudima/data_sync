<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChefCalendar extends Model
{
    
    protected $table = 'booking_chef_calendar';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $guarded =array();

}
