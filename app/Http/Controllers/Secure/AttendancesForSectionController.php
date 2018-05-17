<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\AddAttendanceRequest;
use App\Http\Requests\Secure\AttendanceSectionGetRequest;
use App\Http\Requests\Secure\DeleteRequest;
use App\Models\Attendance;
use App\Models\Option;
use App\Models\ParentStudent;
use App\Models\Section;
use App\Models\Semester;
use App\Models\SmsMessage;
use App\Models\Student;
use App\Models\User;
use App\Repositories\AttendanceRepository;
use App\Repositories\OptionRepository;
use App\Repositories\SectionRepository;
use App\Repositories\SemesterRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TimetableRepository;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Sentinel;

class AttendancesForSectionController extends SecureController {
	/**
	 * @var StudentRepository
	 */
	private $studentRepository;
	/**
	 * @var OptionRepository
	 */
	private $optionRepository;
	/**
	 * @var SectionRepository
	 */
	private $sectionRepository;
	/**
	 * @var TimetableRepository
	 */
	private $timetableRepository;
	/**
	 * @var AttendanceRepository
	 */
	private $attendanceRepository;
    /**
     * @var SemesterRepository
     */
    private $semesterRepository;

    /**
     * AttendancesForSectionController constructor.
     *
     * @param StudentRepository $studentRepository
     * @param OptionRepository $optionRepository
     * @param SectionRepository $sectionRepository
     * @param TimetableRepository $timetableRepository
     * @param AttendanceRepository $attendanceRepository
     * @param SemesterRepository $semesterRepository
     */
	public function __construct(StudentRepository $studentRepository,
								OptionRepository $optionRepository,
								SectionRepository $sectionRepository,
								TimetableRepository $timetableRepository,
								AttendanceRepository $attendanceRepository,
                                SemesterRepository $semesterRepository) {
		parent::__construct();

		view()->share( 'type', 'attendances_for_section' );
		$this->studentRepository = $studentRepository;
		$this->optionRepository = $optionRepository;
		$this->sectionRepository = $sectionRepository;
		$this->timetableRepository = $timetableRepository;
		$this->attendanceRepository = $attendanceRepository;
        $this->semesterRepository = $semesterRepository;
    }

	public function index() {
		$title    = trans( 'attendances_for_section.add_attendance_for_section' );
		$sections = $this->sectionRepository->getAllForSchoolYearSchoolAndHeadTeacher(session( 'current_school_year' ),
																						session( 'current_school' ),
																					Sentinel::getUser()->id)->pluck( 'title', 'id' );
		$attendance_type = $this->optionRepository->getAllForSchool( session( 'current_school' ) )
		                                          ->where( 'category', 'attendance_type' )->get()
		                                          ->map( function ( $option ) {
			                                          return [
				                                          "title" => $option->title,
				                                          "value" => $option->id,
			                                          ];
		                                          } )->pluck( 'title', 'value' )->toArray();
		$hour_list = ['-1'=>trans('attendances_for_section.all_hours')];
		return view( 'attendances_for_section.index', compact( 'title', 'sections','attendance_type','hour_list') );
	}

	public function students( Section $section ) {
		return $this->studentRepository->getAllForSection($section->id)
			->map( function ( $student ) {
				return [
					'id'         => $student->id,
					'name'    => is_null( $student->user ) ? "-" : $student->user->full_name
				];
			} );
	}

