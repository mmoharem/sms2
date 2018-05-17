@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {!! Form::open(array('url' => url($type.'/finish_import'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
    <table class="table subjects import-wrapper">
        <thead>
        <tr>
            <th>
                <input type="checkbox" id="checkAll" class="icheckgreen">
                {{trans('subject.check_all')}}
            </th>
            <th>{{trans('subject.title')}}</th>
            <th>{{trans('subject.direction')}}</th>
            <th>{{trans('subject.order')}}</th>
            <th{{trans('subject.class')}}></th>
            <th>{{trans('subject.mark_system')}}</th>
            <th>{{trans('subject.subject_fee')}}</th>
            <th>{{trans('subject.highest_mark')}}</th>
            <th>{{trans('subject.lowest_mark')}}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($subjects as $key => $item)
            <tr id="{{$key}}">
            <td>
                <div class="input-group">
                    <label>
                        <input type="checkbox" name="import[]" value="{{$key}}" class='icheckgreen'>
                    </label>
                </div>
            </td>
            <td>
                {{ $item['title'] }}
                {!! Form::hidden('title['.$key.']', $item['title']) !!}
            </td>
            <td>
                {!! Form::select('direction_id['.$key.']', $directions, null, array('class' => 'form-control')) !!}
            </td>
            <td>
                {{ $item['order'] }}
                {!! Form::hidden('order['.$key.']', $item['order']) !!}
            </td>
            <td>
                {{ $item['class'] }}
                {!! Form::hidden('class['.$key.']', $item['class']) !!}
            </td>
            <td>
                {!! Form::select('mark_system_id['.$key.']', $mark_systems, null, array('class' => 'form-control')) !!}
            </td>
            <td>
                {{ $item['fee'] }}
                {!! Form::hidden('fee['.$key.']', $item['fee']) !!}
            </td>
            <td>
                {{ $item['highest_mark'] }}
                {!! Form::hidden('highest_mark['.$key.']', $item['highest_mark']) !!}
            </td>
            <td>
                {{ $item['lowest_mark'] }}
                {!! Form::hidden('lowest_mark['.$key.']', $item['lowest_mark']) !!}
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