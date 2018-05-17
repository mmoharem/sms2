<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\DirectionRequest;
use App\Models\Direction;
use App\Repositories\DepartmentRepository;
use App\Repositories\SectionRepository;
use App\Models\SchoolDirection;
use App\Repositories\DirectionRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Guzzle\Http\Message\Response;
use Yajra\DataTables\Facades\DataTables;

class DirectionController extends SecureController
{
    /**
     * @var DirectionRepository
     */
    private $directionRepository;
    private $sectionRepository;
    /**
     * @var DepartmentRepository
     */
    private $departmentRepository;

    /**
     * DirectionController constructor.
     *
     * @param DirectionRepository $directionRepository
     * @param SectionRepository $sectionRepository
     * @param DepartmentRepository $departmentRepository
     */
    public function __construct(DirectionRepository $directionRepository,
                                    SectionRepository $sectionRepository,
                                DepartmentRepository $departmentRepository)
    {
        parent::__construct();

        $this->directionRepository = $directionRepository;
        $this->sectionRepository = $sectionRepository;
        $this->departmentRepository = $departmentRepository;

        view()->share('type', 'direction');

        $columns = ['title','department','code','duration', 'actions'];
        view()->share('columns', $columns);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('direction.directions');
        return view('direction.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('direction.new');
        $departments = $this->departmentRepository->getAll()->pluck('title','id');
        return view('layouts.create', compact('title','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|DirectionRequest $request
     * @return Response
     */
    public function store(DirectionRequest $request)
    {
        $direction = new Direction($request->all());
        $direction->save();
        if(Settings::get('multi_school') == 'no'){
	        SchoolDirection::create(['school_id'=>session('current_school'), 'direction_id'=>$direction->id]);
        }
        return redirect('/direction');
    }

    /**
     * Display the specified resource.
     *
     * @param Direction $direction
     * @return Response
     * @internal param int $id
     */
    public function show(Direction $direction)
    {
        $title = trans('direction.details');
        $action = 'show';
        return view('layouts.show', compact('direction', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Direction $direction
     * @return Response
     * @internal param int $id
     */
    public function edit(Direction $direction)
    {
        $title = trans('direction.edit');
        $departments = $this->departmentRepository->getAll()->pluck('title','id');
        return view('layouts.edit', compact('title', 'direction','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DirectionRequest $request
     * @param Direction $direction
     * @return Response
     */
    public function update(DirectionRequest $request, Direction $direction)
    {
        $direction->update($request->all());
        return redirect('/direction');
    }

    public function delete(Direction $direction)
    {
        $title = trans('direction.delete');
        return view('/direction/delete', compact('direction', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Direction $direction
     * @return Response
     */
    public function destroy(Direction $direction)
    {
        $direction->delete();
        return redirect('/direction');
    }

    public function data()
    {
        $directions = $this->directionRepository->getAll()
            ->get()
            ->map(function ($direction) {
                return [
                    'id' => $direction->id,
                    'title' => $direction->title,
                    'department' => isset($direction->department)?$direction->department->title:"",
                    'code' => $direction->code,
                    'duration' => $direction->duration,
                ];
            });

        return Datatables::make($directions)
            ->addColumn('actions', '<a href="{{ url(\'/direction/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/direction/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/direction/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->removeColumn('id')
            ->rawColumns(['actions'])
            ->make();
    }
}
