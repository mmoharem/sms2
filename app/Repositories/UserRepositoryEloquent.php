<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepositoryEloquent implements UserRepository
{
    /**
     * @var User
     */
    private $model;


    /**
     * UserRepositoryEloquent constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getUsersForRole($role)
    {
        $users = new Collection([]);
        if($role == 'admin' || $role == 'admin_super_admin'){
            $this->model->with('school_admin', 'school_admin.school')->get()
                ->each(function ($user) use ($users) {
                    $users->push($user);
                });
        }else {
            $this->model->get()->each(function ($user) use ($users) {
                $users->push($user);
            });
        }
        $users = $users->filter(function ($user) use ($role) {
            return $user->inRole($role);
        });
        return $users;
    }

    public function getParentsAndStudents()
    {
        $users = new Collection([]);
        $this->model->with('student_parent.students')
            ->get()
            ->each(function ($user) use ($users) {
                $users->push($user);
            });
        $users = $users->filter(function ($user) {
            return $user->inRole('parent');
        });
        return $users;
    }

	public function getAllUsersFromSchool( $school_id, $school_year_id ) {
		$users = new Collection([]);
		$this->model->join('students','students.user_id', '=', 'users.id')
		           	->where('students.school_id', $school_id)
					->where('students.school_year_id', $school_year_id)
					->whereNull('students.deleted_at')
					->distinct()
					->select('users.*')
		            ->get()
		            ->each(function ($user) use ($users) {
			            $users->push($user);
		            });

		$this->model->join('teacher_schools','teacher_schools.user_id', '=', 'users.id')
		            ->where('teacher_schools.school_id', $school_id)
		            ->whereNull('teacher_schools.deleted_at')
		            ->distinct()
		            ->select('users.*')
		            ->get()
		            ->each(function ($user) use ($users) {
			            $users->push($user);
		            });

		$this->model->join('students','students.user_id', '=', 'users.id')
		            ->join('parent_students','parent_students.user_id_student', '=', 'users.id')
		            ->join('users as a','parent_students.user_id_parent', '=', 'a.id')
		            ->where('students.school_id', $school_id)
		            ->where('students.school_year_id', $school_year_id)
		            ->whereNull('students.deleted_at')
		            ->distinct()
		            ->select('a.*')
		            ->get()
		            ->each(function ($user) use ($users) {
			            $users->push($user);
		            });
		$this->model->join('school_admins','school_admins.user_id', '=', 'users.id')
		            ->where('school_admins.school_id', $school_id)
		            ->whereNull('school_admins.deleted_at')
		            ->distinct()
		            ->select('users.*')
		            ->get()
		            ->each(function ($user) use ($users) {
			            $users->push($user);
		            });
		return $users;
	}

	public function getAllAdminAndTeachersForSchool( $school_id ) {
			$users = new Collection([]);
			$this->model->leftJoin('school_admins','school_admins.user_id', '=', 'users.id')
			            ->where('school_admins.school_id', $school_id)
			            ->distinct()
			            ->select('users.*')
			            ->get()
			            ->each(function ($user) use ($users) {
				            $users->push($user);
			            });

			$this->model->leftJoin('teacher_schools','teacher_schools.user_id', '=', 'users.id')
			            ->where('teacher_schools.school_id', $school_id)
			            ->distinct()
			            ->select('users.*')
			            ->get()
			            ->each(function ($user) use ($users) {
				            $users->push($user);
			            });
			return $users;
	}

	public function getAllStudentsParentsUsersFromSchool( $school_id, $school_year_id, $student_group_id ) {
		$users = new Collection([]);
		$this->model->join('students','students.user_id', '=', 'users.id')
					->join('student_student_group','student_student_group.student_id', '=', 'students.id')
		            ->where('students.school_id', $school_id)
		            ->where('students.school_year_id', $school_year_id)
		            ->where('student_student_group.student_group_id', $student_group_id)
		            ->whereNull('students.deleted_at')
		            ->whereNull('student_student_group.deleted_at')
		            ->distinct()
		            ->select('users.*')
		            ->get()
		            ->each(function ($user) use ($users) {
			            $users->push($user);
		            });

		$this->model->join('teacher_schools','teacher_schools.user_id', '=', 'users.id')
					->join('teacher_subjects','teacher_subjects.teacher_id', '=', 'users.id')
		            ->where('teacher_schools.school_id', $school_id)
		            ->where('teacher_subjects.school_year_id', $school_year_id)
		            ->where('teacher_subjects.student_group_id', $student_group_id)
		            ->whereNull('teacher_schools.deleted_at')
		            ->distinct()
		            ->select('users.*')
		            ->get()
		            ->each(function ($user) use ($users) {
			            $users->push($user);
		            });

		$this->model->join('students','students.user_id', '=', 'users.id')
		            ->join('parent_students','parent_students.user_id_student', '=', 'users.id')
		            ->join('users as a','parent_students.user_id_parent', '=', 'a.id')
					->join('student_student_group','student_student_group.student_id', '=', 'students.id')
					->where('students.school_id', $school_id)
					->where('students.school_year_id', $school_year_id)
					->where('student_student_group.student_group_id', $student_group_id)
					->whereNull('students.deleted_at')
					->whereNull('student_student_group.deleted_at')
		            ->distinct()
		            ->select('a.*')
		            ->get()
		            ->each(function ($user) use ($users) {
			            $users->push($user);
		            });
		$this->model->join('school_admins','school_admins.user_id', '=', 'users.id')
		            ->where('school_admins.school_id', $school_id)
		            ->whereNull('school_admins.deleted_at')
		            ->distinct()
		            ->select('users.*')
		            ->get()
		            ->each(function ($user) use ($users) {
			            $users->push($user);
		            });
		return $users;
	}

	public function getAllStudentsAndTeachersForSchoolSchoolYearAndSection( $school_id, $school_year_id, $student_section_id ) {
		$users = new Collection([]);
		$this->model->join('students','students.user_id', '=', 'users.id')
		            ->where('students.school_id', $school_id)
		            ->where('students.school_year_id', $school_year_id)
		            ->where('students.section_id', $student_section_id)
		            ->whereNull('students.deleted_at')
		            ->distinct()
		            ->select('users.*')
		            ->get()
		            ->each(function ($user) use ($users) {
			            $users->push($user);
		            });

		$this->model->join('teacher_schools','teacher_schools.user_id', '=', 'users.id')
		            ->join('teacher_subjects','teacher_subjects.teacher_id', '=', 'users.id')
		            ->join('student_groups','student_groups.id', '=', 'teacher_subjects.student_group_id')
		            ->where('teacher_schools.school_id', $school_id)
		            ->where('teacher_subjects.school_year_id', $school_year_id)
		            ->where('student_groups.section_id', $student_section_id)
		            ->whereNull('teacher_schools.deleted_at')
		            ->distinct()
		            ->select('users.*')
		            ->get()
		            ->each(function ($user) use ($users) {
			            $users->push($user);
		            });
		return $users;
	}

    public function getAllStudentsFromGroup($student_group_id)
    {
        $users = new Collection([]);
        $this->model->join('students','students.user_id', '=', 'users.id')
            ->join('student_student_group','student_student_group.student_id', '=', 'students.id')
            ->where('student_student_group.student_group_id', $student_group_id)
            ->whereNull('students.deleted_at')
            ->whereNull('student_student_group.deleted_at')
            ->distinct()
            ->select('users.id')
            ->get()
            ->each(function ($user) use ($users) {
                $users->push($user);
            });
        return $users;
    }
}