<?php

namespace App\Repositories;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceRepositoryEloquent implements InvoiceRepository
{
    /**
     * @var Invoice
     */
    private $model;


    /**
     * InvoiceRepositoryEloquent constructor.
     * @param Invoice $model
     */
    public function __construct(Invoice $model)
    {
        $this->model = $model;
    }

    public function getAll($school_year_id)
    {
        return $this->model->where('school_year_id', $school_year_id);
    }

	public function getAllStudentsForSchool( $school_id,$school_year_id ) {
		return $this->model->join('students', 'students.user_id', '=', 'invoices.user_id')
		                   ->where('students.school_id', $school_id)
		                   ->where('invoices.school_year_id', $school_year_id)
		                   ->select('invoices.*')
                            ->distinct();
	}

    public function getAllDebtor()
    {
        return $this->model->where('paid', 0)
            ->select('*', DB::raw('sum(amount) as amount'))
            ->groupBy('user_id');
    }

	public function getAllDebtorStudentsForSchool( $school_id ) {
		return $this->model->join('students', 'students.user_id', '=', 'invoices.user_id')
		                   ->where('students.school_id', $school_id)
							->where('paid', 0)
		                   ->select('*', DB::raw('sum(amount) as amount'))
		                   ->groupBy('invoices.user_id');
	}

	public function getAllFullPaymentForSchoolAndSchoolYear( $school_id, $school_year_id ) {
		return $this->model->where('school_id', $school_id)
		                   ->where('school_year_id', $school_year_id)
		                   ->where('paid', 1);
	}

	public function getAllPartPaymentForSchoolAndSchoolYear( $school_id, $school_year_id ) {
		return $this->model->where('school_id', $school_id)
		                   ->where('school_year_id', $school_year_id)
		                   ->where('paid', 0)
		                   ->where('paid_total','>', 0);
	}

	public function getAllNoPaymentForSchoolAndSchoolYear( $school_id, $school_year_id ) {
		return $this->model->where('school_id', $school_id)
		                   ->where('school_year_id', $school_year_id)
		                   ->where('paid', 0);
	}

    public function getAllNoPaymentForSchool( $school_id ) {
        return $this->model->where('school_id', $school_id)
            ->where('paid', 0);
    }

    public function getAllNoPaymentForSchoolYear( $school_year_id ) {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('paid', 0);
    }
}