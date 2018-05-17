<?php

namespace App\Repositories;

interface SubjectQuestionRepository
{
	public function getAllForSubjectAndSchool($subject_id, $school_id);
}