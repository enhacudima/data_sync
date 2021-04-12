<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommonTiming extends Model
{
    protected $table = 'common_timing';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=false;
}
