<?php

namespace App\Http\Controllers\Secure;

use App\Models\Direction;
use App\Models\Student;
use App\Models\User;
use Efriandika\LaravelSettings\Facades\Settings;
use PDF;
use Sentinel;

class VisitorStudentCardController extends SecureController
{
    private $begin_html = '';

    public function __construct()
    {
        parent::__construct();

        $this->begin_html = '<!DOCTYPE html>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <html>
                    <head>
                        <style>
                        table {
                            border-collapse: collapse;
                             width:100%;
                        }

                        table, td, th {
                            border: 1px solid #000000;
                            text-align:center;
                            vertical-align:middle;
                        }
                        </style>
                ';
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return Response
     * @internal param User $visitor
     */
    public function visitor(User $user)
    {
        if (!is_null($user->visitor->last())) {
            $data = $this->begin_html . '<title>' . trans('visitor_student_card.visitor_card') . '</title>
                    </head>
        <body style="height: 0;
				    padding: 0;
				    padding-bottom: 75%;
				    background-image: url(' . url('uploads/visitor_card/' . Settings::get('visitor_card_background')) . ');
				    background-position: top left;
				    background-size: 100%;
				    background-repeat: no-repeat;">';
            $data .= '<table><tr><td>
                <h1>' . trans('visitor_student_card.visitor_card') . ' - ' . Settings::get('name') . '</h1>';
            $data .= '<h2>' . $user->full_name . '</h2>';
            $data .= '<h2>' . $user->email . '</h2>';
            $data .= '<h2>' . trans('visitor_student_card.visitor_no') . ': ' . $user->visitor->last()->visitor_no . '</h2>';
            $data .= '</td></tr></table></body></html>';
            $pdf = PDF::loadHTML($data);
            return $pdf->stream();
        } else {
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Student $student
     *
     * @return Response
     */
    public function student(Student $student)
    {
        $school = $student->school;
        $department = Direction::join('departments', 'departments.id', '=', 'directions.department_id')
                ->join('student_groups','student_groups.direction_id', '=', 'directions.id')
                ->join('student_student_group','student_student_group.student_group_id', '=', 'student_groups.id')
                ->where('student_student_group.student_id', $student->id)
                ->select('departments.*')
                ->first();
        $data = $this->begin_html . '<title>' . trans('visitor_student_card.student_card') . '</title>
                    </head>
            <body style="height: 100%;
			    padding: 0;
			    padding-bottom: 75%;
			    background-image: url(' . (is_null($school->student_card_background)?"":url
            ($school->student_card_background_photo)) . ');
			    background-position: top left;
			    background-size: 100%;
			    background-repeat: no-repeat;">';
        $data .= '<table><tr><td><img src="' . url($school->photo_image) . '" height="200" width="200"><br>
                    <img src="' . url($student->user->picture) . '" height="200" width="200"></td><td>
            <h1>'.$school->title;
        if($school->tax_no != ""){
            $data .= '<br>' . trans('schools.tax_no') . ': '.$school->tax_no;
        }
        $data .= '</h1>';
        $data .= trans('visitor_student_card.student_card');
        $data .= '<h2>' . trans('student.first_name') . ': ' . $student->user->first_name . '</h2>';
        $data .= '<h2>' . trans('student.last_name') . ': ' . $student->user->last_name . '</h2>';
        if(!is_null($department)) {
            $data .= '<h2>' . trans('student.department') . ': ' . $department->title . '</h2>';
        }
        $data .= '<h2>' . trans('student.personal_no') . ': ' .$student->user->personal_no . '</h2>';
        $data .= '<h2>' . trans('visitor_student_card.student_no') . ': ' . $student->order . '</h2></td>';
        $data .= '</tr></table></body></html>';
        //echo $data;
        $pdf = PDF::loadHTML($data);
        return $pdf->stream();
    }

}
