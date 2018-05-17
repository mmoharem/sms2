<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model {
	use SoftDeletes;

	protected $dates = [ 'deleted_at' ];

	protected $guarded = array ( 'id' );

	public function user() {
		return $this->belongsTo( User::class, 'user_id' );
	}

	public function school() {
		return $this->belongsTo( School::class, 'applicant_id' );
	}

	public function section() {
		return $this->belongsTo( Section::class, 'section_id' );
	}

	public function behavior() {
		return $this->belongsToMany( Behavior::class )->withTimestamps();
	}

	public function studentsgroups() {
		return $this->belongsToMany( StudentGroup::class )->withTimestamps();
	}

	public function dormitory() {
		return $this->belongsTo( Dormitory::class, 'dormitory_id' );
	}

	public function school_year() {
		return $this->belongsTo( SchoolYear::class, 'school_year_id' );
	}

	public function admissionlevel() {
		return $this->belongsTo( Level::class, 'level_of_adm', 'id' );
	}
}
