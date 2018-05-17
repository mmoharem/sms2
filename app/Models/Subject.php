<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function teacher_subjects()
    {
        return $this->hasMany(TeacherSubject::class, 'subject_id');
    }

    public function mark_system()
    {
        return $this->belongsTo(MarkSystem::class, 'mark_system_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

	public function setHighestMarkAttribute($highest_mark)
	{
		if($highest_mark!=null && $highest_mark!="") {
			$this->attributes['highest_mark'] = $highest_mark;
		}else{
			$this->attributes['highest_mark'] = null;
		}
	}
}
