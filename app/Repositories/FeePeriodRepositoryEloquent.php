<?php

namespace App\Repositories;

use App\Models\FeePeriod;

class FeePeriodRepositoryEloquent implements FeePeriodRepository
{
    /**
     * @var FeePeriod
     */
    private $model;

    /**
     * SalaryRepositoryEloquent constructor.
     *
     * @param FeePeriod $model
     */
    public function __construct( FeePeriod $model)
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