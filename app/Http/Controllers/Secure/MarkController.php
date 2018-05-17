<?php

namespace App\Http\Controllers\Secure;

use App\Events\Mark\MarkCreated;
use App\Http\Requests\Secure\AddMarkRequest;
use App\Http\Requests\Secure\DeleteRequest;
use App\Http\Requests\Secure\ExamGetRequest;
use App\Http\Requests\Secure\MarkGetRequest;
use App\Http\Requests\Secure\MarkSystemGetRequest;
use App\Models\Mark;
use App\Models\MarkType;
use App\Models\MarkValue;
use App\Models\ParentStudent;
use App\Models\School;
use App\Models\Semester;
use App\Models\SmsMessage;
use App\Models\Student;
use App\Models\StudentGroup;
use App\Models\Subject;
use App\Models\User;
use App\Repositories\ExamRepository;
use App\Repositories\MarkSystemRepository;
use App\Repositories\MarkTypeRepository;
use App\Repositories\MarkValueRepository;
use App\Repositories\SemesterRepository;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use App\Repositories\MarkRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherSubjectRepository;
use SMS;

class MarkController extends SecureController {
	/**
	 * @var StudentRepository
	 */
	private $studentRepository;
	/**
	 * @var MarkRepository
	 */
	private $markRepository;
	/**
	 * @var TeacherSubjectRepository
	 */
	private $teacherSubjectRepository;
	/**
	 * @var ExamRepository
	 */
	private $examRepository;
	/**
	 * @var MarkValueRepository
	 */
	private $markValueRepository;
	/**
	 * @var MarkTypeRepository
	 */
	private $markTypeRepository;
	/**
	 * @var MarkSystemRepository
	 */
	private $markSystemRepository;
    /**
     * @var SemesterRepository
     */
    private $semesterRepository;

    /**
     * MarkController constructor.
     *
     * @param StudentRepository $studentRepository
     * @param MarkRepository $markRepository
     * @param TeacherSubjectRepository $teacherSubjectRepository
     * @param ExamRepository $examRepository
     * @param MarkValueRepository $markValueRepository
     * @param MarkTypeRepository $markTypeRepository
     * @param MarkSystemRepository $markSystemRepository
     * @param SemesterRepository $semesterRepository
     */
	public function __construct(
		StudentRepository $studentRepository,
		MarkRepository $markRepository,
		TeacherSubjectRepository $teacherSubjectRepository,
		ExamRepository $examRepository,
		MarkValueRepository $markValueRepository,
		MarkTypeRepository $markTypeRepository,
		MarkSystemRepository $markSystemRepository,
        SemesterRepository $semesterRepository
	) {
		parent::__construct();

		$this->studentRepository        = $studentRepository;
		$this->markRepository           = $markRepository;
		$this->teacherSubjectRepository = $teacherSubjectRepository;
		$this->examRepository           = $examRepository;
		$this->markValueRepository      = $markValueRepository;
		$this->markTypeRepository       = $markTypeRepository;
		$this->markSystemRepository     = $markSystemRepository;
        $this->semesterRepository       = $semesterRepository;

		view()->share( 'type', 'mark' );
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$title    = trans( 'mark.marks' );
		$students = $this->studentRepository->getAllForStudentGroup( session( 'current_student_group' ) )
		                                    ->map( function ( $student ) {
			                                    return [
				                                    'id'   => $student->id,
				                                    'name' => $student->user->full_name,
			                                    ];
		                                    } )->pluck( 'name', 'id' )->toArray();
        $school_year_id = session('current_school_year');
        $school_id = session('current_school');
        $semester = $this->semesterRepository->getActiveForSchoolAndSchoolYear($school_id,$school_year_id);
        if(isset($semester) && Settings::get('number_of_semesters') > 1){
            $subjects = $this->teacherSubjectRepository
                ->getAllForSchoolYearAndSemesterAndGroupAndTeacher(session('current_school_year'),$semester->id,
                    session('current_student_group'), $this->user->id)
                ->with('subject')
                ->get()
                ->filter(function ($subject) {
                    return (isset($subject->subject->title));
                })
                ->map(function ($subject) {
                    return [
                        'id' => $subject->subject_id,
                        'title' => $subject->subject->title
                    ];
                })->pluck('title', 'id');
        }else{
            $subjects = $this->teacherSubjectRepository
                ->getAllForSchoolYearAndGroupAndTeacher(session('current_school_year'), session('current_student_group'), $this->user->id)
                ->with('subject')
                ->get()
                ->filter(function ($subject) {
                    return (isset($subject->subject->title));
                })
                ->map(function ($subject) {
                    return [
                        'id' => $subject->subject_id,
                        'title' => $subject->subject->title
                    ];
                })->pluck('title', 'id');
        }
		$marktype = $this->markTypeRepository->getAll()->get()->pluck( 'title', 'id' )->toArray();

		return view( 'mark.index', compact( 'title', 'students', 'subjects', 'marktype' ) );
	}

