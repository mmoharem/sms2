<?php

namespace App\Repositories;

use App\Models\SubjectQuestion;

class SubjectQuestionRepositoryEloquent implements SubjectQuestionRepository {
	/**
	 * @var SubjectQuestion
	 */
	private $model;

	/**
	 * SubjectQuestionRepository constructor.
	 *
	 * @param SubjectQuestion $model
	 */
	public function __construct( SubjectQuestion $model ) {
		$this->model = $model;
	}

	public function getAllForSubjectAndSchool( $subject_id, $school_id ) {
		return $this->model->where( 'subject_id', $subject_id )
		                   ->where( 'school_id', $school_id );
	}
}