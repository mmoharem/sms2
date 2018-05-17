@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
@section('content')
    <div class="panel panel-danger">
        <div class="panel-heading">
            <div class="panel-title"> {{$title}}</div>
        </div>
        <div class="panel-body">
            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                {!! Form::label('user_id', trans('all_mails.select_user'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('user_id', $users, null, array('id'=>'user_id', 'class' => 'form-control select2', 'placeholder'=>trans('all_mails.select_user'))) !!}
                    <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> {{trans('all_mails.received')}}</div>
        </div>
        <div class="panel-body messages received">

        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> {{trans('all_mails.sent')}}</div>
        </div>
        <div class="panel-body messages sent">

        </div>
    </div>
@stop

@section('scripts')
    <script>
        $('#user_id').change(function () {
            var user_id = $(this).val();
            $('.messages').html('');
            if (user_id > 0) {
                $.ajax({
                    type: "POST",
                    url: '{{ url('/all_mails/mails') }}',
                    data: {_token: '{{ csrf_token() }}', user_id: user_id},
                    success: function (result) {
                        $.each(result.get_mails, function (val, text) {
                            var mail = '<div class="mail">' + text.sender.full_name +
                                '<img src="' + text.sender.picture + '" class="img-responsive img-circle pull-left" width="45px" height="45px">'+
                                '<br>' + text.subject + '<span class="pull-right">' + text.created_at + '</span> ' +
                                '<br><div class="mail-text">' + text.message + '</div></div><hr>';
                            $('.received').append(mail);
                        });
                        $.each(result.sent_mails, function (val, text) {
                            var mail = '<div class="mail">' + text.receiver.full_name +
                                '<img src="' + text.receiver.picture + '" class="img-responsive img-circle pull-left" width="45px" height="45px">'+
                                '<br>' + text.subject + '<span class="pull-right">' + text.created_at + '</span> ' +
                                '<br><div class="mail-text">' + text.message + '</div></div><hr>';
                            $('.sent').append(mail);
                        });
                    }
                });
            }
        });
    </script>
@endsection
