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
                {{trans('parent.check_all')}}
            </th>
            <th>{{trans('parent.student_email')}}</th>
            <th>{{trans('parent.first_name')}}</th>
            <th>{{trans('parent.last_name')}}</th>
            <th>{{trans('parent.email')}}</th>
            <th>{{trans('parent.password')}}</th>
            <th>{{trans('parent.mobile')}}</th>
            <th>{{trans('parent.fax')}}</th>
            <th>{{trans('parent.birth_city')}}</th>
            <th>{{trans('parent.birth_date')}}</th>
            <th>{{trans('parent.address')}}</th>
            <th>{{trans('parent.gender')}}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($parents as $key => $item)
            <tr id="{{$key}}">
            <td>
                <div class="input-group">
                    <label>
                        <input type="checkbox" name="import[]" value="{{$key}}" class='icheckgreen'>
                    </label>
                </div>
            </td>
            <td>
                {{ $item['student_email'] }}
                {!! Form::hidden('student_email['.$key.']', $item['student_email']) !!}
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
                {{ ($item['gender']=='1')?trans('parent.male'):trans('parent.female') }}
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