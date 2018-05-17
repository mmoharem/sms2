@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {!! Form::open(array('url' => url($type.'/finish_import'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
    <table class="table timetable_periods import-wrapper">
        <thead>
        <tr>
            <th>
                <input type="checkbox" id="checkAll" class="icheckgreen">
                {{trans('subject.check_all')}}
            </th>
            <th>{{trans('timetable_period.start_at')}}</th>
            <th>{{trans('timetable_period.end_at')}}</th>
            <th>{{trans('timetable_period.title')}}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($timetable_periods as $key => $item)
            <tr id="{{$key}}">
            <td>
                <div class="input-group">
                    <label>
                        <input type="checkbox" name="import[]" value="{{$key}}" class='icheckgreen'>
                    </label>
                </div>
            </td>
            <td>
                {{ $item['start_at'] }}
                {!! Form::hidden('start_at['.$key.']', $item['start_at']) !!}
            </td>
            <td>
                {{ $item['end_at'] }}
                {!! Form::hidden('end_at['.$key.']', $item['end_at']) !!}
            </td>
            <td>
                {{ $item['title'] }}
                {!! Form::hidden('title['.$key.']', $item['title']) !!}
            </td>
        </tr>
            @endforeach
        </tbody>
    </table>
    <div class="form-group">
        <div class="controls">
            <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.cancel')}}</a>
            <button type="submit" class="btn btn-success btn-sm">{{trans('table.ok')}}</button>
        </div>
    </div>
    {!! Form::close() !!}
@stop

{{-- Scripts --}}
@section('scripts')
    <script>
        $(document).ready(function () {
            $("#checkAll").on('ifChecked', function () {
                $("input:checkbox").iCheck('check');
            });
            $('.icheckgreen').iCheck({
                checkboxClass: 'icheckbox_minimal-green',
                radioClass: 'iradio_minimal-green'
            });
        });
     </script>
@stop