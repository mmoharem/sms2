<?php

namespace App\Repositories;

use App\Models\EntryMode;

class EntryModeRepositoryEloquent implements EntryModeRepository
{
    /**
     * @var EntryMode
     */
    private $model;

    /**
     * SalaryRepositoryEloquent constructor.
     * @param EntryMode $model
     */
    public function __construct(EntryMode $model)
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