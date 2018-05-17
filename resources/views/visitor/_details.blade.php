<div class="panel panel-danger" xmlns="http://www.w3.org/1999/html">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('visitor.first_name')}}</label>
            <div class="controls">
                @if (isset($visitor)) {{ $visitor->first_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('visitor.last_name')}}</label>
            <div class="controls">
                @if (isset($visitor)) {{ $visitor->last_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('visitor.email')}}</label>
            <div class="controls">
                @if (isset($visitor)) {{ $visitor->email }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('visitor.gender')}}</label>
            <div class="controls">
                @if (isset($visitor)) {{ ($visitor->gender==1)?trans('visitor.male'):trans('visitor.female') }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('visitor.school')}}</label>
            <div class="controls">
                @if (isset($school)) {{ $school->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (!empty($visitor->visitor))
                    <table class="table table-hover">
                        <thead>
                            <td>{{trans('visitor.visitor_no')}}</td>
                            <td>{{trans('visitor.stay_from')}}</td>
                            <td>{{trans('visitor.stay_to')}}</td>
                        </thead>
                        <tbody>
                        @foreach($visitor->visitor as $item)
                            <tr>
                                <td>{{ $item->visitor_no }}</td>
                                <td>{{ $item->stay_from }}</td>
                                <td>{{ $item->stay_to }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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