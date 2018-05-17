<?php

namespace App\Repositories;

use App\Models\Scholarship;

class ScholarshipRepositoryEloquent implements ScholarshipRepository
{
    /**
     * @var Scholarship
     */
    private $model;

    /**
     * ScholarshipRepositoryEloquent constructor.
     * @param Scholarship $model
     */
    public function __construct(Scholarship $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForSchoolYearAndSchool($school_year_id, $school_id)
    {
        return $this->model->join('students', 'students.user_id', '=', 'scholarships.user_id')
            ->where('students.school_id', $school_id)
            ->where('students.school_year_id', $school_year_id)
            ->select('scholarships.*');
    }
}