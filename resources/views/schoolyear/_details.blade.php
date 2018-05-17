<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('schoolyear.title')}}</label>
            <div class="controls">
                @if (isset($schoolYear)) {{ $schoolYear->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="code">{{trans('schoolyear.id_code')}}</label>
            <div class="controls">
                @if (isset($schoolYear)) {{ $schoolYear->code }} @endif
            </div>
        </div>
        @if (!is_null($schoolYear->school))
        <div class="form-group">
            <label class="control-label" for="school">{{trans('schoolyear.school')}}</label>
            <div class="controls">
                {{ $schoolYear->school->title }}
            </div>
        </div>
        @endif
        <div class="form-group">
            <label class="control-label" for="title">{{trans('schoolyear.students_by_school')}}</label>
            <div class="controls">
                @if (isset($students))
                    <table class="table table-bordered">
                        <tr>
                            <th>{{trans('schoolyear.school')}}</th>
                            <th>{{trans('schoolyear.students')}}</th>
                        </tr>
                        @foreach($students as $key=>$item)
                            <tr>
                                <td>{{$key}}</td>
                                <td>{{$item}}</td>
                            </tr>
                        @endforeach
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