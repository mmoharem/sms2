<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="content-type" content="text-html; charset=utf-8">
    <title>SMS Registration</title>
</head>
<body>
<div id="page-wrap">
    <h3>{{trans('registration.subject').': '}}
        @if (isset($registration->subject))
            {{ $registration->subject->title }}
        @endif
    </h3>
    <table width="100%">
        <tr>
            <td width="5%">
                <h2>
                    <img src="{{ url('uploads/site').'/thumb_'.Settings::get('logo') }}"/>
                </h2>
            </td>
            <td width="75%">
                <h3>{{Settings::get('name') }}</h3>
            </td>
            <td width="20%">
                <h5>{{ trans('registration.create_date') . " : " . $registration->created_at->format(Settings::get('date_format'))}}</h5>
            </td>
        </tr>
    </table>
    <br/><br/>
    <table width="100%">
        <tr>
            <td width="33%">
                <table>
                    <tbody>
                    <tr>
                        <th>{{trans('registration.school')}}</th>
                    </tr>
                    <tr>
                        <td>{{ !is_null($registration->school->title)?$registration->school->title:"" }}</td>
                    </tr>
                    <tr>
                        <td>{{ !is_null($registration->school->address)?$registration->school->address:"" }}</td>
                    </tr>
                    <tr>
                        <td>{{trans('registration.school_phone') . " : " . (!is_null($registration->school->phone)?$registration->school->phone:"") }}</td>
                    </tr>
                    <tr>
                        <td>{{trans('registration.school_email') . " : " . (!is_null($registration->school->email)?$registration->school->email:"") }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td width="33%">
                <table>
                    <tbody>
                    <tr>
                        <th>{{trans('registration.student')}}</th>
                    </tr>
                    <tr>
                        <td>{{ !is_null($registration->user)?$registration->user->full_name:"" }}</td>
                    </tr>
                    <tr>
                        <td>{{ !is_null($registration->user)?$registration->user->address:"" }}</td>
                    </tr>
                    <tr>
                        <td>{{ !is_null($registration->user)?$registration->user->phone:"" }}</td>
                    </tr>
                    <tr>
                        <td>{{ !is_null($registration->user)?$registration->user->email:"" }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td width="33%">
                <table>
                    <tbody>
                    <tr>
                        <th>{{trans('registration.results')}}</th>
                    </tr>
                    <tr>
                        <td>{{ trans('registration.credit') . " : " . $registration->credit }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('registration.grade') . " : " . $registration->grade }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('registration.mid_sem') . " : " . $registration->mid_sem }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('registration.exams') . " : " . $registration->exams }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('registration.exam_score') . " : " . $registration->exam_score }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <br/><br/>
</div>
</body>
</html>