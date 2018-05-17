<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 */
class Contact extends Model
{
	protected $guarded = array('id');

	protected $fillable = ['name','email','message'];
}
