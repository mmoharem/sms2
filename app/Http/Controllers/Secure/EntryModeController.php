<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\EntryModeRequest;
use App\Models\EntryMode;
use App\Repositories\EntryModeRepository;
use Guzzle\Http\Message\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class EntryModeController extends SecureController
{
    /**
     * @var EntryModeRepository
     */
    private $entryModeRepository;

	/**
	 * DirectionController constructor.
	 *
	 * @param EntryModeRepository $entryModeRepository
	 *
	 * @internal param DirectionRepository $directionRepository
	 */
    public function __construct(EntryModeRepository $entryModeRepository)
    {
        parent::__construct();

        view()->share('type', 'entry_mode');

        $columns = ['name', 'actions'];
        view()->share('columns', $columns);

	    $this->entryModeRepository = $entryModeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('entry_mode.entry_modes');
        return view('entry_mode.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('entry_mode.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|EntryModeRequest $request
     * @return Response
     */
    public function store(EntryModeRequest $request)
    {
	    $entryMode = new EntryMode($request->all());
	    $entryMode->save();

        return redirect('/entry_mode');
    }

    /**
     * Display the specified resource.
     *
     * @param EntryMode $entryMode
     * @return Response
     */
    public function show(EntryMode $entryMode)
    {
        $title = trans('entry_mode.details');
        $action = 'show';
        return view('layouts.show', compact('entryMode', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EntryMode $entryMode
     * @return Response
     */
    public function edit(EntryMode $entryMode)
    {
        $title = trans('entry_mode.edit');
        return view('layouts.edit', compact('title', 'entryMode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EntryModeRequest $request
     * @param EntryMode $entryMode
     * @return Response
     */
    public function update(EntryModeRequest $request, EntryMode $entryMode)
    {
	    $entryMode->update($request->all());
        return redirect('/entry_mode');
    }

    public function delete(EntryMode $entryMode)
    {
        $title = trans('entry_mode.delete');
        return view('entry_mode.delete', compact('entryMode', 'title'));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param EntryMode $entryMode
	 *
	 * @return Response
	 */
    public function destroy(EntryMode $entryMode)
    {
	    $entryMode->delete();
        return redirect('/entry_mode');
    }

    public function data()
    {
	    $entryModes = $this->entryModeRepository->getAllForSchool(session('current_school'))
            ->get()
            ->map(function ($entryMode) {
                return [
                    'id' => $entryMode->id,
                    'name' => $entryMode->name,
                ];
            });

        return Datatables::make($entryModes)
            ->addColumn('actions', '@if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'entry_mode.edit\', Sentinel::getUser()->permissions)))
										<a href="{{ url(\'/entry_mode/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'entry_mode.show\', Sentinel::getUser()->permissions)))
                                    	<a href="{{ url(\'/entry_mode/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     @endif
                                     @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'entry_mode.delete\', Sentinel::getUser()->permissions)))
                                     	<a href="{{ url(\'/entry_mode/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }
}
