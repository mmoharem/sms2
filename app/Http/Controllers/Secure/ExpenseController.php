<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\ExpenseRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Repositories\ExpenseCategoryRepository;
use App\Repositories\ExpenseRepository;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends SecureController
{
    /**
     * @var ExpenseRepository
     */
    private $expenseRepository;
    /**
     * @var ExpenseCategoryRepository
     */
    private $expenseCategoryRepository;

    /**
     * ExpenseController constructor.
     * @param ExpenseRepository $expenseRepository
     * @param ExpenseCategoryRepository $expenseCategoryRepository
     */
    public function __construct(ExpenseRepository $expenseRepository, ExpenseCategoryRepository $expenseCategoryRepository)
    {
        parent::__construct();

        $this->expenseRepository = $expenseRepository;
        $this->expenseCategoryRepository = $expenseCategoryRepository;

        view()->share('type', 'expense');

	    $columns = ['title','expense_category', 'value', 'actions'];
	    view()->share('columns', $columns);
    }

    public function index()
    {
        $title = trans('expense.expenses');
        return view('expense.index', compact('title'));
    }

    public function create()
    {
        $title = trans('expense.new');
        $expense_categories = $this->expenseCategoryRepository->getAllForSchool(session('current_school'))->pluck('title',
            'id');
        return view('layouts.create', compact('title','expense_categories'));
    }
    public function store(ExpenseRequest $request)
    {
        $expense = new Expense($request->all());
        $expense->school_year_id = session('current_school_year');
        $expense->school_id = session('current_school');
        $expense->save();
        return redirect('/expense');
    }
    public function show(Expense $expense)
    {
        $title = trans('expense.details');
        $action = 'show';
        return view('layouts.show', compact('expense', 'title', 'action'));
    }

    public function edit(Expense $expense)
    {
	    $expense_categories = $this->expenseCategoryRepository->getAllForSchool(session('current_school'))->pluck('title', 'id');
        $title = trans('expense.edit');
        return view('layouts.edit', compact('title', 'expense','expense_categories'));
    }

    public function update(ExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->all());
        return redirect('/expense');
    }


    public function delete(Expense $expense)
    {
        $title = trans('expense.delete');
        return view('/expense/delete', compact('expense', 'title'));
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect('/expense');
    }

    public function data()
    {
        $expenses = $this->expenseRepository->getAllForSchoolAndSchoolYear(session('current_school'), session('current_school_year'))
            ->get()
            ->map(function ($expense) {
                return [
                    'id' => $expense->id,
                    'title' => $expense->title,
                    'expense_category' => is_null($expense->expense_category)?"-":$expense->expense_category->title,
                    'value' => $expense->value,
                ];
            });

        return Datatables::make( $expenses)
            ->addColumn('actions', '<a href="{{ url(\'/expense/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/expense/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/expense/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->removeColumn('id')
             ->rawColumns( [ 'actions' ] )->make();
    }

    public function expenseTable(){
	    $title = trans('expense.expense_table_today');
	    $expenses_yesterday = $this->expenseRepository->getAllForDate(Carbon::now()->addDay(-1)->format('Y-m-d'))->get();
	    $expenses_today = $this->expenseRepository->getAllForDate(Carbon::now()->format('Y-m-d'))->get();
	    $expenses_tomorrow = $this->expenseRepository->getAllForDate(Carbon::now()->addDay(1)->format('Y-m-d'))->get();
	    return view('expense.expense_table', compact('title','expenses_today', 'expenses_tomorrow','expenses_yesterday'));
    }
}
