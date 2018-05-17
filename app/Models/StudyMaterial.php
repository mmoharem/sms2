<?php

namespace App\Models;

use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudyMaterial extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

	protected $appends = ['file_url'];

    public function date_format()
    {
        return Settings::get('date_format');
    }

    public function setDateOffAttribute($date)
    {
        $this->attributes['date_off'] = Carbon::createFromFormat($this->date_format(), $date)->format('Y-m-d');
    }

    public function getDateOffAttribute($date)
    {
        if ($date == "0000-00-00" || $date == "") {
            return "";
        } else {
            return date($this->date_format(), strtotime($date));
        }
    }
    public function setDateOnAttribute($date)
    {
        if(is_null($date)){
            $this->attributes['date_on'] = Carbon::now()->format('Y-m-d');
        }else{
            $this->attributes['date_on'] = Carbon::createFromFormat($this->date_format(), $date)->format('Y-m-d');
        }
    }

    public function getDateOnAttribute($date)
    {
        if ($date == "0000-00-00" || $date == "") {
            return Carbon::now()->format($this->date_format());
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

    public function getFileUrlAttribute()
    {
        $file = $this->attributes['file'];
        return public_path() . '/uploads/study_material/'. $file;
    }
}
