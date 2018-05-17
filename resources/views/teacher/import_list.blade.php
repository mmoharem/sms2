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
                {{trans('teacher.check_all')}}
            </th>
            <th>{{trans('teacher.first_name')}}</th>
            <th>{{trans('teacher.last_name')}}</th>
            <th>{{trans('teacher.email')}}</th>
            <th>{{trans('teacher.password')}}</th>
            <th>{{trans('teacher.mobile')}}</th>
            <th>{{trans('teacher.fax')}}</th>
            <th>{{trans('teacher.birth_city')}}</th>
            <th>{{trans('teacher.birth_date')}}</th>
            <th>{{trans('teacher.address')}}</th>
            <th>{{trans('teacher.gender')}}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($teachers as $key => $item)
            <tr id="{{$key}}">
            <td>
                <div class="input-group">
                    <label>
                        <input type="checkbox" name="import[]" value="{{$key}}" class='icheckgreen'>
                    </label>
                </div>
            </td>
            <td>
                {{ $item['first_name'] }}
                {!! Form::hidden('first_name['.$key.']', $item['first_name']) !!}
            </td>
            <td>
                {{ $item['last_name'] }}
                {!! Form::hidden('last_name['.$key.']', $item['last_name']) !!}
            </td>
            <td>
                {{ $item['email'] }}
                {!! Form::hidden('email['.$key.']', $item['email']) !!}
            </td>
            <td>
                {{ $item['password'] }}
                {!! Form::hidden('password['.$key.']', $item['password']) !!}
            </td>
            <td>
                {{ $item['mobile'] }}
                {!! Form::hidden('mobile['.$key.']', $item['mobile']) !!}
            </td>
            <td>
                {{ $item['fax'] }}
                {!! Form::hidden('fax['.$key.']', $item['fax']) !!}
            </td>
            <td>
                {{ $item['birth_place'] }}
                {!! Form::hidden('birth_place['.$key.']', $item['birth_place']) !!}
            </td>
            <td>
                {{ $item['birth_date'] }}
                {!! Form::hidden('birth_date['.$key.']', $item['birth_date']) !!}
            </td>
            <td>
                {{ $item['address'] }}
                {!! Form::hidden('address['.$key.']', $item['address']) !!}
            </td>
            <td>
                {{ ($item['gender']=='1')?trans('student.male'):trans('student.female') }}
                {!! Form::hidden('gender['.$key.']', $item['gender']) !!}
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