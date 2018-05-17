<?php

namespace App\Repositories;


interface SubjectRepository
{
    public function getAll();

    public function getAllForDirectionAndClass($direction_id, $class);

    public function getAllForDirection($section_id);

    public function getAllForStudentGroup($student_group_id);

    public function getAllStudentsSubjectAndDirection();

    public function getAllStudentsSubjectsTeacher($student_user_id, $school_year_id);

    public function getAllForDirectionAndClassAndSemester($direction_id, $class, $semester_id);

}