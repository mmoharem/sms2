<?php

namespace App\Http\Controllers\Secure;

use App\Models\Registration;
use App\Models\Student;
use App\Models\Semester;
use App\Models\StudentGroup;
use App\Repositories\FeeCategoryRepository;
use App\Repositories\RegistrationRepository;
use App\Repositories\SectionRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\DirectionRepository;
use App\Repositories\OptionRepository;
use App\Repositories\LevelRepository;
use App\Repositories\StudentRepository;
use Yajra\DataTables\Facades\DataTables;
use Efriandika\LaravelSettings\Facades\Settings;
use DB;
use App\Http\Requests\Secure\RegistrationRequest;
use PDF;

class RegistrationController extends SecureController {
	/**
	 * @var RegistrationRepository
	 */
	private $registrationRepository;
	/**
	 * @var StudentRepository
	 */
	private $studentRepository;
	/**
	 * @var SectionRepository
	 */
	private $sectionRepository;
	/**
	 * @var SectionRepository
	 */
	private $subjectRepository;
	/**
	 * @var FeeCategoryRepository
	 */
	private $feeCategoryRepository;
	/**
	 * @var OptionRepository
	 */
	private $optionRepository;
	/**
	 * @var DirectionRepository
	 */
	private $directionRepository;
	/**
	 * @var DirectionRepository
	 */
	private $levelRepository;

	/**
	 * RegistrationController constructor.
	 *
	 * @param RegistrationRepository $registrationRepository
	 * @param StudentRepository $studentRepository
	 * @param SubjectRepository $subjectRepository
	 * @param LevelRepository $levelRepository
	 * @param FeeCategoryRepository $feeCategoryRepository
	 * @param DirectionRepository $directionRepository
	 * @param SectionRepository $sectionRepository
	 * @param OptionRepository $optionRepository
	 */
	public function __construct(
		RegistrationRepository $registrationRepository,
		StudentRepository $studentRepository,
		SubjectRepository $subjectRepository,
		LevelRepository $levelRepository,
		FeeCategoryRepository $feeCategoryRepository,
		DirectionRepository $directionRepository,
		SectionRepository $sectionRepository,
		OptionRepository $optionRepository
	) {
		parent::__construct();

		$this->registrationRepository = $registrationRepository;
		$this->studentRepository      = $studentRepository;
		$this->subjectRepository      = $subjectRepository;
		$this->feeCategoryRepository  = $feeCategoryRepository;
		$this->optionRepository       = $optionRepository;
		$this->sectionRepository      = $sectionRepository;
		$this->levelRepository        = $levelRepository;
		$this->directionRepository    = $directionRepository;

		$this->middleware( 'authorized:registration.show', [ 'only' => [ 'index', 'data' ] ] );
		$this->middleware( 'authorized:registration.create', [ 'only' => [ 'create', 'store' ] ] );
		$this->middleware( 'authorized:registration.edit', [ 'only' => [ 'update', 'edit' ] ] );
		$this->middleware( 'authorized:registration.delete', [ 'only' => [ 'delete', 'destroy' ] ] );

		view()->share( 'type', 'registration' );

		$columns = [ 'student_no', 'full_name', 'semester', 'academic_year', 'subject', 'date', 'actions' ];
		view()->share( 'columns', $columns );
	}

