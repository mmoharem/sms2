<?php

namespace App\Http\Controllers\Secure;

use App\Models\Semester;
use App\Repositories\SchoolRepository;
use App\Repositories\SchoolYearRepository;
use App\Repositories\SemesterRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Secure\SemesterRequest;

class SemesterController extends SecureController {
	/**
	 * @var SchoolYearRepository
	 */
	private $schoolYearRepository;
	/**
	 * @var SemesterRepository
	 */
	private $semesterRepository;
	/**
	 * @var SchoolRepository
	 */
	private $schoolRepository;

	/**
	 * SemesterController constructor.
	 *
	 * @param SchoolYearRepository $schoolYearRepository
	 * @param SemesterRepository $semesterRepository
	 * @param SchoolRepository $schoolRepository
	 */
	public function __construct(
		SchoolYearRepository $schoolYearRepository,
		SemesterRepository $semesterRepository,
		SchoolRepository $schoolRepository
	) {
		parent::__construct();
		view()->share( 'type', 'semester' );

		$columns = [ 'title', 'start', 'end', 'year', 'school', 'active', 'actions' ];
		view()->share( 'columns', $columns );

		$this->schoolYearRepository = $schoolYearRepository;
		$this->semesterRepository   = $semesterRepository;
		$this->schoolRepository     = $schoolRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$title = trans( 'semester.semesters' );

		return view( 'semester.index', compact( 'title' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		$title       = trans( 'semester.new' );
		$schoolyears = $this->schoolYearRepository->getAll()->pluck( 'title', 'id' )->toArray();
		$schools_list     = $this->schoolRepository->getAll()->get()
		                                      ->pluck( 'title', 'id' )
		                                      ->prepend( trans( 'schoolyear.select_school' ), 0 )
		                                      ->toArray();

		return view( 'layouts.create', compact( 'title', 'schoolyears', 'schools_list' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request|SemesterRequest $request
	 *
	 * @return Response
	 */
	public function store( SemesterRequest $request ) {
		$semester = new Semester( $request->all() );
		$semester->save();

		return redirect( '/semester' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Semester $semester
	 *
	 * @return Response
	 * @internal param int $id
	 */
	public function show( Semester $semester ) {
		$title  = trans( 'semester.details' );
		$action = 'show';

		return view( 'layouts.show', compact( 'semester', 'title', 'action' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Semester $semester
	 *
	 * @return Response
	 * @internal param int $id
	 */
	public function edit( Semester $semester ) {
		$title       = trans( 'semester.edit' );
		$schoolyears = $this->schoolYearRepository->getAll()->pluck( 'title', 'id' )->toArray();
		$schools_list     = $this->schoolRepository
			->getAll()
			->get()
			->pluck( 'title', 'id' )
			->prepend( trans( 'schoolyear.select_school' ), 0 )
			->toArray();

		return view( 'layouts.edit', compact( 'title', 'schoolyears', 'semester', 'schools_list' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param SemesterRequest $request
	 * @param Semester $semester
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update( SemesterRequest $request, Semester $semester ) {
		$semester->update( $request->all() );

		return redirect( '/semester' );
	}

	/**
	 * @param Semester $semester
	 *
	 * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function delete( Semester $semester ) {
		$title = trans( 'semester.delete' );

		return view( '/semester/delete', compact( 'semester', 'title' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Semester $semester
	 *
	 * @return Response
	 * @internal param int $id
	 */
	public function destroy( Semester $semester ) {
		$semester->delete();

		return redirect( '/semester' );
	}
	public function active( Semester $semester ) {
		if($semester->school_id > 0 ){
            $semesters = $this->semesterRepository->getAllForSchool($semester->school_id)->get();
            foreach($semesters as $semester){
                Semester::find($semester->id)->update(['active'=>0]);
            }
			$semester->active = 1;
			$semester->save();
		}else{
			$semesters = $this->semesterRepository->getAll()->get();
            foreach($semesters as $semester){
                Semester::find($semester->id)->update(['active'=>0]);
            }
			$semester->active = 1;
			$semester->save();
		}
		return redirect( '/semester' );
	}

	public function data() {
		$semesters = $this->semesterRepository->getAll()
		                                      ->with( 'school_year' )
		                                      ->get()
		                                      ->map( function ( $semester ) {
			                                      return [
				                                      'id'     => $semester->id,
				                                      'title'  => $semester->title,
				                                      'start'  => $semester->start,
				                                      'end'    => $semester->end,
				                                      'active'    => ($semester->active == 1)?trans('semester.active'):trans('semester.archive'),
				                                      'year'   => isset( $semester->school_year ) ? $semester->school_year->title : "",
				                                      'school' => isset( $semester->school ) ? $semester->school->title : trans( 'semester.all' ),
			                                      ];
		                                      } );

		return Datatables::make( $semesters )
		                 ->addColumn( 'actions', '<a href="{{ url(\'/semester/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/semester/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/semester/\' . $id . \'/active\' ) }}" class="btn btn-info btn-sm" >
                                            <i class="fa fa-archive"></i>  {{ trans("semester.active") }}</a>
                                     <a href="{{ url(\'/semester/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>' )
		                 ->removeColumn( 'id' )
		                 ->rawColumns( [ 'actions' ] )
		                 ->make();
	}
}
