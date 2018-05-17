<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentFinalMark extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id');
    }

    public function mark_value()
    {
        return $this->belongsTo(MarkValue::class, 'mark_value_id');
    }
}
