<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('payment.title')}}</label>

            <div class="controls">
                @if (isset($payment)) {{ $payment->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="description">{{trans('payment.description')}}</label>

            <div class="controls">
                @if (isset($payment)) {{ $payment->description }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="student">{{trans('payment.student')}}</label>

            <div class="controls">
                @if (isset($payment->user)) {{ $payment->user->first_name. ' '.$payment->user->last_name }} @endif
            </div>
        </div>
        <div class="form-group">
            @if (isset($payment) && !is_null($payment->items))
                <label class="control-label" for="title">{{trans('payment.items')}}</label>
                <div class="form-group">
                    <table class="table table-bordered">
                        <tr>
                            <td>{{trans('payment.description')}}</td>
                            <td>{{trans('payment.quantity')}}</td>
                            <td>{{trans('payment.subtotal')}}</td>
                        </tr>
                        @foreach($payment->items as $key=>$item)
                            @if (isset($item->option))
                                <tr>
                                    <td>{{ $item->item_name_price}}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->item_sub_price }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
        <div class="form-group">
            <label class="control-label" for="amount">{{trans('payment.amount')}}</label>

            <div class="controls">
                @if (isset($payment)) {{ $payment->amount }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="status">{{trans('payment.status')}}</label>

            <div class="controls">
                @if (isset($payment)) {{ $payment->status }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="payment_method">{{trans('payment.payment_method')}}</label>

            <div class="controls">
                @if (isset($payment)) {{ $payment->payment_method }} @endif
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.close')}}</a>
                @else
                    <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.cancel')}}</a>
                    <button type="submit" class="btn btn-danger btn-sm">{{trans('table.delete')}}</button>
                @endif
            </div>
        </div>
    </div>
</div>