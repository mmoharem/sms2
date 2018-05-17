<?php

namespace App\Models;

use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Account extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function school()
    {
        return $this->belongsTo(User::class, 'school_id');
    }

    public function type()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class, 'voucher_id');
    }
}
