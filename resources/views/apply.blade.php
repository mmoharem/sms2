@extends('layouts.auth')
@section('content')
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <h3>{{trans('auth.apply_to_school')}}</h3>
                <br>
                {!! Form::open(array('url' => url('apply'), 'method' => 'post', 'files'=> true)) !!}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('email', trans('applicant.email'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::text('email', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    {!! Form::label('first_name', trans('applicant.first_name'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::text('first_name', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('middle_name') ? 'has-error' : '' }}">
                    {!! Form::label('middle_name', trans('applicant.middle_name'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::text('middle_name', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('middle_name', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    {!! Form::label('last_name', trans('applicant.last_name'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::text('last_name', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    {!! Form::label('address', trans('applicant.address'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::text('address',null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                    {!! Form::label('mobile', trans('applicant.mobile'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::text('mobile', null, array('class' => 'form-control', 'id'=>'mobile')) !!}
                        <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    {!! Form::label('phone', trans('applicant.phone'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::text('phone', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                    {!! Form::label('gender', trans('applicant.gender'), array('class' => 'control-label required')) !!}
                    <div class="controls radiobutton">
                        {!! Form::label('gender', trans('applicant.female'), array('class' => 'control-label')) !!}
                        {!! Form::radio('gender', '0',false) !!}
                        {!! Form::label('gender', trans('applicant.male'), array('class' => 'control-label')) !!}
                        {!! Form::radio('gender', '1',false)!!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('birth_date') ? 'has-error' : '' }}">
                    {!! Form::label('birth_date', trans('applicant.birth_date'), array('class' => 'control-label')) !!}
                    <div class="controls" style="position: relative">
                        {!! Form::text('birth_date', null, array('class' => 'form-control date')) !!}
                        <span class="help-block">{{ $errors->first('birth_date', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('birth_city') ? 'has-error' : '' }}">
                    {!! Form::label('birth_city', trans('applicant.birth_city'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::text('birth_city', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('birth_city', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
                    {!! Form::label('country_id', trans('applicant.country'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::select('country_id', $countries, null, array('id'=>'country_id', 'class' => 'form-control select2')) !!}
                        <span class="help-block">{{ $errors->first('country_id', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('school_id') ? 'has-error' : '' }}">
                    {!! Form::label('school_id', trans('applicant.school'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::select('school_id', $schools, null, array('id'=>'school_id', 'class' => 'form-control select2', 'placeholder'=>trans('applicant.select_school'))) !!}
                        <span class="help-block">{{ $errors->first('school_id', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('direction_id') ? 'has-error' : '' }}">
                    {!! Form::label('direction_id', trans('applicant.direction_id'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::select('direction_id', [], null, array('id'=>'direction_id', 'class' =>
                        'form-control select2')) !!}
                        <span class="help-block">{{ $errors->first('direction_id', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('disability') ? 'has-error' : '' }}">
                    {!! Form::label('disability', trans('applicant.disability'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::text('disability',null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('disability', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('contact_relation') ? 'has-error' : '' }}">
                    {!! Form::label('contact_relation', trans('applicant.contactRelation'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::text('contact_relation', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('contact_relation', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('contact_name') ? 'has-error' : '' }}">
                    {!! Form::label('contact_name', trans('applicant.contactName'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::text('contact_name',  null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('contact_name', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('contact_address') ? 'has-error' : '' }}">
                    {!! Form::label('contact_address', trans('applicant.contactAddress'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::text('contact_address', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('contact_address', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('contact_phone') ? 'has-error' : '' }}">
                    {!! Form::label('contact_phone', trans('applicant.contactPhone'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::text('contact_phone',  null, array('class' => 'form-control', 'id'=>'phone')) !!}
                        <span class="help-block">{{ $errors->first('contact_phone', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('contact_email') ? 'has-error' : '' }}">
                    {!! Form::label('contact_email', trans('applicant.contact_email'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::email('contact_email',  null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('contact_email', ':message') }}</span>
                    </div>
                </div>
                @if (!isset($applicant))
                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        {!! Form::label('password', trans('applicant.password'), array('class' => 'control-label required')) !!}
                        <div class="controls">
                            {!! Form::password('password', array('class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                        </div>
                    </div>
                @endif
                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    {!! Form::label('image', trans('accountant.picture'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        <div class="controls row">
                            {!! Form::file('image_file', null, array('id'=>'image_file', 'class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('image_file', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-success btn-sm">{{trans('table.ok')}}</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </section>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.date').datetimepicker({
                format: '{{ Settings::get('jquery_date') }}',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
                viewMode: 'years'
            });
            $('.date').on('change dp.change', function (e) {
                $('.date').trigger('change');
            });

            $('#school_id').change(function () {
                $('#direction_id').empty();
                $.ajax({
                    type: "GET",
                    url: '{{url('/apply')}}/' + $(this).val() + '/directions',
                    success: function (response) {
                        $.each(response, function (val, text) {
                            $('#direction_id').append($('<option></option>').val(text.id).html(text.title));
                        });
                    }
                });
            });
        });
    </script>
@endsection