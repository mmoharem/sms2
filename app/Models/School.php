<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

	protected $appends = ['student_card_background_photo', 'photo_image','sms_messages_year'];

    public function getStudentCardBackgroundPhotoAttribute()
    {
        $picture = $this->attributes['student_card_background'];
        return asset('uploads/student_card') . '/' . $picture;
    }

    public function getPhotoImageAttribute()
    {
        $picture = $this->attributes['photo'];
        return asset('uploads/school_photo') . '/' . $picture;
    }
	public function sms_messages()
	{
		return $this->hasMany(SmsMessage::class);
	}
	public function getSmsMessagesYearAttribute()
	{
		return $this->sms_messages()
			->where('created_at', 'LIKE',Carbon::now()->format( 'Y' ) . '%')->count();
	}
}