	public function hoursForDate( AttendanceSectionGetRequest $request ) {
		$request->date = Carbon::createFromFormat( Settings::get( 'date_format' ), $request->get('date') );
        $school_year_id = session('current_school_year');
        $school_id = session('current_school');
        $semester = $this->semesterRepository->getActiveForSchoolAndSchoolYear($school_id,$school_year_id);
        if(Settings::get('number_of_semesters') > 1 && isset($semester)){
            $semester_id = $semester->id;
        }else{
            $semester_id = 0;
        }
		return $hour_list = $this->timetableRepository->getAll()
		                                              ->with( 'teacher_subject' )
		                                              ->get()
		                                              ->filter( function ( $timetable ) use ( $request,$semester_id ) {
			                                              return (  $timetable->week_day == date( 'N', strtotime( $request->get('date') ) )
			                                                        && isset
                                                                  ($timetable->teacher_subject->student_group) &&
                                                              ($timetable->semester_id == $semester_id ||
                                                                  $timetable->semester_id==0) &&
                                                              $timetable->teacher_subject->student_group->section_id == $request->get('section_id') );
		                                              } )
		                                              ->map( function ( $timetable ) {
			                                              return [
				                                              'id'   => $timetable->hour,
                                                              'hour' => (isset($timetable->timetable_period->start_at)?
                                                                  ($timetable->hour .'('.$timetable->timetable_period->start_at.' -  '
                                                                      .$timetable->timetable_period->end_at.')'):
                                                                  $timetable->hour)
			                                              ];
		                                              } )->pluck( 'hour', 'id' )->toArray();
	}

	public function addAttendance( AddAttendanceRequest $request ) {
		$date     = date_format( date_create_from_format( Settings::get( 'date_format' ), $request->date ), 'd-m-Y' );
		$semestar = Semester::where( function ( $query ) use ( $date ) {
			$query->where( 'start', '>=', $date )
			      ->where( 'school_year_id', '=', session( 'current_school_year' ) );
		} )->orWhere( function ( $query ) use ( $date ) {
			$query->where( 'end', '<=', $date )
			      ->where( 'school_year_id', '=', session( 'current_school_year' ) );
		} )->first();

		if(in_array('-1', $request['hour'] )){
			$subjects = $this->timetableRepository->getAll()
			                                     ->with( 'teacher_subject.student_group' )
			                                     ->get()
			                                     ->filter( function ( $timetable ) use ( $date, $request) {
				                                     return ( isset( $timetable->teacher_subject->teacher_id ) &&
				                                              $timetable->week_day == date( 'N', strtotime( $date ) ) &&
				                                              $timetable->teacher_subject->student_group->section_id == $request->get('section_id'));
			                                     } )
			                                     ->map( function ( $timetable ) {
				                                     return [
					                                     'subject_id' => $timetable->teacher_subject->subject_id,
					                                     'hour' => $timetable->hour,
				                                     ];
			                                     } );
			if ( count($subjects) ) {
				foreach($subjects as $subject) {
					$subject_id = $subject['subject_id'];
					$hour      = $subject['hour'];
					$this->add_attendance_to_student( $request, $hour, $semestar, $subject_id, $date );
				}
			}
		}else{
			foreach($request->get('hour') as $hour) {
				$subject = $this->timetableRepository->getAll()
				                                     ->with( 'teacher_subject.student_group' )
				                                     ->get()
				                                     ->filter( function ( $timetable ) use ( $date, $request,$hour ) {
					                                     return ( isset( $timetable->teacher_subject->teacher_id ) &&
					                                              $timetable->week_day == date( 'N', strtotime( $date ) ) &&
					                                              $timetable->hour == $hour &&
					                                              $timetable->teacher_subject->student_group->section_id == $request->get( 'section_id' ) );
				                                     } )
				                                     ->map( function ( $timetable ) {
					                                     return [
						                                     'subject_id' => $timetable->teacher_subject->subject_id,
                                                             'hour' => (isset($timetable->timetable_period->start_at)?
                                                                 ($timetable->hour .'('.$timetable->timetable_period->start_at.' -  '
                                                                     .$timetable->timetable_period->end_at.')'):
                                                                 $timetable->hour)
					                                     ];
				                                     } )->first();
				if ( isset( $subject['subject_id'] ) ) {
					$subject_id = $subject['subject_id'];
					$hour       = $subject['hour'];
					$this->add_attendance_to_student( $request, $hour, $semestar, $subject_id, $date );
				}
			}
		}
	}

