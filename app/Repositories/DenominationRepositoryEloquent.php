<?php

namespace App\Repositories;

use App\Models\Denomination;

class DenominationRepositoryEloquent implements DenominationRepository
{
    /**
     * @var Denomination
     */
    private $model;

    /**
     * DenominationRepositoryEloquent constructor.
     * @param Denomination $model
     */
    public function __construct(Denomination $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

}