<?php

namespace App\Repositories;


interface ApplicantRepository
{
    public function getAll();

    public function getAllForSchool($school_id);

	public function getAllForSchoolYear($school_year_id);

    public function getAllForSchoolSchoolYear($school_id, $school_year_id);

	public function getAllForSchoolWithFilter( $school_id, $school_year_id, $request=null );

	public function create(array $data, $activate = true);

	public function getAllForSchoolSchoolYearAndUser( $school_id, $school_year_id, $user_id );
}