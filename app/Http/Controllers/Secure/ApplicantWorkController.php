<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\ApplicantWorkRequest;
use App\Models\ApplicantWork;
use App\Repositories\ApplicantWorkRepository;
use Yajra\DataTables\Facades\DataTables;
use Sentinel;

class ApplicantWorkController extends SecureController {
	/**
	 * @var ApplicantWorkRepository
	 */
	private $applicantWorkRepository;

	/**
	 * BehaviorController constructor.
	 *
	 * @param ApplicantWorkRepository $applicantWorkRepository
	 */
	public function __construct(
		ApplicantWorkRepository $applicantWorkRepository
	) {
		parent::__construct();

		$this->applicantWorkRepository = $applicantWorkRepository;

		view()->share( 'type', 'applicant_work' );

		$columns = [ 'company', 'position', 'start_date', 'end_date',  'actions' ];
		view()->share( 'columns', $columns );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$title = trans( 'applicant_work.applicant_works' );

		return view( 'applicant_work.index', compact( 'title' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		$title = trans( 'applicant_work.new' );

		return view( 'layouts.create', compact( 'title' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param ApplicantWorkRequest $request
	 *
	 * @return Response
	 */
	public function store( ApplicantWorkRequest $request ) {
		$applicantWork               = new ApplicantWork( $request->all() );
		$applicantWork->user_id      = Sentinel::getUser()->id;
		$applicantWork->save();

		return redirect( '/applicant_work' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param ApplicantWork $applicantWork
	 *
	 * @return Response
	 */
	public function show( ApplicantWork $applicantWork ) {
		$title  = trans( 'applicant_work.details' );
		$action = 'show';

		return view( 'layouts.show', compact( 'applicantWork', 'title', 'action' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param ApplicantWork $applicantWork
	 *
	 * @return Response
	 */
	public function edit( ApplicantWork $applicantWork ) {
		$title = trans( 'applicant_work.edit' );

		return view( 'layouts.edit', compact( 'title', 'applicantWork' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param ApplicantWorkRequest $request
	 * @param ApplicantWork $applicantWork
	 *
	 * @return Response
	 */
	public function update( ApplicantWorkRequest $request, ApplicantWork $applicantWork ) {
		$applicantWork->update( $request->all() );

		return redirect( '/applicant_work' );
	}

	public function delete( ApplicantWork $applicantWork ) {
		$title = trans( 'applicant_work.delete' );

		return view( '/applicant_work/delete', compact( 'applicantWork', 'title' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param ApplicantWork $applicantWork
	 *
	 * @return Response
	 */
	public function destroy( ApplicantWork $applicantWork ) {
		$applicantWork->delete();

		return redirect( '/applicant_work' );
	}

	public function data() {
		$works = $this->applicantWorkRepository->getAllForApplicant( Sentinel::getUser()->id )
		                                       ->get()
		                                       ->map( function ( $work ) {
			                                       return [
				                                       'id'         => $work->id,
				                                       'company'      => $work->company,
				                                       'position'   => $work->position,
				                                       'start_date' => $work->start_date,
				                                       'end_date'   => (($work->end_date=='0000-00-00')?"-":$work->end_date),
			                                       ];
		                                       } );

		return Datatables::make( $works )
		                 ->addColumn( 'actions', '<a href="{{ url(\'/applicant_work/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/applicant_work/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/applicant_work/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>' )
		                 ->removeColumn( 'id' )
		                 ->rawColumns( [ 'actions' ] )->make();
	}
}
