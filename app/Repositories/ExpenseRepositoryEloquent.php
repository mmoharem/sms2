<?php

namespace App\Repositories;

use App\Models\Expense;

class ExpenseRepositoryEloquent implements ExpenseRepository
{
    /**
     * @var Expense
     */
    private $model;


    /**
     * ExpenseRepositoryEloquent constructor.
     * @param Expense $model
     */
    public function __construct(Expense $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForSchoolAndSchoolYear($school_id, $school_year_id)
    {
        return $this->model->where('school_id', $school_id)->where('school_year_id', $school_year_id);
    }
}