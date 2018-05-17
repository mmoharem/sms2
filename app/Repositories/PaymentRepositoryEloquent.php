<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepositoryEloquent implements PaymentRepository
{
    /**
     * @var Payment
     */
    private $model;

    /**
     * PaymentRepositoryEloquent constructor.
     * @param Payment $model
     */
    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    public function getAll($school_year_id)
    {
        return $this->model->where('school_year_id', $school_year_id);
    }

	public function getAllStudentsForSchool( $school_id,$school_year_id ) {
		return $this->model->join('students', 'students.user_id', '=', 'payments.user_id')
		                   ->where('students.school_id', $school_id)
		                   ->where('payments.school_year_id', $school_year_id)
		                   ->select('payments.*');
	}
}