	/**
	 * Display a listing of the resource.
	 *
	 */
	public function index() {
		$title = trans( 'registration.registration' );

		$sections      = $this->sectionRepository
			->getAllForSchoolYearSchool( session( 'current_school_year' ), session( 'current_school' ) )
			->get();
		$registrations = $this->registrationRepository->getAllStudentsForSchool( session( 'current_school' ) )
		                                              ->get();
		$students      = $this->studentRepository->getAllForSchoolYearAndSchool( session( 'current_school_year' ), session( 'current_school' ) )
		                                         ->get();

		return view( 'registration.index', compact( 'title', 'sections', 'registrations', 'students' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 */
	public function create() {
		$title = trans( 'registration.new' );
		$this->generateParams();

		$sections = $this->sectionRepository
			->getAllForSchoolYearSchool( session( 'current_school_year' ), session( 'current_school' ) )
			->get()
			->pluck( 'title', 'id' )
			->prepend( trans( 'student.select_section' ), 0 )
			->toArray();

		return view( 'layouts.create', compact( 'title', 'sections') );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param RegistrationRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store( RegistrationRequest $request ) {
		foreach ( $request->get( 'user_id' ) as $user_id ) {

			$student = Student::where( 'user_id', $user_id )->where( 'school_year_id', session( 'current_school_year' ) )
			                  ->where( 'school_id', session( 'current_school' ) )
			                  ->first();

			$semester = Semester::where( 'school_id', '=', session( 'current_school' ) )
			                    ->orWhereNull( 'school_id' )->orderBy( 'id', 'desc' )->first();

			foreach ( $request->get( 'subject_id' ) as $subject_id ) {

				$user_exists = Registration::where( 'user_id', $user_id )
				                           ->where( 'school_year_id', session( 'current_school_year' ) )
				                           ->where( 'school_id', '=', session( 'current_school' ) )
				                           ->where( 'subject_id', '=', $subject_id )
				                           ->where( function ( $w ) use ( $semester ) {
					                           if ( isset( $semester->id ) ) {
						                           return $w->where( 'semester_id', $semester->id );
					                           } else {
						                           return null;
					                           }
				                           } )->first();
				if ( ! isset( $user_exists->id ) ) {
					$registration                 = new Registration( $request->only( 'level_id', 'remarks', 'section_id', 'student_group_id' ) );
					$registration->user_id        = $user_id;
					$registration->student_id     = $student->id;
					$registration->subject_id     = $subject_id;
					$registration->school_id      = session( 'current_school' );
					$registration->school_year_id = session( 'current_school_year' );
					$registration->semester_id    = isset( $semester->id ) ? $semester->id : 0;
					$registration->save();
				}
			}
		}

		return redirect( '/registration' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Registration $registration
	 *
	 * @return Response
	 */
	public function show( Registration $registration ) {
		$pdf = PDF::loadView( 'report.registration', compact( 'registration' ) );
		return $pdf->stream();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Registration $registration
	 *
	 * @return Response
	 */
	public function edit( Registration $registration ) {
		$title = trans( 'registration.edit' );
		$this->generateParams();
		$subjects = $this->subjectRepository->getAllForStudentGroup( $registration->student_group_id )
		                                    ->get()
		                                    ->map( function ( $subject ) {
			                                    return [
				                                    'id'   => $subject->id,
				                                    'name' => $subject->title,
			                                    ];
		                                    } )->pluck( 'name', 'id' );


		$levels = $this->levelRepository->getAllForSection( session( 'current_school' ) )
		                                ->get()
		                                ->pluck( 'name', 'id' )
		                                ->prepend( trans( 'student.select_level' ), 0 )
		                                ->toArray();

		return view( 'layouts.edit', compact( 'title', 'registration', 'subjects', 'levels' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param RegistrationRequest $request
	 * @param  Registration $registration
	 * @return Response
	 */
	public function update( RegistrationRequest $request, Registration $registration ) {
		$registration->update( $request->only( 'user_id', 'level_id', 'subject_id', 'remarks' ) );

		return redirect( '/registration' );
	}

	/**
	 *
	 *
	 * @param  Registration $registration
	 *
	 * @return Response
	 */
	public function delete( Registration $registration ) {
		$title = trans( 'registration.delete' );

		return view( '/registration/delete', compact( 'registration', 'title' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Registration $registration
	 *
	 * @return Response
	 */
	public function destroy( Registration $registration ) {
		$registration->delete();

		return redirect( '/registration' );
	}

	public function data() {
		$one_school = ( Settings::get( 'account_one_school' ) == 'yes' ) ? true : false;
		if ( $one_school && $this->user->inRole( 'accountant' ) ) {
			$registrations = $this->registrationRepository->getAllStudentsForSchool( session( 'current_school' ) );
		} else {
			$registrations = $this->registrationRepository->getAll();
		}
		$registrations = $registrations->get()
		                               ->map( function ( $registration ) {
			                               return [
				                               "id"            => $registration->id,
				                               "student_no"    => $registration->student_no,
				                               "full_name"     => $registration->full_name,
				                               "semester"      => $registration->semester,
				                               "academic_year" => $registration->school_year,
				                               "subject"       => $registration->subject,
				                               "date"          => $registration->created_at->format( Settings::get( 'date_format' ) ),
			                               ];
		                               } );

		return Datatables::make( $registrations )
		                 ->addColumn( 'actions', '@if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'registration.edit\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/registration/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    <a target="_blank" href="{{ url(\'/registration/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'registration.delete\', Sentinel::getUser()->permissions)))
                                     <a href="{{ url(\'/registration/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif' )
		                 ->removeColumn( 'id' )
		                 ->rawColumns( [ 'actions' ] )->make();
	}

	/**
	 * @return mixed
	 */
	private function generateParams() {
		$one_school = ( Settings::get( 'account_one_school' ) == 'yes' ) ? true : false;
		if ( $one_school && $this->user->inRole( 'accountant' ) ) {
			$students = $this->studentRepository->getAllForSchoolYearAndSchool( session( 'current_school_year' ), session( 'current_school' ) )
			                                    ->with( 'user' )
			                                    ->get()
			                                    ->map( function ( $item ) {
				                                    return [
					                                    "id"   => $item->user_id,
					                                    "name" => isset( $item->user ) ? $item->user->full_name : "",
				                                    ];
			                                    } )->pluck( "name", 'id' )->toArray();
		} else {
			$students = $this->studentRepository->getAllForSchoolYear( session( 'current_school_year' ) )
			                                    ->with( 'user' )
			                                    ->get()
			                                    ->map( function ( $item ) {
				                                    return [
					                                    "id"   => $item->user_id,
					                                    "name" => isset( $item->user ) ? $item->user->full_name : "",
				                                    ];
			                                    } )->pluck( "name", 'id' )->toArray();
		}
		view()->share( 'students', $students );

		$sections = $this->sectionRepository
			->getAllForSchoolYearSchool( session( 'current_school_year' ), session( 'current_school' ) )
			->get()
			->pluck( 'title', 'id' )
			->prepend( trans( 'student.select_section' ), 0 )
			->toArray();
		view()->share( 'sections', $sections );

		$levels = $this->levelRepository
			->getAllForSchool( session( 'current_school' ) )
			->get()
			->pluck( 'name', 'id' )
			->prepend( trans( 'student.select_level' ), 0 )
			->toArray();
		view()->share( 'levels', $levels );
	}

	public function subjectsStudents( StudentGroup $studentGroup ) {
		$students = $this->studentRepository->getAllForStudentGroup( $studentGroup->id );
		$subjects = $this->subjectRepository->getAllForStudentGroup( $studentGroup->id )
		                                    ->get()
		                                    ->map( function ( $subject ) {
			                                    return [
				                                    'id'   => $subject->id,
				                                    'name' => $subject->title,
			                                    ];
		                                    } );

		return response()->json( [ 'subjects' => $subjects, 'students' => $students ] );
	}

}
