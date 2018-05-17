<?php

namespace App\Repositories;

use App\Models\IntakePeriod;

class IntakePeriodRepositoryEloquent implements IntakePeriodRepository
{
    /**
     * @var IntakePeriod
     */
    private $model;

    /**
     * IntakePeriodRepositoryEloquent constructor.
     * @param IntakePeriod $model
     */
    public function __construct(IntakePeriod $model)
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