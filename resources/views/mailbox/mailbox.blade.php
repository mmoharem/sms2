<style>
    a.link {
        color: #000000 !important;
        padding: 5px !important;
    }
</style>
<div class="row">
    <div class="col-sm-3 col-md-3">
        <a href="{{url('mailbox/compose')}}" role="button" class="btn btn-info btn-sm btn-sm btn-block link">COMPOSE</a>
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="nav nav-pills nav-stacked">
                    <li role="presentation">
                        <a href="{{url('mailbox')}}" class="link">
                            <span class="badge pull-right">{{ $email_list->count() }}</span>
                            <i class="fa fa-inbox fa-fw mrs"></i>
                            {{trans('mailbox.inbox')}}
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="{{url('mailbox/sent')}}" class="link">
                            <span class="badge pull-right">{{ $sent_email_list->count() }}</span>
                            <i class="fa fa-plane fa-fw mrs"></i>
                            {{trans('mailbox.send_mail')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="nav nav-pills nav-stacked">
                    @foreach($users_list as $item)
                        <li>
                            @if($item['active'])
                                <i class="fa fa-circle text-success pull-right"></i>
                            @else
                                <i class="fa fa-circle text-warning pull-right"></i>
                            @endif
                            {{ $item['full_name'] }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>