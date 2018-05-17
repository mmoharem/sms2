<?php

namespace App\Repositories;

use App\Models\Direction;

class DirectionRepositoryEloquent implements DirectionRepository
{
    /**
     * @var Direction
     */
    private $model;


    /**
     * DirectionRepositoryEloquent constructor.
     * @param Direction $model
     */
    public function __construct(Direction $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

	public function getAllForSchool($school_id) {
		return $this->model->join('school_directions', 'school_directions.direction_id', '=', 'directions.id')
			->where('school_directions.school_id', $school_id)
            ->select('directions.*');
	}
}