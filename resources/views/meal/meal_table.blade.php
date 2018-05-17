@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <h4>{{trans('meal.yesterday')}}</h4>
   <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th class="col-sm-6">{{ trans('meal.meal_type') }}</th>
            <th class="col-sm-6">{{ trans('table.title') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($meals_yesterday as $item)
            <tr>
                <th>{{ is_null($item->meal_type)?"":$item->meal_type->title }}</th>
                <th>{{ $item->title }}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h4>{{trans('meal.today')}}</h4>
   <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th class="col-sm-6">{{ trans('meal.meal_type') }}</th>
            <th class="col-sm-6">{{ trans('table.title') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($meals_today as $item)
            <tr>
                <th>{{ is_null($item->meal_type)?"":$item->meal_type->title }}</th>
                <th>{{ $item->title }}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h4>{{trans('meal.tomorrow')}}</h4>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th class="col-sm-6">{{ trans('meal.meal_type') }}</th>
            <th class="col-sm-6">{{ trans('table.title') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($meals_tomorrow as $item)
            <tr>
                <th>{{ is_null($item->meal_type)?"":$item->meal_type->title }}</th>
                <th>{{ $item->title }}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop