@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-sm-3">
            <b>{{trans('report.subject')}}</b>
        </div>
        <div class="col-sm-3">
            <b>{{trans('subject.credit_hours')}}</b>
        </div>
        <div class="col-sm-3">
            <b>{{trans('subject.description')}}</b>
        </div>
        <div class="col-sm-3">
            <b>{{trans('teacher_duty.teacher')}}</b>
        </div>
    </div>
    @foreach($subject_list as $item)
        <div class="row">
            <div class="col-sm-3">
                <span>{{((strlen($item['subject_short_name'])>2)?
                $item['title'].' ('.$item['subject_short_name'].')':
                $item['title'])}}</span>
            </div>
            <div class="col-sm-3">
                <span>{{$item['credit_hours']}}</span>
            </div>
            <div class="col-sm-3">
                <span>{!! $item['description'] !!}</span>
            </div>
            <div class="col-sm-3">
                <span>{{((strlen($item['teacher_short_name'])>2)?
                $item['name'].' ('.$item['teacher_short_name'].')':
                $item['name'])}}</span>
            </div>
        </div>
    @endforeach
@stop


