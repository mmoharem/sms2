<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Denomination extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = array('id');

    public function total()
    {
        return $this->hasMany(Student::class, 'denomination_id');
    }
}
