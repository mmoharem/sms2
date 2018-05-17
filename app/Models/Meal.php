<?php

namespace App\Models;

use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $guarded = array('id');

	public function date_format()
	{
		return Settings::get('date_format');
	}

	public function setServeStartDateAttribute($date)
	{
		$this->attributes['serve_start_date'] = Carbon::createFromFormat($this->date_format(), $date)->format('Y-m-d');
	}

	public function getServeStartDateAttribute($date)
	{
		if ($date == "0000-00-00" || $date == "") {
			return "";
		} else {
			return date($this->date_format(), strtotime($date));
		}
	}
	public function setServeEndDateAttribute($date)
	{
		$this->attributes['serve_end_date'] = Carbon::createFromFormat($this->date_format(), $date)->format('Y-m-d');
	}

	public function getServeEndDateAttribute($date)
	{
		if ($date == "0000-00-00" || $date == "") {
			return "";
		} else {
			return date($this->date_format(), strtotime($date));
		}
	}

	public function meal_type()
	{
		return $this->belongsTo(MealType::class);
	}
}
