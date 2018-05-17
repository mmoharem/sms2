@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    @if(Sentinel::inRole('teacher'))
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
            <th>{{ trans('return_book_penalty.user') }}</th>
            <th>{{ trans('return_book_penalty.book') }}</th>
            <th>{{ trans('return_book_penalty.book_get') }}</th>
            <th>{{ trans('return_book_penalty.late_days') }}</th>
            <th>{{ trans('return_book_penalty.amount') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop