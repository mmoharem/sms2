<?php

namespace App\Repositories;


interface ScholarshipRepository
{
    public function getAll();

    public function getAllForSchoolYearAndSchool($school_year_id, $school_id);
}