<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HumanResourceSchool extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

}
