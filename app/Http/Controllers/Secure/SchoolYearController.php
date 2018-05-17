<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\CreateAluminiRequest;
use App\Http\Requests\Secure\CreateNewSections;
use App\Http\Requests\Secure\SchoolYearRequest;
use App\Models\Alumini;
use App\Models\AluminiStudent;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentGroup;
use App\Repositories\SchoolRepository;
use App\Repositories\SchoolYearRepository;
use App\Repositories\SectionRepository;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;

class SchoolYearController extends SecureController {
	/**
	 * @var SchoolYearRepository
	 */
	private $schoolYearRepository;
	/**
	 * @var SectionRepository
	 */
	private $sectionRepository;
	/**
	 * @var StudentRepository
	 */
	private $studentRepository;
	/**
	 * @var SchoolRepository
	 */
	private $schoolRepository;

	/**
	 * SchoolYearController constructor.
	 *
	 * @param SchoolYearRepository $schoolYearRepository
	 * @param SectionRepository $sectionRepository
	 * @param StudentRepository $studentRepository
	 * @param SchoolRepository $schoolRepository
	 */
	public function __construct(
		SchoolYearRepository $schoolYearRepository,
		SectionRepository $sectionRepository,
		StudentRepository $studentRepository,
		SchoolRepository $schoolRepository
	) {
		parent::__construct();

		$this->schoolYearRepository = $schoolYearRepository;
		$this->sectionRepository    = $sectionRepository;
		$this->studentRepository    = $studentRepository;
		$this->schoolRepository     = $schoolRepository;

		view()->share( 'type', 'schoolyear' );

		$columns = [ 'title', 'id_code', 'school', 'actions' ];
		view()->share( 'columns', $columns );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$title = trans( 'schoolyear.schoolyear' );

		return view( 'schoolyear.index', compact( 'title' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		$title = trans( 'schoolyear.new' );

		$schools_lists = $this->schoolRepository
			->getAll()
			->get()
			->pluck( 'title', 'id' )
			->prepend( trans( 'schoolyear.select_school' ), 0 );

		return view( 'layouts.create', compact( 'title', 'schools_lists' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param SchoolYearRequest $request
	 *
	 * @return Response
	 */
	public function store( SchoolYearRequest $request ) {
		$schoolYear = new SchoolYear( $request->all() );
		$schoolYear->save();

		return redirect( '/schoolyear' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  SchoolYear $schoolYear
	 *
	 * @return Response
	 */
	public function show( SchoolYear $schoolYear ) {
		$title    = trans( 'schoolyear.details' );
		$action   = 'show';
		$students = [];
		if ( is_null( $schoolYear->school ) ) {
			foreach ( $this->schoolRepository->getAll()->get() as $item ) {
				$students[ $item->title ] = $this->studentRepository->getCountStudentsForSchoolAndSchoolYear( $item->id, $schoolYear->id );
			}
		} else {
			$students[ $schoolYear->school->title ] = $this->studentRepository->getCountStudentsForSchoolAndSchoolYear( $schoolYear->school->id, $schoolYear->id );
		}

		return view( 'layouts.show', compact( 'schoolYear', 'title', 'action', 'students' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  SchoolYear $schoolYear
	 *
	 * @return Response
	 */
	public function edit( SchoolYear $schoolYear ) {
		$title = trans( 'schoolyear.edit' );

        $schools_lists = $this->schoolRepository
			->getAll()
			->get()
			->pluck( 'title', 'id' )
			->prepend( trans( 'schoolyear.select_school' ), 0 );

		return view( 'layouts.edit', compact( 'title', 'schoolYear', 'schools_lists' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param SchoolYearRequest $request
	 * @param  SchoolYear $schoolYear
	 *
	 * @return Response
	 */
	public function update( SchoolYearRequest $request, SchoolYear $schoolYear ) {
		$schoolYear->update( $request->all() );

		return redirect( '/schoolyear' );
	}

	/**
	 * @param SchoolYear $schoolYear
	 *
	 * @return Response
	 */
	public function delete( SchoolYear $schoolYear ) {
		$title = trans( 'schoolyear.delete' );

		return view( '/schoolyear/delete', compact( 'schoolYear', 'title' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  SchoolYear $schoolYear
	 *
	 * @return Response
	 */
	public function destroy( SchoolYear $schoolYear ) {
		$schoolYear->delete();

		return redirect( '/schoolyear' );
	}

	/**
	 * @return mixed
	 */
	public function data() {
		$schoolYears = $this->schoolYearRepository->getAll()
		                                          ->get()
		                                          ->map( function ( $schoolYear ) {
			                                          return [
				                                          'id'      => $schoolYear->id,
				                                          'title'   => $schoolYear->title,
				                                          'id_code' => $schoolYear->id_code,
				                                          'school'  => is_null( $schoolYear->school ) ? "" : $schoolYear->school->title,
			                                          ];
		                                          } );

		return Datatables::make( $schoolYears )
		                 ->addColumn( 'actions', '<a href="{{ url(\'/schoolyear/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                  	<a href="{{ url(\'/schoolyear/\' . $id . \'/copy_data\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-files-o"></i>  {{ trans("schoolyear.copy_sections_students") }}</a>
                                    <a href="{{ url(\'/schoolyear/\' . $id . \'/make_alumini\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-history"></i>  {{ trans("schoolyear.make_alumini") }}</a>
                                    <a href="{{ url(\'/schoolyear/\' . $id . \'/get_alumini\' ) }}" class="btn btn-info btn-sm" >
                                            <i class="fa fa-history"></i>  {{ trans("schoolyear.get_alumini") }}</a>
                                     <a href="{{ url(\'/schoolyear/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/schoolyear/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>' )
		                 ->removeColumn( 'id' )
		                 ->rawColumns( [ 'actions' ] )
		                 ->make();
	}

	/**
	 * @param SchoolYear $schoolYear
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function copyData( SchoolYear $schoolYear ) {
		$title            = trans( 'schoolyear.copy_sections_students_to' ) . $schoolYear->title;
		$school_year_list = $this->schoolYearRepository->getAll()->where( 'id', '<>', $schoolYear->id )
		                                               ->pluck( 'title', 'id' )->prepend( trans( 'schoolyear.schoolyear_select' ), 0 )->toArray();

		$school_list = $this->schoolRepository->getAll()->pluck( 'title', 'id' )
		                                      ->prepend( trans( 'schoolyear.select_school' ), 0 )->toArray();

		return view( 'schoolyear/copy', compact( 'schoolYear', 'title', 'school_year_list', 'school_list' ) );
	}

	/**
	 * @param SchoolYear $schoolYear
	 * @param School $school
	 *
	 * @return mixed
	 */
	public function getSections( SchoolYear $schoolYear, School $school ) {
		return $this->sectionRepository->getAllForSchoolYearSchool( $schoolYear->id, $school->id )->get()
		                               ->pluck( 'title', 'id' )->toArray();
	}

	/**
	 * @param Section $section
	 *
	 * @return mixed
	 */
	public function getStudents( Section $section ) {
		return $this->studentRepository->getAllForSection( $section->id )
		                               ->map( function ( $student ) {
			                               return [
				                               'id'    => $student->user_id,
				                               'title' => $student->user->full_name,
			                               ];
		                               } )
		                               ->pluck( 'title', 'id' )->toArray();
	}

	public function postData( SchoolYear $schoolYear, CreateNewSections $request ) {
		DB::beginTransaction();
		$section = Section::find( $request->get( 'section_id' ) );
		if ( isset( $section ) ) {
			$section_new                     = new Section();
			$section_new->school_year_id     = $schoolYear->id;
			$section_new->section_teacher_id = $section->section_teacher_id;
			$section_new->school_id          = $request->get( 'select_school_id' );
			$section_new->title              = $request->get( 'section_name' );
			$section_new->save();

			if ( ! empty( $request->get( 'students_list' ) ) ) {
				foreach ( $request->get( 'students_list' ) as $student_user_id ) {
					$old_student = Student::where( 'user_id', $student_user_id )
					                      ->where( 'school_year_id', $request->get( 'select_school_year_id' ) )
					                      ->where( 'school_id', $request->get( 'select_school_id' ) )->first();
					Student::create( [
						'school_year_id'   => $schoolYear->id,
						'user_id'          => $student_user_id,
						'section_id'       => $section_new->id,
						'school_id'        => $old_student->school_id,
						'order'            => $old_student->order,
						'intake_period_id' => $old_student->intake_period_id,
						'level_of_adm'     => $old_student->level_of_adm,
						'level_id'         => $old_student->level_id,
						'dormitory_id'     => $old_student->dormitory_id,
						'student_no'        => $old_student->student_no
					] );
				}
			}
		}
		DB::commit();

		return redirect()->back();
	}


	/**
	 * @param SchoolYear $schoolYear
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function makeAlumini( SchoolYear $schoolYear ) {
		$title = trans( 'schoolyear.make_alumini' ) . $schoolYear->title;

		$school_list = $this->schoolRepository->getAll()->pluck( 'title', 'id' );

		return view( 'schoolyear/make_alumini', compact( 'schoolYear', 'title', 'school_list' ) );
	}

	/**
	 * @param SchoolYear $schoolYear
	 * @param CreateAluminiRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postAlumini( SchoolYear $schoolYear, CreateAluminiRequest $request ) {
		DB::beginTransaction();
		$school_ids = $request->get( 'school_ids' );
		if ( is_null( $school_ids ) ) {
			$school_ids = $this->schoolRepository->getAll()->pluck( 'id', 'id' );
		} else {
			$school_ids = explode( ',', $school_ids );
		}
		$aluminiStudents = [];
		foreach ( $school_ids as $school ) {
			$students = $this->schoolRepository->getAllAluministudents( $school, $schoolYear->id )->get()
			                                   ->map( function ( $student ) {
				                                   return [
					                                   'student_id' => $student->student_id,
				                                   ];
			                                   } )->toArray();
			if ( count( $students ) > 0 ) {
				$aluminiStudents[ $school ] = $students;
			}
		}
		if ( count( $aluminiStudents ) > 0 ) {
			$alumini = Alumini::create( [ 'title' => $request->get( 'title' ), 'school_year_id' => $schoolYear->id ] );
			foreach ( $aluminiStudents as $school => $students ) {
				foreach ( $students as $student ) {
					AluminiStudent::create( [
						'alumini_id'     => $alumini->id,
						'student_id'     => $student['student_id'],
						'school_id'      => $school,
						'school_year_id' => $schoolYear->id
					] );
				}
			}
		}
		DB::commit();

		return back();
	}

	/**
	 * @param SchoolYear $schoolYear
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getAlumini( SchoolYear $schoolYear ) {
		$title = trans( 'schoolyear.get_alumini' ) . $schoolYear->title;

		$school_list = $this->schoolRepository->getAll()->pluck( 'title', 'id' );
		$aluminis    = Alumini::where( 'school_year_id', $schoolYear->id )->pluck( 'title', 'id' );

		return view( 'schoolyear/get_alumini', compact( 'schoolYear', 'title', 'school_list', 'aluminis' ) );
	}

	public function getAluminiStudents( SchoolYear $schoolYear, Alumini $alumini, Request $request ) {
		$aluminiStudents = AluminiStudent::join( 'students', 'students.id', 'alumini_students.student_id' )
		                                 ->join( 'users', 'users.id', 'students.user_id' )
		                                 ->join( 'schools', 'schools.id', 'students.school_id' )
		                                 ->where( 'alumini_students.school_year_id', $schoolYear->id )
		                                 ->where( 'alumini_students.alumini_id', $alumini->id );
		if ( ! is_null( $request->get( 'school_ids' ) ) ) {
			$aluminiStudents->whereIn( 'schools.id', $request->get( 'school_ids' ) );
		}

		return $aluminiStudents->select( 'users.first_name', 'users.last_name', 'schools.title' )->get();
	}

}
