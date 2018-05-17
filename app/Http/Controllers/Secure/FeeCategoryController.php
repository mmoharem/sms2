<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\FeeCategoryRequest;
use App\Models\FeeCategory;
use App\Models\Option;
use App\Repositories\FeeCategoryRepository;
use App\Repositories\FeePeriodRepository;
use App\Repositories\SectionRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Sentinel;

class FeeCategoryController extends SecureController {
	/**
	 * @var FeeCategoryRepository
	 */
	private $feeCategoryRepository;
	/**
	 * @var FeePeriodRepository
	 */
	private $feesPeriodRepository;

	/**
	 * @var SectionRepository
	 */
	private $sectionRepository;

	/**
	 * FeeCategoryController constructor.
	 *
	 * @param FeeCategoryRepository $feeCategoryRepository
	 * @param SectionRepository $sectionRepository
	 * @param FeePeriodRepository $feesPeriodRepository
	 */
	public function __construct(
		FeeCategoryRepository $feeCategoryRepository,
		SectionRepository $sectionRepository,
		FeePeriodRepository $feesPeriodRepository
	) {
		parent::__construct();

		$this->feeCategoryRepository = $feeCategoryRepository;
		$this->feesPeriodRepository  = $feesPeriodRepository;
		$this->sectionRepository     = $sectionRepository;

		$this->middleware( 'authorized:fee_category.show', [ 'only' => [ 'index', 'data' ] ] );
		$this->middleware( 'authorized:fee_category.create', [ 'only' => [ 'create', 'store' ] ] );
		$this->middleware( 'authorized:fee_category.edit', [ 'only' => [ 'update', 'edit' ] ] );
		$this->middleware( 'authorized:fee_category.delete', [ 'only' => [ 'delete', 'destroy' ] ] );

		view()->share( 'type', 'fee_category' );

		$columns = [ 'title', 'section', 'currency', 'amount', 'period', 'actions' ];
		view()->share( 'columns', $columns );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$title = trans( 'fee_category.fee_categories' );

		return view( 'fee_category.index', compact( 'title' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		$title = trans( 'fee_category.new' );

		$this->generateParams();

		return view( 'layouts.create', compact( 'title' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  FeeCategoryRequest $request
	 *
	 * @return Response
	 */
	public function store( FeeCategoryRequest $request ) {
		$feeCategory = new FeeCategory( $request->all() );
		if ( ! Sentinel::getUser()->inRole( 'super_admin' ) ) {
			$feeCategory->school_id = session( 'current_school' );
		}
		$feeCategory->user_id = Sentinel::getUser()->id;
		$feeCategory->save();

		return redirect( '/fee_category' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  FeeCategory $feeCategory
	 *
	 * @return Response
	 */
	public function show( FeeCategory $feeCategory ) {
		$title  = trans( 'fee_category.details' );
		$action = 'show';

		return view( 'layouts.show', compact( 'feeCategory', 'title', 'action' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param FeeCategory $feeCategory
	 *
	 * @return Response
	 */
	public function edit( FeeCategory $feeCategory ) {
		$title = trans( 'fee_category.edit' );
		$this->generateParams();

		return view( 'layouts.edit', compact( 'title', 'feeCategory', 'feesPeriods', 'currencies', 'sections' ) );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  FeeCategoryRequest $request
	 * @param  FeeCategory $feeCategory
	 *
	 * @return Response
	 */
	public function update( FeeCategoryRequest $request, FeeCategory $feeCategory ) {
		$feeCategory->update( $request->all() );

		return redirect( '/fee_category' );
	}


	public function delete( FeeCategory $feeCategory ) {
		$title = trans( 'fee_category.delete' );

		return view( '/fee_category/delete', compact( 'feeCategory', 'title' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  FeeCategory $feeCategory
	 *
	 * @return Response
	 */
	public function destroy( FeeCategory $feeCategory ) {
		$feeCategory->delete();

		return redirect( '/fee_category' );
	}


	public function findFeeCategoryAmount( Request $request ) {
		$feeAmount = FeeCategory::find( $request->fee_category_id );

		return $feeAmount->amount;
	}

	public function data() {
		if ( Sentinel::getUser()->inRole( 'super_admin' ) ) {
			$feeCategorys = $this->feeCategoryRepository->getAll();
		} else {
			$feeCategorys = $this->feeCategoryRepository->getAllForSchool( session( 'current_school' ) );
		}
		$feeCategorys = $feeCategorys->get()
		                             ->map( function ( $feeCategory ) {
			                             return [
				                             'id'       => $feeCategory->id,
				                             'title'    => $feeCategory->title,
				                             'section'  => isset( $feeCategory->section ) ? $feeCategory->section->title : "-",
				                             'currency' => isset( $feeCategory->currency ) ? $feeCategory->currency->title : "-",
				                             'amount'   => $feeCategory->amount,
				                             'period'   => isset( $feeCategory->feesPeriod ) ? $feeCategory->feesPeriod->name : "-",
			                             ];
		                             } );

		return Datatables::make( $feeCategorys )
		                 ->addColumn( 'actions', '@if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'fee_category.edit\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/fee_category/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'fee_category.show\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/fee_category/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @endif
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'fee_category.delete\', Sentinel::getUser()->permissions)))
                                     <a href="{{ url(\'/fee_category/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                    @endif' )
		                 ->removeColumn( 'id' )
		                 ->rawColumns( [ 'actions' ] )->make();
	}

	/**
	 * @return array
	 */
	private function generateParams() {
		$feesPeriods = $this->feesPeriodRepository
			->getAllForSchool( session( 'current_school' ) )
			->get()
			->pluck( 'name', 'id' )
			->prepend( trans( 'student.select_fees_period' ), 0 )
			->toArray();

		$currencies = Option::where( 'category', 'currency' )->pluck( 'title', 'id' )->toArray();

		$sections = $this->sectionRepository
			->getAllForSchoolYearSchool( session( 'current_school_year' ), session( 'current_school' ) )
			->get()
			->pluck( 'title', 'id' )
			->prepend( trans( 'student.select_section' ), 0 )
			->toArray();

		view()->share( 'feesPeriods', $feesPeriods );
		view()->share( 'currencies', $currencies );
		view()->share( 'sections', $sections );
	}
}
