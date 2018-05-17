@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/d3.v3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/c3.min.js')}}"></script>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            @include('charts.department_registration')
        </div>
        <div class="col-lg-6 col-sm-12">
            @include('registration.registration_detail')
        </div>
    </div>
    <div class=" clearfix">
        @if(!Sentinel::getUser()->inRole('admin') ||
        (Sentinel::getUser()->inRole('admin') && Settings::get('multi_school') == 'no') ||
        (Sentinel::getUser()->inRole('admin') && $user->authorized($type.'.create')))
            <div class="pull-right">
                <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            </div>
        @endif
    </div>
    <table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>{{ trans('registration.id') }}</th>
            <th>{{ trans('registration.full_name') }}</th>
            <th>{{ trans('registration.semester') }}</th>
            <th>{{ trans('registration.school_year') }}</th>
            <th>{{ trans('registration.subject') }}</th>
            <th>{{ trans('registration.date') }}</th>
            <th>{{ trans('table.actions') }}</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>{{ trans('registration.id') }}</th>
            <th>{{ trans('registration.full_name') }}</th>
            <th>{{ trans('registration.semester') }}</th>
            <th>{{ trans('registration.school_year') }}</th>
            <th>{{ trans('registration.subject') }}</th>
            <th>{{ trans('registration.date') }}</th>
        </tr>
        </tfoot>
        <tbody>
        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop