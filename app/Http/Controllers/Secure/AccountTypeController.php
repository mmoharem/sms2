<?php

namespace App\Http\Controllers\Secure;

use App\Models\AccountType;
use App\Repositories\AccountRepository;
use App\Repositories\AccountTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Secure\AccountTypeRequest;

class AccountTypeController extends SecureController {
	/**
	 * @var AccountRepository
	 */
	private $accountRepository;
	/**
	 * @var AccountTypeRepository
	 */
	private $accountTypeRepository;
	/**
	 * BehaviorController constructor.
	 *
	 * @param AccountRepository $accountRepository
	 * @param AccountTypeRepository $accountTypeRepository
	 */
	public function __construct(
		AccountRepository $accountRepository,
		AccountTypeRepository $accountTypeRepository
	) {
		$this->middleware( 'authorized:account_type.show', [ 'only' => [ 'index', 'data' ] ] );
		$this->middleware( 'authorized:account_type.create', [ 'only' => [ 'create', 'store' ] ] );
		$this->middleware( 'authorized:account_type.edit', [ 'only' => [ 'update', 'edit' ] ] );
		$this->middleware( 'authorized:account_type.delete', [ 'only' => [ 'delete', 'destroy' ] ] );

		parent::__construct();

		$this->accountRepository     = $accountRepository;
		$this->accountTypeRepository = $accountTypeRepository;

		view()->share( 'type', 'account_type' );

		$columns = [ 'title', 'actions' ];
		view()->share( 'columns', $columns );

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$title = trans( 'account_type.account_type' );

		return view( 'account_type.index', compact( 'title' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		$title = trans( 'account_type.new' );

		return view( 'layouts.create', compact( 'title' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param AccountTypeRequest $request
	 *
	 * @return Response
	 */
	public function store( AccountTypeRequest $request ) {
		$accountType            = new AccountType( $request->all() );
		$accountType->school_id = session( 'current_school' );
		$accountType->save();

		return redirect( '/account_type' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param AccountType $accountType
	 *
	 * @return Response
	 */
	public function show( AccountType $accountType ) {
		$title  = trans( 'account_type.details' );
		$action = 'show';

		return view( 'layouts.show', compact( 'accountType', 'title', 'action' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param AccountType $accountType
	 *
	 * @return Response
	 */
	public function edit( AccountType $accountType ) {
		$title = trans( 'account_type.edit' );

		return view( 'layouts.edit', compact( 'title', 'accountType' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param AccountTypeRequest $request
	 * @param AccountType $accountType
	 *
	 * @return Response
	 */
	public function update( AccountTypeRequest $request, AccountType $accountType ) {
		$accountType->update( $request->all() );

		return redirect( '/account_type' );
	}

	public function delete( AccountType $accountType ) {
		$title = trans( 'account_type.delete' );

		return view( '/account_type/delete', compact( 'accountType', 'title' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param AccountType $accountType
	 *
	 * @return Response
	 */
	public function destroy( AccountType $accountType ) {
		$accountType->delete();

		return redirect( '/account_type' );
	}

	public function data() {
		$accountTypes = $this->accountTypeRepository->getAllForSchool( session( 'current_school' ) )
		                                            ->get()
		                                            ->map( function ( $accountType ) {
			                                            return [
				                                            'id'    => $accountType->id,
				                                            'title' => $accountType->title,
			                                            ];
		                                            } );

		return Datatables::make( $accountTypes )
		                 ->addColumn( 'actions', '@if(!Sentinel::getUser()->inRole(\'admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'account_type.edit\', Sentinel::getUser()->permissions)))
									<a href="{{ url(\'/account_type/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    @if(!Sentinel::getUser()->inRole(\'admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'account_type.show\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/account_type/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     @endif
                                     @if(!Sentinel::getUser()->inRole(\'admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'account_type.delete\', Sentinel::getUser()->permissions)))
                                     <a href="{{ url(\'/account_type/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                    @endif' )
		                 ->removeColumn( 'id' )
		                 ->rawColumns( [ 'actions' ] )->make();
	}
}
