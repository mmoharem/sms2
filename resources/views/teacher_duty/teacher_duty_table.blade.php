@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
   <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th class="col-sm-3">{{ trans('teacher_duty.teacher') }}</th>
            <th class="col-sm-3">{{ trans('teacher_duty.start_date') }}</th>
            <th class="col-sm-3">{{ trans('teacher_duty.end_date') }}</th>
            <th class="col-sm-3">{{ trans('teacher_duty.day_night') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($teacher_duty_table as $item)
            <tr>
                <th>{{ (!is_null($item->user))?$item->user->full_name_email:"" }}</th>
                <th>{{ $item->start_date }}</th>
                <th>{{ $item->end_date }}</th>
                <th>{{ ($item->day_night==0)?trans('teacher_duty.over_day'):trans('teacher_duty.over_night')}}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop