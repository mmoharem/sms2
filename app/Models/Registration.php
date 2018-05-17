<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model {
	use SoftDeletes;

	protected $dates = [ 'deleted_at' ];

	protected $guarded = array ( 'id' );

	public function user() {
		return $this->belongsTo( User::class );
	}

	public function school() {
		return $this->belongsTo( School::class );
	}

	public function student() {
		return $this->belongsTo( Student::class, 'student_id' );
	}

	public function school_year() {
		return $this->belongsTo( SchoolYear::class, 'school_year_id' );
	}

	public function semester() {
		return $this->belongsTo( Semester::class, 'semester_id' );
	}

	public function subject() {
		return $this->belongsTo( Subject::class, 'subject_id' );
	}

	public function level() {
		return $this->belongsTo( Level::class, 'level_id' );
	}

	public function student_group() {
		return $this->belongsTo( StudentGroup::class, 'student_group_id' );
	}
}
