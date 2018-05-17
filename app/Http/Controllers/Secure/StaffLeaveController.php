<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\StaffLeaveRequest;
use App\Models\StaffLeave;
use App\Repositories\StaffLeaveTypeRepository;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Yajra\DataTables\Facades\DataTables;

class StaffLeaveController extends SecureController
{
	/**
	 * @var StaffLeaveTypeRepository
	 */
	private $staffLeaveTypeRepository;

	/**
	 * StaffLeaveController constructor.
	 *
	 * @param StaffLeaveTypeRepository $staffLeaveTypeRepository
	 */
	public function __construct(StaffLeaveTypeRepository $staffLeaveTypeRepository)
    {
        parent::__construct();

        view()->share('type', 'staff_leave');

        $columns = ['date','description','title', 'approved','full_name', 'actions'];
        view()->share('columns', $columns);

	    $this->staffLeaveTypeRepository = $staffLeaveTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('staff_leave.staff_leaves');
        return view('staff_leave.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('staff_leave.new');
	    $staff_leave_types = $this->staffLeaveTypeRepository->getAll()->pluck('title', 'id');
        return view('layouts.create', compact('title','staff_leave_types'));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param StaffLeaveRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function store(StaffLeaveRequest $request)
    {
        $staffLeave = new StaffLeave($request->only('date', 'staff_leave_type_id', 'description'));
	    $staffLeave->school_id = is_null(session('current_school'))?0:session('current_school');
	    $staffLeave->school_year_id = session('current_school_year');
	    $staffLeave->user_id = Sentinel::getUser()->id;
	    $staffLeave->save();

	    return redirect('/staff_leave');
    }

    /**
     * Display the specified resource.
     *
     * @param StaffLeave $staffLeave
     * @return Response
     */
    public function show(StaffLeave $staffLeave)
    {
        $title = trans('staff_leave.details');
        $action = 'show';
        return view('layouts.show', compact('staffLeave', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param StaffLeave $staffLeave
     * @return Response
     */
    public function edit(StaffLeave $staffLeave)
    {
        $title = trans('staff_leave.edit');
	    $staff_leave_types = $this->staffLeaveTypeRepository->getAll()->pluck('title', 'id');
        return view('layouts.edit', compact('title', 'staffLeave','staff_leave_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StaffLeaveRequest $request
     * @param StaffLeave $staffLeave
     * @return Response
     */
    public function update(StaffLeaveRequest $request, StaffLeave $staffLeave)
    {
        $staffLeave->update($request->all());
        return redirect('/staff_leave');
    }

    /**
     * @param StaffLeave $staffLeave
     * @return Response
     */
    public function delete(StaffLeave $staffLeave)
    {
        $title = trans('staff_leave.delete');
        return view('/staff_leave/delete', compact('staffLeave', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     * @param StaffLeave $staffLeave
     * @return Response
     */
    public function destroy(StaffLeave $staffLeave)
    {
        $staffLeave->delete();
        return redirect('/staff_leave');
    }

    public function data()
    {
        $staffLeave = StaffLeave::join('users', 'users.id', '=', 'staff_leaves.user_id')
	                        ->join('staff_leave_types', 'staff_leave_types.id', '=', 'staff_leaves.staff_leave_type_id')
                            ->orderBy('staff_leaves.date','desc')
	                        ->where('staff_leaves.school_year_id', session('current_school_year'))
	                        ->where('staff_leaves.school_id', is_null(session('current_school'))?0:session('current_school'))
                            ->select(array('staff_leaves.id', 'staff_leaves.date', 'staff_leaves.description',
	                            'staff_leave_types.title','staff_leaves.approved',
	                            DB::raw('CONCAT(users.first_name, " ", users.last_name) as full_name')));
	    if(Sentinel::inRole('teacher') || Sentinel::inRole('librarian')
            || Sentinel::inRole('accountant') || Sentinel::inRole('kitchen_admin') || Sentinel::inRole('kitchen_staff')
            || Sentinel::inRole('doorman')){
		    $staffLeave = $staffLeave->where('user_id', Sentinel::getUser()->id);
	    }
	    $staffLeave = $staffLeave->get();

        return Datatables::make( $staffLeave)
	        ->editColumn('approved', function($staffLeave) {
		        if(is_null($staffLeave->approved))
			        return trans("staff_leave.new_request");
			   elseif($staffLeave->approved==1)
		            return trans("staff_leave.approved");
		       else return trans("staff_leave.no_approved");
	        })
            ->addColumn('actions', function($staffLeave){
                if(Sentinel::inRole('teacher') || Sentinel::inRole('librarian')
                    || Sentinel::inRole('accountant') || Sentinel::inRole('kitchen_admin') || Sentinel::inRole('kitchen_staff')
                    || Sentinel::inRole('doorman')){
            		if ( Carbon::createFromFormat(Settings::get( 'date_format' ),$staffLeave->date) > Carbon::now() ) {
			            return '<a href="' . url( 'staff_leave/' . $staffLeave->id . '/edit' ) . '" class="btn btn-success btn-sm" >
                                        <i class="fa fa-pencil-square-o "></i>  ' . trans( "table.edit" ) . '</a>
                                <a href="' . url( 'staff_leave/' . $staffLeave->id . '/delete' ) . '" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> ' . trans( "table.delete" ) . '</a>';
		            } else {
			            return '';
		            }
                } else{
            		return '<a href="'. url('staff_leave/'. $staffLeave->id . '/edit' ).'" class="btn btn-success btn-sm" >
                           		<i class="fa fa-pencil-square-o "></i>  '.trans("table.edit") .'</a>
                            <a href="'. url('staff_leave/'. $staffLeave->id . '/show' ) .'" class="btn btn-primary btn-sm" >
                            	<i class="fa fa-eye"></i>  '. trans("table.details") .'</a>
                            <a href="'. url('staff_leave/'. $staffLeave->id . '/approve' ).'" class="btn btn-success btn-sm" >
                                <i class="fa fa-check-circle "></i>  '.trans("staff_leave.approve") .'</a>
                            <a href="'. url('staff_leave/'. $staffLeave->id . '/no_approve' ).'" class="btn btn-danger btn-sm" >
                            	<i class="fa fa-circle "></i>  '.trans("staff_leave.no_approve") .'</a>
                            <a href="'. url('staff_leave/'. $staffLeave->id . '/delete' ) .'" class="btn btn-danger btn-sm">
                               	<i class="fa fa-trash"></i> '. trans("table.delete") .'</a>';
                }
            })
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }

	public function approveLeave(StaffLeave $staffLeave){
	    $staffLeave->approved = true;
	    $staffLeave->save();
	    return redirect()->back();
    }

	public function noApproveLeave(StaffLeave $staffLeave){
	    $staffLeave->approved = false;
	    $staffLeave->save();
	    return redirect()->back();
    }
}
