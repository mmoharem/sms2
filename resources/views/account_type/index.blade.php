@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
{{-- Content --}}
@section('content')
    <div class=" clearfix">
        @if(!Sentinel::getUser()->inRole('admin') ||
            (Sentinel::getUser()->inRole('admin') && Settings::get('multi_school') == 'no') ||
            (Sentinel::getUser()->inRole('admin') && in_array('account_type.create', Sentinel::getUser()->permissions)))
            <div class="pull-right">
                <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            </div>
        @endif
    </div>
    <table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>{{ trans('account.title') }}</th>
            <th>{{ trans('table.actions') }}</th>
        </tr>
        </thead>
    </table>
@stop
{{-- Scripts --}}
@section('scripts')

@stop