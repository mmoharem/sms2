<?php

namespace App\Models;

use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimetablePeriod extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    protected $appends = ['start_at_time', 'end_at_time'];

    public function time_format()
    {
        return Settings::get('time_format');
    }

    public function getStartAtTimeAttribute()
    {
        return Carbon::createFromFormat('Y-m-d '.$this->time_format(), date('Y-m-d').' '.$this->attributes['start_at'])->timestamp;
    }


    public function getEndAtTimeAttribute()
    {
        return Carbon::createFromFormat('Y-m-d '.$this->time_format(), date('Y-m-d').' '.$this->attributes['end_at'])->timestamp;
    }

}
