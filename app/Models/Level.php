<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model {
	use SoftDeletes;

	protected $dates = [ 'deleted_at' ];
	protected $guarded = array ( 'id' );
	protected $table = 'levels';

	public function section() {
		return $this->belongsTo( Section::class, 'section_id' );
	}

	public function registrations() {
		return $this->hasMany( Registration::class );
	}
}
