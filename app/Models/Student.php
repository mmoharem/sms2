<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Student extends Model {
	use SoftDeletes;

	protected $dates = [ 'deleted_at' ];

	protected $guarded = array ( 'id' );

	public function user() {
		return $this->belongsTo( User::class, 'user_id' );
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

	public function bed() {
		return $this->hasOne( DormitoryBed::class );
	}

	public function school() {
		return $this->belongsTo( School::class, 'school_id' );
	}

	public function dormitory() {
		return $this->belongsTo( Dormitory::class, 'dormitory_id' );
	}

	public function school_year() {
		return $this->belongsTo( SchoolYear::class, 'school_year_id' );
	}

	public function level() {
		return $this->belongsTo( Level::class, 'level_id', 'id' );
	}

	public function admissionlevel() {
		return $this->belongsTo( Level::class, 'level_of_adm', 'id' );
	}

	public function registration() {
		return $this->hasMany( Registration::class );
	}

	public function currentRegistration() {
		return $this->hasMany( Registration::class )
		            ->where( 'registrations.school_id', '=', session( 'current_school' ) )
		            ->where( 'registrations.school_year_id', '=', session( 'current_school_year' ) );
	}

	public function feesPayments() {
		return $this->hasMany( Payment::class, 'user_id', 'user_id' )
		            ->where( 'registrations.school_id', '=', session( 'current_school' ) )
		            ->where( 'registrations.school_year_id', '=', session( 'current_school_year' ) );
	}

	public function lastPayment() {
		return $this->hasOne( Payment::class, 'user_id', 'user_id' )
		            ->where( 'registrations.school_id', '=', session( 'current_school' ) )
		            ->where( 'registrations.school_year_id', '=', session( 'current_school_year' ) );
	}

	public function intakePeriod() {
		return $this->belongsTo( IntakePeriod::class, 'intake_period_id' );
	}

	public function feesStatus() {
		return $this->hasMany( Invoice::class, 'user_id', 'user_id' )
		            ->where( 'registrations.school_id', '=', session( 'current_school' ) )
		            ->where( 'registrations.school_year_id', '=', session( 'current_school_year' ) );
	}

	public function AllRegistration() {
		return $this->hasMany( Registration::class );
	}

	public function religion() {
		return $this->belongsTo( Religion::class, 'religion_id' );
	}

	public function courses( $level, $semester ) {
		return $this->belongsToMany( Subject::class, 'registrations', 'student_id', 'subject_id' )
		            ->withPivot( 'user_id', 'level_id', 'academic_year_id', 'semester_id', 'grade', 'mid_sem', 'credit', 'exams', 'exam_score' )
		            ->wherePivot( 'level_id', '=', $level )
		            ->wherePivot( 'semester_id', '=', $semester );
	}
}
