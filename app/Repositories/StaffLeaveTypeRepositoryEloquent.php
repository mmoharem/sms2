<?php

namespace App\Repositories;

use App\Models\StaffLeaveType;

class StaffLeaveTypeRepositoryEloquent implements StaffLeaveTypeRepository
{
    /**
     * @var StaffLeaveType
     */
    private $model;


    /**
     * StaffLeaveTypeRepositoryEloquent constructor.
     * @param StaffLeaveType $model
     */
    public function __construct(StaffLeaveType $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }
}