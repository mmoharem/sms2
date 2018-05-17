<?php

namespace App\Repositories;

use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class RegistrationRepositoryEloquent implements RegistrationRepository {
	/**
	 * @var Registration
	 */
	private $model;


	/**
	 * RegistrationRepositoryEloquent constructor.
	 *
	 * @param Registration $model
	 */
	public function __construct( Registration $model ) {
		$this->model = $model;
	}

	public function getAll() {
		return $this->model->join( 'students', 'students.id', 'registrations.student_id' )
		                   ->join( 'users', 'users.id', 'registrations.user_id' )
		                   ->leftJoin( 'semesters', 'semesters.id', 'registrations.semester_id' )
		                   ->join( 'school_years', 'school_years.id', 'registrations.school_year_id' )
		                   ->join( 'subjects', 'subjects.id', 'registrations.subject_id' )
		                   ->select( 'registrations.id', 'students.student_no',
			                   DB::raw( 'CONCAT(users.first_name, " ", COALESCE(users.middle_name, ""), " ", users.last_name) as full_name' ),
			                   'semesters.title as semester', 'school_years.title as school_year', 'subjects.title as subject',
			                   'registrations.created_at' );
	}

	public function getAllStudentsForSchool( $school_id ) {
		return $this->model->join( 'students', 'students.id', 'registrations.student_id' )
		                   ->join( 'users', 'users.id', 'registrations.user_id' )
		                   ->leftJoin( 'semesters', 'semesters.id', 'registrations.semester_id' )
		                   ->join( 'school_years', 'school_years.id', 'registrations.school_year_id' )
		                   ->join( 'subjects', 'subjects.id', 'registrations.subject_id' )
		                   ->where( 'registrations.school_id', $school_id )
		                   ->select( 'registrations.id', 'students.student_no',
			                   DB::raw( 'CONCAT(users.first_name, " ", COALESCE(users.middle_name, ""), " ", users.last_name) as full_name' ),
			                   'semesters.title as semester', 'school_years.title as school_year', 'subjects.title as subject',
			                   'registrations.created_at' );
	}


}