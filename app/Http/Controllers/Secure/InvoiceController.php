<?php

namespace App\Http\Controllers\Secure;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Option;
use App\Models\Student;
use App\Models\Semester;
use App\Repositories\FeeCategoryRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\SectionRepository;
use App\Repositories\DirectionRepository;
use App\Repositories\OptionRepository;
use App\Repositories\SemesterRepository;
use App\Repositories\StudentRepository;
use Yajra\DataTables\Facades\DataTables;
use Efriandika\LaravelSettings\Facades\Settings;
use DB;
use App\Http\Requests\Secure\InvoiceRequest;
use PDF;

class InvoiceController extends SecureController {
	/**
	 * @var InvoiceRepository
	 */
	private $invoiceRepository;
	/**
	 * @var StudentRepository
	 */
	private $studentRepository;
	/**
	 * @var SectionRepository
	 */
	private $sectionRepository;
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
     * @var SemesterRepository
     */
    private $semesterRepository;

    /**
     * InvoiceController constructor.
     *
     * @param InvoiceRepository $invoiceRepository
     * @param StudentRepository $studentRepository
     * @param FeeCategoryRepository $feeCategoryRepository
     * @param DirectionRepository $directionRepository
     * @param SectionRepository $sectionRepository
     * @param OptionRepository $optionRepository
     * @param SemesterRepository $semesterRepository
     */
	public function __construct(
		InvoiceRepository $invoiceRepository,
		StudentRepository $studentRepository,
		FeeCategoryRepository $feeCategoryRepository,
		DirectionRepository $directionRepository,
		SectionRepository $sectionRepository,
		OptionRepository $optionRepository,
        SemesterRepository $semesterRepository
	) {
		parent::__construct();

		$this->invoiceRepository     = $invoiceRepository;
		$this->studentRepository     = $studentRepository;
		$this->feeCategoryRepository = $feeCategoryRepository;
		$this->optionRepository      = $optionRepository;
		$this->sectionRepository     = $sectionRepository;
		$this->directionRepository   = $directionRepository;
        $this->semesterRepository = $semesterRepository;

		$this->middleware( 'authorized:invoice.show', [ 'only' => [ 'index', 'data' ] ] );
		$this->middleware( 'authorized:invoice.create', [ 'only' => [ 'create', 'store' ] ] );
		$this->middleware( 'authorized:invoice.edit', [ 'only' => [ 'update', 'edit' ] ] );
		$this->middleware( 'authorized:invoice.delete', [ 'only' => [ 'delete', 'destroy' ] ] );

		view()->share( 'type', 'invoice' );

		$columns = [ 'full_name', 'arrears', 'paid', 'amount', 'currency', 'actions' ];
		view()->share( 'columns', $columns );
    }

