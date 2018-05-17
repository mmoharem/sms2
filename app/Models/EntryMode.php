<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntryMode extends Model
{
    //
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');
    protected $table = 'entry_modes';

    public function total()
    {
        return $this->hasMany(Student::class, 'entry_mode_id');
    }
}
