<?php

namespace App\Repositories;

use App\Models\TeacherSubject;

class TeacherSubjectRepositoryEloquent implements TeacherSubjectRepository
{
    /**
     * @var TeacherSubject
     */
    private $model;


    /**
     * TimetableRepositoryEloquent constructor.
     * @param TeacherSubject $model
     */
    public function __construct(TeacherSubject $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForGroup($group_id)
    {
        return $this->model->where('student_group_id', $group_id)
            ->distinct();
    }

    public function getAllForSubjectAndGroup($subject_id, $group_id)
    {
        return $this->model->where('student_group_id', $group_id)
            ->where('subject_id', $subject_id)
            ->distinct();
    }

    public function getAllForSchoolYearAndGroup($school_year_id, $group_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('student_group_id', $group_id)
            ->distinct();
    }

    public function getAllTeacherSubjectsForSchoolYearAndGroup($school_year_id, $student_group_id)
    {
        return $this->model->where('teacher_subjects.school_year_id', $school_year_id)
            ->where('teacher_subjects.student_group_id', $student_group_id);
    }

    public function getAllForSchoolYearAndGroups($school_year_id, $student_group_ids)
    {
        return $this->model->where('teacher_subjects.school_year_id', $school_year_id)
            ->whereIn('teacher_subjects.student_group_id', $student_group_ids);
    }

    public function getAllForSchoolYear($school_year_id)
    {
        return $this->model->where('teacher_subjects.school_year_id', $school_year_id);
    }

    public function getAllForSchoolYearAndGroupAndTeacher($school_year_id, $group_id, $user_id)
    {
        return $this->model->join('subjects', 'subjects.id','=','teacher_subjects.subject_id')
            ->whereNull('subjects.deleted_at')
            ->whereNull('teacher_subjects.deleted_at')
            ->where('teacher_subjects.school_year_id', $school_year_id)
            ->where('teacher_subjects.student_group_id', $group_id)
            ->where('teacher_subjects.teacher_id', $user_id)
            ->select('teacher_subjects.*');
    }

    public function getAllForSchoolYearAndSchool($school_year_id, $school_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('school_id', $school_id)
            ->distinct();
    }

    public function getAllForSchoolYearAndSchoolAndTeacher($school_year_id, $school_id, $user_id)
    {
        return $this->model->join('subjects', 'subjects.id','=','teacher_subjects.subject_id')
            ->whereNull('subjects.deleted_at')
            ->whereNull('teacher_subjects.deleted_at')
            ->where('school_year_id', $school_year_id)
            ->where('school_id', $school_id)
            ->where('teacher_id', $user_id)
            ->distinct('student_group_id');
    }

    public function getAllForSchoolYearAndGroupAndSemester($school_year_id, $group_id, $semester_id)
    {
        return $this->model->join('subjects', 'subjects.id','=','teacher_subjects.subject_id')
            ->join('student_groups', function ($join) {
                $join->on('student_groups.direction_id', '=', 'subjects.direction_id');
                $join->on('student_groups.class', '=', 'subjects.class');
                $join->on('student_groups.id', '=', 'teacher_subjects.student_group_id');
            })
            ->whereNull('subjects.deleted_at')
            ->where('teacher_subjects.school_year_id', $school_year_id)
            ->where('student_groups.id', $group_id)
            ->where(function($w) use ($semester_id){
                $w->where('teacher_subjects.semester_id', $semester_id)
                    ->orWhere('teacher_subjects.semester_id', 0);
            })
            ->select('teacher_subjects.*')
            ->distinct();
    }

    public function getAllForSchoolYearAndSemesterAndGroupAndTeacher($school_year_id, $semester_id, $group_id, $user_id)
    {
        return $this->model->join('subjects', 'subjects.id','=','teacher_subjects.subject_id')
            ->join('student_groups', function ($join) {
                $join->on('student_groups.direction_id', '=', 'subjects.direction_id');
                $join->on('student_groups.class', '=', 'subjects.class');
                $join->on('student_groups.id', '=', 'teacher_subjects.student_group_id');
            })
            ->whereNull('subjects.deleted_at')
            ->whereNull('teacher_subjects.deleted_at')
            ->where('teacher_subjects.school_year_id', $school_year_id)
            ->where(function($w) use ($semester_id){
                $w->where('teacher_subjects.semester_id', $semester_id)
                    ->orWhere('teacher_subjects.semester_id', 0);
            })
            ->where('teacher_subjects.student_group_id', $group_id)
            ->where('teacher_subjects.teacher_id', $user_id)
            ->select('teacher_subjects.*');
    }

    public function getAllForSchoolYearAndSchoolAndTeacherAndSemester($school_year_id, $school_id, $user_id,
                                                                      $semester_id)
    {
        return $this->model->join('subjects', 'subjects.id','=','teacher_subjects.subject_id')
            ->join('student_groups', function ($join) {
                $join->on('student_groups.direction_id', '=', 'subjects.direction_id');
                $join->on('student_groups.class', '=', 'subjects.class');
                $join->on('student_groups.id', '=', 'teacher_subjects.student_group_id');
            })
            ->whereNull('subjects.deleted_at')
            ->whereNull('teacher_subjects.deleted_at')
            ->where('teacher_subjects.school_year_id', $school_year_id)
            ->where('teacher_subjects.school_id', $school_id)
            ->where('teacher_subjects.teacher_id', $user_id)
            ->where(function($w) use ($semester_id){
                $w->where('teacher_subjects.semester_id', $semester_id)
                    ->orWhere('teacher_subjects.semester_id', 0);
            })
            ->distinct('student_group_id');
    }

    public function getAllForSchoolYearAndGroupsAndSemester($school_year_id, $student_group_ids, $semester_id)
    {
        return $this->model->join('subjects', 'subjects.id','=','teacher_subjects.subject_id')
            ->join('student_groups', function ($join) {
                $join->on('student_groups.direction_id', '=', 'subjects.direction_id');
                $join->on('student_groups.class', '=', 'subjects.class');
                $join->on('student_groups.id', '=', 'teacher_subjects.student_group_id');
            })
            ->whereNull('subjects.deleted_at')
            ->where('teacher_subjects.school_year_id', $school_year_id)
            ->whereIn('student_groups.id', $student_group_ids)
            ->where(function($w) use ($semester_id){
                $w->where('teacher_subjects.semester_id', $semester_id)
                    ->orWhere('teacher_subjects.semester_id', 0);
            })
            ->select('teacher_subjects.*');
    }
}