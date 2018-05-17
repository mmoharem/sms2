<?php

namespace App\Http\Controllers\Traits;

use App\Models\Message;
use App\Models\School;
use App\Models\SchoolYear;
use DB;
use Efriandika\LaravelSettings\Facades\Settings;
use Sentinel;
use Session;
use Laracasts\Flash\Flash;

trait SharedValuesTrait
{
    use SchoolYearTrait;

    public function shareValues()
    {
        if (isset($this->user->id)) {
	        $new_emails = Message::where('to', $this->user->id)->whereNull('deleted_at_receiver')->where('read', 0)->get();
	        view()->share('new_emails', $new_emails);

	        if ($this->user->inRole('super_admin')
                || $this->user->inRole('human_resources')
                || $this->user->inRole('accountant')
                || $this->user->inRole('librarian')
                || $this->user->inRole('admin_super_admin')
            ) {
                /*
                * if current user is super admin , human resources or accountant
                */
                if ($this->user->inRole('super_admin')
                    || $this->user->inRole('human_resources')
                    || $this->user->inRole('accountant')
                    || $this->user->inRole('admin_super_admin')
                ) {
                    $current_school = session('current_school');
                    if ($this->user->inRole('accountant') && Settings::get('account_one_school') == 'yes') {
                        $result = $this->currentSchoolAccountant($current_school, $this->user->id);
                    } else if ($this->user->inRole('human_resources') && Settings::get('human_resource_one_school') == 'yes') {
                        $result = $this->currentSchoolHumanResources($current_school, $this->user->id);
                    } else if($this->user->inRole('admin_super_admin')) {
                        $result = $this->currentSchoolAdmin($current_school, $this->user->id);
                    }
                    else {
                        $result = $this->currentSchool($current_school);
                    }
                    if ((!isset($result['other_schools']) || count($result['other_schools']) == 0) &&
                        ($this->user->inRole('human_resources') || $this->user->inRole('accountant'))
                    ) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_schools'));

                        return redirect()->guest('/');
                    } else {
                        if ($this->user->inRole('super_admin')){
                            if(School::count() == 0) {
	                            Flash::error( trans( 'secure.create_school' ) );
                            }
	                        if(SchoolYear::count() == 0) {
		                        Flash::error( trans( 'secure.create_school_year' ) );
	                        }
                        }
                        else {
                            $this->setSessionSchool($result);
                        }
                    }
                }
                /*
                 * if current user is admin or human_resources or librarian
                 */
                if ($this->user->inRole('human_resources')
                    || $this->user->inRole('librarian')
                    || $this->user->inRole('accountant')
                    || $this->user->inRole('admin_super_admin')
                ) {
                    $current_school_year = session('current_school_year');
                    $current_school = session('current_school');

                    $result = $this->currentSchoolYear($current_school_year, $current_school);
                    if (!isset($result['other_school_years'])) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_school_year'));

                        return redirect()->guest('/');
                    } else {
                        $this->setSessionSchoolYears($result);
                    }
                }
            }
            /*
             * if current user is admin
             */
            else if ($this->user->inRole('admin')) {

                $current_school = session('current_school');

                $result = $this->currentSchoolAdmin($current_school, $this->user->id);

                if (!isset($result['other_schools']) || count($result['other_schools']) == 0) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.no_schools'));

                    return redirect()->guest('/');
                } else {
                    $this->setSessionSchool($result);
                }

                $current_school_year = session('current_school_year');
                $current_school = session('current_school');

                $result = $this->currentSchoolYear($current_school_year, $current_school);
                if (!isset($result['other_school_years'])) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.no_school_year'));

