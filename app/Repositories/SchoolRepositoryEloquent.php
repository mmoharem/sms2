<?php

namespace App\Repositories;

use App\Models\School;
use Sentinel;

class SchoolRepositoryEloquent implements SchoolRepository {
	/**
	 * @var School
	 */
	private $model;


	/**
	 * SchoolRepositoryEloquent constructor.
	 *
	 * @param School $model
	 */
	public function __construct( School $model ) {
		$this->model = $model;
	}

	public function getAll() {
		return $this->model
			->select( 'schools.*' );
	}

	public function getAllAdmin() {
		return $this->model->join( 'school_admins', 'schools.id', '=', 'school_admins.school_id' )
		                   ->where( 'school_admins.user_id', Sentinel::getUser()->id )
		                   ->where( 'schools.active', 1 )
		                   ->distinct()
		                   ->select( 'schools.*' );
	}

	public function getAllTeacher() {
		return $this->model->join( 'teacher_subjects', 'schools.id', '=', 'teacher_subjects.school_id' )
		                   ->where( 'teacher_subjects.teacher_id', Sentinel::getUser()->id )
		                   ->where( 'schools.active', 1 )
		                   ->distinct()
		                   ->select( 'schools.*' );
	}

	public function getAllStudent() {
		return $this->model->join( 'sections', 'schools.id', '=', 'sections.school_id' )
		                   ->join( 'students', 'students.section_id', '=', 'sections.id' )
		                   ->where( 'schools.active', 1 )
		                   ->where( 'students.user_id', Sentinel::getUser()->id )
		                   ->distinct()
		                   ->select( 'schools.*' );
	}

	public function getAllAluministudents( $school_id, $schoolYearId ) {
		return $this->model->join( 'sections', 'schools.id', '=', 'sections.school_id' )
		                   ->join( 'student_groups', 'student_groups.section_id', '=', 'sections.id' )
		                   ->join( 'directions', function ( $join ) {
			                   $join->on( 'student_groups.direction_id', '=', 'directions.id' );
			                   $join->on( 'directions.duration', '=', 'student_groups.class' );
		                   } )
		                   ->join( 'student_student_group', 'student_student_group.student_group_id', '=', 'student_groups.id' )
		                   ->where( 'schools.active', 1 )
		                   ->where( 'schools.id', $school_id )
		                   ->where( 'sections.school_year_id', $schoolYearId )
		                   ->distinct()
		                   ->select( 'student_student_group.student_id' );
	}

	public function getAllCanApply() {
		return $this->model->where('can_apply', 1)
			->select( 'schools.*' );
	}

	public function getAllApplicant() {
		return $this->model->join( 'applicants', 'schools.id', '=', 'applicants.school_id' )
		                   ->where( 'applicants.user_id', Sentinel::getUser()->id )
		                   ->where( 'schools.active', 1 )
		                   ->distinct()
		                   ->select( 'schools.*' );
	}
}