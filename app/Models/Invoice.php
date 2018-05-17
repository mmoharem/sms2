<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model {
	use SoftDeletes;

	protected $dates = [ 'deleted_at' ];

	protected $guarded = array ( 'id' );

	public function user() {
		return $this->belongsTo( User::class );
	}

	public function items() {
		return $this->hasMany( InvoiceItem::class );
	}

	public function school() {
		return $this->belongsTo( School::class );
	}

	public function fee_category() {
		return $this->belongsTo( FeeCategory::class );
	}

	public function school_year() {
		return $this->belongsTo( SchoolYear::class, 'academic_year_id' );
	}

	public function semester() {
		return $this->belongsTo( Semester::class, 'semester_id' );
	}

	public function currency() {
		return $this->belongsTo( Option::class, 'currency_id' );
	}
}
