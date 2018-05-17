<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model {
	use SoftDeletes;

	protected $dates = [ 'deleted_at' ];

	protected $guarded = array ( 'id' );

	public function prepared_user() {
		return $this->belongsTo( User::class, 'prepared_user_id' );
	}

	public function debit() {
		return $this->belongsTo( Account::class, 'debit_account_id' );
	}

	public function credit() {
		return $this->belongsTo( Account::class, 'credit_account_id' );
	}

	public function school_year() {
		return $this->belongsTo( SchoolYear::class, 'school_year_id' );
	}

	public function school() {
		return $this->belongsTo( School::class, 'school_year' );
	}
}
