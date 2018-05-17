<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Direction extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function registrations()
    {
        return $this->hasManyThrough(Registration::class, Student::class, 'direction_id', 'student_id')
            ->where('registrations.school_id','=', session('current_school'))
            ->where('registrations.school_year_id','=',session('current_school_year'));
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