                    return redirect()->guest('/');
                } else {
                    $this->setSessionSchoolYears($result);
                }
            }
            /*
             * if current user is teacher
             */
            else if ($this->user->inRole('teacher')) {

                    $current_school = session('current_school');

                    $result = $this->currentSchoolTeacher($current_school, $this->user->id);

                    if (!isset($result['other_schools']) || count($result['other_schools']) == 0) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_schools'));

                        return redirect()->guest('/');
                    } else {
                        $this->setSessionSchool($result);
                    }

                    $current_school_year = session('current_school_year');
                    $result_school_years = $this->currentSchoolYearTeacher($current_school_year, $this->user->id);
                    if (!isset($result_school_years['other_school_years']) || count($result_school_years['other_school_years']) == 0) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_school_year'));

                        return redirect()->guest('/');
                    } else {
                        $this->setSessionSchoolYears($result_school_years);
                    }
                    $student_group = session('current_student_group');
                    $current_school_year = session('current_school_year');
                    $current_school = session('current_school');

                    $result_groups = $this->currentTeacherStudentGroupSchool($student_group, $current_school_year, $current_school);
                    if (empty($result_groups['student_groups'])) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_school_year'));
                        return redirect()->guest('/');
                    } else {
                        $this->setSessionTeacherStudentGroups($result_groups);
                    }
                }

                /*
                * if current user is parent
                */
                else if ($this->user->inRole('parent')) {
                    $current_school = session('current_school');

                    $result = $this->currentSchoolParent($current_school, $this->user->id);

                    if (!isset($result['other_schools']) || count($result['other_schools']) == 0) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_schools'));

                        return redirect()->guest('/');
                    } else {
                        $this->setSessionSchool($result);
                    }

                    $current_school_year = session('current_school_year');
                    $student_id = session('current_student_id');
                    $current_school = session('current_school');

                    $result = $this->currentSchoolYearParent($current_school_year, $student_id, $current_school);
                    if (!isset($result['other_school_years']) || count($result['other_school_years']) == 0) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_school_year'));
                        return redirect()->guest('/');
                    } else {
                        $this->setSessionSchoolYears($result);
                    }

                    $current_school_year = session('current_school_year');
                    $student_id = session('current_student_id');

                    $result = $this->currentParentStudents($student_id, $current_school_year, $current_school);

                    if (!isset($result['student_ids'])) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_students_added'));
                        return redirect()->guest('/');
                    } else {
                        $this->setStudentParent($result);
                    }
                }
            /*
             * if current user is student
             */
            else if ($this->user->inRole('student')) {

                $current_school = session('current_school');

                $result = $this->currentSchoolStudent($current_school, $this->user->id);

                if (!isset($result['other_schools'])) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.no_schools'));

                    return redirect()->guest('/');
                } else {
                    $this->setSessionSchool($result);
                }
                $current_school_year = session('current_school_year');
                $result_school_year = $this->currentSchoolYearSchoolStudent($current_school_year, $this->user->id, session('current_school'));

                if (!isset($result_school_year['other_school_years']) || count($result_school_year['other_school_years']) == 0) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.no_school_year'));
                    return redirect()->guest('/');
                } else {
                    $this->setSessionSchoolYears($result_school_year);
                }

                $student_section = session('current_student_section');
                $current_school_year = session('current_school_year');
                $current_school = session('current_school');

                $result_section = $this->currentStudentSectionSchool($student_section, $current_school_year, $current_school);

                if (!isset($result_section['student_section_id']) || $result_section['student_section_id'] == 0) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.no_sections_added'));
                    return redirect()->guest('/');
                } else {
                    $this->setSessionStudentSection($result_section);
                }
            }

            /*
             * if current user is applicant
             */
            else if ($this->user->inRole('applicant')) {

                $current_school = session('current_school');

                $result = $this->currentSchoolApplicant($current_school, $this->user->id);

                if (!isset($result['other_schools'])) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.no_schools'));

                    return redirect()->guest('/');
                } else {
                    $this->setSessionSchool($result);
                }
                $current_school_year = session('current_school_year');
                $current_school = session('current_school');

                $result_school_year = $this->currentSchoolYearSchoolApplicant($current_school_year, $this->user->id, $current_school);
                if (!isset($result_school_year['other_school_years']) || count($result_school_year['other_school_years']) == 0) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.no_school_year'));
                    return redirect()->guest('/');
                } else {
                    $this->setSessionSchoolYears($result_school_year);
                }
            }
        } else {
            return redirect('/signin');
        }
    }
}