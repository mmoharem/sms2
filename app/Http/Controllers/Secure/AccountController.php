<?php

namespace App\Http\Controllers\Secure;

use App\Models\Account;
use App\Repositories\AccountRepository;
use App\Repositories\AccountTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Secure\AccountRequest;

class AccountController extends SecureController
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;
    /**
     * @var AccountTypeRepository
     */
    private $accountTypeRepository;
	/**
	 * AccountController constructor.
	 *
	 * @param AccountRepository $accountRepository
	 * @param AccountTypeRepository $accountTypeRepository
	 */
    public function __construct(AccountRepository $accountRepository,
                                AccountTypeRepository $accountTypeRepository)
    {
        $this->middleware('authorized:account.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:account.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:account.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:account.delete', ['only' => ['delete', 'destroy']]);

        parent::__construct();

        $this->accountRepository = $accountRepository;
        $this->accountTypeRepository = $accountTypeRepository;

        view()->share('type', 'account');

        $columns = ['title', 'code', 'type', 'actions'];
        view()->share('columns', $columns);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('account.accounts');
        return view('account.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('account.new');

        $accountTypes = $this->accountTypeRepository
            ->getAllForSchool(session('current_school'))
            ->get()
            ->pluck('title', 'id')
            ->prepend(trans('account.select_account_type'), 0)
            ->toArray();

        return view('layouts.create', compact('title', 'accountTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|AccountRequest $request
     * @return Response
     */
    public function store(AccountRequest $request)
    {
        $account = new Account($request->all());
        $account->school_id = session('current_school');
        $account->save();

        return redirect('/account');
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @return Response
     */
    public function show(Account $account)
    {
        $title = trans('account.details');
        $action = 'show';
        return view('layouts.show', compact('account', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Account $account
     * @return Response
     * @internal param int $id
     */
    public function edit(Account $account)
    {
        $title = trans('account.edit');

        $accountTypes = $this->accountTypeRepository
            ->getAllForSchool(session('current_school'))
            ->get()
            ->pluck('title', 'id')
            ->prepend(trans('account.select_account_type'), 0)
            ->toArray();

        return view('layouts.edit', compact('title', 'account', 'accountTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountRequest $request
     * @param Account $account
     * @return Response
     */
    public function update(AccountRequest $request, Account $account)
    {
        $account->update($request->all());
        return redirect('/account');
    }

    public function delete(Account $account)
    {
        $title = trans('account.delete');
        return view('/account/delete', compact('account', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Account $account
     * @return Response
     * @internal param int $id
     */
    public function destroy(Account $account)
    {
        $account->delete();
        return redirect('/account');
    }

    public function data()
    {
        $financialAccounts = $this->accountRepository->getAllForSchool(session('current_school'))
            ->get()
            ->map(function ($account) {
                return [
                    'id' => $account->id,
                    'title' => $account->title,
                    'code' => $account->code,
                    'type' => $account->type->title,
                ];
            });

        return Datatables::make( $financialAccounts)
            ->addColumn('actions', '@if(!Sentinel::getUser()->inRole(\'admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'account.edit\', Sentinel::getUser()->permissions)))
									<a href="{{ url(\'/account/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    @if(!Sentinel::getUser()->inRole(\'admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'account.show\', Sentinel::getUser()->permissions)))
                                    	<a href="{{ url(\'/account/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @endif
                                     @if(!Sentinel::getUser()->inRole(\'admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'account.delete\', Sentinel::getUser()->permissions)))
                                     	<a href="{{ url(\'/account/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                    @endif')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }
}
