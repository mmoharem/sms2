<?php

namespace App\Repositories;

use App\Models\MarkSystem;

class MarkSystemRepositoryEloquent implements MarkSystemRepository
{
    /**
     * @var MarkSystem
     */
    private $model;


    /**
     * MarkSystemRepositoryEloquent constructor.
     * @param MarkSystem $model
     */
    public function __construct(MarkSystem $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }
}