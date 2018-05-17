<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($feeCategory))
            {!! Form::model($feeCategory, array('url' => url($type) . '/' . $feeCategory->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('fee_category.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('section_id') ? 'has-error' : '' }}">
            {!! Form::label('section_id', trans('student.section_id'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('section_id', $sections, null, array('id'=>'section_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('section_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('currency_id') ? 'has-error' : '' }}">
            {!! Form::label('currency_id', trans('fee_category.currency'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('currency_id', $currencies, null, array('id'=>'currency_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('currency_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
            {!! Form::label('amount', trans('fee_category.amount'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('amount', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('fees_period_id') ? 'has-error' : '' }}">
            {!! Form::label('fees_period_id', trans('fee_category.fees_period'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('fees_period_id', $feesPeriods, null, array('id'=>'fees_period_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('fees_period_id', ':message') }}</span>
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
