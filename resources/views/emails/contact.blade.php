<body>
{{trans('mailbox.you_get_new_mail')}}<br>
@if(!empty($request))
    {{trans('mailbox.name', ['name' => $request['name']])}}<br>
    {{trans('mailbox.message_email', ['message' => $request['message']])}}<br>
    {{trans('mailbox.email', ['email' => $request['email']])}}<br>
@else
    {{trans('mailbox.go_to_page_to_read_it')}} <a href="{{url('')}}">{{url('')}}</a>
@endif
</body>