<?php

namespace App\Http\Controllers\Secure;

use App\Helpers\CustomFormUserFields;
use App\Helpers\ExcelfileValidator;
use App\Http\Requests\Secure\ImportRequest;
use App\Helpers\Thumbnail;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Session;
use App\Models\Student;
use App\Models\UserDocument;
use App\Repositories\DenominationRepository;
use App\Repositories\DormitoryRepository;
use App\Repositories\ExcelRepository;
use App\Repositories\OptionRepository;
use App\Repositories\SectionRepository;
use App\Repositories\SessionRepository;
use App\Repositories\StudentGroupRepository;
use App\Repositories\StudentRepository;
use App\Repositories\DirectionRepository;
use App\Repositories\LevelRepository;
use App\Repositories\IntakePeriodRepository;
use App\Repositories\EntryModeRepository;
use App\Repositories\CountryRepository;
use App\Repositories\MaritalStatusRepository;
use App\Repositories\ReligionRepository;
use App\Repositories\SchoolYearRepository;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use DB;
use Sentinel;
use App\Http\Requests\Secure\StudentRequest;

class StudentController extends SecureController
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;
    /**
     * @var ExcelRepository
     */
    private $excelRepository;
    /**
     * @var SectionRepository
     */
    private $sectionRepository;
    /**
     * @var DirectionRepository
     */
    private $directionRepository;
    /**
     * @var LevelRepository
     */
    private $levelRepository;
    /**
     * @var IntakePeriodRepository
     */
    private $intakePeriodRepository;
    /**
     * @var EntryModeRepository
     */
    private $entryModeRepository;
    /**
     * @var CountryRepository
     */
    private $countryRepository;
    /**
     * @var MaritalStatusRepository
     */
    private $maritalStatusRepository;
    /**
     * @var ReligionRepository
     */
    private $religionRepository;
    /**
     * @var SchoolYearRepository
     */
    private $schoolYearRepository;
    /**
     * @var SessionRepository
     */
    private $sessionRepository;
    /**
     * @var StudentGroupRepository
     */
    private $studentGroupRepository;
    /**
     * @var DenominationRepository
     */
    private $denominationRepository;
    /**
     * @var DormitoryRepository
     */
    private $dormitoryRepository;

    /**
     * StudentController constructor.
     *
     * @param StudentRepository $studentRepository
     * @param OptionRepository $optionRepository
     * @param ExcelRepository $excelRepository
     * @param LevelRepository $levelRepository
     * @param EntryModeRepository $entryModeRepository
     * @param IntakePeriodRepository $intakePeriodRepository
     * @param CountryRepository $countryRepository
     * @param MaritalStatusRepository $maritalStatusRepository
     * @param ReligionRepository $religionRepository
     * @param DirectionRepository $directionRepository
     * @param SchoolYearRepository $schoolYearRepository
     * @param SessionRepository $sessionRepository
     * @param SectionRepository $sectionRepository
     * @param StudentGroupRepository $studentGroupRepository
     * @param DenominationRepository $denominationRepository
     * @param DormitoryRepository $dormitoryRepository
     */
    public function __construct(
        StudentRepository $studentRepository,
        OptionRepository $optionRepository,
        ExcelRepository $excelRepository,
        LevelRepository $levelRepository,
        EntryModeRepository $entryModeRepository,
        IntakePeriodRepository $intakePeriodRepository,
        CountryRepository $countryRepository,
        MaritalStatusRepository $maritalStatusRepository,
        ReligionRepository $religionRepository,
        DirectionRepository $directionRepository,
        SchoolYearRepository $schoolYearRepository,
        SessionRepository $sessionRepository,
        SectionRepository $sectionRepository,
        StudentGroupRepository $studentGroupRepository,
        DenominationRepository $denominationRepository,
        DormitoryRepository $dormitoryRepository
    )
    {
        parent::__construct();
        $this->studentRepository = $studentRepository;
        $this->optionRepository = $optionRepository;
        $this->excelRepository = $excelRepository;
        $this->sectionRepository = $sectionRepository;
        $this->levelRepository = $levelRepository;
        $this->entryModeRepository = $entryModeRepository;
        $this->intakePeriodRepository = $intakePeriodRepository;
        $this->countryRepository = $countryRepository;
        $this->maritalStatusRepository = $maritalStatusRepository;
        $this->religionRepository = $religionRepository;
        $this->directionRepository = $directionRepository;
        $this->schoolYearRepository = $schoolYearRepository;
        $this->sessionRepository = $sessionRepository;
        $this->studentGroupRepository = $studentGroupRepository;
        $this->denominationRepository = $denominationRepository;
        $this->dormitoryRepository = $dormitoryRepository;

        $this->middleware('authorized:student.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:student.create', [
            'only' => [
                'create',
                'store',
                'getImport',
                'postImport',
                'downloadTemplate'
            ]
        ]);
        $this->middleware('authorized:student.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:student.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'student');

        $columns = ['student_no', 'full_name', 'email', 'session', 'order', 'actions'];
        view()->share('columns', $columns);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('student.student');

        $this->generateParams();

        $sectionsChart = $this->sectionRepository
            ->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->select('title', 'id')
            ->get();

        $maleStudents = $this->studentRepository->getAllMaleForSchoolYearSchool(session('current_school_year'), session('current_school'))->count();
        $femaleStudents = $this->studentRepository->getAllFemaleForSchoolYearSchool(session('current_school_year'), session('current_school'))->count();

        return view('student.index', compact('title', 'sectionsChart', 'maleStudents', 'femaleStudents'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('student.new');
        $this->generateParams();
        $custom_fields = CustomFormUserFields::getCustomUserFields('student');
        return view('layouts.create', compact('title', 'custom_fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StudentRequest $request
     *
     * @return Response
     */
    public function store(StudentRequest $request)
    {
        $user = $this->studentRepository->create($request->except('document', 'document_id', 'image_file'));

        if ($request->hasFile('image_file') != "") {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatar/';
            $file->move($destinationPath, $picture);
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $destinationPath . 'thumb_' . $picture);
            $user->picture = $picture;
            $user->save();
        }

        if ($request->hasFile('document') != "") {
            $file = $request->file('document');
            $extension = $file->getClientOriginalExtension();
            $document = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/documents/';
            $file->move($destinationPath, $document);

            UserDocument::where('user_id', $user->id)->delete();

            $userDocument = new UserDocument;
            $userDocument->user_id = $user->id;
            $userDocument->document = $document;
            $userDocument->option_id = $request->get('document_id');
            $userDocument->save();
        }
        CustomFormUserFields::storeCustomUserField('student', $user->id, $request);

        return redirect('/student');
    }

    /**
     * Display the specified resource.
     *
     * @param Student $student
     *
     * @return Response
     */
    public function show(Student $student)
    {
        $title = trans('student.details');
        $action = 'show';
        $custom_fields = CustomFormUserFields::getCustomUserFieldValues('student', $student->user_id);

        return view('layouts.show', compact('student', 'title', 'action', 'custom_fields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Student $student
     *
     * @return Response
     */
    public function edit(Student $student)
    {
        $title = trans('student.edit');
        $this->generateParams();

        $documents = UserDocument::where('user_id', $student->user->id)->first();
        $custom_fields = CustomFormUserFields::fetchCustomValues('student', $student->user_id);
        $levels = $this->levelRepository->getAllForSection($student->section_id)
            ->pluck('name', 'id');

        $student_groups_select = $this->studentGroupRepository->getAllForSection($student->section_id)
            ->pluck('title', 'id');
        return view('layouts.edit', compact('title', 'student', 'documents', 'custom_fields', 'levels', 'student_groups_select'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StudentRequest $request
     * @param Student $student
     *
     * @return Response
     */
    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->only('section_id', 'order',
            'level_of_adm', 'level_id', 'intake_period_id', 'campus_id'));
        $student->save();
        if ($request->password != "") {
            $student->user->password = bcrypt($request->password);
        }
        if ($request->hasFile('image_file') != "") {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatar/';
            $file->move($destinationPath, $picture);
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $destinationPath . 'thumb_' . $picture);
            $student->user->picture = $picture;
            $student->user->save();
        }

        $student->user->update($request->except('section_id', 'order', 'password', 'document', 'document_id', 'image_file',
            'entry_mode_id', 'country_id', 'marital_status_id', 'no_of_children', 'religion_id', 'denomination',
            'disability', 'contact_relation', 'contact_name', 'contact_address', 'contact_phone',
            'contact_email'));

        if ($request->hasFile('document') != "") {
            $file = $request->file('document');
            $user = $student->user;
            $extension = $file->getClientOriginalExtension();
            $document = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/documents/';
            $file->move($destinationPath, $document);

            UserDocument::where('user_id', $user->id)->delete();

            $userDocument = new UserDocument;
            $userDocument->user_id = $user->id;
            $userDocument->document = $document;
            $userDocument->option_id = $request->document_id;
            $userDocument->save();
        }
        CustomFormUserFields::updateCustomUserField('student', $student->user->id, $request);

        return redirect('/student');
    }

    /**
     * @param Student $student
     *
     * @return Response
     */
    public function delete(Student $student)
    {
        $title = trans('student.delete');
        $custom_fields = CustomFormUserFields::getCustomUserFieldValues('student', $student->user_id);

        return view('/student/delete', compact('student', 'title', 'custom_fields'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Student $student
     *
     * @return Response
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect('/student');
    }

    public function data($first_name = null, $last_name = null, $student_no = null,
                         $country_id = null, $session_id = null, $section_id = null, $level_id = null,
                         $entry_mode_id = null, $gender = null, $marital_status_id = null, $dormitory_id = null)
    {
        $request = ['first_name' => $first_name, 'last_name' => $last_name,
            'student_no' => $student_no, 'session_id' => $session_id, 'country_id' => $country_id,
            'section_id' => $section_id, 'level_id' => $level_id,
            'entry_mode_id' => $entry_mode_id, 'gender' => $gender,
            'marital_status_id' => $marital_status_id, 'dormitory_id' => $dormitory_id];
        $students = $this->studentRepository->getAllForSchoolWithFilter(session('current_school'), session('current_school_year'), $request)
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'student_no' => $student->student_no,
                    'full_name' => $student->full_name,
                    'email' => $student->email,
                    'session' => $student->section,
                    'order' => $student->order,
                    'user_id' => $student->user_id
                ];
            });
        return Datatables::make($students)
            ->addColumn('actions', '@if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'student.edit\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/student/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    <a href="{{ url(\'/report/\' . $user_id . \'/forstudent\' ) }}" class="btn btn-warning btn-sm" >
                                            <i class="fa fa-bar-chart"></i>  {{ trans("table.report") }}</a>
                                    <a href="{{ url(\'/student/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    <a href="{{ url(\'/student_card/\' . $id ) }}" target="_blank" class="btn btn-success btn-sm" >
                                            <i class="fa fa-credit-card"></i>  {{ trans("student.student_card") }}</a>
                                    <a href="{{ url(\'/student/\' . $id.\'/new_student_no\' ) }}" 
                                     class="btn btn-info btn-sm" > <i class="fa fa-refresh"></i>  {{ trans("student.new_student_no") }}</a>
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'student.delete\', Sentinel::getUser()->permissions)))
                                     <a href="{{ url(\'/student/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                      @endif')
            ->removeColumn('id')
            ->removeColumn('user_id')
            ->rawColumns(['actions'])->make();
    }

    public function getImport()
    {
        $title = trans('student.import_student');

        return view('student.import', compact('title'));
    }

    public function postImport(ImportRequest $request)
    {
        $title = trans('student.import_student');

        ExcelfileValidator::validate($request);

        $reader = $this->excelRepository->load($request->file('file'));

        $students = $reader->all()->map(function ($row) {
            return [
                'first_name' => trim($row->first_name),
                'last_name' => trim($row->last_name),
                'email' => trim($row->email),
                'password' => trim($row->password),
                'mobile' => trim($row->mobile),
                'fax' => trim($row->fax),
                'birth_date' => trim($row->birth_date),
                'birth_place' => trim($row->birth_place),
                'address' => trim($row->address),
                'order' => intval($row->order),
                'gender' => intval($row->gender)
            ];
        });

        $sections = $this->sectionRepository
            ->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->get()->map(function ($section) {
                return [
                    'text' => $section->title,
                    'id' => $section->id,
                ];
            })->pluck('text', 'id');

        return view('student.import_list', compact('students', 'sections', 'title'));
    }

    public function finishImport(Request $request)
    {
        foreach ($request->import as $item) {
            $import_data = [
                'first_name' => $request->get('first_name')[$item],
                'last_name' => $request->get('last_name')[$item],
                'email' => $request->get('email')[$item],
                'password' => $request->get('password')[$item],
                'mobile' => $request->get('mobile')[$item],
                'fax' => $request->get('fax')[$item],
                'birth_date' => $request->get('birth_date')[$item],
                'birth_place' => $request->get('birth_place')[$item],
                'address' => $request->get('address')[$item],
                'order' => $request->get('order')[$item],
                'section_id' => $request->get('section_id')[$item],
                'student_group_id' => $request->get('student_group_id')[$item],
                'gender' => $request->get('gender')[$item],
            ];
            $this->studentRepository->create($import_data);
        }

        return redirect('/student');
    }

    public function downloadExcelTemplate()
    {
        return response()->download(base_path('resources/excel-templates/students.xlsx'));
    }

    public function export()
    {
        $students = $this->studentRepository->getAllForSchoolYearAndSchool(session('current_school_year'), session('current_school'))
            ->with('user', 'section')
            ->orderBy('students.order')
            ->get()
            ->map(function ($student) {
                return [
                    'Student No' => $student->student_no,
                    'Section' => isset($student->section) ? $student->section->title : "",
                    'Student Name' => isset($student->user) ? $student->user->full_name : "",
                    'Order' => $student->order,
                    'Student id' => $student->id
                ];
            })->toArray();


        Excel::create(trans('student.student'), function ($excel) use ($students) {
            $excel->sheet(trans('student.student'), function ($sheet) use ($students) {
                $sheet->fromArray($students, null, 'A1', true);
            });
        })->export('csv');
    }

    private function generateParams()
    {
        $sections = $this->sectionRepository
            ->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->get()
            ->pluck('title', 'id');

        $sessions = $this->sessionRepository
            ->getAllForSchool(session('current_school'))
            ->get()
            ->pluck('name', 'id');

        $levels = $this->levelRepository
            ->getAllForSchool(session('current_school'))
            ->get()
            ->pluck('name', 'id');

        $entrymodes = $this->entryModeRepository
            ->getAll()
            ->get()
            ->pluck('name', 'id')
            ->toArray();

        $intakeperiods = $this->intakePeriodRepository
            ->getAllForSchool(session('current_school'))
            ->get()
            ->pluck('name', 'id');

        $dormitories = $this->dormitoryRepository->getAll()
            ->get()
            ->pluck('title', 'id');

        $countries = $this->countryRepository
            ->getAll()
            ->get()
            ->pluck('name', 'id')
            ->toArray();

        $maritalStatus = $this->maritalStatusRepository
            ->getAll()
            ->get()
            ->pluck('name', 'id');

        $religion = $this->religionRepository
            ->getAll()
            ->get()
            ->pluck('name', 'id');

        $denominations = $this->denominationRepository
            ->getAll()
            ->get()
            ->pluck('name', 'id');

        $document_types = $this->optionRepository->getAllForSchool(session('current_school'))
            ->where('category', 'student_document_type')->get()
            ->map(function ($option) {
                return [
                    "title" => $option->title,
                    "value" => $option->id,
                ];
            });
        view()->share('sections', $sections);
        view()->share('sessions', $sessions);
        view()->share('levels', $levels);
        view()->share('entrymodes', $entrymodes);
        view()->share('countries', $countries);
        view()->share('intakeperiods', $intakeperiods);
        view()->share('dormitories', $dormitories);
        view()->share('maritalStatus', $maritalStatus);
        view()->share('religion', $religion);
        view()->share('document_types', $document_types);
        view()->share('denominations', $denominations);
    }

    /**
     * @param Session $session
     * @return \Illuminate\Http\JsonResponse
     */
    function getSectionBySession(Session $session)
    {
        $sections = $this->sectionRepository
            ->getAllForSchoolYearSchoolAndSession(session('current_school_year'), session('current_school'), $session->id)
            ->select('title', 'id')
            ->get();

        return response()->json(['sections' => $sections]);
    }

    /**
     * @param Section $section
     * @return \Illuminate\Http\JsonResponse
     */
    function getLevelsBySection(Section $section)
    {
        $levels = $this->levelRepository->getAllForSection($section->id)
            ->select('name', 'id')
            ->get();

        $student_groups = $this->studentGroupRepository->getAllForSection($section->id)
            ->select('title', 'id')
            ->get();
        return response()->json(['levels' => $levels, 'student_groups' => $student_groups]);
    }

    public function newStudentNo(Student $student)
    {
        $school = School::find(session('current_school'));
        $yearCode = SchoolYear::find(session('current_school_year'));
        $section = Section::find($student->section_id);
        $student->student_no = $school->student_card_prefix . '/' .
            ((isset($section->id_code) && $section->id_code > 0) ? $section->id_code . '/' : "") .
            ((isset($yearCode->id_code) && $yearCode->id_code > 0) ? $yearCode->id_code . '/' : "") .
            $school->next_id_no;
        $student->save();

        $school->next_id_no = $school->next_id_no + 1;
        $school->save();
        return back();
    }
}
