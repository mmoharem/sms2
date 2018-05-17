<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('invoice.title')}}</label>
            <div class="controls">
                @if (isset($invoice)) {{ $invoice->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('invoice.description')}}</label>
            <div class="controls">
                @if (isset($invoice)) {{ $invoice->description }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('invoice.student')}}</label>
            <div class="controls">
                @if (isset($invoice->user)) {{ $invoice->user->first_name }} {{ $invoice->user->last_name }} @endif
            </div>
        </div>
        <div class="form-group">
            @if (isset($invoice) && !is_null($invoice->items))
                <label class="control-label" for="title">{{trans('invoice.items')}}</label>
                <div class="form-group">
                    <table class="table table-bordered">
                        <tr>
                            <td>{{trans('invoice.description')}}</td>
                            <td>{{trans('invoice.quantity')}}</td>
                            <td>{{trans('invoice.subtotal')}}</td>
                        </tr>
                        @foreach($invoice->items as $key=>$item)
                            @if (isset($item->option))
                                <tr>
                                    <td>{{ $item->item_name_price}}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->item_sub_price }}</td>
                                </tr>
                            @elseif (!is_null($item->option_title))
                                <tr>
                                    <td>{{ $item->option_title.' '.$item->option_amount}}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->option_amount }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('invoice.amount')}}</label>
            <div class="controls">
                @if (isset($invoice)) {{ $invoice->amount }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('invoice.payed')}}</label>
            <div class="controls">
                @if (isset($invoice))  {{ $invoice->paid_amount }} @endif
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