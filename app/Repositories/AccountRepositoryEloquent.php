<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepositoryEloquent implements AccountRepository
{
    /**
     * @var Account
     */
    private $model;

    /**
     * AccountRepositoryEloquent constructor.
     * @param Account $model
     */
    public function __construct(Account $model)
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