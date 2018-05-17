<?php

namespace App\Http\Controllers\Secure;

use App\Events\MessageCreated;
use App\Http\Requests\Secure\DebtorRequest;
use App\Models\Message;
use App\Models\School;
use App\Models\SmsMessage;
use App\Models\User;
use App\Repositories\InvoiceRepository;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Efriandika\LaravelSettings\Facades\Settings;

class DebtorController extends SecureController
{
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    /**
     * InvoiceController constructor.
     * @param InvoiceRepository $invoiceRepository
     */
    public function __construct(InvoiceRepository $invoiceRepository)
    {
        parent::__construct();

        $this->invoiceRepository = $invoiceRepository;

        $this->middleware('authorized:debtor.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:debtor.create', ['only' => ['create', 'store']]);

        view()->share('type', 'debtor');

        $columns = ['name', 'amount'];
        view()->share('columns', $columns);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('debtor.debtor');
        return view('debtor.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('debtor.new');
	    $one_school = (Settings::get('account_one_school')=='yes')?true:false;
	    if($one_school &&  $this->user->inRole('accountant')){
		    $debtors = $this->invoiceRepository->getAllDebtorStudentsForSchool(session( 'current_school' ));
	    }else{
		    $debtors = $this->invoiceRepository->getAllDebtor();
	    }
	    $debtors = $debtors->with('user')
            ->get()
            ->map(function ($debtor) {
                return [
                    "id" => $debtor->user_id,
                    "name" => isset($debtor->user) ? $debtor->user->full_name : "",
                ];
            })->pluck('name', 'id');

        return view('layouts.create', compact('title', 'debtors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(DebtorRequest $request)
    {
        foreach ($request['user_id'] as $item) {
            $user = User::find($item);

            if ($request->sms_email == 1) {

	            $school = School::find(session( 'current_school' ))->first();
	            if($school->limit_sms_messages == 0 ||
	               $school->limit_sms_messages > $school->sms_messages_year) {
		            $smsMessage                 = new SmsMessage();
		            $smsMessage->text           = $request->message;
		            $smsMessage->number         = $user->mobile;
		            $smsMessage->user_id        = $user->id;
		            $smsMessage->user_id_sender = $this->user->id;
		            $smsMessage->school_id      = session( 'current_school' );
		            $smsMessage->save();
	            }

            } else {
                $email = new Message();
                $email->to = $item;
                $email->from = $this->user->id;
                $email->message = $request->message;
                $email->subject = trans('debtor.debtor_message');
                $email->save();

	            event(new MessageCreated($email));
            }
        }
        return redirect('/debtor');
    }

    public function data()
    {
	    $one_school = (Settings::get('account_one_school')=='yes')?true:false;
	    if($one_school &&  $this->user->inRole('accountant')){
		    $debtors = $this->invoiceRepository->getAllDebtorStudentsForSchool(session( 'current_school' ));
	    }else{
		    $debtors = $this->invoiceRepository->getAllDebtor();
	    }
	    $debtors = $debtors->with('user')
            ->get()
            ->map(function ($debtor) {
                return [
                    "id" => $debtor->id,
                    "name" => isset($debtor->user) ? $debtor->user->full_name : "",
                    "amount" => $debtor->amount,
                ];
            });
        return Datatables::make( $debtors)
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }

}
