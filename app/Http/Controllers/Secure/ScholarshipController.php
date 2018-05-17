<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\ScholarshipRequest;
use App\Models\Scholarship;
use App\Repositories\ScholarshipRepository;
use App\Repositories\StudentRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Sentinel;
use Yajra\DataTables\Facades\DataTables;
use DB;

class ScholarshipController extends SecureController
{
    /**
     * @var ScholarshipRepository
     */
    private $scholarshipRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * SectionController constructor.
     *
     * @param StudentRepository $studentRepository
     * @param ScholarshipRepository $scholarshipRepository
     */
    public function __construct(
        ScholarshipRepository $scholarshipRepository,
        StudentRepository $studentRepository
    )
    {
        parent::__construct();

        $this->scholarshipRepository = $scholarshipRepository;
        $this->studentRepository = $studentRepository;

        $this->middleware('authorized:scholarship.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:scholarship.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:scholarship.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:scholarship.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'scholarship');

        $columns = ['name', 'student', 'price', 'actions'];
        view()->share('columns', $columns);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('scholarship.scholarship');

        return view('scholarship.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('scholarship.new');
        $users = $this->studentRepository->getAllForSchoolYearAndSchool(session('current_school_year'), session('current_school'))
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->user->id,
                    'name' => $student->user->full_name,
                ];
            })
            ->pluck('name', 'id')
            ->toArray();

        return view('layouts.create', compact('title', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ScholarshipRequest $request
     *
     * @return Response
     */
    public function store(ScholarshipRequest $request)
    {
        $scholarship = new Scholarship($request->all());
        $scholarship->save();

        return redirect('/scholarship');
    }

    /**
     * Display the specified resource.
     *
     * @param  Scholarship $scholarship
     *
     * @return Response
     */
    public function show(Scholarship $scholarship)
    {
        $title = trans('scholarship.details');
        $action = 'show';

        return view('layouts.show', compact('scholarship', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Scholarship $scholarship)
    {
        $title = trans('scholarship.edit');
        $users = $this->studentRepository->getAllForSchoolYearAndSchool(session('current_school_year'), session('current_school'))
            ->get()->map(function ($student) {
                return [
                    'id' => $student->user->id,
                    'name' => $student->user->full_name
                ];
            })
            ->pluck('name', 'id')
            ->toArray();

        return view('layouts.edit', compact('title', 'scholarship', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update(ScholarshipRequest $request, Scholarship $scholarship)
    {
        $scholarship->update($request->all());

        return redirect('/scholarship');
    }

    /**
     * @param $website
     *
     * @return Response
     */
    public function delete(Scholarship $scholarship)
    {
        $title = trans('scholarship.delete');

        return view('/scholarship/delete', compact('scholarship', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Scholarship $scholarship
     * @return Response
     * @throws \Exception
     */
    public function destroy(Scholarship $scholarship)
    {
        $scholarship->delete();

        return redirect('/scholarship');
    }

    public function data()
    {
        $one_school = (Settings::get('account_one_school') == 'yes') ? true : false;

        if (($one_school && $this->user->inRole('accountant')) || $this->user->inRole('admin')) {
            $scholarships = $this->scholarshipRepository->getAllForSchoolYearAndSchool(session('current_school_year')
                , session('current_school'));
        } else {
            $scholarships = $this->scholarshipRepository->getAll();
        }
        $scholarships = $scholarships->with('user')->get()->map(function ($scholarship) {
            return [
                'id' => $scholarship->id,
                'name' => $scholarship->name,
                'price' => $scholarship->price,
                'student' => isset($scholarship->user) ? $scholarship->user->full_name : "",
            ];
        });

        return Datatables::make($scholarships)
            ->addColumn('actions', '@if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'scholarship.edit\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/scholarship/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    <a href="{{ url(\'/scholarship/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'scholarship.delete\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/scholarship/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif')
            //->removeColumn('id')
            ->rawColumns(['actions'])->make();
    }
}