	public function attendanceForDate( AttendanceSectionGetRequest $request ) {
		$students = [];
		foreach($this->studentRepository->getAllForSection( $request->get('section_id') ) as $item){
			$students[$item->id] = $item->id;
		}
		$attendances = $this->attendanceRepository->getAllForStudentsAndSchoolYear( $students, session( 'current_school_year' ) )
		                                          ->with( 'student', 'student.user' )
		                                          ->orderBy( 'hour' )
		                                          ->get()
												  ->filter( function ( $attendance ) use ( $request ) {
			                                          return ( Carbon::createFromFormat( Settings::get( 'date_format' ), $attendance->date ) ==
			                                                   Carbon::createFromFormat( Settings::get( 'date_format' ), $request->date ) &&
			                                                   !is_null( $attendance->student->user ) );
		                                          } )
		                                          ->map( function ( $attendance ) {
			                                          return [
				                                          'id'     => $attendance->id,
				                                          'name'   => $attendance->student->user->full_name,
				                                          'hour'   => $attendance->hour,
				                                          'option' => isset( $attendance->option ) ? $attendance->option->title : "",
			                                          ];
		                                          } )->toArray();

		return json_encode( $attendances );
	}

	public function deleteattendance( DeleteRequest $request ) {
		$attendance = Attendance::find( $request['id'] );
		$attendance->delete();
	}

	/**
	 * @param AddAttendanceRequest $request
	 * @param $student_id
	 * @param $date
	 * @param $hour
	 */
	private function send_sms_to_parent( AddAttendanceRequest $request, $student_id, $date, $hour ) {
		$parents_sms = ParentStudent::join( 'students', 'students.user_id', '=', 'parent_students.user_id_student' )
		                            ->join( 'users', 'users.id', '=', 'parent_students.user_id_parent' )
		                            ->where( 'students.id', $student_id )
		                            ->where( function ( $q ) {
			                            $q->where( 'users.get_sms', 1 );
			                            $q->orWhereNull( 'users.get_sms' );
		                            } )
		                            ->select( 'users.*' )->get();
		foreach ( $parents_sms as $item ) {
			$school = School::find( session( 'current_school' ) )->first();
			if ( $school->limit_sms_messages == 0 ||
			     $school->limit_sms_messages > $school->sms_messages_year ) {
				$student     = User::find( Student::find( $student_id )->user_id );
				$option_type = Option::find( $request->option_id );

				$sms_text = trans( 'attendance.student' ) . ": " . $student->full_name . ', ' .
				            trans( 'attendance.date' ) . ': ' . $date . ', ' .
				            trans( 'attendance.attendance_type' ) . ': ' . $option_type->title . ', ' .
				            trans( 'attendance.hour' ) . ': ' . $hour;

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

	/**
	 * @param AddAttendanceRequest $request
	 * @param $hour
	 * @param $semestar
	 * @param $subject_id
	 * @param $date
	 */
	private function add_attendance_to_student( AddAttendanceRequest $request, $hour, $semestar, $subject_id, $date ) {
		foreach ( $request['students'] as $student_id ) {
			$attendance                 = new Attendance( $request->except( 'students', 'hour','section_id' ) );
			$attendance->teacher_id     = $this->user->id;
			$attendance->student_id     = $student_id;
			$attendance->semester_id    = isset( $semestar->id ) ? $semestar->id : 1;
			$attendance->subject_id     = $subject_id;
			$attendance->hour           = $hour;
			$attendance->school_year_id = session( 'current_school_year' );
			$attendance->save();

			//event(new AttendanceCreated($attendance));
			if ( Settings::get( 'automatic_sms_mark' ) == 1 && Settings::get( 'sms_driver' ) != "" && Settings::get( 'sms_driver' ) != 'none' ) {
				$this->send_sms_to_parent( $request, $student_id, $date, $hour );
			}
		}
	}

}
