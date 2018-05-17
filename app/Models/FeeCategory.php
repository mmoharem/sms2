<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeCategory extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');


    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function currency()
    {
        return $this->belongsTo(Option::class, 'currency_id');
    }

    public function feesPeriod()
    {
        return $this->belongsTo(FeePeriod::class, 'fees_period_id');
    }
}
