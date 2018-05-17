@extends('layouts.update')
@section('content')
    <div class="step-content">
        <h3>{{trans('update.welcome')}}</h3>
        <hr>
        @if (! $allLoaded)
            <div class="alert alert-danger">
                {!!trans('install.system_not_meet_requirements')!!}
            </div>
        @endif
        <p>{{trans('update.steps_guide')}}</p>
        <p>{{trans('update.update_process')}} </p>
        <br>
        <div class="step-content">
            <h3>{{trans('install.system_requirements')}}</h3>
            <hr>
            <ul class="list-group list_req">
                @foreach ($requirements as $extension => $loaded)
                    <li class="list-group-item {{ ! $loaded ? 'list-group-item-danger' : '' }}">
                        {{ $extension }}
                        @if ($loaded)
                            <span class="badge badge1"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge2"><i class="fa fa-times"></i></span>
                        @endif
                    </li>
                @endforeach
            </ul>
            @if ($allLoaded)
                {!! Form::open(['url' => 'update/'.$version.'/start-update']) !!}
                <button class="btn btn-success btn-sm pull-right" type="submit">
                    {{trans('update.begin_update')}}
                    <i class="fa fa-arrow-right" style="margin-left: 6px"></i>
                </button>
                {!! Form::close() !!}
            @else
                <a class="btn btn-info btn-sm pull-right" href="{{ url('install/permissions') }}">
                    {{trans('install.refresh')}}
                    <i class="fa fa-refresh"></i></a>
                <button class="btn btn-success btn-sm pull-right" disabled>
                    {{trans('update.begin_update')}}
                    <i class="fa fa-arrow-right"></i>
                </button>
            @endif
        <div class="clearfix"></div>
    </div>
@stop