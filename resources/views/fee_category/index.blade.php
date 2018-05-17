@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class=" clearfix">
        @if($user->authorized($type.'.create') || $user->inRole('admin_super_admin') || $user->inRole('super_admin'))
            <div class="pull-right">
                <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            </div>
        @endif
    </div>
    <table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>{{ trans('fee_category.title') }}</th>
            <th>{{ trans('fee_category.department') }}</th>
            <th>{{ trans('fee_category.currency') }}</th>
            <th>{{ trans('fee_category.amount') }}</th>
            <th>{{ trans('fee_category.fees_period') }}</th>
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