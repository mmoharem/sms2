<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Section extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function teacher()
    {
        return $this->belongsTo(User::class, 'section_teacher_id');
    }

    public function setSchoolYearIdAttribute($school_year_id)
    {
        $this->attributes['school_year_id'] = ($school_year_id != '') ? $school_year_id : session('current_school_year');
    }

    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'section_id');
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class, 'direction_id');
    }

    public function student_groups()
    {
        return $this->hasMany(StudentGroup::class, 'section_id');
    }

    public function registrations()
    {
        return $this->hasManyThrough(Registration::class, Student::class, 'section_id', 'student_id')
            ->where('registrations.school_id','=', session('current_school'))
            ->where('registrations.school_year_id','=',session('current_school_year'));
    }

    public function studentsPaidAllFees()
    {
        return $this->hasManyThrough(Invoice::class, Student::class, 'section_id', 'student_id')
            ->where('invoices.school_id','=', session('current_school'))
            ->where('invoices.school_year_id','=',session('current_school_year'))
            ->where('invoices.amount','<=','0');
    }

    public function studentsPaidPartFees()
    {
        return $this->hasManyThrough(Invoice::class,  Student::class, 'section_id', 'student_id')
            ->where('invoices.school_id','=', session('current_school'))
            ->where('invoices.school_year_id','=',session('current_school_year'))
            ->where('invoices.paid','>','0')
            ->where('invoices.amount','>','0');
    }

    public function studentsNotPaidFees()
    {
        return $this->hasManyThrough( Invoice::class, Student::class, 'section_id', 'student_id')
            ->where('invoices.school_id','=', session('current_school'))
            ->where('invoices.school_year_id','=',session('current_school_year'))
            ->where('invoices.paid','=','0')
            ->where('invoices.amount','>','0');
    }

}
