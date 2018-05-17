<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\DeleteRequest;
use App\Http\Requests\Secure\TimetableRequest;
use App\Models\StudentGroup;
use App\Models\Timetable;
use App\Repositories\SemesterRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherSubjectRepository;
use App\Repositories\TimetablePeriodRepository;
use App\Repositories\TimetableRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Collection;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Traits\TimeTableTrait;

class TeacherGroupController extends SecureController
{
    use TimeTableTrait;
    /**
     * @var TimetableRepository
     */
    private $timetableRepository;
    /**
     * @var TeacherSubjectRepository
     */
    private $teacherSubjectRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
	/**
	 * @var TimetablePeriodRepository
	 */
	private $timetablePeriodRepository;
    /**
     * @var SemesterRepository
     */
    private $semesterRepository;

    /**
     * TeacherGroupController constructor.
     *
     * @param TimetableRepository $timetableRepository
     * @param TeacherSubjectRepository $teacherSubjectRepository
     * @param StudentRepository $studentRepository
     * @param TimetablePeriodRepository $timetablePeriodRepository
     * @param SemesterRepository $semesterRepository
     */
    public function __construct(TimetableRepository $timetableRepository,
                                TeacherSubjectRepository $teacherSubjectRepository,
                                StudentRepository $studentRepository,
	                            TimetablePeriodRepository $timetablePeriodRepository,
	                            SemesterRepository $semesterRepository)
    {
        parent::__construct();

        $this->timetableRepository = $timetableRepository;
        $this->teacherSubjectRepository = $teacherSubjectRepository;
        $this->studentRepository = $studentRepository;
	    $this->timetablePeriodRepository = $timetablePeriodRepository;
        $this->semesterRepository = $semesterRepository;

        view()->share('type', 'teachergroup');

        $columns = ['title','direction','class', 'actions'];
        view()->share('columns', $columns);
    }

    /**
     * Display the specified resource.
     *
     * @param  StudentGroup $studentGroup
     * @return Response
     */
    public function show(StudentGroup $studentGroup)
    {
        $title = trans('teachergroup.details');
        $action = 'show';
        return view('teachergroup.show', compact('studentGroup', 'title', 'action'));
    }

    public function index()
    {
        $title = trans('teachergroup.mygroups');
        return view('teachergroup.mygroup', compact('title'));
    }

