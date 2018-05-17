@extends('layouts.auth')
@section('content')
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <h3>{{trans('auth.sign_account')}}</h3>
                <br>
                {!! Form::open(array('url' => url('signin'), 'method' => 'post', 'name' => 'form')) !!}
                <div class="form-group required {{ $errors->has('mobile_email') ? 'has-error' : '' }}">
                    {!! Form::label('mobile_email',trans('auth.mobile_email'), array('class' => 'control-label required')) !!} :
                    <span class="help-block">{{ $errors->first('mobile_email', ':message') }}</span>
                    {!! Form::text('mobile_email', null, array('class' => 'form-control', 'required'=>'required')) !!}
                    {!! Form::label('mobile_email',trans('auth.mobile_prefix'), array('class' => 'control-label')) !!}
                </div>
                <div class="form-group required {{ $errors->has('password') ? 'has-error' : '' }}">
                    {!! Form::label('password',trans('auth.password'), array('class' => 'control-label required')) !!} :
                    <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                    {!! Form::password('password', array('class' => 'form-control', 'required'=>'required')) !!}
                </div>
                <button type="submit" class="btn btn-primary btn-sm btn-block">{{trans('auth.login')}}</button>
                {!! Form::close() !!}
                <div class="text-center">
                    <h5><a href="{{url('passwordreset')}}" class="text-primary">{{trans('auth.forgot')}}?</a></h5>
                    @if(Settings::get('self_registration')=='yes')
                        <h5><a href="{{url('signup')}}" class="text-primary">{{trans('auth.create_account')}}</a>
                        </h5>
                    @endif
                    @if(Settings::get('can_apply_to_school')=='yes')
                        <h5><a href="{{url('apply')}}" class="text-primary">{{trans('auth.apply_to_school')}}</a>
                        </h5>
                    @endif
                </div>
            </section>
        </div>
    </div>
@stop