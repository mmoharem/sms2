<?php

namespace App\Models;

use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineExam extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function date_format()
    {
        return Settings::get('date_format');
    }

    public function setDateStartAttribute($date)
    {
        $this->attributes['date_start'] = Carbon::createFromFormat($this->date_format(), $date)->format('Y-m-d');
    }

    public function getDateStartAttribute($date)
    {
        if ($date == "0000-00-00" || $date == "") {
            return "";
        } else {
            return date($this->date_format(), strtotime($date));
        }
    }

    public function setDateEndAttribute($date)
    {
        $this->attributes['date_end'] = Carbon::createFromFormat($this->date_format(), $date)->format('Y-m-d');
    }

    public function getDateEndAttribute($date)
    {
        if ($date == "0000-00-00" || $date == "") {
            return "";
        } else {
            return date($this->date_format(), strtotime($date));
        }
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function student_group()
    {
        return $this->belongsTo(StudentGroup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(OnlineExamQuestion::class);
    }

    public function answered()
    {
        return $this->hasMany(OnlineExamUserAnswer::class)->groupBy('user_id')->groupBy('online_exam_id');
    }
}
