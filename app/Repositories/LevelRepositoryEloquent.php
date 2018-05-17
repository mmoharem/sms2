<?php

namespace App\Repositories;

use App\Models\Level;

class LevelRepositoryEloquent implements LevelRepository
{
    /**
     * @var Level
     */
    private $model;

    /**
     * LevelRepositoryEloquent constructor.
     * @param Level $model
     */
    public function __construct(Level $model)
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

    public function getAllForSection($section_id)
    {
        return $this->model->where('section_id', $section_id);
    }

}