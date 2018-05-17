<?php

namespace App\Repositories;


interface SectionRepository
{
    public function getAll();

    public function getAllForSchoolYear($school_year_id);

    public function getAllForSchoolYearSchool($school_year_id, $school_id);

	public function getAllForSchoolYearSchoolAndHeadTeacher( $school_year_id, $school_id, $user_id );

	public function getAllForSchoolYearSchoolAndSession( $school_year_id, $school_id, $session_id );

	public function getAllSession( $session_id );
}