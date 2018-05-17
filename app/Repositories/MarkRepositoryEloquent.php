<?php

namespace App\Repositories;

use App\Models\Exam;
use App\Models\Mark;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\DB;

class MarkRepositoryEloquent implements MarkRepository {
	/**
	 * @var Mark
	 */
	private $model;


	/**
	 * MarkRepositoryEloquent constructor.
	 *
	 * @param Mark $model
	 */
	public function __construct( Mark $model ) {
		$this->model = $model;
	}

	public function getAll() {
		return $this->model;
	}

	public function getAllForSchoolYearAndBetweenDate( $school_year_id, $date_start, $date_end ) {
		return $this->model->with( 'student', 'student.user', 'mark_type', 'mark_value', 'subject' )
		                   ->orderBy( 'date' )
		                   ->orderBy( 'student_id' )
		                   ->get()
		                   ->filter( function ( $marksItem ) use ( $school_year_id, $date_start, $date_end ) {
			                   return ( $marksItem->school_year_id == $school_year_id &&
			                            ( Carbon::createFromFormat( Settings::get( 'date_format' ), $marksItem->date ) >=
			                              Carbon::createFromFormat( Settings::get( 'date_format' ), $date_start ) &&
			                              ( Carbon::createFromFormat( Settings::get( 'date_format' ), $marksItem->date ) <=
			                                Carbon::createFromFormat( Settings::get( 'date_format' ), $date_end ) ) ) );
		                   } );

	}

	public function getAllForSchoolYearAndExam( $school_year_id, $exam_id ) {
		return $this->model->with( 'student', 'student.user', 'mark_type', 'mark_value', 'subject' )
		                   ->orderBy( 'date' )
		                   ->get()
		                   ->filter( function ( $marksItem ) use ( $school_year_id, $exam_id ) {
			                   return ( $marksItem->school_year_id == $school_year_id &&
			                            $marksItem->exam_id == $exam_id );
		                   } );

	}

	public function getAllForSchoolYearSubjectUserAndSemester( $school_year_id, $subject_id, $user_id, $semester_id ) {
		return $this->model->with( 'student', 'student.user', 'mark_type', 'mark_value', 'subject' )
		                   ->orderBy( 'date' )
		                   ->get()
		                   ->filter( function ( $marksItem ) use ( $school_year_id, $subject_id, $user_id ) {
			                   return ( $marksItem->school_year_id == $school_year_id &&
			                            $marksItem->subject_id == $subject_id &&
			                            isset( $marksItem->student->user ) && $marksItem->student->user_id == $user_id &&
			                            ( ( isset( $semester_id ) ) ? $marksItem->semester_id == $semester_id : true ) );
		                   } );

	}

	public function getAllForSchoolYearStudents( $school_year_id, $student_user_ids ) {
		return $this->model->with( 'student', 'mark_type', 'mark_value', 'subject' )
		                   ->orderBy( 'date' )
		                   ->orderBy( 'student_id' )
		                   ->get()
		                   ->filter( function ( $marksItem ) use ( $school_year_id,$student_user_ids ) {
			                   return ( isset( $marksItem->student ) &&
			                            $marksItem->student->school_year_id == $school_year_id &&
			                            in_array( $marksItem->student->user_id, $student_user_ids ) );
		                   } );
	}

	public function getAllForExam( $exam_id ) {
		$exam = Exam::find($exam_id);
		if($exam->parent_id != 0){
			$exams = Exam::where('parent_id', $exam_id)->pluck('id', 'id')->toArray();
		}else{
			$exams[$exam_id] = $exam_id;
		}
		return $this->model->with( 'student', 'mark_type', 'mark_value', 'subject' )
		                   ->orderBy( 'date' )
		                   ->orderBy( 'subject_id' )
		                   ->orderBy( 'student_id' )
		                   ->get()
		                   ->filter( function ( $marksItem ) use ( $exams ) {
			                   return ( isset( $marksItem->student ) &&
			                            in_array( $marksItem->exam_id, $exams ) );
		                   } );
	}

	public function getAllForSchoolYearStudentsAndBetweenDate( $school_year_id, $student_user_ids, $start_date, $end_date ) {
		return $this->model->with( 'student', 'mark_type', 'mark_value', 'subject' )
		                   ->orderBy( 'date' )
		                   ->orderBy( 'student_id' )
							->whereBetween( 'date', [
								Carbon::createFromFormat( Settings::get( 'date_format' ), $start_date ),
								Carbon::createFromFormat( Settings::get( 'date_format' ), $end_date )
							] )
		                   ->get()
		                   ->filter( function ( $marksItem ) use ( $school_year_id,$student_user_ids ) {
			                   return ( isset( $marksItem->student ) &&
			                            $marksItem->student->school_year_id == $school_year_id &&
			                            in_array( $marksItem->student->user_id, $student_user_ids ) );
		                   } );
	}

	public function getAllForSchoolYearStudentsSubject( $school_year_id, $student_user_ids, $subject_id ) {
		return $this->model->with( 'student', 'mark_type', 'mark_value', 'subject' )
		                   ->orderBy( 'date' )
		                   ->orderBy( 'student_id' )
		                   ->get()
		                   ->filter( function ( $marksItem ) use ( $school_year_id,$student_user_ids,$subject_id ) {
			                   return ( isset( $marksItem->student ) &&
			                            $marksItem->student->school_year_id == $school_year_id &&
			                            $marksItem->subject_id == $subject_id &&
			                            in_array( $marksItem->student->user_id, $student_user_ids ) );
		                   } );
	}


    public function getAllForSchoolYearSemesterStudents( $school_year_id, $semester_id, $student_user_ids ) {
        return $this->model->join('students', 'students.id', '=', 'marks.student_id')
            ->whereIn('marks.student_id', $student_user_ids)
            ->where('marks.semester_id', $semester_id)
            ->where('marks.school_year_id', $school_year_id)
            ->whereNull('students.deleted_at')
            ->groupBy( 'marks.school_year_id' )
            ->groupBy( 'marks.semester_id' )
            ->groupBy( 'marks.student_id' )
            ->distinct()
            ->select(DB::raw('avg(mark_percent) as avg_mark_percent'), 'marks.student_id')
            ->orderBy( 'avg_mark_percent','desc' )
            ->get();
    }
}