<?php

namespace App\Repositories;


interface UserRepository
{
    public function getAll();

    public function getUsersForRole($role);

    public function getParentsAndStudents();

	public function getAllUsersFromSchool( $school_id, $school_year_id);

	public function getAllAdminAndTeachersForSchool( $school_id );

	public function getAllStudentsParentsUsersFromSchool( $school_id, $school_year_id, $student_group_id );

	public function getAllStudentsAndTeachersForSchoolSchoolYearAndSection( $school_id, $school_year_id, $student_section_id );

    public function getAllStudentsFromGroup( $student_group_id );
}