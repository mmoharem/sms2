<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($expense))
            {!! Form::model($expense, array('url' => url($type) . '/' . $expense->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group  {{ $errors->has('expense_category_id') ? 'has-error' : '' }}">
            {!! Form::label('expense_category_id', trans('expense.expense_category'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('expense_category_id', $expense_categories, null, array('class' => 'form-control
                select2')) !!}
                <span class="help-block">{{ $errors->first('expense_category_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('expense.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('value') ? 'has-error' : '' }}">
            {!! Form::label('value', trans('expense.value'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('value', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('value', ':message') }}</span>
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
