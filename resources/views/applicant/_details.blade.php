<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('applicant.first_name')}}</label>
                    <div class="controls">
                        @if (isset($applicant)) {{ $applicant->user->first_name }} @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('applicant.last_name')}}</label>
                    <div class="controls">
                        @if (isset($applicant)) {{ $applicant->user->last_name }} @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('applicant.email')}}</label>
                    <div class="controls">
                        @if (isset($applicant)) {{ $applicant->user->email }} @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('applicant.gender')}}</label>
                    <div class="controls">
                        @if (isset($applicant)) {{ ($applicant->user->gender=='1')?trans('applicant.male'):trans('applicant.female') }} @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('applicant.order')}}</label>
                    <div class="controls">
                        @if (isset($applicant)) {{ $applicant->order }} @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('applicant.section')}}</label>
                    <div class="controls">
                        @if (isset($applicant->section)) {{ $applicant->section->title }} @endif
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('user_avatar_file', trans('profile.avatar'), array('class' => 'control-label')) !!}
                    <div class="controls row">
                        <div class="col-sm-6">
                            <img src="{{ url($applicant->user->picture) }}" alt="User Image" class="img-thumbnail">
                        </div>
                    </div>
                </div>
                @if (isset($applicant->dormitory->title))
                    <div class="form-group">
                        <label class="control-label" for="title">{{trans('applicant.dormitory')}}</label>
                        <div class="controls">
                            {{ isset($applicant->dormitory->title)?$applicant->dormitory->title:"" }}
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-sm-12 col-lg-6">
                @if (isset($document_types))
                    @foreach($document_types as $document_type)
                        <div class="form-group {{ $errors->has('document') ? 'has-error' : '' }}">
                            {!! Form::label('document', $document_type['title'], array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::hidden('document_id', $document_type['value']) !!}
                                {!! Form::file('document', null, array('class' => 'form-control')) !!}
                                @if (isset($documents))
                                    <a href="{{url('uploads/documents/'.$documents->document)}}">{{$documents->document}}</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>{{trans('applicant_work.company')}}</th>
                        <th>{{trans('applicant_work.position')}}</th>
                        <th>{{trans('applicant_work.start_date')}}</th>
                        <th>{{trans('applicant_work.end_date')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applicantWorks as $item)
                        <tr>
                            <th>{{$item->company}}</th>
                            <th>{{$item->position}}</th>
                            <th>{{$item->start_date}}</th>
                            <th>{{ (($item->end_date=='0000-00-00')?"-":$item->end_date) }}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
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