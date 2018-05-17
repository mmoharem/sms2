<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\DepartmentRequest;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Guzzle\Http\Message\Response;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends SecureController
{
    /**
     * @var DepartmentRepository
     */
    private $departmentRepository;

    /**
     * DepartmentController constructor.
     * @param DepartmentRepository $departmentRepository
     */
    public function __construct(DepartmentRepository $departmentRepository)
    {
        parent::__construct();

        view()->share('type', 'department');

        $columns = ['title', 'actions'];
        view()->share('columns', $columns);

        $this->departmentRepository = $departmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('department.departments');
        return view('department.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('department.new');

        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|DepartmentRequest $request
     * @return Response
     */
    public function store(DepartmentRequest $request)
    {
        $department = new Department($request->all());
        $department->save();
        return redirect('/department');
    }

    /**
     * Display the specified resource.
     *
     * @param Department $department
     * @return Response
     * @internal param int $id
     */
    public function show(Department $department)
    {
        $title = trans('department.details');
        $action = 'show';
        return view('layouts.show', compact('department', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Department $department
     * @return Response
     * @internal param int $id
     */
    public function edit(Department $department)
    {
        $title = trans('department.edit');
        return view('layouts.edit', compact('title', 'department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DepartmentRequest $request
     * @param Department $department
     * @return Response
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->all());
        return redirect('/department');
    }

    public function delete(Department $department)
    {
        $title = trans('department.delete');
        return view('/department/delete', compact('department', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Department $department
     * @return Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect('/department');
    }

    public function data()
    {
        $departments = $this->departmentRepository->getAll()
            ->get()
            ->map(function ($department) {
                return [
                    'id' => $department->id,
                    'title' => $department->title
                ];
            });

        return Datatables::make($departments)
            ->addColumn('actions', '<a href="{{ url(\'/department/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/department/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/department/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->removeColumn('id')
            ->rawColumns(['actions'])
            ->make();
    }
}
