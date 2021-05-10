<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanStatus extends Model
{
    use HasFactory;

    protected $table = 'plan_status';

    public $primaryKey = 'id';

    public $timestamps=true;

    protected $fillable = [
        'status',
    ];
}
