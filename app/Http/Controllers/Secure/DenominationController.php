<?php

namespace App\Http\Controllers\Secure;

use App\Models\Denomination;
use App\Http\Requests\Secure\DenominationRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DenominationController extends SecureController
{
    public function __construct()
    {
        parent::__construct();

        view()->share('type', 'denomination');

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
        $title = trans('denomination.denomination');
        return view('denomination.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('denomination.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DenominationRequest|Request $request
     * @return Response
     */
    public function store(DenominationRequest $request)
    {
        $denomination = new Denomination($request->all());
        $denomination->save();
        return redirect("/denomination");
    }

    /**
     * Display the specified resource.
     *
     * @param Denomination $denomination
     * @return Response
     * @internal param int $id
     */
    public function show(Denomination $denomination)
    {
        $title = trans('denomination.details');
        $action = 'show';
        return view('layouts.show', compact('title', 'denomination', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Denomination $denomination
     * @return Response
     */
    public function edit(Denomination $denomination)
    {
        $title = trans('denomination.edit');
        return view('layouts.edit', compact('title', 'denomination'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Denomination|Request $request
     * @param Denomination $denomination
     * @return Response
     */
    public function update(DenominationRequest $request, Denomination $denomination)
    {
        $denomination->update($request->all());
        $denomination->save();
        return redirect('/denomination');
    }

    public function delete(Denomination $denomination)
    {
        $title = trans('denomination.delete');
        return view('denomination.delete', compact('title', 'denomination'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Denomination $denomination
     * @return Response
     */
    public function destroy(Denomination $denomination)
    {
        $denomination->delete();
        return redirect('/denomination');
    }

    public function data()
    {
        $denominations = Denomination::get()
            ->map(function ($denomination) {
                return [
                    'id' => $denomination->id,
                    'title' => $denomination->name,
                ];
            });

        return Datatables::make( $denominations)
            ->addColumn('actions', '<a href="{{ url(\'/denomination/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/denomination/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/denomination/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }
}
