@extends('layouts.secure')
@section('content')
    <div class="panel panel-danger">
        <div class="panel-heading">
            <div class="panel-title"> {{$title}}</div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label class="control-label" for="first_name">{{trans('applicant.first_name')}}</label>
                        <div class="controls">
                            @if (isset($applicant)) {{ $applicant->user->first_name }} @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="last_name">{{trans('applicant.last_name')}}</label>
                        <div class="controls">
                            @if (isset($applicant)) {{ $applicant->user->last_name }} @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="middle_name">{{trans('applicant.middle_name')}}</label>
                        <div class="controls">
                            @if (isset($applicant)) {{ $applicant->user->middle_name }} @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">{{trans('applicant.email')}}</label>
                        <div class="controls">
                            @if (isset($applicant)) {{ $applicant->user->email }} @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="phone">{{trans('applicant.phone')}}</label>
                        <div class="controls">
                            @if (isset($applicant)) {{ $applicant->user->phone }} @endif
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
                    @if(($custom_fields))
                        {!! $custom_fields !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop