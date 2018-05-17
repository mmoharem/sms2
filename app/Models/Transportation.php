<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transportation extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function locations()
    {
        return $this->hasMany(TransportationLocation::class);
    }
    public function passengers()
    {
        return $this->hasMany(TransportationPassengers::class);
    }
}
