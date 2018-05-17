<?php

namespace App\Repositories;

use App\Models\Religion;

class ReligionRepositoryEloquent implements ReligionRepository
{
    /**
     * @var Religion
     */
    private $model;

    /**
     * ReligionRepositoryEloquent constructor.
     * @param Religion $model
     */
    public function __construct(Religion $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

}