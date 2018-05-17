<?php

namespace App\Http\Controllers\Secure;

use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\SemesterRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherSubjectRepository;
use App\Repositories\TimetablePeriodRepository;
use App\Repositories\TimetableRepository;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class StudentSectionController extends SecureController
{
    /**
     * @var TimetableRepository
     */
    private $timetableRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var TeacherSubjectRepository
     */
    private $teacherSubjectRepository;
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;
	/**
	 * @var TimetablePeriodRepository
	 */
	private $timetablePeriodRepository;
    /**
     * @var SemesterRepository
     */
    private $semesterRepository;

    /**
     * StudentSectionController constructor.
     *
     * @param TimetableRepository $timetableRepository
     * @param StudentRepository $studentRepository
     * @param TeacherSubjectRepository $teacherSubjectRepository
     * @param PaymentRepository $paymentRepository
     * @param InvoiceRepository $invoiceRepository
     * @param TimetablePeriodRepository $timetablePeriodRepository
     * @param SemesterRepository $semesterRepository
     */
    public function __construct(TimetableRepository $timetableRepository,
                                StudentRepository $studentRepository,
                                TeacherSubjectRepository $teacherSubjectRepository,
                                PaymentRepository $paymentRepository,
                                InvoiceRepository $invoiceRepository,
	                            TimetablePeriodRepository $timetablePeriodRepository,
                                SemesterRepository $semesterRepository)
    {
        parent::__construct();

        $this->timetableRepository = $timetableRepository;
        $this->studentRepository = $studentRepository;
        $this->teacherSubjectRepository = $teacherSubjectRepository;
        $this->paymentRepository = $paymentRepository;
        $this->invoiceRepository = $invoiceRepository;
	    $this->timetablePeriodRepository = $timetablePeriodRepository;
        $this->semesterRepository = $semesterRepository;

        view()->share('type', 'studentsection');

        $columns = ['title','payment_method','amount', 'status'];
        view()->share('columns', $columns);
    }

    public function timetable()
    {
        $title = trans('teachergroup.timetable');

        if ($this->user->inRole('student')) {
            $student_user_id = $this->user->id;
        } else {
            $student_user_id = session('current_student_user_id');
        }
        $school_year_id = session('current_school_year');
        $school_id = session('current_school');

        $studentgroups = $this->studentRepository
            ->getAllStudentGroupsForStudentUserAndSchoolYear($student_user_id, $school_year_id);
        $semester = $this->semesterRepository->getActiveForSchoolAndSchoolYear($school_id,$school_year_id);
        if(isset($semester)){
            $semester_id = $semester->id;
        }else{
            $semester_id = 0;
        }
        $subject_list = $this->teacherSubjectRepository
            ->getAllForSchoolYearAndGroupsAndSemester($school_year_id, $studentgroups,$semester_id)
            ->with('teacher', 'subject')
            ->get()
            ->filter(function ($teacherSubject) {
                return (isset($teacherSubject->subject) && isset($teacherSubject->teacher));
            })
            ->map(function ($teacherSubject) {
                return [
                    'id' => $teacherSubject->id,
                    'subject_id' => $teacherSubject->subject_id,
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

        return view('studentsection.timetable', compact('title', 'action',
	                                                                    'timetable','timetablePeriods'));
    }

    public function print_timetable()
    {
        $title = trans('teachergroup.timetable');

        if ($this->user->inRole('student')) {
            $student_user_id = $this->user->id;
        } else {
            $student_user_id = session('current_student_user_id');
        }
        $school_year_id = session('current_school_year');

        $studentgroups = $this->studentRepository
            ->getAllStudentGroupsForStudentUserAndSchoolYear($student_user_id, $school_year_id);

        $subject_list = $this->teacherSubjectRepository
            ->getAllForSchoolYearAndGroups($school_year_id, $studentgroups)
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

    public function payment()
    {
        $title = trans('payment.payment');
        return view('studentsection.payment', compact('title'));
    }

    public function data()
    {
        if ($this->user->inRole('student')) {
            $student_user_id = $this->user->id;
        } else {
            $student_user_id = session('current_student_user_id');
        }
        $payments = $this->paymentRepository->getAll()
            ->get()
            ->filter(function ($payment) use ($student_user_id) {
                return $payment->user_id == $student_user_id;
            })
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'title' => $payment->title,
                    'payment_method' => $payment->payment_method,
                    'amount' => $payment->amount,
                    'status' => $payment->status,
                ];
            });

        return Datatables::make( $payments)
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }

    public function invoice()
    {
        if ($this->user->inRole('student')) {
            $student_user_id = $this->user->id;
        } else {
            $student_user_id = session('current_student_user_id');
        }

        $title = trans('invoice.invoice');

        $invoices = $this->invoiceRepository->getAll()
            ->get()
            ->filter(function ($invoice) use ($student_user_id) {
                return ($invoice->user_id == $student_user_id && $invoice->paid == 0);
            })
            ->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'title' => $invoice->title,
                    'amount' => $invoice->amount,
                    'description' => $invoice->description,
                ];
            });

        return view('studentsection.invoice', compact('title', 'invoices'));
    }

    public function showInvoice(Invoice $invoice)
    {
	    $pdf = PDF::loadView( 'report.invoice', compact( 'invoice' ) );
	    return $pdf->stream();
    }

    public function subjects()
    {
        $title = trans('teachergroup.subjects');

        if ($this->user->inRole('student')) {
            $student_user_id = $this->user->id;
        } else {
            $student_user_id = session('current_student_user_id');
        }
        $school_year_id = session('current_school_year');
        $school_id = session('current_school');

        $studentgroups = $this->studentRepository
            ->getAllStudentGroupsForStudentUserAndSchoolYear($student_user_id, $school_year_id);
        $semester = $this->semesterRepository->getActiveForSchoolAndSchoolYear($school_id,$school_year_id);
        if(isset($semester)){
            $semester_id = $semester->id;
        }else{
            $semester_id = 0;
        }
        $subject_list = $this->teacherSubjectRepository
            ->getAllForSchoolYearAndGroupsAndSemester($school_year_id, $studentgroups,$semester_id)
            ->with('teacher', 'subject')
            ->get()
            ->filter(function ($teacherSubject) {
                return (isset($teacherSubject->subject) && isset($teacherSubject->teacher));
            })
            ->map(function ($teacherSubject) {
                return [
                    'id' => $teacherSubject->id,
                    'subject_id' => $teacherSubject->subject_id,
                    'title' => isset($teacherSubject->subject) ? $teacherSubject->subject->title : "",
                    'credit_hours' => isset($teacherSubject->credit_hours) ? $teacherSubject->subject->credit_hours : "",
                    'subject_short_name' => isset($teacherSubject->subject) ?
                        $teacherSubject->subject->short_name : "",
                    'subject_room' => isset($teacherSubject->subject) ? $teacherSubject->subject->room : "",
                    'description' => isset($teacherSubject->subject) ? $teacherSubject->subject->description : "",
                    'name' => isset($teacherSubject->teacher) ? $teacherSubject->teacher->full_name : "",
                    'teacher_short_name' => isset($teacherSubject->teacher) ? $teacherSubject->teacher->short_name :
                        "",
                ];
            });
        return view('studentsection.subjects', compact('title', 'action',
            'subject_list'));
    }
}
