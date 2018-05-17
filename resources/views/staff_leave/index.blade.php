@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    @if(Sentinel::inRole('teacher') || Sentinel::inRole('librarian')
    || Sentinel::inRole('accountant') || Sentinel::inRole('kitchen_admin') || Sentinel::inRole('kitchen_staff')
    || Sentinel::inRole('doorman'))
    <div class=" clearfix">
        <div class="pull-right">
            <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
        </div>
    </div>
    @endif
    <table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>{{ trans('staff_leave.date') }}</th>
            <th>{{ trans('staff_leave.description') }}</th>
            <th>{{ trans('staff_leave.staff_leave_type') }}</th>
            <th>{{ trans('staff_leave.status') }}</th>
            <th>{{ trans('staff_leave.staff_name') }}</th>
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