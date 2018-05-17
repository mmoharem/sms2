<?php

namespace App\Models;

use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class AccountType extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');


    public function accounts()
    {
        return $this->hasMany(Account::class, 'account_type_id');
    }
}
