@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    @include('mailbox.mailbox')
        <div class="col-lg-9">
            @foreach($sent_email_list as $item)
                <div class="mail">
                    <img src="{{isset($item->receiver)?$item->receiver->picture:""}}" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    {{isset($item->sender)?$item->receiver->full_name:""}}<br>
                    {{$item->subject}}
                    <a href="{{url('mailbox/'.$item->id.'/delete')}}" class="btn btn-danger btn-sm btn-sm">
                        <i class="fa fa-remove"></i> </a>
                    <span class="pull-right">
                        {{$item->created_at->format(Settings::get('date_format').' '.Settings::get('time_format'))}}
                    </span> <br>
                    <div class="mail-text">
                        {!! $item->message !!}
                    </div>
                    @if($item->attachment)
                        <a class="btn btn-xs btn-info" href="{{ url($type.'/'.$item->id.'/download') }}">
                            {{$item->attachment}}</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@stop