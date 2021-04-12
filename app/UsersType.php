<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersType extends Model
{
    protected $table = 'users_type';

    protected $guarded =array();

    public $primaryKey = 'id';

    public $timestamps=false;
}
