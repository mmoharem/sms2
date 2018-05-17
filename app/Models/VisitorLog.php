<?php

namespace App\Models;

use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitorLog extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $guarded = array('id');

	public function user()
	{
		return $this->belongsTo(User::class);
	}
	public function visited_user()
	{
		return $this->belongsTo(User::class, 'visited_user_id');
	}

	public function date_time_format()
	{
		return Settings::get('date_format').' '.Settings::get('time_format');
	}

	public function setCheckInAttribute($date)
	{
		$this->attributes['check_in'] = Carbon::createFromFormat($this->date_time_format(), $date)->format('Y-m-d H:i');
	}

	public function getCheckInAttribute($date)
	{
		if ($date == "0000-00-00 00:00" || $date == "") {
			return "";
		} else {
			return date($this->date_time_format(), strtotime($date));
		}
	}
	public function setCheckOutAttribute($date)
	{
		if($date == ''){
			$this->attributes['check_out'] = null;
		}else{
			$this->attributes['check_out'] = Carbon::createFromFormat($this->date_time_format(), $date)->format('Y-m-d H:i');
		}
	}

	public function getCheckOutAttribute($date)
	{
		if ($date == "0000-00-00 00:00" || $date == "") {
			return "";
		} else {
			return date($this->date_time_format(), strtotime($date));
		}
	}

}
