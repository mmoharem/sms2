<?php

namespace App\Repositories;


interface MarkRepository
{
    public function getAll();

    public function getAllForSchoolYearAndBetweenDate($school_year_id, $date_start, $date_end);

    public function getAllForSchoolYearAndExam($school_year_id, $exam_id);

    public function getAllForSchoolYearSubjectUserAndSemester($school_year_id, $subject_id, $user_id, $semester_id);

    public function getAllForSchoolYearStudents( $school_year_id, $student_user_ids );

    public function getAllForExam( $exam_id );

	public function getAllForSchoolYearStudentsAndBetweenDate( $school_year_id, $student_user_ids, $start_date, $end_date );

	public function getAllForSchoolYearStudentsSubject( $school_year_id, $student_user_ids, $subject_id );

    public function getAllForSchoolYearSemesterStudents( $school_year_id, $semester_id, $student_user_ids );
}