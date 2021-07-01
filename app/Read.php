<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Meals;
use Illuminate\Support\Facades\Request;

class Read extends Model
{
    protected $table = 'read';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=true;



    public static function make($key)
    {
        return self::firstOrCreate([
            'ip_address' => Request::ip(),
            'pub_key' => $key,
        ]);
    }

    public static function getIP(){
        return Request::ip();
    }

}
