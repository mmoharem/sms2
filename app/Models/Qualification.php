<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Qualification extends Model
{
    protected $guarded = array('id');

    public function applicantSchools()
    {
        return $this->hasMany(Applicant_school::class, 'qualification_id');
    }
}
