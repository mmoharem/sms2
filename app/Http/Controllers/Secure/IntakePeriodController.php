<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\IntakePeriodRequest;
use App\Models\IntakePeriod;
use App\Repositories\IntakePeriodRepository;
use Guzzle\Http\Message\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class IntakePeriodController extends SecureController
{
    /**
     * @var IntakePeriodRepository
     */
    private $intakePeriodRepository;

	/**
	 * IntakePeriodController constructor.
	 *
	 * @param IntakePeriodRepository $intakePeriodRepository
	 */
    public function __construct(IntakePeriodRepository $intakePeriodRepository)
    {
        parent::__construct();

	    $this->intakePeriodRepository = $intakePeriodRepository;

	    view()->share('type', 'intake_period');

	    $columns = ['name', 'actions'];
	    view()->share('columns', $columns);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('intake_period.intake_periods');
        return view('intake_period.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('intake_period.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|IntakePeriodRequest $request
     * @return Response
     */
    public function store(IntakePeriodRequest $request)
    {
	    $intakePeriod = new IntakePeriod($request->all());
	    $intakePeriod->school_id = session('current_school');
	    $intakePeriod->save();

        return redirect('/intake_period');
    }

    /**
     * Display the specified resource.
     *
     * @param IntakePeriod $intakePeriod
     * @return Response
     */
    public function show(IntakePeriod $intakePeriod)
    {
        $title = trans('intake_period.details');
        $action = 'show';
        return view('layouts.show', compact('intakePeriod', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param IntakePeriod $intakePeriod
     * @return Response
     */
    public function edit(IntakePeriod $intakePeriod)
    {
        $title = trans('intake_period.edit');
        return view('layouts.edit', compact('title', 'intakePeriod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IntakePeriodRequest $request
     * @param IntakePeriod $intakePeriod
     * @return Response
     */
    public function update(IntakePeriodRequest $request, IntakePeriod $intakePeriod)
    {
	    $intakePeriod->update($request->all());
        return redirect('/intake_period');
    }

    public function delete(IntakePeriod $intakePeriod)
    {
        $title = trans('intake_period.delete');
        return view('intake_period.delete', compact('intakePeriod', 'title'));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param IntakePeriod $intakePeriod
	 *
	 * @return Response
	 */
    public function destroy(IntakePeriod $intakePeriod)
    {
	    $intakePeriod->delete();
        return redirect('/intake_period');
    }

    public function data()
    {
	    $intakePeriods = $this->intakePeriodRepository->getAllForSchool(session('current_school'))
            ->get()
            ->map(function ($intakePeriod) {
                return [
                    'id' => $intakePeriod->id,
                    'name' => $intakePeriod->name,
                ];
            });

        return Datatables::make($intakePeriods)
            ->addColumn('actions', '@if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'intake_period.edit\', Sentinel::getUser()->permissions)))
										<a href="{{ url(\'/intake_period/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'intake_period.show\', Sentinel::getUser()->permissions)))
                                    	<a href="{{ url(\'/intake_period/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     @endif
                                     @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'intake_period.delete\', Sentinel::getUser()->permissions)))
                                     	<a href="{{ url(\'/intake_period/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }
}
