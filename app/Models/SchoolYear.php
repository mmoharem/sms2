<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolYear extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'school_id');
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'school_id');
    }
}
