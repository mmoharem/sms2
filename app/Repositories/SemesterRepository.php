<?php

namespace App\Repositories;


interface SemesterRepository
{
    public function getAll();

    public function getAllForSchool($school_id);

    public function getAllForSchoolAndSchoolYear($school_id,$school_year_id);

    public function getAllForSchoolAndSchoolYearForStudent($school_id,$school_year_id,$student_id);

    public function getAllActive();

    public function getActiveForSchoolAndSchoolYear($school_id,$school_year_id);
}