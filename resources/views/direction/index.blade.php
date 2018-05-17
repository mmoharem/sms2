@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class=" clearfix">
        <div class="pull-right">
            <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
        </div>
    </div>
    <table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>{{trans('table.title') }}</th>
            <th>{{trans('direction.department') }}</th>
            <th>{{trans('direction.code') }}</th>
            <th>{{trans('direction.duration') }}</th>
            <th>{{trans('table.actions') }}</th>
        </tr>
        </thead>

        <tfoot>
        <tr>
            <th>{{trans('table.title') }}</th>
            <th>{{trans('direction.department') }}</th>
            <th>{{trans('direction.code') }}</th>
            <th>{{trans('direction.duration') }}</th>
            <th></th>
        </tr>
        </tfoot>

        <tbody>
        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop