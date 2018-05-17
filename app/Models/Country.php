<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');

    public function users()
    {
        return $this->hasMany(User::class, 'country_id');
    }
    public function students()
    {
        return $this->hasManyThrough(Student::class, User::class);
    }
}
