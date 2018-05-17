<?php

namespace App\Http\Controllers\Secure;

use App\Models\Voucher;
use App\Repositories\AccountRepository;
use App\Repositories\VoucherRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Secure\VoucherRequest;
use Sentinel;

class VoucherController extends SecureController
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;
    /**
     * @var VoucherRepository
     */
    private $voucherRepository;


	/**
	 * BehaviorController constructor.
	 *
	 * @param AccountRepository $accountRepository
	 * @param VoucherRepository $voucherRepository
	 *
	 * @internal param BehaviorRepository $behaviorRepository
	 */
    public function __construct(AccountRepository $accountRepository,
                                VoucherRepository $voucherRepository)
    {

	    $this->middleware('authorized:voucher.show', ['only' => ['index', 'data']]);
	    $this->middleware('authorized:voucher.create', ['only' => ['create', 'store']]);
	    $this->middleware('authorized:voucher.edit', ['only' => ['update', 'edit']]);
	    $this->middleware('authorized:voucher.delete', ['only' => ['delete', 'destroy']]);

        parent::__construct();

        $this->accountRepository = $accountRepository;
        $this->voucherRepository = $voucherRepository;

        view()->share('type', 'voucher');

        $columns = ['code', 'debit_account', 'credit_account', 'amount','prep_by', 'actions'];
        view()->share('columns', $columns);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('voucher.vouchers');
        return view('voucher.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('voucher.new');

        $accounts = $this->accountRepository
            ->getAllForSchool(session('current_school'))
            ->get()
            ->pluck('title', 'id')
            ->prepend(trans('account.select_account_type'), 0)
            ->toArray();

        return view('layouts.create', compact('title', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VoucherRequest $request
     * @return Response
     */
    public function store(VoucherRequest $request)
    {
        $voucher = new Voucher($request->all());
        $voucher->school_id = session('current_school');
        $voucher->school_year_id = session('current_school_year');
        $voucher->prepared_user_id = Sentinel::getUser()->id;
        $voucher->save();

        return redirect('/voucher');
    }

    /**
     * Display the specified resource.
     *
     * @param Voucher $voucher
     * @return Response
     */
    public function show(Voucher $voucher)
    {
        $title = trans('voucher.details');
        $action = 'show';
        return view('layouts.show', compact('voucher', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Voucher $voucher
     * @return Response
     */
    public function edit(Voucher $voucher)
    {
        $title = trans('voucher.edit');

        $accounts = $this->accountRepository
            ->getAllForSchool(session('current_school'))
            ->get()
            ->pluck('title', 'id')
            ->prepend(trans('account.select_account'), 0)
            ->toArray();

        return view('layouts.edit', compact('title', 'voucher', 'accounts'));
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request|VoucherRequest $request
	 * @param Voucher $voucher
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    public function update(VoucherRequest $request, Voucher $voucher)
    {
        $voucher->update($request->all());
        return redirect('/voucher');
    }

    public function delete(Voucher $voucher)
    {
        $title = trans('account.delete');
        return view('/voucher/delete', compact('voucher', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Voucher $voucher
     * @return Response
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect('/voucher');
    }

    public function data()
    {
        $vouchers = $this->voucherRepository->getAllForSchool(session('current_school'))
            ->get()
            ->map(function ($voucher) {
                return [
                    'id' => $voucher->id,
                    'code' => $voucher->code,
                    'debit_account' => $voucher->debit->title,
                    'credit_account' => $voucher->credit->title,
                    'amount' => $voucher->amount,
                    'prep_by' => $voucher->prepared_user->full_name,
                ];
            });

        return Datatables::make( $vouchers)
            ->addColumn('actions', '@if(!Sentinel::getUser()->inRole(\'admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'voucher.edit\', Sentinel::getUser()->permissions)))
									<a href="{{ url(\'/voucher/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    @if(!Sentinel::getUser()->inRole(\'admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'voucher.show\', Sentinel::getUser()->permissions)))
									<a href="{{ url(\'/voucher/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @endif
                                    @if(!Sentinel::getUser()->inRole(\'admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'voucher.delete\', Sentinel::getUser()->permissions)))
									 <a href="{{ url(\'/voucher/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }
}
