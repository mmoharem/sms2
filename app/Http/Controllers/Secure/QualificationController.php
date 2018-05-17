<?php

namespace App\Http\Controllers\Secure;

use App\Models\Qualification;
use App\Http\Requests\Secure\QualificationRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QualificationController extends SecureController
{
    public function __construct()
    {
        parent::__construct();

        view()->share('type', 'qualification');

        $columns = ['title', 'actions'];
        view()->share('columns', $columns);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('qualification.qualification');
        return view('qualification.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('qualification.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QualificationRequest|Request $request
     * @return Response
     */
    public function store(QualificationRequest $request)
    {
        $qualification = new Qualification($request->all());
        $qualification->save();
        return redirect("/qualification");
    }

    /**
     * Display the specified resource.
     *
     * @param Qualification $qualification
     * @return Response
     * @internal param int $id
     */
    public function show(Qualification $qualification)
    {
        $title = trans('qualification.details');
        $action = 'show';
        return view('layouts.show', compact('title', 'qualification', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Qualification $qualification
     * @return Response
     */
    public function edit(Qualification $qualification)
    {
        $title = trans('qualification.edit');
        return view('layouts.edit', compact('title', 'qualification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Qualification|Request $request
     * @param Qualification $qualification
     * @return Response
     */
    public function update(QualificationRequest $request, Qualification $qualification)
    {
        $qualification->update($request->all());
        $qualification->save();
        return redirect('/qualification');
    }

    public function delete(Qualification $qualification)
    {
        $title = trans('qualification.delete');
        return view('qualification.delete', compact('title', 'qualification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Qualification $qualification
     * @return Response
     */
    public function destroy(Qualification $qualification)
    {
        $qualification->delete();
        return redirect('/qualification');
    }

    public function data()
    {
        $qualifications = Qualification::get()
            ->map(function ($qualification) {
                return [
                    'id' => $qualification->id,
                    'title' => $qualification->title,
                ];
            });

        return Datatables::make( $qualifications)
            ->addColumn('actions', '<a href="{{ url(\'/qualification/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/qualification/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/qualification/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }
}
