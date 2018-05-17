<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealType extends Model
{
	protected $guarded = array('id');

	use SoftDeletes;

	protected $dates = ['deleted_at'];
}
