<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\DeleteRequest;
use App\Http\Requests\Secure\TimetableRequest;
use App\Models\Direction;
use App\Models\Section;
use App\Models\Semester;
use App\Models\StudentGroup;
use App\Models\Subject;
use App\Models\TeacherSubject;
use App\Models\Timetable;
use App\Repositories\SchoolDirectionRepository;
use App\Repositories\SemesterRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TeacherSubjectRepository;
use App\Repositories\TimetablePeriodRepository;
use App\Repositories\TimetableRepository;
use App\Repositories\TeacherSchoolRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Http\Request;
use PDF;
use Sentinel;
use DB;
use App\Http\Requests\Secure\StudentGroupRequest;
use App\Http\Controllers\Traits\TimeTableTrait;

class StudentGroupController extends SecureController
{
    use TimeTableTrait;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var SubjectRepository
     */
    private $subjectRepository;
    /**
     * @var TeacherSchoolRepository
     */
    private $teacherSchoolRepository;
    /**
     * @var TeacherSubjectRepository
     */
    private $teacherSubjectRepository;
    /**
     * @var TimetableRepository
     */
    private $timetableRepository;
    /**
     * @var SchoolDirectionRepository
     */
    private $schoolDirectionRepository;
	/**
	 * @var TimetablePeriodRepository
	 */
	private $timetablePeriodRepository;
    /**
     * @var SemesterRepository
     */
    private $semesterRepository;

