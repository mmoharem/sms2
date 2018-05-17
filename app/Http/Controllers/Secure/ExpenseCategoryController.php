<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\ExpenseCategoryRequest;
use App\Models\ExpenseCategory;
use App\Repositories\ExpenseCategoryRepository;
use Yajra\DataTables\Facades\DataTables;

class ExpenseCategoryController extends SecureController
{
    /**
     * @var ExpenseCategoryRepository
     */
    private $expenseCategoryRepository;

    /**
     * ExpenseCategoryController constructor.
     * @param ExpenseCategoryRepository $expenseCategoryRepository
     */
    public function __construct(ExpenseCategoryRepository $expenseCategoryRepository)
    {
        parent::__construct();

        $this->expenseCategoryRepository = $expenseCategoryRepository;

        view()->share('type', 'expense_category');

	    $columns = ['title', 'actions'];
	    view()->share('columns', $columns);
    }

    public function index()
    {
        $title = trans('expense_category.expense_categories');
        return view('expense_category.index', compact('title'));
    }

    public function create()
    {
        $title = trans('expense_category.new');
        return view('layouts.create', compact('title'));
    }

    public function store(ExpenseCategoryRequest $request)
    {
        $expenseCategory = new ExpenseCategory($request->all());
        $expenseCategory->school_id = session('current_school');
        $expenseCategory->save();

        return redirect('/expense_category');
    }

    public function show(ExpenseCategory $expenseCategory)
    {
        $title = trans('expense_category.details');
        $action = 'show';
        return view('layouts.show', compact('expenseCategory', 'title', 'action'));
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        $title = trans('expense_category.edit');
        return view('layouts.edit', compact('title', 'expenseCategory'));
    }

    public function update(ExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        $expenseCategory->update($request->all());
        return redirect('/expense_category');
    }


    public function delete(ExpenseCategory $expenseCategory)
    {
        $title = trans('expense_category.delete');
        return view('/expense_category/delete', compact('expenseCategory', 'title'));
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();
        return redirect('/expense_category');
    }

    public function data()
    {
        $expenseCategorys = $this->expenseCategoryRepository->getAllForSchool(session('current_school'))
            ->get()
            ->map(function ($expenseCategory) {
                return [
                    'id' => $expenseCategory->id,
                    'title' => $expenseCategory->title,
                ];
            });

        return Datatables::make( $expenseCategorys)
            ->addColumn('actions', '<a href="{{ url(\'/expense_category/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/expense_category/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/expense_category/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }
}
