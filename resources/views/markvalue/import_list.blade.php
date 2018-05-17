@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {!! Form::open(array('url' => url($type.'/finish_import'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
    <table class="table markvalues import-wrapper">
        <thead>
        <tr>
            <th>
                <input type="checkbox" id="checkAll" class="icheckgreen">
                {{trans('subject.check_all')}}
            </th>
            <th>{{trans('markvalue.max_score')}}</th>
            <th>{{trans('markvalue.min_score')}}</th>
            <th>{{trans('markvalue.grade')}}</th>
            <th>{{trans('markvalue.mark_system')}}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($markvalues as $key => $item)
            <tr id="{{$key}}">
            <td>
                <div class="input-group">
                    <label>
                        <input type="checkbox" name="import[]" value="{{$key}}" class='icheckgreen'>
                    </label>
                </div>
            </td>
                <td>
                    {!! Form::select('mark_system_id['.$key.']', $mark_systems, null, array('class' => 'form-control')) !!}
                </td>
            <td>
                {{ $item['max_score'] }}
                {!! Form::hidden('max_score['.$key.']', $item['max_score']) !!}
            </td>
            <td>
                {{ $item['min_score'] }}
                {!! Form::hidden('min_score['.$key.']', $item['min_score']) !!}
            </td>
            <td>
                {{ $item['grade'] }}
                {!! Form::hidden('grade['.$key.']', $item['grade']) !!}
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