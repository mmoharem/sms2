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
                {{trans('student.check_all')}}
            </th>
            <th>{{trans('student.first_name')}}</th>
            <th>{{trans('student.last_name')}}</th>
            <th>{{trans('student.section')}}</th>
            <th>{{trans('student.student_group')}}</th>
            <th>{{trans('student.email')}}</th>
            <th>{{trans('student.password')}}</th>
            <th>{{trans('student.mobile')}}</th>
            <th>{{trans('student.fax')}}</th>
            <th>{{trans('student.birth_city')}}</th>
            <th>{{trans('student.birth_date')}}</th>
            <th>{{trans('student.address')}}</th>
            <th>{{trans('student.gender')}}</th>
            <th>{{trans('student.order')}}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($students as $key => $item)
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
                {!! Form::select('section_id['.$key.']', $sections, null, array('id'=>'section_id_'.$key, 'class' => 'form-control', 'placeholder'=>trans('student.select_section'))) !!}
            </td>
            <td>
                {!! Form::select('student_group_id['.$key.']', [], null, array('id'=>'student_group_id_'.$key, 'class' => 'form-control', 'placeholder'=>trans('student.select_group'))) !!}
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
            <td>
                {{ $item['order'] }}
                {!! Form::hidden('order['.$key.']', $item['order']) !!}
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
        $('body').toggleClass('nav-md nav-sm');
         $(document).ready(function () {
            $("#checkAll").on('ifChecked', function () {
                $("input:checkbox").iCheck('check');
            });
            $('.icheckgreen').iCheck({
                checkboxClass: 'icheckbox_minimal-green',
                radioClass: 'iradio_minimal-green'
            });

             $('select[id^="section_id_"]').change(function() {
                 var value = $(this).val();
                 var id = parseInt($(this).attr('id').split('section_id_')[1]);

                 $('#student_group_id_'+id).find('option').remove().end();
                 $('#student_group_id_'+id).attr("placeholder", "{{trans('student.select_group')}}");;

                 $.ajax({
                     type: "GET",
                     url: '{{url('/section')}}/' + value + '/get_groups',
                     success: function (response) {
                         $.each(response, function (val, text) {
                             $('#student_group_id_'+id).append($('<option></option>').val(text.id).html(text.title));
                         });
                     }
                 });
             });
        });

     </script>
@stop