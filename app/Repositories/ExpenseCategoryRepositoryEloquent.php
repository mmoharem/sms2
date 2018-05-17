<?php

namespace App\Repositories;

use App\Models\ExpenseCategory;

class ExpenseCategoryRepositoryEloquent implements ExpenseCategoryRepository
{
    /**
     * @var ExpenseCategory
     */
    private $model;


    /**
     * ExpenseCategoryRepositoryEloquent constructor.
     * @param ExpenseCategory $model
     */
    public function __construct(ExpenseCategory $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForSchool($school_id)
    {
        return $this->model->where('school_id', $school_id);
    }
}