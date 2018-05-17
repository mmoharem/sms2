@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class=" clearfix">
        <div class="pull-right">
            <a href="{{ url('teacher_duty_table') }}" class="btn btn-sm btn-success">
                <i class="fa fa-table"></i> {{ trans('teacher_duty.teacher_duty_table') }}</a>
            <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
        </div>
    </div>
    <table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>{{ trans('teacher_duty.teacher') }}</th>
            <th>{{ trans('teacher_duty.day_night') }}</th>
            <th>{{ trans('teacher_duty.start_date') }}</th>
            <th>{{ trans('teacher_duty.end_date') }}</th>
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