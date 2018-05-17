<?php
namespace App\Models;

use App\Events\MessageCreated;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = array('id');

	protected $events = ['created'=> MessageCreated::class];

	protected $appends = ['file_url'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'from');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'to');
    }

	public function getFileUrlAttribute()
	{
		$file = $this->attributes['attachment'];
        return public_path() . '/uploads/messages/'. $file;
	}

}
