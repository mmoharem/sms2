@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    @if($user->authorized('school_exam.create'))
    <div class=" clearfix">
        <a href="{{ url($type.'/create_by_group') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus-circle"></i> {{ trans('admin_exam.new_by_group') }}</a>
        <a href="{{ url($type.'/create_by_subject') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus-circle"></i> {{ trans('admin_exam.new_by_subject') }}</a>
    </div>
    @endif
    <table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>{{ trans('admin_exam.title') }}</th>
            <th>{{ trans('admin_exam.date') }}</th>
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