<?php

namespace App\Repositories;

use App\Models\NoticeType;

class NoticeTypeRepositoryEloquent implements NoticeTypeRepository
{
    /**
     * @var NoticeType
     */
    private $model;


    /**
     * NoticeTypeRepositoryEloquent constructor.
     * @param NoticeType $model
     */
    public function __construct(NoticeType $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }
}