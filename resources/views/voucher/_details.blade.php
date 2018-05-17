<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('voucher.code')}}</label>
            <div class="controls">
                @if (isset($voucher))
                    {{ $voucher->code }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('voucher.debit_account')}}</label>
            <div class="controls">
                @if (isset($voucher->debit))
                    {{ $voucher->debit->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('voucher.credit_account')}}</label>
            <div class="controls">
                @if (isset($voucher->credit))
                    {{ $voucher->credit->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('voucher.amount')}}</label>
            <div class="controls">
                @if (isset($voucher))
                    {{ $voucher->amount }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('voucher.description')}}</label>
            <div class="controls">
                @if (isset($voucher))
                    {!! $voucher->description !!}
                @endif
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