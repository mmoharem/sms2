<?php

namespace App\Repositories;


interface InvoiceRepository
{
    public function getAll($school_year_id);

	public function getAllStudentsForSchool($school_id,$school_year_id);

    public function getAllDebtor();

	public function getAllDebtorStudentsForSchool($school_id);

	public function getAllFullPaymentForSchoolAndSchoolYear( $school_id, $school_year_id );

	public function getAllPartPaymentForSchoolAndSchoolYear( $school_id, $school_year_id );

	public function getAllNoPaymentForSchoolAndSchoolYear( $school_id, $school_year_id );

    public function getAllNoPaymentForSchool($school_id);

    public function getAllNoPaymentForSchoolYear($school_year_id);
}