    /**
     * StudentGroupController constructor.
     *
     * @param StudentRepository $studentRepository
     * @param SubjectRepository $subjectRepository
     * @param TeacherSchoolRepository $teacherSchoolRepository
     * @param TeacherSubjectRepository $teacherSubjectRepository
     * @param TimetableRepository $timetableRepository
     * @param SchoolDirectionRepository $schoolDirectionRepository
     * @param TimetablePeriodRepository $timetablePeriodRepository
     * @param SemesterRepository $semesterRepository
     */
    public function __construct(StudentRepository $studentRepository,
                                SubjectRepository $subjectRepository,
                                TeacherSchoolRepository $teacherSchoolRepository,
                                TeacherSubjectRepository $teacherSubjectRepository,
                                TimetableRepository $timetableRepository,
                                SchoolDirectionRepository $schoolDirectionRepository,
                                TimetablePeriodRepository $timetablePeriodRepository,
                                SemesterRepository $semesterRepository)
    {
        parent::__construct();

        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;
        $this->teacherSchoolRepository = $teacherSchoolRepository;
        $this->teacherSubjectRepository = $teacherSubjectRepository;
        $this->timetableRepository = $timetableRepository;
        $this->schoolDirectionRepository = $schoolDirectionRepository;
	    $this->timetablePeriodRepository = $timetablePeriodRepository;

        $this->middleware('authorized:student_group.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:student_group.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:student_group.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:student_group.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'studentgroup');
        $this->semesterRepository = $semesterRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Section $section)
    {
        $title = trans('studentgroup.new');
        $directions = $this->schoolDirectionRepository->getAllForSchool(session('current_school'))
                ->with('direction')->get()
                ->pluck('direction.title', 'direction.id')
	            ->prepend(trans('studentgroup.select_direction'), 0)->toArray();
        return view('layouts.create', compact('title', 'directions', 'section'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StudentGroupRequest $request)
    {
        $studentGroup = new StudentGroup($request->all());
        $studentGroup->save();
        return redirect('/section/' . $request->section_id . '/groups');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.details');
        $action = 'show';
        return view('layouts.show', compact('studentGroup', 'title', 'action', 'section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.edit');
        $directions = $this->schoolDirectionRepository->getAllForSchool(session('current_school'))
                ->with('direction')->get()
                ->pluck('direction.title', 'direction.id')
	            ->prepend(trans('studentgroup.select_direction'), 0)
	            ->toArray();
        $class = array();
        $duration = isset($studentGroup->direction->duration) ? $studentGroup->direction->duration : 1;
        for ($i = 1; $i <= $duration; $i++) {
            $class[$i] = $i;
        }
        return view('layouts.edit', compact('title', 'studentGroup', 'section', 'directions', 'class'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(StudentGroupRequest $request, StudentGroup $studentGroup)
    {
        $studentGroup->update($request->all());
        return redirect('/section/' . $request->section_id . '/groups');
    }

    /**
     *
     *
     * @param $website
     * @return Response
     */
    public function delete(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.delete');
        return view('/studentgroup/delete', compact('studentGroup', 'title', 'section'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Section $section, StudentGroup $studentGroup
     * @return Response
     */
    public function destroy(Section $section, StudentGroup $studentGroup)
    {
        $studentGroup->delete();
        return redirect('/section/' . $section->id . '/groups');
    }

    public function students(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.students');
        $students = $this->studentRepository
            ->getAllForSchoolYearAndSection(session('current_school_year'), $studentGroup->section_id)
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->user->full_name,
                ];
            })->pluck('name', 'id')->toArray();

        return view('studentgroup.students', compact('studentGroup', 'title', 'section', 'students'));
    }

    public function addstudents(Section $section, StudentGroup $studentGroup, Request $request)
    {
        if (isset($request['students_select']) && $request['students_select'] != null) {
            $studentGroup->students()->sync($request['students_select']);
        }
        return redirect('/section/' . $section->id . '/groups');
    }

    public function subjects(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.subjects');
        $teacher_subject = array();
        $teachers = $this->teacherSchoolRepository->getAllForSchool(session('current_school'))
            ->map(function ($teacher) {
                return [
                    'id' => $teacher->id,
                    'name' => $teacher->full_name,
                ];
            })->pluck('name', 'id')->toArray();

        if(intval(Settings::get('number_of_semesters')) > 0){
            for($i=1; $i<=intval(Settings::get('number_of_semesters')); $i++) {
                $semesters[$i] = Semester::where('order', $i)
                    ->where(function($w){
                        $w->where('school_id', session('current_school'))->orWhere('school_id', 0);
                    })
                    ->where('school_year_id', session('current_school_year'))
                    ->first();
                $subjects[$i] = $this->subjectRepository
                    ->getAllForDirectionAndClassAndSemester($studentGroup->direction_id, $studentGroup->class, $i)
                    ->orderBy('order')
                    ->get();
                foreach ($subjects[$i] as $item) {
                    $teacher_subject[$i][$item->id] =
                        $this->teacherSubjectRepository->getAllForSubjectAndGroup($item->id, $studentGroup->id)
                            ->get()
                            ->pluck('teacher_id', 'teacher_id');
                }
            }
        }else{
            $subjects[0] = $this->subjectRepository
                ->getAllForDirectionAndClass($studentGroup->direction_id, $studentGroup->class)
                ->orderBy('order')
                ->get();
            foreach ($subjects[0] as $item) {
                $teacher_subject[0][$item->id] =
                    $this->teacherSubjectRepository->getAllForSubjectAndGroup($item->id, $studentGroup->id)
                        ->get()
                        ->pluck('teacher_id','teacher_id');
            }
            $semesters = null;
        }

        return view('studentgroup.subjects', compact('studentGroup', 'title', 'subjects',
            'section', 'teachers', 'teacher_subject','semesters'));
    }

    public function addeditsubject(Subject $subject, StudentGroup $studentGroup, Request $request)
    {
        $this->teacherSubjectRepository->getAllForSubjectAndGroup($subject->id, $studentGroup->id)
            ->delete();

        if (!empty($request['teachers_select'])) {
            foreach ($request['teachers_select'] as $teacher) {
                $teacherSubject = new TeacherSubject;
                $teacherSubject->subject_id = $subject->id;
                $teacherSubject->school_year_id = session('current_school_year');
                $teacherSubject->school_id = session('current_school');
                $teacherSubject->student_group_id = $studentGroup->id;
                $teacherSubject->teacher_id = $teacher;
                $teacherSubject->semester_id = $request->get('semester_id');
                $teacherSubject->save();
            }
        }
    }

    public function timetable(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.timetable');
        $timetablePeriods = $this->timetablePeriodRepository->getAll();
        if(Settings::get('number_of_semesters') > 1){
            for ($i = 1; $i <= intval(Settings::get('number_of_semesters')); $i++) {
                $semesters[$i] = Semester::where('order', $i)
                    ->where(function($w){
                        $w->where('school_id', session('current_school'))->orWhere('school_id', 0);
                    })
                    ->where('school_year_id', session('current_school_year'))
                    ->first();
                if(isset($semesters[$i]->id)) {
                    $subject_list[$i] = $this->teacherSubjectRepository
                        ->getAllForSchoolYearAndGroupAndSemester(session('current_school_year'), $studentGroup->id,
                            $semesters[$i]->id)
                        ->with('teacher', 'subject')
                        ->get()
                        ->filter(function ($teacherSubject) {
                            return (isset($teacherSubject->subject) && isset($teacherSubject->teacher));
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
                    $timetable[$i] = $this->timetableRepository
                        ->getAllForTeacherSubject($subject_list[$i]);
                }
            }
        }else {
            $subject_list[0] = $this->teacherSubjectRepository
                ->getAllForSchoolYearAndGroup(session('current_school_year'), $studentGroup->id)
                ->with('teacher', 'subject')
                ->get()
                ->filter(function ($teacherSubject) {
                    return (isset($teacherSubject->subject) && isset($teacherSubject->teacher));
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
            $timetable[0] = $this->timetableRepository
                ->getAllForTeacherSubject($subject_list[0]);
        }
        return view('studentgroup.timetable', compact('studentGroup', 'timetablePeriods',
	        'title', 'action', 'section', 'subject_list', 'timetable','semesters'));
    }

    public function addtimetable(Section $section, StudentGroup $studentGroup, TimetableRequest $request)
    {
        $timetable = new Timetable($request->all());
        $timetable->save();

        return $timetable->id;
    }

    public function deletetimetable(Section $section, StudentGroup $studentGroup, DeleteRequest $request)
    {
        $timetable = Timetable::find($request['id']);
        $timetable->delete();
    }

    public function getDuration(Request $request)
    {
        $direction = Direction::find($request['direction']);
        return isset($direction->duration) ? $direction->duration : 1;
    }


    public function print_timetable(Section $section, StudentGroup $studentGroup, $semester_id=0)
    {
        $title = trans('studentgroup.timetable');
        if($semester_id == 0) {
            $subject_list = $this->teacherSubjectRepository
                ->getAllForSchoolYearAndGroup(session('current_school_year'), $studentGroup->id)
                ->with('teacher', 'subject')
                ->get()
                ->filter(function ($teacherSubject) {
                    return (isset($teacherSubject->subject) && isset($teacherSubject->teacher));
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
        }else{
            $subject_list = $this->teacherSubjectRepository
                ->getAllForSchoolYearAndGroupAndSemester(session('current_school_year'), $studentGroup->id,$semester_id)
                ->with('teacher', 'subject')
                ->get()
                ->filter(function ($teacherSubject) {
                    return (isset($teacherSubject->subject) && isset($teacherSubject->teacher));
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
        }
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