	/**
	 * Display a listing of the resource.
	 *
	 */
	public function index() {
		$title          = trans( 'invoice.invoice' );
		$fullPayment    = $this->invoiceRepository->getAllFullPaymentForSchoolAndSchoolYear( session( 'current_school' ), session( 'current_school_year' ) )->count();
		$partPayment    = $this->invoiceRepository->getAllPartPaymentForSchoolAndSchoolYear( session( 'current_school' ), session( 'current_school_year' ) )->count();
		$noPayment      = $this->invoiceRepository->getAllNoPaymentForSchoolAndSchoolYear( session( 'current_school' ), session( 'current_school_year' ) )->count();
		$fullPaymentSum = $this->invoiceRepository->getAllFullPaymentForSchoolAndSchoolYear( session( 'current_school' ), session( 'current_school_year' ) )->sum( 'paid_amount' );
		$partPaymentSum = $this->invoiceRepository->getAllPartPaymentForSchoolAndSchoolYear( session( 'current_school' ), session( 'current_school_year' ) )->sum( 'paid_amount' );
		$noPaymentSum   = $this->invoiceRepository->getAllNoPaymentForSchoolAndSchoolYear( session( 'current_school' ), session( 'current_school_year' ) )->sum( 'amount' );

		return view( 'invoice.index', compact( 'title',
			'fullPayment', 'partPayment', 'noPayment',
			'fullPaymentSum', 'partPaymentSum', 'noPaymentSum' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 */
	public function create() {
		$title = trans( 'invoice.new' );
		$this->generateParams();

		return view( 'layouts.create', compact( 'title' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param InvoiceRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store( InvoiceRequest $request ) {
        $currency = Option::where('title',Settings::get( 'currency' ))->where('category', 'currency')->first();

        foreach ( $request->get( 'user_id' ) as $user_id ) {

			$student = Student::where( 'user_id', $user_id )
			                  ->where( 'school_year_id', session( 'current_school_year' ) )
			                  ->where( 'school_id', '=', session( 'current_school' ) )
			                  ->first();

			$semester = $this->semesterRepository->getActiveForSchoolAndSchoolYear(session( 'current_school' ),
                session( 'current_school-year' ));

            if ( isset( $student->id ) && intval($request->get( 'amount' )) > 0) {
                $invoice = new Invoice($request->except('user_id', 'section_id', 'option_id', 'quantity'));
                $invoice->user_id = $user_id;
                $invoice->school_id = session('current_school');
                $invoice->school_year_id = session('current_school_year');
                $invoice->currency_id = $currency->id;
                $invoice->semester_id = isset($semester->id) ? $semester->id : 0;
                $invoice->total_fees = $request->get('amount');
                $invoice->fee_category_id = $request->get('fee_category_id');
                $invoice->save();


                if (!empty($request->get('option_id'))) {
                    foreach ($request->get('option_id') as $key => $option_id) {
                        InvoiceItem::create([
                            'option_id' => $option_id,
                            'invoice_id' => $invoice->id,
                            'quantity' => $request->get('quantity')[$key]
                        ]);
                    }
                }
            }
		}

		return redirect( '/invoice' )->with( 'status', 'Invoice Applied Successfully!' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Invoice $invoice
	 *
	 * @return Response
	 */
	public function show( Invoice $invoice ) {
		$pdf = PDF::loadView( 'report.invoice', compact( 'invoice' ) );

		return $pdf->stream();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Invoice $invoice
	 *
	 * @return Response
	 */
	public function edit( Invoice $invoice ) {
		$title = trans( 'invoice.edit' );
		$this->generateParams();

		return view( 'layouts.edit', compact( 'title', 'invoice' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param InvoiceRequest $request
	 * @param  Invoice $invoice
	 *
	 * @return Response
	 */
	public function update( InvoiceRequest $request, Invoice $invoice ) {
		$invoice->update( $request->except( 'option_id', 'section_id', 'quantity', 'remove' ) );

		InvoiceItem::where( 'invoice_id', $invoice->id )->delete();
		if ( !empty( $request->get( 'option_id' ) ) ) {
			foreach ( $request->get( 'option_id' ) as $key => $option_id ) {
				InvoiceItem::create( [
					'option_id'  => $option_id,
					'invoice_id' => $invoice->id,
					'quantity'   => $request->get( 'quantity' )[ $key ]
				] );
			}
		}

		return redirect( '/invoice' );
	}

	/**
	 * @param Invoice $invoice
	 *
	 * @return Response
	 */
	public function delete( Invoice $invoice ) {
		$title = trans( 'invoice.delete' );

		return view( '/invoice/delete', compact( 'invoice', 'title' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy( Invoice $invoice ) {
		$invoice->delete();

		return redirect( '/invoice' );
	}

	public function data() {
		$one_school = ( Settings::get( 'account_one_school' ) == 'yes' ) ? true : false;
		if ( ($one_school && $this->user->inRole( 'accountant' )) || $this->user->inRole( 'admin' ) ) {
			$invoices = $this->invoiceRepository->getAllStudentsForSchool( session( 'current_school' ),session( 'current_school_year' ) );
		} else {
			$invoices = $this->invoiceRepository->getAll(session( 'current_school_year' ));
		}
		$invoices = $invoices->with( 'user' )
		                     ->get()
		                     ->map( function ( $invoice ) use ($one_school){
			                     return [
				                     "id"         => $invoice->id,
				                     "full_name"  => isset( $invoice->user ) ? $invoice->user->full_name : "",
				                     "arrears"    => $invoice->amount - $invoice->paid_amount,
				                     "paid"       => ( $invoice->paid == 1 ) ? trans( 'attendance.yes' ) : trans( 'attendance.no' ),
				                     "amount"     => $invoice->amount,
				                     "currency"   => Settings::get('currency'),
				                     "one_school"   => $one_school,
			                     ];
		                     } );

		return Datatables::make( $invoices )
		                 ->addColumn( 'actions', '@if(Sentinel::getUser()->inRole(\'super_admin\') || ($one_school && Sentinel::getUser()->inRole( \'accountant\' )) || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'invoice.edit\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/invoice/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    <a target="_blank" href="{{ url(\'/invoice/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || ($one_school && Sentinel::getUser()->inRole( \'accountant\' )) || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'invoice.delete\', Sentinel::getUser()->permissions)))
                                     <a href="{{ url(\'/invoice/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif' )
		                 ->removeColumn( 'id','one_school' )
		                 ->rawColumns( [ 'actions' ] )->make();
	}

	/**
	 * @return mixed
	 */
	private function generateParams() {
		$one_school = ( Settings::get( 'account_one_school' ) == 'yes' ) ? true : false;
		if ( $one_school && $this->user->inRole( 'accountant' ) || $this->user->inRole( 'admin' ) ) {
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

		$fee_categories = $this->feeCategoryRepository->getAll()
		                                              ->get()
		                                              ->map( function ( $item ) {
			                                              return [
				                                              "id"    => $item->id,
				                                              "title" => $item->title,
			                                              ];
		                                              } )->pluck( "title", 'id' )->toArray();
		view()->share( 'fee_categories', $fee_categories );

		$items = $this->optionRepository->getAllForSchool( session( 'current_school' ) )
		                                ->where( 'category', 'invoice_item' )->get()
		                                ->map( function ( $item ) {
			                                return [
				                                "id"    => $item->id,
				                                "title" => $item->title . ' ' . $item->value,
			                                ];
		                                } )->pluck( "title", 'id' )->toArray();
		view()->share( 'invoice_items', $items );

		$sections = $this->sectionRepository
			->getAllForSchoolYearSchool( session( 'current_school_year' ), session( 'current_school' ) )
			->get()
			->pluck( 'title', 'id' )
			->prepend( trans( 'student.select_section' ), 0 )
			->toArray();
		view()->share( 'sections', $sections );
	}

}
