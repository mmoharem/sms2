<?php

namespace App\Http\Controllers\Secure;

use App\Helpers\CustomFormUserFields;
use App\Models\AccountantSchool;
use App\Models\School;
use App\Models\User;
use App\Repositories\UserRepository;
use Yajra\DataTables\Facades\DataTables;
use Efriandika\LaravelSettings\Facades\Settings;
use DB;
use App\Helpers\Thumbnail;
use Sentinel;
use App\Http\Requests\Secure\TeacherRequest;

class SupplierController extends SecureController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * TeacherController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('authorized:supplier.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:supplier.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:supplier.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:supplier.delete', ['only' => ['delete', 'destroy']]);

        parent::__construct();

        $this->userRepository = $userRepository;

        view()->share('type', 'supplier');

	    $columns = ['full_name', 'actions'];
	    view()->share('columns', $columns);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('supplier.supplier');
        return view('supplier.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('supplier.new');
        $custom_fields =  CustomFormUserFields::getCustomUserFields('supplier');
        $all_schools = School::pluck('title', 'id')->toArray();
        return view('layouts.create', compact('title','custom_fields','all_schools'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeacherRequest $request
     * @return Response
     */
    public function store(TeacherRequest $request)
    {
        $user = Sentinel::registerAndActivate($request->except('school_id'));

        $role = Sentinel::findRoleBySlug('supplier');
        $role->users()->attach($user);

        $user = User::find($user->id);

        if ($request->hasFile('image_file') != "") {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatar/';
            $file->move($destinationPath, $picture);
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $destinationPath . 'thumb_' . $picture);
            $user->picture = $picture;
            $user->save();
        }

        $user->update($request->except('password','image_file'));


        CustomFormUserFields::storeCustomUserField('supplier', $user->id, $request);

        if(Settings::get('account_one_school')=='yes'){
            AccountantSchool::create(['school_id'=>$request->get('school_id'),'user_id'=>$user->id]);
        }

        return redirect('/supplier');
    }

    /**
     * Display the specified resource.
     *
     * @param User $supplier
     * @return Response
     */
    public function show(User $supplier)
    {
        $title = trans('supplier.details');
        $action = 'show';
        $custom_fields =  CustomFormUserFields::getCustomUserFieldValues('supplier',$supplier->id);
        return view('layouts.show', compact('supplier', 'title', 'action','custom_fields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $supplier
     * @return Response
     */
    public function edit(User $supplier)
    {
        $title = trans('supplier.edit');
        $custom_fields =  CustomFormUserFields::fetchCustomValues('supplier',$supplier->id);
        $all_schools = School::pluck('title', 'id')->toArray();
        $supplier_schools = AccountantSchool::where('user_id', $supplier->id)->pluck('school_id', 'school_id')->toArray();
        return view('layouts.edit', compact('title', 'supplier','custom_fields','all_schools','supplier_schools'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TeacherRequest $request
     * @param User $supplier
     * @return Response
     */
    public function update(TeacherRequest $request, User $supplier)
    {
        if ($request->password != "") {
            $supplier->password = bcrypt($request->password);
        }
        if ($request->hasFile('image_file') != "") {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatar/';
            $file->move($destinationPath, $picture);
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $destinationPath . 'thumb_' . $picture);
            $supplier->picture = $picture;
            $supplier->save();
        }

        $supplier->update($request->except('password','image_file'));
        CustomFormUserFields::updateCustomUserField('supplier', $supplier->id, $request);

        AccountantSchool::where('user_id',$supplier->id)->delete();

        if(Settings::get('account_one_school')=='yes'){
            AccountantSchool::create(['school_id'=>$request->get('school_id'),'user_id'=>$supplier->id]);
        }
        return redirect('/supplier');
    }

    /**
     * @param User $supplier
     * @return Response
     */
    public function delete(User $supplier)
    {
        $title = trans('supplier.delete');
        $custom_fields =  CustomFormUserFields::getCustomUserFieldValues('supplier',$supplier->id);
        return view('/supplier/delete', compact('supplier', 'title','custom_fields'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $supplier
     * @return Response
     */
    public function destroy(User $supplier)
    {
        $supplier->delete();
        return redirect('/supplier');
    }

    public function data()
    {
        $suppliers = $this->userRepository->getUsersForRole('supplier')
            ->map(function ($supplier) {
                return [
                    'id' => $supplier->id,
                    'full_name' => $supplier->full_name,
                ];
            });
        return Datatables::make( $suppliers)
            ->addColumn('actions', '@if(!Sentinel::inRole(\'admin\') || (Sentinel::inRole(\'admin\') && array_key_exists(\'supplier.edit\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/supplier/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                        <a href="{{ url(\'/supplier/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || Sentinel::getUser()->inRole(\'admin_super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'supplier.delete\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/supplier/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }

}
