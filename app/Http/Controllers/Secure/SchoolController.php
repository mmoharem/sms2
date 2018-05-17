<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests;
use App\Http\Requests\Secure\SchoolRequest;
use App\Models\School;
use App\Repositories\SchoolDirectionRepository;
use App\Repositories\SchoolRepository;
use Yajra\DataTables\Facades\DataTables;
use Efriandika\LaravelSettings\Facades\Settings;

class SchoolController extends SecureController
{
    /**
     * @var SchoolRepository
     */
    private $schoolRepository;
    /**
     * @var SchoolDirectionRepository
     */
    private $schoolDirectionRepository;

    /**
     * SchoolController constructor.
     * @param SchoolRepository $schoolRepository
     * @param SchoolDirectionRepository $schoolDirectionRepository
     */
    public function __construct(SchoolRepository $schoolRepository, SchoolDirectionRepository $schoolDirectionRepository)
    {
        parent::__construct();

        view()->share('type', 'schools');

        $columns = ['title','address','phone', 'email', 'actions'];
        view()->share('columns', $columns);

        $this->schoolDirectionRepository = $schoolDirectionRepository;
        $this->schoolRepository = $schoolRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('schools.school');
        return view('schools.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('schools.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(SchoolRequest $request)
    {
        if(Settings::get('multi_school')=='yes') {
            $school = new School($request->except('student_card_background_file', 'photo_file'));
            if ($request->hasFile('student_card_background_file') != "") {
                $file = $request->file('student_card_background_file');
                $extension = $file->getClientOriginalExtension();
                $picture = str_random(10) . '.' . $extension;

                $destinationPath = public_path() . '/uploads/student_card/';
                $file->move($destinationPath, $picture);
                $school->student_card_background = $picture;
            }
            if ($request->hasFile('photo_file') != "") {
                $file = $request->file('photo_file');
                $extension = $file->getClientOriginalExtension();
                $picture = str_random(10) . '.' . $extension;

                $destinationPath = public_path() . '/uploads/school_photo/';
                $file->move($destinationPath, $picture);
                $school->photo = $picture;
            }
            $school->save();
        }
        return redirect('/schools');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(School $school)
    {
        $title = trans('schools.details');
        $action = 'show';
        return view('layouts.show', compact('school', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(School $school)
    {
        $title = trans('schools.edit');
        return view('layouts.edit', compact('title', 'school'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(SchoolRequest $request, School $school)
    {
        if ($request->hasFile('student_card_background_file') != "") {
            $file = $request->file('student_card_background_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/student_card/';
            $file->move($destinationPath, $picture);
            $school->student_card_background = $picture;
        }
        if ($request->hasFile('photo_file') != "") {
            $file = $request->file('photo_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/school_photo/';
            $file->move($destinationPath, $picture);
            $school->photo = $picture;
        }
        $school->update($request->except('student_card_background_file', 'photo_file'));
        return redirect('/schools');
    }

    /**
     *
     *
     * @param $website
     * @return Response
     */
    public function delete(School $school)
    {
        $title = trans('schools.delete');
        return view('/schools/delete', compact('school', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param School $school
     * @return Response
     */
    public function destroy(School $school)
    {
        $school->delete();
        return redirect('/schools');
    }

    public function directions(School $school){
        return $this->schoolDirectionRepository->getAllForSchool($school->id)
            ->get()
            ->filter(function($direction){
                return isset($direction->direction);
            })
            ->map(function ($direction) {
                return [
                    'id' => $direction->direction->id,
                    'title' => $direction->direction->title
                ];
            });
    }

    public function activate(School $school)
    {
        $school->active = ($school->active + 1) % 2;
        $school->save();
        return redirect('/schools');
    }

    public function data()
    {
        if (Settings::get('multi_school') == 'yes') {
            if ($this->user->inRole('super_admin')) {
                $schools = $this->schoolRepository->getAll();
            } elseif ($this->user->inRole('admin') ||
                $this->user->inRole('human_resources') ||
                $this->user->inRole('librarian')) {
                $schools = $this->schoolRepository->getAllAdmin();
            } elseif ($this->user->inRole('teacher')) {
                $schools = $this->schoolRepository->getAllTeacher();
            }  elseif ($this->user->inRole('applicant')) {
	            $schools = $this->schoolRepository->getAllApplicant();
            } else {
                $schools = $this->schoolRepository->getAllStudent();
            }
        } else {
            if ($this->user->inRole('admin') || $this->user->inRole('super_admin')
                || $this->user->inRole('admin_super_admin')
                || $this->user->inRole('human_resources') || $this->user->inRole('librarian')) {
                $schools = $this->schoolRepository->getAll();
            } elseif ($this->user->inRole('teacher')) {
                $schools = $this->schoolRepository->getAllTeacher();
            }  elseif ($this->user->inRole('applicant')) {
                $schools = $this->schoolRepository->getAllApplicant();
            } else {
                $schools = $this->schoolRepository->getAllStudent();
            }
        }
        $schools = $schools->get()
            ->map(function ($school) {
                return [
                    'id' => $school->id,
                    'title' => $school->title,
                    'address' => $school->address,
                    'phone' => $school->phone,
                    'email' => $school->email,
                    'active' => $school->active,
                ];
            });
        if (Settings::get('multi_school') == 'yes') {
            if ($this->user->inRole('super_admin')) {
                return Datatables::make( $schools)
                    ->addColumn('actions', '<a href="{{ url(\'/schools/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                     <a href="{{ url(\'/schools/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                             @if($active==0)
                                     <a href="{{ url(\'/schools/\' . $id . \'/activate\' ) }}" class="btn btn-warning btn-sm" >                                          
                                           <i class="fa fa-square-o" aria-hidden="true"></i> {{ trans("schools.activate") }}
                                           @else
                                     <a href="{{ url(\'/schools/\' . $id . \'/activate\' ) }}" class="btn btn-info btn-sm" >
                                            <i class="fa fa-check-square-o" aria-hidden="true"></i> {{trans("schools.deactivate") }}
                                           @endif
                                    </a>
                                    <a href="{{ url(\'/schools/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
                    ->removeColumn('id')
                    ->removeColumn('active')
                     ->rawColumns( [ 'actions' ] )->make();
            } elseif ($this->user->inRole('admin')) {
                return Datatables::make( $schools)
                    ->addColumn('actions', '<a href="{{ url(\'/schools/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                     <a href="{{ url(\'/schools/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>')
                    ->removeColumn('id')
                    ->removeColumn('active')
                     ->rawColumns( [ 'actions' ] )->make();
            } else {
                return Datatables::make( $schools)
                    ->addColumn('actions', '<a href="{{ url(\'/schools/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>')
                    ->removeColumn('id')
                    ->removeColumn('active')
                     ->rawColumns( [ 'actions' ] )->make();
            }
        } else {
            if ($this->user->inRole('admin') || $this->user->inRole('super_admin')) {
                return Datatables::make( $schools)
                    ->addColumn('actions', '<a href="{{ url(\'/schools/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                     <a href="{{ url(\'/schools/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>')
                    ->removeColumn('id')
                    ->removeColumn('active')
                     ->rawColumns( [ 'actions' ] )->make();
            } else {
                return Datatables::make( $schools)
                    ->addColumn('actions', '<a href="{{ url(\'/schools/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>')
                    ->removeColumn('id')
                    ->removeColumn('active')
                     ->rawColumns( [ 'actions' ] )->make();
            }
        }
    }
}
