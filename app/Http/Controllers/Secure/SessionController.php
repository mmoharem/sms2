<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\SessionRequest;
use App\Models\Session;
use App\Repositories\SessionRepository;
use Guzzle\Http\Message\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class SessionController extends SecureController
{
    /**
     * @var SessionRepository
     */
    private $sessionRepository;

	/**
	 * SessionController constructor.
	 *
	 * @param SessionRepository $sessionRepository
	 */
    public function __construct(SessionRepository $sessionRepository)
    {
        parent::__construct();

        view()->share('type', 'session');

        $columns = ['name', 'actions'];
        view()->share('columns', $columns);

	    $this->sessionRepository = $sessionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('session.sessions');
        return view('session.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('session.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|SessionRequest $request
     * @return Response
     */
    public function store(SessionRequest $request)
    {
	    $session = new Session($request->all());
	    $session->school_id = session('current_school');
	    $session->save();

        return redirect('/session');
    }

    /**
     * Display the specified resource.
     *
     * @param Session $session
     * @return Response
     */
    public function show(Session $session)
    {
        $title = trans('session.details');
        $action = 'show';
        return view('layouts.show', compact('session', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Session $session
     * @return Response
     */
    public function edit(Session $session)
    {
        $title = trans('session.edit');
        return view('layouts.edit', compact('title', 'session'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SessionRequest $request
     * @param Session $session
     * @return Response
     */
    public function update(SessionRequest $request, Session $session)
    {
	    $session->update($request->all());
        return redirect('/session');
    }

    public function delete(Session $session)
    {
        $title = trans('session.delete');
        return view('session.delete', compact('session', 'title'));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Session $session
	 *
	 * @return Response
	 */
    public function destroy(Session $session)
    {
	    $session->delete();
        return redirect('/session');
    }

    public function data()
    {
	    $sessions = $this->sessionRepository->getAllForSchool(session('current_school'))
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'name' => $session->name,
                ];
            });

        return Datatables::make($sessions)
            ->addColumn('actions', '@if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'session.edit\', Sentinel::getUser()->permissions)))
										<a href="{{ url(\'/session/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'session.show\', Sentinel::getUser()->permissions)))
                                    	<a href="{{ url(\'/session/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     @endif
                                     @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'session.delete\', Sentinel::getUser()->permissions)))
                                     	<a href="{{ url(\'/session/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }
}
