<?php

namespace App\Repositories;


interface AttendanceRepository
{
    public function getAll();

    public function getAllForStudentsAndSchoolYear($students, $school_year_id);

    public function getAllForSchoolYearAndBetweenDate($school_year_id, $start_date, $end_date);

    public function getAllForSchoolYearSubjectUserAndSemester($school_year_id, $subject_id, $user_id, $semester_id);

    public function getAllForSectionIdAndBetweenDate($section_id, $start_date, $end_date);

    public function getAllForStudentAndOptionAndBetweenDate($student_id, $option_id, $start_date, $end_date);

    public function getAllForStudentGroupAndOptionAndBetweenDate($group_id, $option_id, $start_date, $end_date);

    public function getAllForSectionAndOptionAndBetweenDate($section_id, $option_id, $start_date, $end_date);

	public function getAllForSchoolYearStudents( $school_year_id, $student_user_ids );

	public function getAllForSchoolYearStudentsAndBetweenDate( $school_year_id, $student_user_ids,$start_date, $end_date );

	public function getAllForSchoolYearSubjectUserAndSemesterSum( $school_year_id, $student_user_ids,$start_date,
                                                                $end_date );

    public function getAllForSchoolYearStudentsSum($school_year_id, $student_user_id);

}