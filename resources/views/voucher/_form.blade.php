<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($voucher))
            {!! Form::model($voucher, array('url' => url($type) . '/' . $voucher->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('code') ? 'has-error' : '' }}">
            {!! Form::label('code', trans('voucher.code'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('code', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('code', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('debit_account_id') ? 'has-error' : '' }}">
            {!! Form::label('debit_account_id', trans('voucher.debit_account'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('debit_account_id', $accounts, null, array('id'=>'debit_account_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('debit_account_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('credit_account_id') ? 'has-error' : '' }}">
            {!! Form::label('credit_account_id', trans('voucher.credit_account'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('credit_account_id', $accounts, null, array('id'=>'credit_account_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('credit_account_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('amount') ? 'has-error' : '' }}">
            {!! Form::label('amount', trans('voucher.amount'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('amount', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('amount', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('description') ? 'has-error' : '' }}">
            {!! Form::label('description', trans('voucher.description'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success btn-sm">{{trans('table.ok')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
