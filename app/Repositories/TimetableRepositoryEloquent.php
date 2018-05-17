<?php

namespace App\Repositories;

use App\Models\Timetable;
use Illuminate\Support\Collection;

class TimetableRepositoryEloquent implements TimetableRepository
{
    /**
     * @var Timetable
     */
    private $model;


    /**
     * TimetableRepositoryEloquent constructor.
     * @param Timetable $model
     */
    public function __construct(Timetable $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForTeacherSubject($teacher_subject_ids)
    {
        $timetable = new Collection([]);
        $this->model->get()
            ->each(function ($timetables) use ($teacher_subject_ids, $timetable) {
                foreach ($teacher_subject_ids as $teacher_subject) {
                    if ($timetables->teacher_subject_id == $teacher_subject['id']) {
                        $teacher_subject['week_day'] = $timetables->week_day;
                        $teacher_subject['hour'] = $timetables->hour;
                        $teacher_subject['id'] = $timetables->id;
                        $teacher_subject['semester_id'] = $timetables->semester_id;
                        $timetable->push($teacher_subject);
                    }
                }
            });
        return $timetable;
    }
}