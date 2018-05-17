<?php

namespace App\Repositories;

use App\Models\ApplicantWork;

class ApplicantWorkRepositoryEloquent implements ApplicantWorkRepository
{
    /**
     * @var ApplicantWork
     */
    private $model;


    /**
     * ApplicantWorkRepositoryEloquent constructor.
     * @param ApplicantWork $model
     */
    public function __construct(ApplicantWork $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForApplicant($user_id)
    {
        return $this->model->where('user_id', $user_id);
    }
}