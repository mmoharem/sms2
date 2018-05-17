<?php

namespace App\Repositories;

use App\Models\InvoiceItem;
use App\Models\Option;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\FeeCategory;
use App\Models\Invoice;
use App\Models\Student;
use App\Models\Semester;
use App\Models\StudentGroup;
use App\Models\User;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Session;
use Sentinel;

class StudentRepositoryEloquent implements StudentRepository
{
    /**
     * @var Student
     */
    private $model;


    /**
     * StudentRepositoryEloquent constructor.
     *
     * @param Student $model
     */
    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllMale()
    {
        return $this->model->whereHas('user', function ($query) {
            $query->where('gender', '=', '1');
        });
    }

    public function getAllFeMale()
    {
        return $this->model->whereHas('user', function ($query) {
            $query->where('gender', '=', '0');
        });
    }

    public function getAllForSchoolYearAndSection($school_year_id, $section_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('section_id', $section_id);
    }

    public function getAllForSchoolYear($school_year_id)
    {
        return $this->model->where('school_year_id', $school_year_id)->with('user');
    }

    public function getAllStudentGroupsForStudentUserAndSchoolYear($student_user_id, $school_year_id)
    {
        $studentgroups = new Collection([]);
        $this->model->with('user', 'studentsgroups')
            ->get()
            ->filter(function ($studentItem) use ($student_user_id, $school_year_id) {
                return (isset($studentItem->user) &&
                    $studentItem->user->id == $student_user_id &&
                    $studentItem->school_year_id == $school_year_id);
            })
            ->each(function ($studentItem) use ($studentgroups) {
                foreach ($studentItem->studentsgroups as $studentsgroup) {
                    $studentgroups->push($studentsgroup->id);
                }
            });

        return $studentgroups;
    }

    public function getAllForStudentGroup($student_group_id)
    {
        $studentitems = new Collection([]);
        $this->model->with('user', 'studentsgroups')
            ->orderBy('order')
            ->get()
            ->each(function ($studentItem) use ($studentitems, $student_group_id) {
                foreach ($studentItem->studentsgroups as $studentsgroup) {
                    if ($studentsgroup->id == $student_group_id) {
                        $studentitems->push($studentItem);
                    }
                }
            });

        return $studentitems;
    }

    public function getAllForSchoolYearAndSchool($school_year_id, $school_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('school_id', $school_id);
    }

    public function getAllForSchoolYearSchoolAndSection($school_year_id, $school_id, $section_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('school_id', $school_id)
            ->where('section_id', $section_id);
    }

    public function getSchoolForStudent($student_user_id, $school_year_id)
    {
        return $this->model->whereIn('user_id', $student_user_id)->where('school_year_id', $school_year_id);
    }


