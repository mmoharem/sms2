<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('registration.subject')}}</label>
            <div class="controls">
                @if (isset($registration->subject)) {{ $registration->subject->title }} @endif
            </div>
        </div>
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
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.close')}}</a>
                @else
                    <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.cancel')}}</a>
                    <button type="submit" class="btn btn-danger btn-sm">{{trans('table.delete')}}</button>
                @endif
            </div>
        </div>
    </div>
</div>