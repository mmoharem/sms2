<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\LevelRequest;
use App\Models\Level;
use App\Repositories\SectionRepository;
use App\Models\SchoolDirection;
use App\Repositories\LevelRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Guzzle\Http\Message\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class LevelController extends SecureController
{
    /**
     * @var LevelRepository
     */
    private $levelRepository;
	/**
	 * @var SectionRepository
	 */
    private $sectionRepository;

	/**
	 * DirectionController constructor.
	 *
	 * @param LevelRepository $levelRepository
	 * @param SectionRepository $sectionRepository
	 *
	 * @internal param DirectionRepository $directionRepository
	 */
    public function __construct(LevelRepository $levelRepository,
                                    SectionRepository $sectionRepository)
    {
        parent::__construct();

        $this->levelRepository = $levelRepository;
        $this->sectionRepository = $sectionRepository;

        view()->share('type', 'levels');

        $columns = ['name', 'section', 'actions'];
        view()->share('columns', $columns);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('level.levels');
        return view('levels.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('level.new');

        $sections = $this->sectionRepository
            ->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->get()
            ->pluck('title', 'id')
            ->prepend(trans('student.select_section'), 0)
            ->toArray();

        return view('layouts.create', compact('title', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|LevelRequest $request
     * @return Response
     */
    public function store(LevelRequest $request)
    {
        $level = new Level($request->all());
	    $level->save();

        return redirect('/levels');
    }

    /**
     * Display the specified resource.
     *
     * @param Level $level
     * @return Response
     */
    public function show(Level $level)
    {
        $title = trans('level.details');
        $action = 'show';
        return view('layouts.show', compact('level', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Level $level
     * @return Response
     */
    public function edit(Level $level)
    {
        $title = trans('level.edit');

        $sections = $this->sectionRepository
            ->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->get()
            ->pluck('title', 'id')
            ->prepend(trans('student.select_section'), 0)
            ->toArray();

        return view('layouts.edit', compact('title', 'level', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|LevelRequest $request
     * @param Level $level
     * @return Response
     */
    public function update(LevelRequest $request, Level $level)
    {
	    $level->update($request->all());
        return redirect('/levels');
    }

    public function delete(Level $level)
    {
        $title = trans('level.delete');
        return view('levels.delete', compact('level', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Level $level
     * @return Response
     */
    public function destroy(Level $level)
    {
	    $level->delete();
        return redirect('/levels');
    }

    public function data()
    {
        $levels = $this->levelRepository->getAllForSchool(session('current_school'))
            ->get()
            ->map(function ($level) {
                return [
                    'id' => $level->id,
                    'name' => $level->name,
                    'section' => $level->section->title,
                ];
            });

        return Datatables::make($levels)
            ->addColumn('actions', '@if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'level.edit\', Sentinel::getUser()->permissions)))
										<a href="{{ url(\'/levels/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'level.show\', Sentinel::getUser()->permissions)))
                                    	<a href="{{ url(\'/levels/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     @endif
                                     @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'level.delete\', Sentinel::getUser()->permissions)))
                                     	<a href="{{ url(\'/levels/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }
}