    public function students(StudentGroup $studentGroup) {
        session(['current_student_group'=>$studentGroup->id]);

        $students = $this->studentRepository->getAllForStudentGroup( session( 'current_student_group' ) )
            ->map( function ( $student ) {
                return [
                    'id'   => $student->id,
                    'name' => $student->user->full_name,
                ];
            } )->pluck( 'name', 'id' )->toArray();
        $school_year_id = session('current_school_year');
        $school_id = session('current_school');
        $semester = $this->semesterRepository->getActiveForSchoolAndSchoolYear($school_id,$school_year_id);
        if(isset($semester) && Settings::get('number_of_semesters') > 1){
            $subjects = $this->teacherSubjectRepository
                ->getAllForSchoolYearAndSemesterAndGroupAndTeacher(session('current_school_year'),$semester->id,
                    session('current_student_group'), $this->user->id)
                ->with('subject')
                ->get()
                ->filter(function ($subject) {
                    return (isset($subject->subject->title));
                })
                ->map(function ($subject) {
                    return [
                        'id' => $subject->subject_id,
                        'title' => $subject->subject->title
                    ];
                })->pluck('title', 'id')->prepend( trans( 'mark.select_subject' ), 0 );
        }else{
            $subjects = $this->teacherSubjectRepository
                ->getAllForSchoolYearAndGroupAndTeacher(session('current_school_year'), session('current_student_group'), $this->user->id)
                ->with('subject')
                ->get()
                ->filter(function ($subject) {
                    return (isset($subject->subject->title));
                })
                ->map(function ($subject) {
                    return [
                        'id' => $subject->subject_id,
                        'title' => $subject->subject->title
                    ];
                })->pluck('title', 'id')->prepend( trans( 'mark.select_subject' ), 0 );
        }

        return response()->json( ['students'=>$students, 'subjects'=>$subjects], 200);
    }

	public function marksForSubjectAndDate( MarkGetRequest $request ) {
		$marks = $this->markRepository->getAll()
		                              ->with( 'student', 'student.user', 'mark_type', 'mark_value', 'subject' )
		                              ->get()
		                              ->filter( function ( $marksItem ) use ( $request ) {
			                              return ( $marksItem->school_year_id == session( 'current_school_year' ) &&
			                                       $marksItem->subject_id == $request->get( 'subject_id' ) &&
			                                       Carbon::createFromFormat( Settings::get( 'date_format' ), $marksItem->date ) ==
			                                       Carbon::createFromFormat( Settings::get( 'date_format' ), $request->get( 'date' ) ) );
		                              } )
		                              ->map( function ( $mark ) {
			                              return [
				                              'id'         => $mark->id,
				                              'name'       => isset( $mark->student->user->full_name ) ? $mark->student->user->full_name : "",
				                              'mark_type'  => isset( $mark->mark_type ) ? $mark->mark_type->title : '',
				                              'mark_value' => isset( $mark->mark_value ) ? $mark->mark_value->grade : '',
				                              'mark_percent' => isset( $mark->mark_percent ) ? $mark->mark_percent : '',
			                              ];
		                              } );

		return json_encode( $marks );
	}

	public function examsForSubject( ExamGetRequest $request ) {
		return $this->examRepository->getAllForGroupAndSubject( session( 'current_student_group' ), $request['subject_id'] )
		                            ->get()
		                            ->map( function ( $exam ) {
			                            return [
				                            'id'    => $exam->id,
				                            'title' => $exam->title,
			                            ];
		                            } )->pluck( 'title', 'id' )->toArray();
	}

	public function markValuesForSubject( MarkSystemGetRequest $request ) {
		return $this->markValueRepository->getAllForSubject( $request['subject_id'] )
		                                 ->get()
		                                 ->map( function ( $mark_value ) {
			                                 return [
				                                 'id'    => $mark_value->id,
				                                 'title' => $mark_value->grade.((!is_null($mark_value->max_score))?' ('.$mark_value->max_score
                                                         .' - '. $mark_value->min_score.')':'')
			                                 ];
		                                 } )->pluck( 'title', 'id' )->prepend( trans( 'mark.select_mark_value' ), 0 )->toArray();
	}

