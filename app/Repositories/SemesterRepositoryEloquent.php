<?php

namespace App\Repositories;

use App\Models\Semester;
use Illuminate\Support\Facades\DB;

class SemesterRepositoryEloquent implements SemesterRepository
{
    /**
     * @var Semester
     */
    private $model;


    /**
     * SemesterRepositoryEloquent constructor.
     * @param Semester $model
     */
    public function __construct(Semester $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForSchool($school_id)
    {
        return $this->model->join('school_years', 'school_years.id', '=', 'semesters.school_year_id')
            ->where('semesters.school_id', $school_id)->orWhere('semesters.school_id', 0)
            ->select('semesters.id', DB::raw('CONCAT(school_years.title, " - ", semesters.title) as title'));
    }

    public function getAllForSchoolAndSchoolYear($school_id,$school_year_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where(function($w) use ($school_id){
                $w->where('school_id', $school_id)->orWhere('school_id', 0);
            });
    }

    public function getAllForSchoolAndSchoolYearForStudent($school_id,$school_year_id,$student_id)
    {
        return $this->model->join('students', 'students.school_year_id', '=', 'semesters.school_year_id')
            ->where('semesters.school_year_id', $school_year_id)
            ->where('students.id', $student_id)
            ->where(function($w) use ($school_id){
                $w->where('semesters.school_id', $school_id)->orWhere('semesters.school_id', 0);
            })->select('semesters.*');
    }

    public function getAllActive()
    {
        return $this->model->where('active', 1);
    }

    public function getActiveForSchoolAndSchoolYear($school_id,$school_year_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('active', 1)
            ->where(function($w) use ($school_id){
                $w->where('semesters.school_id', $school_id)->orWhere('semesters.school_id', 0);
            })->first();
    }
}