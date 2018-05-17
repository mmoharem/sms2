<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('expense.title')}}</label>
            <div class="controls">
                @if (isset($expense)) {{ $expense->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('expense.expense_category')}}</label>
            <div class="controls">
                @if (!is_null($expense->expense_category)) {{ $expense->expense_category->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('expense.value')}}</label>
            <div class="controls">
                @if (isset($expense)) {{ $expense->value }} @endif
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