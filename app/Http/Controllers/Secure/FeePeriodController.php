<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\FeePeriodRequest;
use App\Models\FeePeriod;
use App\Repositories\FeePeriodRepository;
use Guzzle\Http\Message\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class FeePeriodController extends SecureController
{
    /**
     * @var FeePeriodRepository
     */
    private $feePeriodRepository;

	/**
	 * FeePeriodController constructor.
	 *
	 * @param FeePeriodRepository $feePeriodRepository
	 */
    public function __construct(FeePeriodRepository $feePeriodRepository)
    {
        parent::__construct();

        view()->share('type', 'fee_period');

        $columns = ['name', 'actions'];
        view()->share('columns', $columns);

	    $this->feePeriodRepository = $feePeriodRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('fee_period.fee_periods');
        return view('fee_period.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('fee_period.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|FeePeriodRequest $request
     * @return Response
     */
    public function store(FeePeriodRequest $request)
    {
	    $feePeriod = new FeePeriod($request->all());
	    $feePeriod->school_id = session('current_school');
	    $feePeriod->save();

        return redirect('/fee_period');
    }

    /**
     * Display the specified resource.
     *
     * @param FeePeriod $feePeriod
     * @return Response
     */
    public function show(FeePeriod $feePeriod)
    {
        $title = trans('fee_period.details');
        $action = 'show';
        return view('layouts.show', compact('feePeriod', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FeePeriod $feePeriod
     * @return Response
     */
    public function edit(FeePeriod $feePeriod)
    {
        $title = trans('fee_period.edit');
        return view('layouts.edit', compact('title', 'feePeriod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FeePeriodRequest $request
     * @param FeePeriod $feePeriod
     * @return Response
     */
    public function update(FeePeriodRequest $request, FeePeriod $feePeriod)
    {
	    $feePeriod->update($request->all());
        return redirect('/fee_period');
    }

    public function delete(FeePeriod $feePeriod)
    {
        $title = trans('fee_period.delete');
        return view('fee_period.delete', compact('feePeriod', 'title'));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param FeePeriod $feePeriod
	 *
	 * @return Response
	 */
    public function destroy(FeePeriod $feePeriod)
    {
	    $feePeriod->delete();
        return redirect('/fee_period');
    }

    public function data()
    {
	    $feePeriods = $this->feePeriodRepository->getAllForSchool(session('current_school'))
            ->get()
            ->map(function ($feePeriod) {
                return [
                    'id' => $feePeriod->id,
                    'name' => $feePeriod->name,
                ];
            });

        return Datatables::make($feePeriods)
            ->addColumn('actions', '@if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'fee_period.edit\', Sentinel::getUser()->permissions)))
										<a href="{{ url(\'/fee_period/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'fee_period.show\', Sentinel::getUser()->permissions)))
                                    	<a href="{{ url(\'/fee_period/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     @endif
                                     @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'fee_period.delete\', Sentinel::getUser()->permissions)))
                                     	<a href="{{ url(\'/fee_period/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }
}
