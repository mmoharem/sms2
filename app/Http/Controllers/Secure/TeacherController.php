<?php

namespace App\Http\Controllers\Secure;

use App\Helpers\CustomFormUserFields;
use App\Helpers\ExcelfileValidator;
use App\Http\Requests\Secure\ImportRequest;
use App\Http\Requests\Secure\TeacherImportRequest;
use App\Models\TeacherSchool;
use App\Models\User;
use App\Models\UserDocument;
use App\Repositories\ExcelRepository;
use App\Repositories\OptionRepository;
use App\Repositories\TeacherSchoolRepository;
use App\Helpers\Thumbnail;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use DB;
use Sentinel;
use App\Http\Requests\Secure\TeacherRequest;

class TeacherController extends SecureController
{
    /**
     * @var TeacherSchoolRepository
     */
    private $teacherSchoolRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;
    /**
     * @var ExcelRepository
     */
    private $excelRepository;

    /**
     * TeacherController constructor.
     * @param TeacherSchoolRepository $teacherSchoolRepository
     * @param OptionRepository $optionRepository
     * @param ExcelRepository $excelRepository
     */
    public function __construct(TeacherSchoolRepository $teacherSchoolRepository,
                                OptionRepository $optionRepository,
                                ExcelRepository $excelRepository)
    {
        parent::__construct();

        $this->teacherSchoolRepository = $teacherSchoolRepository;
        $this->optionRepository = $optionRepository;
        $this->excelRepository = $excelRepository;

        $this->middleware('authorized:teacher.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:teacher.create', ['only' => ['create', 'store', 'getImport', 'postImport', 'downloadTemplate']]);
        $this->middleware('authorized:teacher.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:teacher.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'teacher');

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
        $title = trans('teacher.teacher');
        return view('teacher.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('teacher.new');
        $document_types = $this->optionRepository->getAllForSchool(session('current_school'))
            ->where('category', 'staff_document_type')->get()
            ->map(function ($option) {
                return [
                    "title" => $option->title,
                    "value" => $option->id,
                ];
            });
        $custom_fields =  CustomFormUserFields::getCustomUserFields('teacher');
        return view('layouts.create', compact('title', 'document_types','custom_fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeacherRequest $request
     * @return Response
     */
    public function store(TeacherRequest $request)
    {
        $user = $this->teacherSchoolRepository->create($request->except('document', 'document_id','image_file'));

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

        if ($request->hasFile('document') != "") {
            $file = $request->file('document');
            $extension = $file->getClientOriginalExtension();
            $document = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/documents/';
            $file->move($destinationPath, $document);

            UserDocument::where('user_id', $user->id)->delete();

            UserDocument::firstOrCreate(['user_id' => $user->id, 'document' => $document, 'option_id' => $request->document_id]);
        }

        CustomFormUserFields::storeCustomUserField('teacher', $user->id, $request);
        return redirect('/teacher');
    }

    /**
     * Display the specified resource.
     *
     * @param User $teacher
     * @return Response
     */
    public function show(User $teacher)
    {
        $title = trans('teacher.details');
        $action = 'show';
        $custom_fields =  CustomFormUserFields::getCustomUserFieldValues('teacher',$teacher->id);
        return view('layouts.show', compact('teacher', 'title', 'action','custom_fields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $teacher
     * @return Response
     */
    public function edit(User $teacher)
    {
        $title = trans('teacher.edit');

        $document_types = $this->optionRepository->getAllForSchool(session('current_school'))
            ->where('category', 'staff_document_type')->get()
            ->map(function ($option) {
                return [
                    "title" => $option->title,
                    "value" => $option->id,
                ];
            });
        $documents = UserDocument::where('user_id', $teacher->id)->first();
        $custom_fields =  CustomFormUserFields::fetchCustomValues('teacher',$teacher->id);

        return view('layouts.edit', compact('title', 'teacher', 'document_types', 'documents','custom_fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TeacherRequest $request
     * @param User $teacher
     * @return Response
     */
    public function update(TeacherRequest $request, User $teacher)
    {
        if ($request->password != "") {
            $teacher->password = bcrypt($request->password);
        }
        $teacher->update($request->except('password', 'document', 'document_id','image_file'));

        if ($request->hasFile('image_file') != "") {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatar/';
            $file->move($destinationPath, $picture);
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $destinationPath . 'thumb_' . $picture);
            $teacher->picture = $picture;
            $teacher->save();
        }
        if ($request->hasFile('document') != "") {
            $file = $request->file('document');
            $extension = $file->getClientOriginalExtension();
            $document = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/documents/';
            $file->move($destinationPath, $document);

            UserDocument::where('user_id', $teacher->id)->delete();

            UserDocument::firstOrCreate(['user_id' => $teacher->id, 'document' => $document, 'option_id' => $request->document_id]);
        }
        CustomFormUserFields::updateCustomUserField('teacher', $teacher->id, $request);

        return redirect('/teacher');
    }

    /**
     * @param User $teacher
     * @return Response
     */
    public function delete(User $teacher)
    {
        $title = trans('teacher.delete');
        $custom_fields =  CustomFormUserFields::getCustomUserFieldValues('teacher',$teacher->id);
        return view('/teacher/delete', compact('teacher', 'title','custom_fields'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $teacher
     * @return Response
     */
    public function destroy(User $teacher)
    {
        TeacherSchool::where('user_id', $teacher->id)
            ->where('school_id', session('current_school'))->delete();

        return redirect('/teacher');
    }

    public function data()
    {
        $teachers = $this->teacherSchoolRepository->getAllForSchool(session('current_school'))
            ->map(function ($teacher) {
                return [
                    'id'        => $teacher->id,
                    'full_name' => $teacher->full_name_title,
                ];
            });
        return Datatables::make( $teachers)
            ->addColumn('actions', '@if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'teacher.edit\', Sentinel::getUser()->permissions)))
                                 <a href="{{ url(\'/teacher/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/join_date/\' . $id ) }}" class="btn btn-warning btn-sm" >
                                            <i class="fa fa-calendar"></i>  {{ trans("teacher.join_date") }}</a>
                                   @endif 
                                   @if(Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'admin_super_admin\'))
                                    <a href="{{ url(\'/login_as_user/\' . $id . \'\' ) }}" class="btn btn-warning btn-sm" >
                                            <i class="fa fa-exclamation-triangle"></i>  {{ trans("teacher.login_as_user") }}</a>
                                  @endif 
                                   @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'staff_salary.show\', Sentinel::getUser()->permissions)))
                                   <a href="{{ url(\'/staff_salary/\' . $id ) }}" class="btn btn-warning btn-sm" >
                                            <i class="fa fa-money"></i>  {{ trans("teacher.set_salary") }}</a>
                                   @endif
                                   <a href="{{ url(\'/teacher/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                   	@if(Sentinel::getUser()->inRole(\'super_admin\') || Sentinel::getUser()->inRole(\'admin_super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'teacher.delete\', Sentinel::getUser()->permissions)))         
                                     <a href="{{ url(\'/teacher/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                    @endif')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }


    function getExists(Request $request)
    {
        $teacher = User::where('email', $request->email)->first();
        return response()->json(['teacher' => $teacher]);
    }

    public function getImport()
    {
        $title = trans('teacher.import_teachers');

        return view('teacher.import', compact('title'));
    }

    public function postImport(ImportRequest $request)
    {
	    $title = trans('teacher.import_teachers');

	    ExcelfileValidator::validate($request);

        $reader = $this->excelRepository->load($request->file('file'));

        $teachers = $reader->all()->map(function ($row) {
            return [
                'first_name' => trim($row->first_name),
                'last_name' => trim($row->last_name),
                'email' => trim($row->email),
                'password' => trim($row->password),
                'mobile' => trim($row->mobile),
                'fax' => trim($row->fax),
                'birth_date' => trim($row->birth_date),
                'birth_place' => trim($row->birth_place),
                'address' => trim($row->address),
                'gender' => trim($row->gender),
            ];
        });
	    return view('teacher.import_list', compact('teachers','title'));
    }

    public function finishImport(Request $request)
    {
	    foreach($request->import as $item){
		    $import_data = [
			    'first_name'=>$request->first_name[$item],
			    'last_name'=>$request->last_name[$item],
			    'email'=>$request->email[$item],
			    'password'=>$request->password[$item],
			    'mobile'=>$request->mobile[$item],
			    'fax'=>$request->fax[$item],
			    'birth_date'=>$request->birth_date[$item],
			    'birth_place'=>$request->birth_place[$item],
			    'address'=>$request->address[$item],
			    'gender'=>$request->gender[$item],
		    ];
		    $this->teacherSchoolRepository->create( $import_data );
	    }

	    return redirect('/teacher');
    }

    public function downloadExcelTemplate()
    {
        return response()->download(base_path('resources/excel-templates/teachers.xlsx'));
    }

	public function export(){
		$teachers = $this->teacherSchoolRepository->getAllForSchool(session('current_school'))
		                                          ->map(function ($teacher) {
			                                          return [
				                                          'Email'        => $teacher->email,
				                                          'Full name' => $teacher->full_name,
			                                          ];
		                                          })->toArray();


		Excel::create(trans('teacher.teacher'), function($excel) use ($teachers){
			$excel->sheet(trans('teacher.teacher'), function($sheet) use ($teachers) {
				$sheet->fromArray($teachers, null, 'A1', true);
			});
		})->export('csv');
	}

}
