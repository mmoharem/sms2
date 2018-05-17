<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepositoryEloquent implements DepartmentRepository
{
    /**
     * @var Department
     */
    private $model;


    /**
     * DepartmentRepositoryEloquent constructor.
     * @param Department $model
     */
    public function __construct(Department $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }
}