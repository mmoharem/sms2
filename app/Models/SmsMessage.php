<?php

namespace App\Models;

use App\Events\SMSMessageCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsMessage extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

	protected $events = ['created'=> SMSMessageCreated::class];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
