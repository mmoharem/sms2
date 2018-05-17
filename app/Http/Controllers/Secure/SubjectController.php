<?php

namespace App\Http\Controllers\Secure;

use App\Helpers\ExcelfileValidator;
use App\Http\Requests\Secure\ImportRequest;
use App\Models\Option;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\SchoolYear;
use App\Models\Subject;
use App\Repositories\DirectionRepository;
use App\Repositories\LevelRepository;
use App\Repositories\ExcelRepository;
use App\Repositories\MarkSystemRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\SemesterRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Secure\SubjectRequest;


class SubjectController extends SecureController
{
    /**
     * @var SubjectRepository
     */
    private $subjectRepository;
    /**
     * @var DirectionRepository
     */
    private $directionRepository;
    /**
     * @var MarkSystemRepository
     */
    private $markSystemRepository;
    /**
     * @var ExcelRepository
     */
    private $excelRepository;
    /**
     * @var LevelRepository
     */
    private $levelRepository;
    /**
     * @var SemesterRepository
     */
    private $semesterRepository;

    /**
     * SubjectController constructor.
     *
     * @param SubjectRepository $subjectRepository
     * @param DirectionRepository $directionRepository
     * @param MarkSystemRepository $markSystemRepository
     * @param LevelRepository $levelRepository
     * @param SemesterRepository $semesterRepository
     * @param ExcelRepository $excelRepository
     */
    public function __construct(
        SubjectRepository $subjectRepository,
        DirectionRepository $directionRepository,
        MarkSystemRepository $markSystemRepository,
        LevelRepository $levelRepository,
        SemesterRepository $semesterRepository,
        ExcelRepository $excelRepository
    )
    {
        parent::__construct();

        $this->subjectRepository = $subjectRepository;
        $this->directionRepository = $directionRepository;
        $this->markSystemRepository = $markSystemRepository;
        $this->excelRepository = $excelRepository;
        $this->levelRepository = $levelRepository;
        $this->semesterRepository = $semesterRepository;

        view()->share('type', 'subject');

        $columns = [
            'order',
            'class',
            'mark_system',
            'title',
            'code',
            'credit_hours',
            'direction',
            'actions'
        ];
        view()->share('columns', $columns);
    }

    /**
     *
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $title = trans('subject.subjects');

        return view('subject.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('subject.new');
        list($directions, $levels, $semesters, $mark_systems) = $this->generateDate();

        return view('layouts.create', compact('title', 'directions', 'mark_systems', 'levels', 'semesters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|SubjectRequest $request
     *
     * @return Response
     */
    public function store(SubjectRequest $request)
    {
        foreach ($request->get('direction_id') as $direction_id) {
            $subject = new Subject($request->except('direction_id'));
            $subject->direction_id = $direction_id;
            $subject->save();
        }
        return redirect('/subject');
    }

