<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\ReportRequest;
use App\Models\Exam;
use App\Models\MarkValue;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use App\Repositories\AttendanceRepository;
use App\Repositories\BehaviorRepository;
use App\Repositories\BookRepository;
use App\Repositories\BookUserRepository;
use App\Repositories\ExamRepository;
use App\Repositories\MarkRepository;
use App\Repositories\NoticeRepository;
use App\Repositories\OnlineExamRepository;
use App\Repositories\OptionRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\SemesterRepository;
use App\Repositories\StudentFinalMarkRepository;
use App\Repositories\StudentGroupRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PDF;

class ReportController extends SecureController
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var ExamRepository
     */
    private $examRepository;
    /**
     * @var StudentGroupRepository
     */
    private $studentGroupRepository;
    /**
     * @var AttendanceRepository
     */
    private $attendanceRepository;
    /**
     * @var MarkRepository
     */
    private $markRepository;
    /**
     * @var BehaviorRepository
     */
    private $behaviorRepository;
    /**
     * @var BookRepository
     */
    private $bookRepository;
    /**
     * @var BookUserRepository
     */
    private $bookUserRepository;
    /**
     * @var NoticeRepository
     */
    private $noticeRepository;
    /**
     * @var SemesterRepository
     */
    private $semesterRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;
    /**
     * @var StudentFinalMarkRepository
     */
    private $studentFinalMarkRepository;
    /**
     * @var SubjectRepository
     */
    private $subjectRepository;
    /**
     * @var SchoolRepository
     */
    private $schoolRepository;
    /**
     * @var OnlineExamRepository
     */
    private $onlineExamRepository;

    /**
     * ReportController constructor.
     * @param StudentRepository $studentRepository
     * @param ExamRepository $examRepository
     * @param StudentGroupRepository $studentGroupRepository
     * @param AttendanceRepository $attendanceRepository
     * @param MarkRepository $markRepository
     * @param BehaviorRepository $behaviorRepository
     * @param BookRepository $bookRepository
     * @param BookUserRepository $bookUserRepository
     * @param NoticeRepository $noticeRepository
     * @param SemesterRepository $semesterRepository
     * @param OptionRepository $optionRepository
     * @param StudentFinalMarkRepository $studentFinalMarkRepository
     * @param SubjectRepository $subjectRepository
     * @param SchoolRepository $schoolRepository
     * @param OnlineExamRepository $onlineExamRepository
     */
    public function __construct(StudentRepository $studentRepository,
                                ExamRepository $examRepository,
                                StudentGroupRepository $studentGroupRepository,
                                AttendanceRepository $attendanceRepository,
                                MarkRepository $markRepository,
                                BehaviorRepository $behaviorRepository,
                                BookRepository $bookRepository,
                                BookUserRepository $bookUserRepository,
                                NoticeRepository $noticeRepository,
                                SemesterRepository $semesterRepository,
                                OptionRepository $optionRepository,
                                StudentFinalMarkRepository $studentFinalMarkRepository,
                                SubjectRepository $subjectRepository,
                                SchoolRepository $schoolRepository,
                                OnlineExamRepository $onlineExamRepository)
    {
        parent::__construct();

        $this->studentRepository = $studentRepository;
        $this->examRepository = $examRepository;
        $this->studentGroupRepository = $studentGroupRepository;
        $this->attendanceRepository = $attendanceRepository;
        $this->markRepository = $markRepository;
        $this->behaviorRepository = $behaviorRepository;
        $this->bookRepository = $bookRepository;
        $this->bookUserRepository = $bookUserRepository;
        $this->noticeRepository = $noticeRepository;
        $this->semesterRepository = $semesterRepository;
        $this->optionRepository = $optionRepository;
        $this->studentFinalMarkRepository = $studentFinalMarkRepository;
        $this->subjectRepository = $subjectRepository;
        $this->schoolRepository = $schoolRepository;
        $this->onlineExamRepository = $onlineExamRepository;

        ini_set("memory_limit", "-1");
        set_time_limit(1000000);

        view()->share('type', 'report');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('report.report');
        $exams = array();
        if ($this->user->inRole('teacher')) {
            $students = $this->studentRepository->getAllForStudentGroup(session('current_student_group'))
                ->map(function ($student) {
                    return [
                        'id' => $student->user_id,
                        'name' => $student->user->full_name
                    ];
                })
                ->pluck('name', 'id')->toArray();

            $exams = $this->examRepository->getAllForGroup(session('current_student_group'))
                ->with('subject')
                ->get()
                ->filter(function ($exam) {
                    return isset($exam->subject);
                })
                ->map(function ($exam) {
                    return [
                        'id' => $exam->id,
                        'name' => $exam->title . ' ' . $exam->subject->title,
                    ];
                })->pluck('name', 'id')->toArray();
        }
        if ($this->user->inRole('admin')) {
            $students = $this->studentRepository->getAllForSchoolYearAndSchool(session('current_school_year'), session('current_school'))
                ->get()
                ->map(function ($student) {
                    return [
                        'id' => $student->user_id,
                        'name' => $student->user->full_name
                    ];
                })
                ->pluck('name', 'id')->toArray();

            $exams = $this->examRepository->getAll()
                ->with('subject', 'student_group')
                ->get()
                ->filter(function ($exam) {
                    return ($exam->parent_id == 0);
                })
                ->map(function ($exam) {
                    return [
                        'id' => $exam->id,
                        'name' => $exam->title,
                    ];
                })->pluck('name', 'id')->toArray();
        }
        $start_date = $end_date = date('d.m.Y.');
        $report_type = $this->optionRepository->getAllForSchool(session('current_school'))
            ->where('category', 'report_type')->get()
            ->filter(function($option){
                if($option->value == 'list_average_marks_all_subjects') {
                    if ($this->user->inRole('admin') || $this->user->inRole('admin_school_admin')){
                        return true;
                    }else{
                        return false;
                    }
                }
                return true;
            })
            ->map(function ($option) {
                return [
                    "title" => $option->title,
                    "value" => $option->value,
                ];
            })->pluck('title', 'value')->toArray();
        return view('report.index', compact('title', 'students', 'start_date', 'end_date', 'exams', 'report_type'));
    }


    public function student(User $user)
    {
        $title = trans('report.report');
        $students = array();

        $students[$user->id] = $user->full_name;
        $student = Student::where('user_id', $user->id)
            ->where('school_year_id', session('current_school_year'))
            ->first();

        $student_groups = new Collection([]);
        $stGroups = array();
        $this->studentGroupRepository->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->with('students')
            ->get()
            ->each(function ($group) use ($student, $student_groups) {
                foreach ($group->students as $student_item) {
                    if ($student_item->id == $student->id) {
                        $student_groups->push($group);
                    }
                }
            });
        foreach ($student_groups as $group) {
            $stGroups[] = $group->id;
        }

        $exams = $this->examRepository->getAll()
            ->with('subject', 'student_group')
            ->whereIn('student_group_id', $stGroups)
            ->get()
            ->filter(function ($exam) use ($student) {
                return isset($exam->subject);
            })
            ->map(function ($exam) {
                return [
                    'id' => $exam->id,
                    'name' => $exam->title . ' - ' . $exam->subject->title,
                ];
            })->pluck('name', 'id')->toArray();

        $start_date = $end_date = date('d.m.Y.');
        $report_type = $this->optionRepository->getAllForSchool(session('current_school'))
            ->where('category', 'report_type')->get()
            ->filter(function($option){
                if($option->value == 'list_average_marks_all_subjects') {
                    if ($this->user->inRole('admin') || $this->user->inRole('admin_school_admin')){
                        return true;
                    }else{
                        return false;
                    }
                }
                return true;
            })
            ->map(function ($option) {
                return [
                    "title" => $option->title,
                    "value" => $option->value,
                ];
            })->pluck('title', 'value')->toArray();
        return view('report.index', compact('title', 'students', 'start_date', 'end_date', 'exams', 'report_type'));
    }

    public function create(ReportRequest $request)
    {
        switch ($request->report_type) {
            case 'list_attendances':
                return $this->getListOfAttendances($request);
                break;
            case 'list_marks':
                return $this->getListOfMarks($request);
                break;
            case 'list_behaviors':
                return $this->getListOfBehaviors($request);
                break;
            case 'list_exam_marks':
                return $this->getListOfExamMarks($request);
                break;
            case 'student_cards':
                return $this->getStudentCard($request);
                break;
            case 'list_average_marks_all_subjects':
                return $this->getAverageMarksAllSubjects($request);
                break;
            default:
                return null;
                break;
        }
    }

    private function getListOfAttendances($request)
    {
        $document_html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <html>
                    <head>
                        <style>
                        table {
                            border-collapse: collapse;
                             width:100%;
                        }

                        table, td, th {
                            border: 1px solid #000000;
                            text-align:center;
                            vertical-align:middle;
                        }
						.page-break {
							page-break-after: always;
						}
                        </style>
                        <title>' . trans('report.list_attendances') . '</title>
                    </head>
                    <body>
                ';
        $student_user_ids = $request->get('student_id', []);

        $students = $this->studentRepository->getAllForSchoolYearStudents(session('current_school_year'), $student_user_ids)
            ->map(function ($student) {
                return [
                    'user_id' => $student->user_id,
                    'name' => $student->user->full_name,
                    'order' => $student->order,
                    'section' => isset($student->section) ? $student->section->title : "",
                    'student_no' => $student->student_no,
                ];
            })
            ->toArray();

        $attendances = $this->attendanceRepository
            ->getAllForSchoolYearStudentsAndBetweenDate(session('current_school_year'),
                $student_user_ids,
                $request->get('start_date'), $request->get('end_date'))
            ->map(function ($attendance) {
                return [
                    'date' => Carbon::createFromFormat(Settings::get('date_format'), $attendance->date)->toDateString(),
                    'attendance_type' => $attendance->option->title,
                    'attendance_id' => $attendance->option->id,
                    'subject_id' => $attendance->subject_id,
                    'user_id' => $attendance->student->user_id,
                    'student_id' => $attendance->student_id,
                    'hours' => $attendance->hours,
                ];
            })->toArray();

        $school = School::find(session('current_school'));
        foreach ($students as $student) {
            $document_html .= '<table><tr>
				<td>
					<img src="' . url("uploads/site/thumb_" . Settings::get("logo")) . '" style="margin-right:0px;"/>
					' . $school->title . '
				</td>
				<td>
                	<b>' . $student['name'] . '</b><br>
					' . trans('diary.date') . ': ' . Carbon::now()->format(Settings::get("date_format")) . '<br>'
                . trans('report.list_attendances') . ': ' . $request['start_date'] . ' - ' . $request['end_date'] . '
				</td>
				<td>
					' . trans('visitor_student_card.student_no') . ': ' . $student['student_no'] . '<br>
					' . trans('attendances_by_subject.section') . ': ' . $student['section'] . '<br>
					' . trans('student.order') . ': ' . $student['order'] . '
				</td>
				</tr>
				</table><br>
				<table>
					<thead><tr>
						<td>' . trans('report.sum') . '</td>
						<td>' . trans('report.percentage') . '</td>
						<td>' . trans('report.attendance_type') . '</td>
						</tr>
					</thead>
					<tbody>';
            $sum_attendance = $this->attendanceRepository
                ->getAllForSchoolYearStudentsSum(session('current_school_year'), $student['user_id'])
                ->map(function ($attendance) {
                    return [
                        'sum' => $attendance->sum,
                        'attendance_type' => $attendance->attendance_type,
                    ];
                })->toArray();
            $total_sum = 0;
            foreach ($sum_attendance as $item) {
                $total_sum += $item['sum'];
            }
            foreach ($sum_attendance as $id => $item) {
                $sum_attendance[$id]['percentage'] = round((($item['sum'] / $total_sum) * 100), 2);
            }
            foreach ($sum_attendance as $item) {
                $document_html .= '<tr><td>' . $item['sum'] . '</td><td>' . $item['percentage'] .
                    '</td><td>' . $item['attendance_type'] . '</td></tr>';
            }
            $document_html .= '</tbody></table><br>
				<table>
					<thead><tr>
						<td>' . trans('report.date') . '</td>
						<td>' . trans('report.hours') . '</td>
						</tr>
					</thead>
					<tbody>';

            $student_attendances = [];
            $student_att_dates = [];
            foreach ($attendances as $item) {
                if ($item['user_id'] == $student['user_id']) {
                    if (!in_array($item['date'], $student_att_dates)) {
                        $student_att_dates[$item['date']] = $item['date'];
                    }
                    $student_attendances[$item['date']][] = [
                        'date' => $item['date'],
                        'hours' => $item['hours'],
                        'attendance_type' => $item['attendance_type']
                    ];
                }
            }
            foreach ($student_att_dates as $key => $date) {
                $document_html .= '<tr>
						<td>' . $date . '<td>';
                foreach ($student_attendances[$key] as $att) {
                    $document_html .= $att['hours'] . ' - ' . $att['attendance_type'] . '<br>';
                }
                $document_html .= '</td>
						</tr>';
            }
            $document_html .= '</tbody>
				</table>
				<div class="page-break"></div>';
        }
        $document_html .= '</body></html>';

        $pdf = PDF::loadHTML($document_html);
        return $pdf->stream();
    }

    private function getListOfMarks($request)
    {
        $document_html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <html>
                    <head>
                        <style>
                        table {
                            border-collapse: collapse;
                             width:100%;
                        }

                        table, td, th {
                            border: 1px solid #000000;
                            text-align:center;
                            vertical-align:middle;
                        }
						.page-break {
							page-break-after: always;
						}
                        </style>
                        <title>' . trans('report.list_marks') . '</title>
                    </head>
                    <body>
                ';
        $student_user_ids = $request->get('student_id', []);

        $students = $this->studentRepository->getAllForSchoolYearStudents(session('current_school_year'), $student_user_ids)
            ->map(function ($student) {
                return [
                    'user_id' => $student->user_id,
                    'name' => $student->user->full_name,
                    'order' => $student->order,
                    'section' => isset($student->section) ? $student->section->title : "",
                    'student_no' => $student->student_no,
                ];
            })
            ->toArray();
        $marks = $this->markRepository
            ->getAllForSchoolYearStudentsAndBetweenDate(session('current_school_year'), $student_user_ids,
                $request->get('start_date'), $request->get('end_date'))
            ->map(function ($mark) {
                return [
                    'date' => Carbon::createFromFormat(Settings::get('date_format'), $mark->date)->toDateString(),
                    'mark_type' => isset($mark->mark_type) ? $mark->mark_type->title : '',
                    'mark_value' => isset($mark->mark_value) ? $mark->mark_value->grade : '',
                    'mark_percent' => isset($mark->mark_value) ? $mark->mark_percent : '',
                    'subject' => isset($mark->subject) ? $mark->subject->title : '',
                    'subject_highest_mark' => isset($mark->subject) ? $mark->subject->highest_mark : '',
                    'subject_lowest_mark' => isset($mark->subject) ? $mark->subject->lowest_mark : '',
                    'subject_id' => $mark->subject_id,
                    'user_id' => $mark->student->user_id,
                    'student_id' => $mark->student_id,
                ];
            })->toArray();

        $school = School::find(session('current_school'));

        foreach ($students as $student) {
            $document_html .= '<table><tr>
				<td>
					<img src="' . url("uploads/site/thumb_" . Settings::get("logo")) . '" style="margin-right:0px;"/>
					' . $school->title . '
				</td>
				<td>
                	<b>' . $student['name'] . '</b><br>
					' . trans('diary.date') . ': ' . Carbon::now()->format(Settings::get("date_format")) . '<br>
					' . trans('report.list_marks') . ': ' . $request['start_date'] . ' - ' . $request['end_date'] . '
				</td>
				<td>
					' . trans('visitor_student_card.student_no') . ': ' . $student['student_no'] . '<br>
					' . trans('attendances_by_subject.section') . ': ' . $student['section'] . '<br>
					' . trans('student.order') . ': ' . $student['order'] . '
				</td>
				</tr>
				</table>
				<table>
					<thead><tr>
						<td>' . trans('report.subject') . '</td>
						<td>' . trans('report.marks') . '</td>
						</tr>
					</thead>
					<tbody>';

            $student_marks = [];
            $student_subjects = [];
            $student_subjects_ids = [];

            foreach ($marks as $item) {
                if ($item['user_id'] == $student['user_id']) {
                    if (!in_array($item['subject_id'], $student_subjects_ids)) {
                        $student_subjects_ids[$item['subject_id']] = $item['subject_id'];
                        $student_subjects[$item['subject_id']] = [
                            'subject' => $item['subject'],
                            'subject_highest_mark' => $item['subject_highest_mark'],
                        ];
                    }
                    $student_marks[$item['subject_id']][] = [
                        'date' => $item['date'],
                        'mark_type' => $item['mark_type'],
                        'mark_value' => $item['mark_value'],
                        'mark_percent' => $item['mark_percent']
                    ];
                }
            }
            foreach ($student_subjects as $key => $subject) {
                $document_html .= '<tr>
					<td>' . $subject['subject'] .
                    (($subject['subject_highest_mark'] != "") ? ' (' . $subject['subject_highest_mark'] . ')' : "") . '<td>';
                foreach ($student_marks[$key] as $mark) {
                    $document_html .= $mark['date'] . ' - ' . $mark['mark_value'] .
                        ((!is_null($mark['mark_percent'])) ? ' (' . $mark['mark_percent'] . ')' : "")
                        . ' - ' . $mark['mark_type'] . '<br>';
                }
                $document_html .= '</td>
					</tr>';
            }
            $document_html .= '</tbody>
				</table>
				<div class="page-break"></div>';
        }

        $document_html .= '</body></html>';

        $pdf = PDF::loadHTML($document_html);
        return $pdf->stream();
    }

    private function getListOfExamMarks($request)
    {
        $document_html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <html>
                    <head>
                        <style>
                        table {
                            border-collapse: collapse;
                             width:100%;
                        }

                        table, td, th {
                            border: 1px solid #000000;
                            text-align:center;
                            vertical-align:middle;
                        }
						.page-break {
							page-break-after: always;
						}
                        </style>
                        <title>' . trans('report.list_marks_exam') . '</title>
                    </head>
                    <body>
                ';
        $student_user_ids = $request->get('student_id', []);

        $students = $this->studentRepository->getAllForSchoolYearStudents(session('current_school_year'), $student_user_ids)
            ->map(function ($student) {
                return [
                    'user_id' => $student->user_id,
                    'name' => $student->user->full_name,
                    'order' => $student->order,
                    'section' => isset($student->section) ? $student->section->title : "",
                    'student_no' => $student->student_no,
                ];
            })
            ->toArray();
        $marks = $this->markRepository->getAllForExam($request->get('exam_id'))
            ->map(function ($mark) {
                return [
                    'date' => Carbon::createFromFormat(Settings::get('date_format'), $mark->date)->toDateString(),
                    'mark_type' => isset($mark->mark_type) ? $mark->mark_type->title : '',
                    'mark_value' => isset($mark->mark_value) ? $mark->mark_value->grade : '',
                    'mark_percent' => isset($mark->mark_value) ? $mark->mark_percent : '',
                    'subject' => isset($mark->subject) ? $mark->subject->title : '',
                    'subject_highest_mark' => isset($mark->subject) ? $mark->subject->highest_mark : '',
                    'subject_lowest_mark' => isset($mark->subject) ? $mark->subject->lowest_mark : '',
                    'subject_id' => $mark->subject_id,
                    'user_id' => $mark->student->user_id,
                    'student_id' => $mark->student_id,
                ];
            })->toArray();

        $school = School::find(session('current_school'));
        $exam = Exam::find($request->get('exam_id'));

        foreach ($students as $student) {
            $document_html .= '<table><tr>
				<td>
					<img src="' . url("uploads/site/thumb_" . Settings::get("logo")) . '" style="margin-right:0px;"/>
					' . $school->title . '
				</td>
				<td>
                	<b>' . $student['name'] . '</b><br>
					' . trans('diary.date') . ': ' . Carbon::now()->format(Settings::get("date_format")) . '<br>
					' . trans('report.list_marks_exam') . ': ' . $exam->title . '
				</td>
				<td>
					' . trans('visitor_student_card.student_no') . ': ' . $student['student_no'] . '<br>
					' . trans('attendances_by_subject.section') . ': ' . $student['section'] . '<br>
					' . trans('student.order') . ': ' . $student['order'] . '
				</td>
				</tr>
				</table>
				<table>
					<thead><tr>
						<td>' . trans('report.subject') . '</td>
						<td>' . trans('report.obtained_marks') . '</td>
						<td>' . trans('report.highest_mark') . '</td>
						<td>' . trans('report.grade') . '</td>
						</tr>
					</thead>
					<tbody>';

            $student_marks = [];
            $student_subjects = [];
            $student_subjects_ids = [];

            foreach ($marks as $item) {
                if ($item['user_id'] == $student['user_id']) {
                    if (!in_array($item['subject_id'], $student_subjects_ids)) {
                        $student_subjects_ids[$item['subject_id']] = $item['subject_id'];
                        $student_subjects[$item['subject_id']] = [
                            'subject' => $item['subject'],
                            'subject_highest_mark' => $item['subject_highest_mark'],
                            'subject_lowest_mark' => $item['subject_lowest_mark'],
                        ];
                    }
                    $student_marks[$item['subject_id']][] = [
                        'date' => $item['date'],
                        'mark_value' => $item['mark_value'],
                        'mark_percent' => $item['mark_percent']
                    ];
                }
            }
            $sum_marks = 0;
            $sum_highest_marks = 0;
            $lower_mark = false;
            foreach ($student_subjects as $key => $subject) {
                $document_html .= '<tr>
						<td>' . $subject['subject'] . '<td>';
                foreach ($student_marks[$key] as $mark) {
                    $sum_marks += $mark['mark_percent'];
                    $lower_mark = (!$lower_mark && $mark['mark_percent'] < $subject['subject_lowest_mark']);
                    $document_html .= ((!is_null($mark['mark_percent'])) ? $mark['mark_percent'] : "100") . '<br>';
                }
                $sum_highest_marks += $subject['subject_highest_mark'];
                $document_html .= '</td><td>' . $subject['subject_highest_mark'] . '</td><td>';
                foreach ($student_marks[$key] as $mark) {
                    $document_html .= $mark['mark_value'] . '<br>';
                }
                $document_html .= '</td>
						</tr>';
            }
            $document_html .= '<tr>
						<td>' . trans('report.overall_grade') . '</td>
						<td>' . $sum_marks . '</td>
						<td>' . $sum_highest_marks . '</td>
						<td>' . (($lower_mark || $sum_highest_marks == 0) ? ' ' : round(($sum_marks / $sum_highest_marks) * 100, 2)) . '</td>
						</tr>
						</tbody>
				</table>
				<br>
				<p>' . trans('report.principal_signature') . ': ____________________________________</p>
				<p>' . trans('report.teacher_signature') . ': ____________________________________</p>
				<p>' . trans('report.guardian_signature') . ': ____________________________________</p>
				<div class="page-break"></div>';
        }
        $document_html .= '</body></html>';

        $pdf = PDF::loadHTML($document_html);
        return $pdf->stream();

    }

    private function getListOfBehaviors($request)
    {
        $behaviours = new Collection([]);
        $this->behaviorRepository->getAll()
            ->with('students', 'students.user')
            ->get()
            ->each(function ($behaviourItem) use ($request, $behaviours) {
                foreach ($request->student_id as $student_user_id) {
                    if (isset($behaviourItem->students)) {
                        foreach ($behaviourItem->students as $studentItem) {
                            if ($student_user_id == $studentItem->user_id &&
                                $studentItem->school_year_id == session('current_school_year')
                            ) {
                                $behaviours->push($behaviourItem);
                            }
                        }
                    }
                }
            });
        $behaviours = $behaviours
            ->map(function ($behaviour) {
                return [
                    'behaviour' => $behaviour->title,
                    'name' => isset($behaviour->students->first()->user->full_name) ?
                        $behaviour->students->first()->user->full_name : "",
                    'student_no' => isset($behaviour->students->first()->student_no) ?
                        $behaviour->students->first()->student_no : "",
                    'order' => isset($behaviour->students->first()->order) ?
                        $behaviour->students->first()->order : "",
                ];
            });
        $school = School::find(session('current_school'));
        $document_html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <html>
                    <head>
                        <style>
                        table {
                            border-collapse: collapse;
                             width:100%;
                        }

                        table, td, th {
                            border: 1px solid #000000;
                            text-align:center;
                            vertical-align:middle;
                        }
						.page-break {
							page-break-after: always;
						}
                        </style>
                        <title>' . trans('report.behaviours') . '</title>
                    </head>
                    <body>
                    <table><tr>
				<td>
					<img src="' . url("uploads/site/thumb_" . Settings::get("logo")) . '" style="margin-right:0px;"/>
					' . $school->title . '
				</td>
				<td>
                	' . trans('diary.date') . ': ' . Carbon::now()->format(Settings::get("date_format")) . '<br>
					' . trans('report.behaviours') . '
				</td>
				</tr>
				</table>
				<table>
					<thead><tr>
						<td>' . trans('report.order') . '</td>
						<td>' . trans('report.student_no') . '</td>
						<td>' . trans('report.student') . '</td>
						<td>' . trans('report.behaviour') . '</td>
						</tr>
					</thead>
					<tbody>';
        foreach ($behaviours as $item) {
            $document_html .= '<tr>
                            <td>' . $item['order'] . '</td>
                            <td>' . $item['student_no'] . '</td>
                            <td>' . $item['name'] . '</td>
                            <td>' . $item['behaviour'] . '</td>
                         </tr>';
        }
        $document_html .= '</tbody></table>
		</body></html>';

        $pdf = PDF::loadHTML($document_html);
        return $pdf->stream();
    }

    public function attendances(User $user)
    {
        $title = trans('report.attendances');
        $method = 'getAttendances';
        if (!$this->user->inRole('student')) {
            $user = User::find(session('current_student_user_id'));
        }
        $student_user = $user;
        return view('report.list', compact('title', 'student_user', 'method'));
    }

    public function marks(User $user)
    {
        $title = trans('report.marks');
        $method = 'getMarks';
        if (!$this->user->inRole('student')) {
            $user = User::find(session('current_student_user_id'));
        }
        $student_user = $user;
        return view('report.list', compact('title', 'student_user', 'method'));
    }

    public function notice(User $user)
    {
        $title = trans('report.notices');
        $method = 'getNotices';
        if (!$this->user->inRole('student')) {
            $user = User::find(session('current_student_user_id'));
        }
        $student_user = $user;
        return view('report.list', compact('title', 'student_user', 'method'));
    }

    public function subjectBook(User $user)
    {
        $title = trans('report.subjectbook');
        $method = 'getSubjectBook';
        if ($this->user->inRole('parent')) {
            $user = User::find(session('current_student_user_id'));
        }
        $student_user = $user;
        return view('report.list', compact('title', 'method', 'student_user'));
    }

    public function exams(User $user)
    {
        $title = trans('report.exams');
        $method = 'getSubjectExams';
        if (!$this->user->inRole('student')) {
            $user = User::find(session('current_student_user_id'));
        }
        $student_user = $user;
        return view('report.list', compact('title', 'method', 'student_user'));
    }

    public function onlineExams(User $user)
    {
        $title = trans('report.online_exams');
        if (!$this->user->inRole('student')) {
            $user = User::find(session('current_student_user_id'));
        }
        $student_user = $user;

        $onlineExamList = $this->onlineExamRepository->getAllForStudentUserId($user->id)
            ->map(function ($onlineExam) {
                return [
                    'id' => $onlineExam->id,
                    'title' => $onlineExam->title,
                    'date_start' => $onlineExam->date_start,
                    'date_end' => $onlineExam->date_end,
                    'subject' => isset($onlineExam->subject->title) ? $onlineExam->subject->title : "",
                ];
            });
        return view('report.online_exam', compact('title', 'onlineExamList', 'student_user'));
    }

    public function getStudentSubjects(User $user)
    {
        return $this->subjectRepository->getAllStudentsSubjectAndDirection()
            ->where('students.user_id', $user->id)
            ->where('students.school_year_id', session('current_school_year'))
            ->orderBy('subjects.class')
            ->orderBy('subjects.order')
            ->select('subjects.id', 'subjects.title')->pluck('subjects.title', 'subjects.id')->toArray();
    }

    public function semesters(User $user)
    {
        return $this->semesterRepository->getAllForSchoolAndSchoolYear(session('current_school'), session('current_school_year'))
            ->orderBy('start')
            ->get()
            ->map(function ($semester) {
                return [
                    'id' => $semester->id,
                    'title' => $semester->title,
                ];
            })
            ->pluck('title', 'id')->toArray();
    }

    public function marksForSubject(User $user, Request $request)
    {
        $marks = $this->markRepository->getAllForSchoolYearSubjectUserAndSemester(session('current_school_year'), $request->subject_id, $user->id, $request->semester_id)
            ->map(function ($mark) {
                return [
                    'date' => Carbon::createFromFormat(Settings::get('date_format'), $mark->date)->toDateString(),
                    'mark_type' => isset($mark->mark_type) ? $mark->mark_type->title : '',
                    'mark_value' => isset($mark->mark_value) ? $mark->mark_value->grade : '',
                    'mark_percent' => isset($mark->mark_percent) ? $mark->mark_percent : '',
                ];
            })->toArray();

        $student = Student::where('school_year_id', session('current_school_year'))
            ->where('school_id', session('current_school'))
            ->where('user_id', $user->id)->first();

        $final_marks = $this->studentFinalMarkRepository
            ->getAllForStudentSubjectSchoolYearSchool($student->id, $request->subject_id,
                session('current_school_year'), session('current_school'))
            ->with('mark_value')
            ->get()
            ->map(function ($final_mark) {
                return [
                    'date' => $final_mark->created_at->format(Settings::get('date_format')),
                    'mark_type' => trans('student_final_mark.final_mark'),
                    'mark_value' => isset($final_mark->mark_value) ? $final_mark->mark_value->grade : '',
                    'mark_percent' => isset($final_mark->mark_percent) ? $final_mark->mark_percent : '',
                ];
            })->toArray();
        return $marks + $final_marks;
    }

    public function attendancesForSubject(User $user, Request $request)
    {
        $attendance = $this->attendanceRepository->getAllForSchoolYearSubjectUserAndSemester(session('current_school_year'),
            $request->get('subject_id'), $user->id, $request->get('semester_id'))
            ->map(function ($attendance) {
                return [
                    'date' => $attendance->date,
                    'attendance_type' => ($attendance->option) ? $attendance->option->title : "",
                    'hour' => $attendance->hour
                ];
            });
        $sum_attendance = $this->attendanceRepository
            ->getAllForSchoolYearSubjectUserAndSemesterSum(session('current_school_year'), $request->get('subject_id'),
                $user->id, $request->get('semester_id'))
            ->map(function ($attendance) {
                return [
                    'sum' => $attendance->sum,
                    'attendance_type' => $attendance->attendance_type,
                ];
            })->toArray();
        $total_sum = 0;
        foreach ($sum_attendance as $item) {
            $total_sum += $item['sum'];
        }
        foreach ($sum_attendance as $id => $item) {
            $sum_attendance[$id]['percentage'] = round((($item['sum'] / $total_sum) * 100), 2);
        }
        return ['attendances' => $attendance, 'sum_attendance' => $sum_attendance];
    }

    public function noticesForSubject(User $user, Request $request)
    {
        $notices = $this->noticeRepository->getAllForSchoolYearAndSchool(session('current_school_year'),
            session('current_school'))
            ->with('student_group', 'student_group.students')
            ->orderBy('date')
            ->get()
            ->filter(function ($notice) use ($request) {
                return ($notice->subject_id == $request->subject_id && isset($notice->student_group->students));
            })
            ->map(function ($notice) {
                return [
                    'date' => Carbon::createFromFormat(Settings::get('date_format'), $notice->date)->toDateString(),
                    'title' => $notice->title,
                    'description' => $notice->description
                ];
            })
            ->toBase()->unique();
        return $notices;
    }

    public function getSubjectBook(Request $request)
    {
        return $this->bookRepository->getAll()
            ->get()
            ->filter(function ($book) use ($request) {
                return ($book->subject_id == $request->subject_id);
            })
            ->map(function ($book) {
                return [
                    'id' => $book->id,
                    'publisher' => $book->publisher,
                    'version' => $book->version,
                    'quantity' => $book->quantity,
                    'author' => $book->author,
                    'title' => $book->title,
                    'issued' => $this->bookUserRepository->getAll()
                        ->get()
                        ->filter(function ($item) use ($book) {
                            return ($item->book_id == $book->id &&
                                (!is_null($item->get)) && is_null($item->back));
                        })->count()
                ];
            });
    }

    public function examForSubject(User $user, Request $request)
    {
        $student_groups = new Collection([]);
        $stGroups = array();
        $this->studentGroupRepository->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->with('students', 'students.user')
            ->get()
            ->each(function ($group) use ($user, $student_groups) {
                foreach ($group->students as $student_item) {
                    if ($student_item->user->id == $user->id) {
                        $student_groups->push($group);
                    }
                }
            });
        foreach ($student_groups as $group) {
            $stGroups[] = $group->id;
        }

        return $this->examRepository->getAll()
            ->with('subject', 'student_group')
            ->whereIn('student_group_id', $stGroups)
            ->get()
            ->filter(function ($exam) use ($request) {
                return (isset($exam->subject) && $exam->subject_id == $request->subject_id);
            })
            ->map(function ($exam) {
                return [
                    'title' => $exam->title,
                    'subject' => $exam->subject->title,
                    'date' => Carbon::createFromFormat(Settings::get('date_format'), $exam->date)->toDateString(),
                    'description' => $exam->description,
                ];
            });
    }

    public function getStudentCard(Request $request)
    {
        $document_html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <html>
                    <head>
                        <style>
                        table {
                            border-collapse: collapse;
                             width:100%;
                        }

                        table, td, th {
                            border: 1px solid #000000;
                            text-align:center;
                            vertical-align:middle;
                        }
						.page-break {
							page-break-after: always;
						}
                        </style>
                        <title>' . trans('report.student_cards') . '</title>
                    </head>
                    <body>
                ';
        $student_user_ids = $request->get('student_id', []);

        $students = $this->studentRepository->getAllForSchoolYearStudents(session('current_school_year'), $student_user_ids)
            ->map(function ($student) {
                return [
                    'user_id' => $student->user_id,
                    'name' => $student->user->full_name,
                    'order' => $student->order,
                    'section' => isset($student->section) ? $student->section->title : "",
                    'student_no' => $student->student_no,
                ];
            })
            ->toArray();
        $marks = $this->markRepository
            ->getAllForSchoolYearStudents(session('current_school_year'), $student_user_ids)
            ->map(function ($mark) {
                return [
                    'date' => Carbon::createFromFormat(Settings::get('date_format'), $mark->date)->toDateString(),
                    'mark_type' => isset($mark->mark_type) ? $mark->mark_type->title : '',
                    'mark_value' => isset($mark->mark_value) ? $mark->mark_value->grade : '',
                    'mark_percent' => isset($mark->mark_value) ? $mark->mark_percent : '',
                    'subject' => isset($mark->subject) ? $mark->subject->title : '',
                    'subject_highest_mark' => isset($mark->subject) ? $mark->subject->highest_mark : '',
                    'subject_lowest_mark' => isset($mark->subject) ? $mark->subject->lowest_mark : '',
                    'subject_id' => $mark->subject_id,
                    'user_id' => $mark->student->user_id,
                    'student_id' => $mark->student_id,
                ];
            })->toArray();

        $final_marks = $this->studentFinalMarkRepository
            ->getAllForSchoolYearStudents(session('current_school_year'), $student_user_ids)
            ->map(function ($final_mark) {
                return [
                    'mark_type' => trans('student_final_mark.final_mark'),
                    'mark_value' => isset($final_mark->mark_value) ? $final_mark->mark_value->grade : '',
                    'mark_percent' => isset($final_mark->mark_percent) ? $final_mark->mark_percent : '',
                    'subject' => isset($final_mark->subject) ? $final_mark->subject->title : '',
                    'subject_highest_mark' => isset($final_mark->subject) ? $final_mark->subject->highest_mark : '',
                    'subject_lowest_mark' => isset($final_mark->subject) ? $final_mark->subject->lowest_mark : '',
                    'subject_id' => $final_mark->subject_id,
                    'user_id' => $final_mark->student->user_id,
                    'student_id' => $final_mark->student_id,
                ];
            })->toArray();

        $attendances = $this->attendanceRepository
            ->getAllForSchoolYearStudents(session('current_school_year'), $student_user_ids)
            ->map(function ($attendance) {
                return [
                    'date' => Carbon::createFromFormat(Settings::get('date_format'), $attendance->date)->toDateString(),
                    'attendance_type' => $attendance->option->title,
                    'attendance_id' => $attendance->option->id,
                    'subject_id' => $attendance->subject_id,
                    'user_id' => $attendance->student->user_id,
                    'student_id' => $attendance->student_id,
                    'hours' => $attendance->hours,
                ];
            })->toArray();

        $school = School::find(session('current_school'));

        foreach ($students as $student) {
            $document_html .= '<table><tr>
				<td>
					<img src="' . url("uploads/site/thumb_" . Settings::get("logo")) . '" style="margin-right:0px;"/>
					' . $school->title . '
				</td>
				<td>
                	<b>' . $student['name'] . '</b><br>
					' . trans('diary.date') . ': ' . Carbon::now()->format(Settings::get("date_format")) . '<br>
					' . trans('report.student_cards') . '
				</td>
				<td>
					' . trans('visitor_student_card.student_no') . ': ' . $student['student_no'] . '<br>
					' . trans('attendances_by_subject.section') . ': ' . $student['section'] . '<br>
					' . trans('student.order') . ': ' . $student['order'] . '
				</td>
				</tr>
				</table><br>
				<table>
					<thead><tr>
						<td>' . trans('report.sum') . '</td>
						<td>' . trans('report.percentage') . '</td>
						<td>' . trans('report.attendance_type') . '</td>
						</tr>
					</thead>
					<tbody>';
            $sum_attendance = $this->attendanceRepository
                ->getAllForSchoolYearStudentsSum(session('current_school_year'), $student['user_id'])
                ->map(function ($attendance) {
                    return [
                        'sum' => $attendance->sum,
                        'attendance_type' => $attendance->attendance_type,
                    ];
                })->toArray();
            $total_sum = 0;
            foreach ($sum_attendance as $item) {
                $total_sum += $item['sum'];
            }
            foreach ($sum_attendance as $id => $item) {
                $sum_attendance[$id]['percentage'] = round((($item['sum'] / $total_sum) * 100), 2);
            }
            foreach ($sum_attendance as $item) {
                $document_html .= '<tr><td>' . $item['sum'] . '</td><td>' . $item['percentage'] .
                    '</td><td>' . $item['attendance_type'] . '</td></tr>';
            }
            $document_html .= '</tbody></table><br>
                    <table>
					<thead><tr>
						<td>' . trans('report.subject') . '</td>
						<td>' . trans('report.marks') . '</td>
						<td>' . trans('report.final_marks') . '</td>
						<td>' . trans('report.attendances') . '</td>
						<td>' . trans('report.sum_attendances') . '</td>
						</tr>
					</thead>
					<tbody>';

            $student_marks = [];
            $student_subjects = [];
            $student_subjects_ids = [];
            $student_attendances = [];
            $student_attendances_sum = [];

            foreach ($marks as $item) {
                if ($item['user_id'] == $student['user_id']) {
                    if (!in_array($item['subject_id'], $student_subjects_ids)) {
                        $student_subjects_ids[$item['subject_id']] = $item['subject_id'];
                        $final_mark = null;
                        foreach ($final_marks as $final) {
                            if ($final['subject_id'] == $item['subject_id'] &&
                                $final['user_id'] == $item['user_id']
                            ) {
                                $final_mark = $final['mark_value'].' ('.$final['mark_percent'].')';
                            }
                        }
                        $student_subjects[$item['subject_id']] = [
                            'subject' => $item['subject'],
                            'subject_highest_mark' => $item['subject_highest_mark'],
                            'final_mark' => $final_mark
                        ];
                    }
                    $student_marks[$item['subject_id']][] = [
                        'date' => $item['date'],
                        'mark_type' => $item['mark_type'],
                        'mark_value' => $item['mark_value'],
                        'mark_percent' => $item['mark_percent']
                    ];
                    foreach ($attendances as $att) {
                        if ($att['user_id'] == $student['user_id']
                            && $att['subject_id'] == $item['subject_id']
                        ) {
                            if (in_array($att['subject_id'], $student_subjects_ids)) {
                                if (isset($student_attendances_sum[$att['user_id']][$att['subject_id']][$att['attendance_id']])) {
                                    $student_attendances_sum[$att['user_id']][$att['subject_id']][$att['attendance_id']]['hours'] =
                                        $student_attendances_sum[$att['user_id']][$att['subject_id']][$att['attendance_id']]['hours'] + $att['hours'];
                                } else {
                                    $student_attendances_sum[$att['subject_id']][$att['attendance_id']] = [
                                        'hours' => $att['hours'],
                                        'attendance_type' => $att['attendance_type']
                                    ];
                                }
                            }
                            $student_attendances[$att['subject_id']][] = [
                                'date' => $att['date'],
                                'hours' => $att['hours'],
                                'attendance_type' => $att['attendance_type']
                            ];
                        }
                    }
                }
            }
            foreach ($student_subjects as $key => $subject) {
                $document_html .= '<tr>
						<td>' . $subject['subject'] .
                    (($subject['subject_highest_mark'] != "") ? ' (' . $subject['subject_highest_mark'] . ')' : "") . '<td>';
                foreach ($student_marks[$key] as $mark) {
                    $document_html .= $mark['date'] . ' - ' . $mark['mark_value'] .
                        ((!is_null($mark['mark_percent'])) ? ' (' . $mark['mark_percent'] . ')' : "") . '<br>';
                }
                $document_html .= '</td> <td>' . $subject['final_mark'] . '</td> <td>';
                if (isset($student_attendances[$key])) {
                    foreach ($student_attendances[$key] as $attendance) {
                        $document_html .= $attendance['date'] . ' - ' . trans('report.sum_hours') . $attendance['hours'] .
                            ' (' . $attendance['attendance_type'] . ')<br>';
                    }
                }
                $document_html .= '</td> <td>';
                if (isset($student_attendances_sum[$key])) {
                    foreach ($student_attendances_sum[$key] as $attendance) {
                        $document_html .= $attendance['hours'] . ' (' . $attendance['attendance_type'] . ')<br>';
                    }
                }
                $document_html .= '</td>
						</tr>';
            }
            $document_html .= '</tbody>
				</table>
				<div class="page-break"></div>';
        }
        $document_html .= '</body></html>';

        $pdf = PDF::loadHTML($document_html);
        return $pdf->stream();
    }

    public function getAverageMarksAllSubjects(Request $request)
    {
        $document_html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <html>
                    <head>
                        <style>
                        table {
                            border-collapse: collapse;
                             width:100%;
                        }

                        table, td, th {
                            border: 1px solid #000000;
                            text-align:center;
                            vertical-align:middle;
                        }
						.page-break {
							page-break-after: always;
						}
                        </style>
                        <title>' . trans('report.list_average_marks_all_subjects') . '</title>
                    </head>
                    <body>
                ';
        $students = $this->studentRepository->getAllForSchoolYearAndSchool(session('current_school_year'), session('current_school'))
            ->get()
            ->map(function ($student) {
                return [
                    'student_id' => $student->id,
                    'user_id' => $student->user_id,
                    'name' => $student->user->full_name,
                    'order' => $student->order,
                    'section' => isset($student->section) ? $student->section->title : "",
                    'student_no' => $student->student_no,
                ];
            });
        $semester_id = 0;
        $semester = $this->semesterRepository->getActiveForSchoolAndSchoolYear(session('current_school'), session('current_school_year'));
        if (isset($semester) && Settings::get('number_of_semesters') > 1) {
            $semester_id = $semester->id;
        }
        $marks = $this->markRepository
            ->getAllForSchoolYearSemesterStudents(session('current_school_year'), $semester_id, $students->pluck('student_id'))
            ->map(function ($mark) {
                return [
                    'avg_mark_percent' => isset($mark->avg_mark_percent) ?
                        number_format($mark->avg_mark_percent,2) : '',
                    'avg_mark' => isset($mark->avg_mark_percent) ?
                        $this->getGradeValue(number_format($mark->avg_mark_percent,2)) : '',
                    'student' => $mark->student->user->full_name,
                    'student_id' => $mark->student_id,
                ];
            });
        $school = School::find(session('current_school'));

        $document_html .= '<table><tr>
            <td>
                <img src="' . url("uploads/site/thumb_" . Settings::get("logo")) . '" style="margin-right:0px;"/>
                ' . $school->title . '<br>' . $school->address . '<br>' .trans('schools.phone').': '. $school->phone. '
            </td>
            </tr>
            </table><br>
            <table>
                <thead>
                    <tr>
                        <th>' . trans('report.student') . '</th>
                        <th>' . trans('report.avg_percentage') .'</th>
                        <th>' . trans('report.avg_mark') . '</th>
                    </tr>
                </thead>
                <tbody>';
        foreach($marks as $mark){
            $document_html .= '<tr>
                                    <th>' . $mark['student'] . '</th>
                                    <th>' . $mark['avg_mark_percent'] .'</th>
                                    <th>' . $mark['avg_mark'] . '</th>
                            </tr>';
        }
        $document_html .= '</tbody></table></body></html>';

        $pdf = PDF::loadHTML($document_html);
        return $pdf->stream();
    }

    private function getGradeValue($avg_mark_percent)
    {
        $mark_value = MarkValue::where('max_score', '>=', number_format($avg_mark_percent,0))
            ->where('min_score', '<=', number_format($avg_mark_percent,0))->first();
        if (isset($mark_value->grade)) {
            return $mark_value->grade;
        }
        return '';
    }
}
