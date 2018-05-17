@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    @include('mailbox.mailbox')
        <div class="col-lg-9">
            {!! Form::open(array('url' => url('mailbox/compose'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
            <div class="form-group {{ $errors->has('recipients') ? 'has-error' : '' }}">
                {!! Form::label('recipients', trans('mailbox.select_receiver'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('recipients[]', $users_select, null, array('id'=>'recipients', 'class' => 'form-control select2', 'multiple')) !!}
                    <span class="help-block">{{ $errors->first('recipients', ':message') }}</span>
                    <input type="checkbox" id="select_all">{{trans('mailbox.select_all')}}
                    @if (Sentinel::getUser()->inRole('teacher'))
                        <input type="checkbox" name="include_all_from_group" value="1">
                        {{trans('mailbox.include_all_from_group')}}
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                {!! Form::label('subject', trans('mailbox.subject'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::text('subject', null, array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('subject', ':message') }}</span>
                </div>
            </div>
            <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                {!! Form::label('message', trans('mailbox.message'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::textarea('message', null, array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('message', ':message') }}</span>
                </div>
            </div>
            <div class="form-group {{ $errors->has('file') ? 'has-error' : '' }}">
                {!! Form::label('file_file', trans('mailbox.file'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::file('file_file', null, array('id'=>'file_file', 'class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('file_file', ':message') }}</span>
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <button type="submit" class="btn btn-success btn-sm">{{trans('mailbox.send_mail')}}</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <script>
        $("#select_all").click(function () {
            if ($("#select_all").is(':checked')) {
                $("#recipients > option").prop("selected", "selected");
                $("#recipients").trigger("change");
            } else {
                $("#recipients > option").removeAttr("selected");
                $("#recipients").trigger("change");
            }
        });
    </script>
@stop