    public function data()
    {
        $studentGroups = $this->teacherSubjectRepository->getAllForSchoolYearAndSchoolAndTeacher(session('current_school_year'), session('current_school'),$this->user->id)
            ->get()
            ->map(function ($teacherSubject) {
                return [
                    'id' => $teacherSubject->student_group->id,
                    'title' => $teacherSubject->student_group->title,
                    'direction' => isset($teacherSubject->student_group->direction->title) ? $teacherSubject->student_group->direction->title : "",
                    "class" => $teacherSubject->student_group->class,
                ];
            });
        return Datatables::make( $studentGroups->toBase()->unique())
            ->addColumn('actions', '<a href="{{ url(\'/teachergroup/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @if(Settings::get(\'teacher_can_add_students\')==\'yes\')
                                    <a href="{{ url(\'/teachergroup/\' . $id . \'/students\' ) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-users"></i> {{ trans("section.students") }}</a>
                                    @endif
                                    <a href="{{ url(\'/teachergroup/\' . $id . \'/generate_csv\' ) }}" class="btn btn-info btn-sm" >
                                            <i class="fa fa-file-excel-o"></i>  {{ trans("section.generate_csv") }}</a>
                                     <a href="{{ url(\'/teachergroup/\' . $id . \'/grouptimetable\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-calendar"></i>  {{ trans("teachergroup.timetable") }}</a>')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }
    public function generateCsvStudentsGroup(StudentGroup $studentGroup){

        $students = $this->studentRepository->getAllForStudentGroup($studentGroup->id)
            ->map(function ($student) {
                return [
                    'Order No.' => $student->order,
                    'First name' => $student->user->first_name,
                    'Last name' => $student->user->last_name,
                ];
            })->toArray();
        Excel::create(trans('section.students'), function($excel) use ($students){
            $excel->sheet(trans('section.students'), function($sheet) use ($students) {
                $sheet->fromArray($students, null, 'A1', true);
            });
        })->export('csv');
    }

    public function students(StudentGroup $studentGroup)
    {
        $title = trans('teachergroup.students');
        $students_added = $this->studentRepository->getAllForStudentGroup($studentGroup->id)->pluck('id')->all();
        $students = $this->studentRepository->getAllForSchoolYear(session('current_school_year'))
            ->get()
            ->filter(function($student){
                return isset($student->user);
            })
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->user->full_name
                ];
            })
            ->pluck('name', 'id')->toArray();
        return view('teachergroup.students', compact('studentGroup', 'title', 'section', 'students', 'students_added'));
    }

    public function addstudents(StudentGroup $studentGroup, Request $request)
    {
        $studentGroup->students()->sync($request['students_select']);
        return redirect('/teachergroup');
    }

    public function grouptimetable(StudentGroup $studentGroup)
    {
        $title = trans('teachergroup.timetable');

        $school_year_id = session('current_school_year');
        $school_id = session('current_school');
        $semester = $this->semesterRepository->getActiveForSchoolAndSchoolYear($school_id,$school_year_id);
        if(isset($semester) && Settings::get('number_of_semesters') > 1){
            $semester_id = $semester->id;
            $subject_list = $this->teacherSubjectRepository->getAllForSchoolYearAndSemesterAndGroupAndTeacher
            ($school_year_id, $semester_id, $studentGroup->id, $this->user->id)
                ->get()
                ->map(function ($teacherSubject) {
                    return [
                        'id' => $teacherSubject->id,
                        'title' => isset($teacherSubject->subject) ? $teacherSubject->subject->title : "",
                        'subject_short_name' => isset($teacherSubject->subject) ?
                            $teacherSubject->subject->short_name : "",
                        'subject_room' => isset($teacherSubject->subject) ? $teacherSubject->subject->room : "",
                        'name' => isset($teacherSubject->teacher) ? $teacherSubject->teacher->full_name : "",
                        'teacher_short_name' => isset($teacherSubject->teacher) ? $teacherSubject->teacher->short_name :
                            "",
                    ];
                });
        }else {
            $semester_id = 0;
            $subject_list = $this->teacherSubjectRepository->getAllForSchoolYearAndGroupAndTeacher($school_year_id, $studentGroup->id, $this->user->id)
                ->get()
                ->map(function ($teacherSubject) {
                    return [
                        'id' => $teacherSubject->id,
                        'title' => isset($teacherSubject->subject) ? $teacherSubject->subject->title : "",
                        'subject_short_name' => isset($teacherSubject->subject) ?
                            $teacherSubject->subject->short_name : "",
                        'subject_room' => isset($teacherSubject->subject) ? $teacherSubject->subject->room : "",
                        'name' => isset($teacherSubject->teacher) ? $teacherSubject->teacher->full_name : "",
                        'teacher_short_name' => isset($teacherSubject->teacher) ? $teacherSubject->teacher->short_name :
                            "",
                    ];
                });
        }
        $timetable = $this->timetableRepository
            ->getAllForTeacherSubject($subject_list);

	    $timetablePeriods = $this->timetablePeriodRepository->getAll();
        return view('teachergroup.timetable', compact('studentGroup', 'semester_id',
            'timetablePeriods', 'title', 'section', 'subject_list', 'timetable'));
    }

    public function addtimetable(TimetableRequest $request)
    {
        $timetable = new Timetable($request->all());
        $timetable->save();

        return $timetable->id;
    }

    public function deletetimetable(DeleteRequest $request)
    {
        $timetable = Timetable::find($request['id']);
        if (!is_null($timetable)) {
            $timetable->delete();
        }
    }

    public function timetable()
    {
        $title = trans('teachergroup.timetable');

        $school_year_id = session('current_school_year');
        $school_id = session('current_school');
        $semester = $this->semesterRepository->getActiveForSchoolAndSchoolYear($school_id,$school_year_id);
        if(isset($semester) && Settings::get('number_of_semesters') > 1){
            $semester_id = $semester->id;
        }else{
            $semester_id = 0;
        }
        $studentgroups = new Collection([]);
        $studentGroupsList = $this->teacherSubjectRepository->getAllForSchoolYearAndSchoolAndTeacherAndSemester
        (session('current_school_year'), session('current_school'),$this->user->id,$semester_id)
            ->get();

        foreach ($studentGroupsList as $items) {
            $studentgroups->push($items['id']);
        }

        $subject_list = $this->teacherSubjectRepository
            ->getAllForSchoolYearAndGroupsAndSemester($school_year_id, $studentgroups,$semester_id)
            ->with('teacher', 'subject')
            ->get()
            ->filter(function ($teacherSubject) {
                return (isset($teacherSubject->subject) &&
                    $teacherSubject->teacher_id == $this->user->id &&
                    isset($teacherSubject->teacher));
            })
            ->map(function ($teacherSubject) {
                return [
                    'id' => $teacherSubject->id,
                    'title' => isset($teacherSubject->subject) ? $teacherSubject->subject->title : "",
                    'subject_short_name' => isset($teacherSubject->subject) ?
                        $teacherSubject->subject->short_name : "",
                    'subject_room' => isset($teacherSubject->subject) ? $teacherSubject->subject->room : "",
                    'name' => isset($teacherSubject->teacher) ? $teacherSubject->teacher->full_name : "",
                    'teacher_short_name' => isset($teacherSubject->teacher) ? $teacherSubject->teacher->short_name :
                        "",
                ];
            });
        $timetable = $this->timetableRepository
            ->getAllForTeacherSubject($subject_list);
	    $timetablePeriods = $this->timetablePeriodRepository->getAll();

        return view('teachergroup.timetable', compact('title', 'action', 'subject_list',
	        'timetable','timetablePeriods','semester_id'));
    }

    public function print_timetable()
    {
        $title = trans('teachergroup.timetable');

        $school_year_id = session('current_school_year');
        $school_id = session('current_school');
        $semester = $this->semesterRepository->getActiveForSchoolAndSchoolYear($school_id,$school_year_id);
        if(isset($semester) && Settings::get('number_of_semesters') > 1){
            $semester_id = $semester->id;
            $semester_order = $semester->order;
        }else{
            $semester_id = 0;
            $semester_order = 0;
        }
        $studentgroups = new Collection([]);
        $studentGroupsList = $this->teacherSubjectRepository->getAllForSchoolYearAndSchoolAndTeacherAndSemester
        (session('current_school_year'), session('current_school'),$this->user->id,$semester_id)
            ->get()
            ->map(function ($studentGroup) {
                return [
                    'id' => $studentGroup->student_group->id,
                    'title' => $studentGroup->student_group->title,
                    'direction' => isset($studentGroup->student_group->direction->title) ? $studentGroup->student_group->direction->title : "",
                    "class" => $studentGroup->student_group->class,
                ];
            })->toBase()->unique();
        foreach ($studentGroupsList as $items) {
            $studentgroups->push($items['id']);
        }
        $subject_list = $this->teacherSubjectRepository
            ->getAllForSchoolYearAndGroupsAndSemester($school_year_id, $studentgroups,$semester_order)
            ->with('teacher', 'subject')
            ->get()
            ->filter(function ($teacherSubject) {
                return (isset($teacherSubject->subject) &&
                    $teacherSubject->teacher_id == $this->user->id &&
                    isset($teacherSubject->teacher));
            })
            ->map(function ($teacherSubject) {
                return [
                    'id' => $teacherSubject->id,
                    'title' => isset($teacherSubject->subject) ? $teacherSubject->subject->title : "",
                    'subject_short_name' => isset($teacherSubject->subject) ?
                        $teacherSubject->subject->short_name : "",
                    'subject_room' => isset($teacherSubject->subject) ? $teacherSubject->subject->room : "",
                    'name' => isset($teacherSubject->teacher) ? $teacherSubject->teacher->full_name : "",
                    'teacher_short_name' => isset($teacherSubject->teacher) ? $teacherSubject->teacher->short_name :
                        "",
                ];
            });
        $timetable = $this->timetableRepository
            ->getAllForTeacherSubject($subject_list);

	    $timetablePeriods = $this->timetablePeriodRepository->getAll();

        $data = '<h1>' . $title . '</h1>
				<table style="border: double" class="table-bordered">
					<tbody>
					<tr>
						<th>#</th>
						<th width="14%">' . trans('teachergroup.monday') . '</th>
						<th width="14%">' . trans('teachergroup.tuesday') . '</th>
						<th width="14%">' . trans('teachergroup.wednesday') . '</th>
						<th width="14%">' . trans('teachergroup.thursday') . '</th>
						<th width="14%">' . trans('teachergroup.friday') . '</th>
                        <th width="14%">' . trans('teachergroup.saturday') . '</th>
                        <th width="14%">' . trans('teachergroup.sunday') . '</th>
					</tr>';
	    if($timetablePeriods->count() >0 ){
            foreach($timetablePeriods as $timetablePeriod){
			    $data .= '<tr>
            <td>' . $timetablePeriod->start_at.' - '. $timetablePeriod->end_at . '</td>';
			    for ( $j = 1; $j < 8; $j ++ ) {
				    $data .= '<td>';
				    if($timetablePeriod->title==""){
					    foreach ( $timetable as $item ) {
						    if ( $item['week_day'] == $j && $item['hour'] == $timetablePeriod->id ) {
                                $data .= '<div>
                            <span>' . ((strlen($item['subject_short_name'])>2)?$item['subject_short_name']:$item['title']) . '</span>
                            <br>
                            <span>' . ((strlen($item['teacher_short_name'])>2)
                                        ?$item['teacher_short_name']:$item['name']) . '</span></div>';
						    }
					    }
				    }else{
					    $data .=$timetablePeriod->title;
				    }
				    $data .= '</td>';
			    }
			    $data .= '</tr>';
		    }
	    }
        else {
	        for ( $i = 1; $i < 8; $i ++ ) {
		        $data .= '<tr>
            <td>' . $i . '</td>';
		        for ( $j = 1; $j < 8; $j ++ ) {
			        $data .= '<td>';
			        foreach ( $timetable as $item ) {
				        if ( $item['week_day'] == $j && $item['hour'] == $i ) {
                            $data .= '<div>
                            <span>' . ((strlen($item['subject_short_name'])>2)?$item['subject_short_name']:$item['title']) . '</span>
                            <br>
                            <span>' . ((strlen($item['teacher_short_name'])>2)
                                    ?$item['teacher_short_name']:$item['name']) . '</span></div>';
				        }
			        }
			        $data .= '</td>';
		        }
		        $data .= '</tr>';
	        }
        }
        $data .= '</tbody>
				</table>';
        $pdf = PDF::loadView('report.timetable', compact('data'));
        return $pdf->stream();
    }

}