    /**
     * Display the specified resource.
     *
     * @param Subject $subject
     *
     * @return Response
     * @internal param int $id
     */
    public function show(Subject $subject)
    {
        $title = trans('subject.details');
        $action = 'show';

        return view('layouts.show', compact('subject', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Subject $subject
     *
     * @return Response
     */
    public function edit(Subject $subject)
    {
        $title = trans('subject.edit');
        list($directions, $levels, $semesters, $mark_systems) = $this->generateDate();

        return view('layouts.edit', compact('title', 'subject', 'directions', 'mark_systems', 'levels', 'semesters'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|SubjectRequest $request
     * @param Subject $subject
     *
     * @return Response
     * @internal param int $id
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $subject->update($request->all());

        return redirect('/subject');
    }

    public function delete(Subject $subject)
    {
        $title = trans('subject.delete');

        return view('/subject/delete', compact('subject', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subject $subject
     *
     * @return Response
     * @throws \Exception
     * @internal param int $id
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect('/subject');
    }

    public function create_invoices(Subject $subject)
    {
        $last_school_year = SchoolYear::orderBy('id', 'DESC')->first();
        if (isset($last_school_year->id) && $subject->fee > 0) {
            $student_users = $this->subjectRepository->getAllStudentsSubjectAndDirection()
                ->where('subjects.id', $subject->id)
                ->where('students.school_year_id', $last_school_year->id)
                ->distinct('students.user_id')->select('students.user_id','students.school_id','students.school_year_id')
                ->get();
            $currency = Option::where('title',Settings::get( 'currency' ))->where('category', 'currency')->first();
            if(intval($subject->fee) > 0) {
                foreach ($student_users as $user) {
                    $invoice = new Invoice();
                    $invoice->title = trans("subject.fee");
                    $invoice->description = trans("subject.subject_fee") . $subject->title;
                    $invoice->amount = $subject->fee;
                    $invoice->currency_id = $currency->id;
                    $invoice->user_id = $user->user_id;
                    $invoice->school_id = $user->school_id;
                    $invoice->school_year_id = $user->school_year_id;
                    $invoice->save();
                }
            }
        }

        return redirect('/subject');
    }

    public function data()
    {
        $subjects = $this->subjectRepository->getAll()
            ->with('direction')
            ->orderBy('subjects.class')
            ->orderBy('subjects.order')
            ->get()
            ->map(function ($subject) {
                return [
                    'id' => $subject->id,
                    'order' => $subject->order,
                    'class' => $subject->class,
                    'mark_system' => isset($subject->mark_system->id) ? $subject->mark_system->title : "",
                    'title' => $subject->title,
                    'code' => $subject->code,
                    'credit_hours' => $subject->credit_hours,
                    'direction' => isset($subject->direction) ? $subject->direction->title : "",
                ];
            });

        return Datatables::make($subjects)
            ->addColumn('actions', '<a href="{{ url(\'/subject/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/subject/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    <a href="{{ url(\'/subject/\' . $id . \'/create_invoices\' ) }}" class="btn btn-warning btn-sm" >
                                            <i class="fa fa-money"></i>  {{ trans("subject.create_invoices") }}</a>
                                     <a href="{{ url(\'/subject/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->removeColumn('id')
            ->rawColumns(['actions'])
            ->make();
    }

    public function getImport()
    {
        $title = trans('subject.import_subject');

        return view('subject.import', compact('title'));
    }

    public function postImport(ImportRequest $request)
    {
        $title = trans('subject.import_subject');

        ExcelfileValidator::validate($request);

        $reader = $this->excelRepository->load($request->file('file'));

        $subjects = $reader->all()->map(function ($row) {
            return [
                'title' => trim($row->title),
                'order' => intval($row->order),
                'class' => intval($row->class),
                'fee' => floatval($row->fee),
                'highest_mark' => floatval($row->highest_mark),
                'lowest_mark' => floatval($row->lowest_mark),
            ];
        });

        $directions = $this->directionRepository->getAllForSchool(session('current_school'))
            ->get()->map(function ($section) {
                return [
                    'text' => $section->title,
                    'id' => $section->id,
                ];
            })->pluck('text', 'id');

        $mark_systems = $this->markSystemRepository->getAll()
            ->get()->map(function ($section) {
                return [
                    'text' => $section->title,
                    'id' => $section->id,
                ];
            })->pluck('text', 'id');

        return view('subject.import_list', compact('subjects', 'directions', 'mark_systems', 'title'));
    }

    public function finishImport(Request $request)
    {
        foreach ($request->import as $item) {
            $import_data = [
                'title' => $request->title[$item],
                'direction_id' => $request->direction_id[$item],
                'order' => $request->order[$item],
                'class' => $request->class[$item],
                'mark_system_id' => $request->mark_system_id[$item],
                'fee' => $request->fee[$item],
                'highest_mark' => $request->highest_mark[$item],
                'lowest_mark' => $request->lowest_mark[$item]
            ];
            $this->subjectRepository->create($import_data);
        }

        return redirect('/subject');
    }

    public function downloadExcelTemplate()
    {
        return response()->download(base_path('resources/excel-templates/subjects.xlsx'));
    }

    public function bulkDelete()
    {
        Subject::getQuery()->delete();

        return redirect("/subject");
    }

    /**
     * @return array
     */
    private function generateDate()
    {
        $directions = $this->directionRepository->getAll()->pluck('title', 'id')->toArray();

        $levels = $this->levelRepository
            ->getAllForSchool(session('current_school'))
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('student.select_level'), 0)
            ->toArray();

        $semesters = $this->semesterRepository
            ->getAllActive()
            ->get()
            ->pluck('title', 'id')
            ->prepend(trans('student.select_semester'), 0)
            ->toArray();

        $mark_systems = $this->markSystemRepository->getAll()->pluck('title', 'id')->toArray();

        return array($directions, $levels, $semesters, $mark_systems);
    }
}
