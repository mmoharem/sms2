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
            <a href="{{ url($type.'/import') }}" class="btn btn-sm btn-success">
                <i class="fa fa-upload"></i> {{trans('markvalue.import_markvalue')}}
            </a>
        </div>
    </div>
    <table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>{{ trans('markvalue.mark_system') }}</th>
            <th>{{ trans('markvalue.max_score') }}</th>
            <th>{{ trans('markvalue.min_score') }}</th>
            <th>{{ trans('markvalue.grade') }}</th>
            <th>{{ trans('table.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop