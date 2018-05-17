<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');

    public function students()
    {
        return $this->hasMany(Student::class, 'session_id');
    }
}
