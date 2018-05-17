<?php

namespace App\Repositories;

use App\Models\TimetablePeriod;
use Carbon\Carbon;

class TimetablePeriodRepositoryEloquent implements TimetablePeriodRepository
{
    /**
     * @var TimetablePeriod
     */
    private $model;


    /**
     * TimetablePeriodRepositoryEloquent constructor.
     * @param TimetablePeriod $model
     */
    public function __construct(TimetablePeriod $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->get()->sortBy(function($timeTablePeriod){
            return $timeTablePeriod->start_at_time;
        });
    }
}