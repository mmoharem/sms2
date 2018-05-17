<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportationPassengers extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $guarded = array('id');

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
