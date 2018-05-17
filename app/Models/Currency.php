<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model {
	use SoftDeletes;

	protected $dates = [ 'deleted_at' ];
	protected $guarded = array ( 'id' );
	protected $table = 'currencies';

	public function students() {
		return $this->hasMany( Student::class, 'currency_id' );
	}

	public function studentsPaidFees() {
		return $this->hasMany( Invoice::class )
		            ->where( 'registrations.school_id', '=', session( 'current_school' ) )
		            ->where( 'registrations.school_year_id', '=', session( 'current_school_year' ) )
		            ->where( 'paid', '>', '0' );
	}

	public function studentsPaidFeesPercentage() {

		return @$this->percent( @$this->studentsPaidFees()->sum( 'paid' ), @$this->totalFees() );

	}

	public function studentsNotPaidFeesPercentage() {

		return @$this->percent( @$this->studentsNotPaidFees()->sum( 'amount' ), @$this->totalFees() );

	}


	public function studentsPaidPartFees() {
		return $this->hasMany( Invoice::class )
		            ->where( 'registrations.school_id', '=', session( 'current_school' ) )
		            ->where( 'registrations.school_year_id', '=', session( 'current_school_year' ) )
		            ->where( 'invoices.paid', '>', '0' )
		            ->where( 'invoices.amount', '>', '0' );
	}

	public function studentsNotPaidFees() {
		return $this->hasMany( Invoice::class )
		            ->where( 'registrations.school_id', '=', session( 'current_school' ) )
		            ->where( 'registrations.school_year_id', '=', session( 'current_school_year' ) )
		            ->where( 'paid', '=', '0' );

	}

	public function percent( $num, $total ) {

		$row_this = number_format( ( 100.0 * $num ) / $total, 2 );

		return $row_this;

	}

	public function totalFees() {
		return ( @$this->studentsPaidFees()->sum( 'paid' ) ) + ( @$this->studentsNotPaidFees()->sum( 'amount' ) );

	}


}
