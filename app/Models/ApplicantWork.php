<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class ApplicantWork extends Model
{
	use SoftDeletes;

	protected $dates = [ 'deleted_at' ];

	protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}