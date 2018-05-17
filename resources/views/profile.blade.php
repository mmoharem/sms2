@extends('layouts.secure')
@section('content')
<div class="col-sm-4 col-md-2">
    <a class="thumbnail">
        <img src="{{ url($user->picture) }}" class="img-rounded" alt="User Image">
    </a>
</div>
<div class="col-sm-7 col-md-9 col-sm-offset-1">
    <div class="table-responsive">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td><b>{{trans('profile.first_name')}}</b></td>
                <td>{{$user->first_name}}</td>
            </tr>
            <tr>
                <td><b>{{trans('profile.last_name')}}</b></td>
                <td> {{$user->last_name}}</td>
            </tr>
            <tr>
                <td><b>{{trans('profile.gender')}}</b></td>
                <td>@if($user->gender==1) {{trans('profile.male')}} @else {{trans('profile.female')}} @endif</td>
            </tr>
            <tr>
                <td><b>{{trans('profile.email')}}</b></td>
                <td>{{$user->email}}</td>
            </tr>
            <tr>
                <td><b>{{trans('profile.mobile')}}</b></td>
                <td>{{$user->mobile}}</td>
            </tr>
            <tr>
                <td><b>{{trans('profile.phone')}}</b></td>
                <td>{{$user->phone}}</td>
            </tr>
            <tr>
                <td><b>{{trans('profile.address')}}</b></td>
                <td>{{$user->address}}</td>
            </tr>
            <tr>
                <td><b>{{trans('profile.birth_date')}}</b></td>
                <td>{{$user->birth_date}}</td>
            </tr>
            <tr>
                <td><b>{{trans('profile.birth_city')}}</b></td>
                <td>{{$user->birth_city}}</td>
            </tr>
        </tbody>
    </table>
        <a href="{{url('/change_account')}}" class="btn btn-success btn-sm">
            <i class="fa fa-pencil-square-o"></i> {{trans('profile.change_profile')}}</a>
    </div>
</div>

@stop