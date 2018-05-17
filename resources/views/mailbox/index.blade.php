@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    @include('mailbox.mailbox')
        <div class="col-lg-9">
            @foreach($email_list as $item)
                <div class="mail">
                    <img src="{{isset($item->sender)?$item->sender->picture:""}}" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    {{isset($item->sender)?$item->sender->full_name:""}}<br>
                    {{str_limit($item->subject,50)}}
                    <button class="btn btn-info btn-sm btn-sm">
                        @if($item->read)
                            <i class="fa fa-envelope-open"></i>
                        @else
                            <i class="fa fa-envelope"></i>
                        @endif
                    </button>
                    <a href="{{url('mailbox/'.$item->id.'/replay')}}" class="btn btn-success btn-sm btn-sm">
                        <i class="fa fa-reply-all"></i> </a>
                    <a href="{{url('mailbox/'.$item->id.'/delete')}}" class="btn btn-danger btn-sm btn-sm">
                        <i class="fa fa-remove"></i> </a>
                    <span class="pull-right">
                        {{$item->created_at->format(Settings::get('date_format').' '.Settings::get('time_format'))}}
                    </span> <br>
                    <div class="mail-text">
                        {!! str_limit($item->message,200) !!}
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