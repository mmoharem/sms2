@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    @include('mailbox.mailbox')
        <div class="col-lg-9">
            <div class="mail">
                    <img src="{{isset($message->sender)?$message->sender->picture:""}}" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    {{isset($message->sender)?$message->sender->full_name:""}}<br>
                    {{$message->subject}}
                    <a href="{{url('mailbox/'.$message->id.'/delete')}}" class="btn btn-danger btn-sm btn-sm">
                        <i class="fa fa-remove"></i> </a>
                    <span class="pull-right">
                        {{$message->created_at->format(Settings::get('date_format').' '.Settings::get('time_format'))}}
                    </span> <br>
                    <div class="mail-text">
                        {!! $message->message !!}
                    </div>
                </div>
            {!! Form::open(array('url' => url('mailbox/'.$message->id.'/replay'), 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
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
@stop