    public function create(array $data, $activate = true)
    {
        $user_exists = User::where('email', $data['email'])->first();
        if (!isset($user_exists->id)) {
            $user_tem = Sentinel::registerAndActivate($data, $activate);
            $user = User::find($user_tem->id);
        } else {
            $user = $user_exists;
        }
        try {
            $role = Sentinel::findRoleBySlug('student');
            $role->users()->attach($user);
        } catch (\Exception $e) {
        }
        $user->update([
            'birth_date' => $data['birth_date'],
            'birth_city' => isset($data['birth_city']) ? $data['birth_city'] : "-",
            'gender' => isset($data['gender']) ? $data['gender'] : 0,
            'address' => isset($data['address']) ? $data['address'] : "-",
            'mobile' => isset($data['mobile']) ? $data['mobile'] : 0,
            'phone' => isset($data['phone']) ? $data['phone'] : 0,
            'title' => isset($data['title']) ? $data['title'] : 0,
            'middle_name' => isset($data['middle_name']) ? $data['middle_name'] : '',
            'personal_no' => isset($data['personal_no']) ? $data['personal_no'] : '',
            'country_id' => isset($data['country_id']) ? $data['country_id'] : 0,
            'entry_mode_id' => isset($data['entry_mode_id']) ? $data['entry_mode_id'] : 0,
            'marital_status_id' => isset($data['marital_status_id']) ? $data['marital_status_id'] : 0,
            'no_of_children' => isset($data['no_of_children']) ? $data['no_of_children'] : 0,
            'religion_id' => isset($data['religion_id']) ? $data['religion_id'] : 0,
            'disability' => isset($data['disability']) ? $data['disability'] : "",
            'contact_relation' => isset($data['contact_relation']) ? $data['contact_relation'] : "",
            'contact_name' => isset($data['contact_name']) ? $data['contact_name'] : "",
            'contact_address' => isset($data['contact_address']) ? $data['contact_address'] : "",
            'contact_phone' => isset($data['contact_phone']) ? $data['contact_phone'] : "",
            'contact_email' => isset($data['contact_email']) ? $data['contact_email'] : "",
            'denomination_id' => isset($data['denomination_id']) ? $data['denomination_id'] : 0,
        ]);

        if (is_null(session('current_school')) && Settings::get('multi_school') == 'no' && isset(School::first()->id)) {
            session('current_school', School::first()->id);
        }

        $student = new Student();
        $student->section_id = $data['section_id'];
        $student->order = $data['order'];
        $student->school_year_id = session('current_school_year');
        $student->school_id = session('current_school');
        $student->intake_period_id = isset($data['intake_period_id']) ? $data['intake_period_id'] : 0;
        $student->level_of_adm = isset($data['level_of_adm']) ? $data['level_of_adm'] : 0;
        $student->level_id = isset($data['level_id']) ? $data['level_id'] : 0;
        $student->dormitory_id = isset($data['dormitory_id']) ? $data['dormitory_id'] : 0;
        $student->user_id = $user->id;
        $student->save();

        if (isset($data['student_group_id']) && !is_null($data['student_group_id']) &&
            intval($data['student_group_id']) > 0) {
            $studentGroup = StudentGroup::find($data['student_group_id']);
            $studentGroup->students()->attach($student->id);

            $school = School::find(session('current_school'));
            $yearCode = SchoolYear::find(session('current_school_year'));
            $section = Section::find($data['section_id']);
            $student->student_no = $school->student_card_prefix . '/' .
                ((isset($section->id_code) && $section->id_code>0) ? $section->id_code . '/' : "") .
                ((isset($yearCode->id_code) && $yearCode->id_code>0) ? $yearCode->id_code . '/' : "") .
                $school->next_id_no;
            $student->save();

            $school->next_id_no = $school->next_id_no + 1;
            $school->save();

            if (isset($data['section_id']) && $data['section_id'] != "") {
                $fees = FeeCategory::where('section_id', $data['section_id'])
                    ->where('school_id', session('current_school'))->get();

                if (!is_null($fees) && intval($fees->sum('amount'))>0) {
                    $currentSemester = Semester::where('school_year_id', '=', session('current_school_year'))
                        ->orderBy('id', 'desc')
                        ->first();

                    $currency = Option::where('title', Settings::get('currency'))->where('category', 'currency')->first();

                    $invoice = new Invoice();
                    $invoice->user_id = $user->id;
                    $invoice->school_id = session('current_school');
                    $invoice->school_year_id = session('current_school_year');
                    $invoice->semester_id = isset($currentSemester->id)?$currentSemester->id:0;
                    $invoice->currency_id = isset($currency->id)?$currency->id:0;
                    $invoice->total_fees = $fees->sum('amount');
                    $invoice->amount = $fees->sum('amount');
                    $invoice->save();

                    foreach ($fees as $fee) {
                        InvoiceItem::create([
                            'option_id' => 0,
                            'option_title' => $fee->title,
                            'option_amount' => $fee->amount,
                            'invoice_id' => $invoice->id,
                            'quantity' => 1
                        ]);
                    }
                }
            }
        } else {
            $school = School::find(session('current_school'));
            $yearCode = SchoolYear::find(session('current_school_year'));
            $section = Section::find($data['section_id']);
            $student->student_no = $school->student_card_prefix . '/' .
                ((isset($section->id_code)) ? $section->id_code . '/' : "") .
                ((isset($yearCode->id_code)) ? $yearCode->id_code . '/' : "") .
                $school->next_id_no;
            $student->save();

            $school->next_id_no = $school->next_id_no + 1;
            $school->save();
        }

        return $user;
    }

    public function getAllForSection($section_id)
    {
        $studentitems = new Collection([]);
        $this->model->with('user')
            ->orderBy('order')
            ->get()
            ->each(function ($studentItem) use ($studentitems, $section_id) {
                if ($studentItem->section_id == $section_id && isset($studentItem->user)) {
                    $studentitems->push($studentItem);
                }
            });
        return $studentitems;
    }


    public function getAllForSection2($section_id)
    {
        return $this->model->where('section_id', $section_id);
    }

    public function getAllForSectionCurrency($section_id, $currency_id)
    {
        return $this->model->where('section_id', $section_id)
            ->where('currency_id', $currency_id);
    }

    public function getAllForDirection($direction_id)
    {
        return $this->model->where('direction_id', $direction_id);
    }

