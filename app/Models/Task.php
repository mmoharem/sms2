<?php namespace App\Models;

use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $table = 'tasks';
    protected $guarded = array('id');

    public function date_format()
    {
        return Settings::get('date_format');
    }

    public function user_ids()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task_from_users()
    {
        return $this->belongsTo(User::class, 'task_from_user');
    }

    public function setTaskDeadlineAttribute($task_deadline)
    {
        $this->attributes['task_deadline'] = Carbon::createFromFormat($this->date_format(), $task_deadline)->format('Y-m-d');
    }

    public function getTaskDeadlineAttribute()
    {
        $task_deadline = $this->attributes['task_deadline'];
        if ($task_deadline == "") {
            return "";
        } else {
            return date($this->date_format(), strtotime($task_deadline));
        }
    }
}