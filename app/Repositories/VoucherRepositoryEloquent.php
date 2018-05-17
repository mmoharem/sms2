<?php

namespace App\Repositories;

use App\Models\Voucher;

class VoucherRepositoryEloquent implements VoucherRepository
{
    /**
     * @var Voucher
     */
    private $model;

    /**
     * VoucherRepositoryEloquent constructor.
     * @param Voucher $model
     */
    public function __construct(Voucher $model)
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