    public function getAllForDirectionCurrency($direction_id, $currency_id)
    {
        return $this->model->where('direction_id', $direction_id)
            ->where('currency_id', $currency_id);
    }

    public function getAllForSchoolYearStudents($school_year_id, $student_user_ids)
    {
        $studentItems = new Collection([]);
        $this->model->with('user', 'section')
            ->orderBy('order')
            ->get()
            ->each(function ($studentItem) use ($studentItems, $student_user_ids, $school_year_id) {
                if (in_array($studentItem->user_id, $student_user_ids) &&
                    $studentItem->school_year_id == $school_year_id) {
                    $studentItems->push($studentItem);
                }
            });

        return $studentItems;
    }

    public function getCountStudentsForSchoolAndSchoolYear($school_id, $schoolYearId)
    {
        return $this->model->where('school_id', $school_id)
            ->where('school_year_id', $schoolYearId)
            ->count();
    }

    public function getAllForSchoolWithFilter($school_id, $school_year_id, $request = null)
    {
        $studentItems = new Collection([]);
        $this->model->join('users', 'users.id', '=', 'students.user_id')
            ->join('sections', 'sections.id', '=', 'students.section_id')
            ->leftJoin('levels', 'levels.id', '=', 'students.section_id')
            ->whereNull('users.deleted_at')
            ->whereNull('sections.deleted_at')
            ->where('students.school_id', $school_id)
            ->where('students.school_year_id', $school_year_id)
            ->where(function ($w) use ($request) {
                if (!is_null($request['first_name']) && $request['first_name'] != "*") {
                    $w->where('users.first_name', 'LIKE', '%' . $request['first_name'] . '%');
                }
                if (!is_null($request['last_name']) && $request['last_name'] != "*") {
                    $w->where('users.last_name', 'LIKE', '%' . $request['last_name'] . '%');
                }
                if (!is_null($request['student_no']) && $request['student_no'] != "*") {
                    $w->where('students.student_no', 'LIKE', '%' . $request['student_no'] . '%');
                }
                if (!is_null($request['country_id']) && $request['country_id'] != "*" && $request['country_id'] != "null") {
                    $w->where('users.country_id', $request['country_id']);
                }
                if (!is_null($request['session_id']) && $request['session_id'] != "*" && $request['session_id'] != "null") {
                    $w->where('sections.session_id', $request['session_id']);
                }
                if (!is_null($request['section_id']) && $request['section_id'] != "*" && $request['section_id'] != "null") {
                    $w->where('students.section_id', $request['section_id']);
                }
                if (!is_null($request['level_id']) && $request['level_id'] != "*" && $request['level_id'] != "null") {
                    $w->where('levels.id', $request['level_id']);
                }
                if (!is_null($request['entry_mode_id']) && $request['entry_mode_id'] != "*" && $request['entry_mode_id'] != "null") {
                    $w->where('users.entry_mode_id', $request['entry_mode_id']);
                }
                if (!is_null($request['gender']) && $request['gender'] != "*" && $request['entry_mode_id'] != "null") {
                    $w->where('users.gender', $request['gender']);
                }
                if (!is_null($request['marital_status_id']) && $request['marital_status_id'] != "*" && $request['marital_status_id'] != "null") {
                    $w->where('users.marital_status_id', $request['marital_status_id']);
                }
                if (!is_null($request['dormitory_id']) && $request['dormitory_id'] != "*" && $request['dormitory_id'] != "null") {
                    $w->where('students.dormitory_id', $request['dormitory_id']);
                }
            })->orderBy('order')
            ->select('users.id as user_id', 'students.id as id', 'students.student_no as student_no', 'students.order as order',
                DB::raw('CONCAT(users.first_name, " ", COALESCE(users.middle_name, ""), " ", users.last_name) as full_name'),
                'sections.title as section', 'users.email as email')
            ->get()
            ->each(function ($studentItem) use ($studentItems) {
                $studentItems->push($studentItem);
            });

        return $studentItems;
    }

    public function getAllMaleForSchoolYearSchool($school_id, $school_year_id)
    {
        return $this->model->whereHas('user', function ($query) {
            $query->where('gender', '=', '1');
        })->where('school_id', $school_id)
            ->where('school_year_id', $school_year_id);
    }

    public function getAllFemaleForSchoolYearSchool($school_id, $school_year_id)
    {
        return $this->model->whereHas('user', function ($query) {
            $query->where('gender', '=', '0');
        })->where('school_id', $school_id)
            ->where('school_year_id', $school_year_id);
    }
}