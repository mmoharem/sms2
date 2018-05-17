<?php

namespace App\Repositories;


interface StudentRepository
{
    public function getAll();

    public function getAllMale();

    public function getAllFemale();

    public function getAllForSchoolYearAndSection($school_year_id, $section_id);

    public function getAllForSchoolYear($school_year_id);

    public function getAllStudentGroupsForStudentUserAndSchoolYear($student_user_id, $school_year_id);

    public function getAllForStudentGroup($student_group_id);

    public function getAllForSchoolYearAndSchool($school_year_id, $school_id);

    public function getAllForSchoolYearSchoolAndSection($school_year_id, $school_id, $section_id);

    public function getSchoolForStudent($student_user_id, $school_year_id);

    public function create(array $data, $activate = true);

    public function getAllForSection($section_id);

    public function getAllForSection2($section_id);

    public function getAllForDirection($section_id);

    public function getAllForSectionCurrency($section_id, $currency_id);

    public function getAllForDirectionCurrency($direction_id, $currency_id);

    public function getAllForSchoolYearStudents($school_year_id, $student_user_ids);

	public function getCountStudentsForSchoolAndSchoolYear($school_id,$schoolYearId);

	public function getAllForSchoolWithFilter( $school_id, $school_year_id, $request=null );

    public function getAllMaleForSchoolYearSchool($school_id, $school_year_id);

    public function getAllFemaleForSchoolYearSchool($school_id, $school_year_id);
}