	public function deleteMark( DeleteRequest $request ) {
		$mark = Mark::find( $request['id'] );
		$mark->delete();
	}

	public function addmark( AddMarkRequest $request ) {
		$date     = date_format( date_create_from_format( Settings::get( 'date_format' ), $request->date ), 'd-m-Y' );
        $school_year_id = session('current_school_year');
        $school_id = session('current_school');
        $semester = $this->semesterRepository->getActiveForSchoolAndSchoolYear($school_id,$school_year_id);
		foreach ( $request['students'] as $student_id ) {
			$mark                 = new Mark( $request->except( 'students', '_token', 'mark_value_id' ) );
			$mark->teacher_id     = $this->user->id;
			$mark->student_id     = $student_id;
			$mark->school_year_id = session( 'current_school_year' );
			$mark->semester_id    = isset( $semester->id ) ? $semester->id : 1;

			$subject = Subject::find( $request->get( 'subject_id' ) );
			if ( $request->get( 'mark_percent' ) != "" ) {
				if ( $subject->highest_mark > 0 ) {
					//if subject have highest mark
					$mark_percent = round( ( $request->get( 'mark_percent' ) * $subject->highest_mark ) / 100, 0 );
				} else {
					//if subject didn't have highest mark
					$mark_percent = round( $request->get( 'mark_percent' ), 0 );
				}
				//find mark value for that percent
				$markValue = MarkValue::where( 'max_score', '>=', $mark_percent )
				                      ->where( 'min_score', '<=', $mark_percent )
				                      ->where( 'mark_system_id', $subject->mark_system_id )->first();
				if ( ! is_null( $markValue ) ) {
					$mark->mark_value_id = $markValue->id;
				} else {
					$mark->mark_value_id = $request->get( 'mark_value_id' );
				}
			} else {
				$markValue = MarkValue::find( $request->get( 'mark_value_id' ) );
				if ( $subject->highest_mark > 0 ) {
					//if subject have highest mark
					$mark_percent = round( ( $markValue->max_score * $subject->highest_mark ) / 100, 0 );
				} else {
					//if subject didn't have highest mark
					$mark_percent = round( $markValue->max_score, 0 );
				}
				$mark->mark_percent  = $mark_percent;
				$mark->mark_value_id = $request->get( 'mark_value_id' );
			}
			$mark->save();

			event(new MarkCreated($mark));

			if ( Settings::get( 'automatic_sms_mark' ) == 1
			     && Settings::get( 'sms_driver' ) != ""
			     && Settings::get( 'sms_driver' ) != 'none' ) {
				$parents_sms = ParentStudent::join( 'students', 'students.user_id', '=', 'parent_students.user_id_student' )
				                            ->join( 'users', 'users.id', '=', 'parent_students.user_id_parent' )
				                            ->where( 'students.id', $student_id )
				                            ->where( function ( $q ) {
					                            $q->where( 'users.get_sms', 1 );
					                            $q->orWhereNull( 'users.get_sms' );
				                            } )
				                            ->select( 'users.*' )->get();
				foreach ( $parents_sms as $item ) {
					$school = School::find(session( 'current_school' ))->first();
					if($school->limit_sms_messages == 0 ||
					   $school->limit_sms_messages > $school->sms_messages_year) {
						$student    = User::find( Student::find( $student_id )->user_id );
						$subject    = Subject::find( $request->subject_id );
						$mark_type  = MarkType::find( $request->mark_type_id );
						$mark_value = MarkValue::find( $request->mark_value_id );

						$sms_text = trans( 'mark.student' ) . ": " . $student->full_name . ', ' .
						            trans( 'mark.date' ) . ': ' . $date . ', ' .
						            trans( 'mark.subject' ) . ': ' . $subject->title . ', ' .
						            trans( 'mark.mark_type' ) . ': ' . $mark_type->title . ', ' .
						            trans( 'mark.mark_value' ) . ': ' . $mark_value->title;

						$smsMessage                 = new SmsMessage();
						$smsMessage->text           = $sms_text;
						$smsMessage->number         = $item->mobile;
						$smsMessage->user_id        = $item->id;
						$smsMessage->user_id_sender = $this->user->id;
						$smsMessage->school_id      = session( 'current_school' );
						$smsMessage->save();
					}
				}
			}
		}
	}
}
