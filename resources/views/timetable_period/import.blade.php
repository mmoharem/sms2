@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {!! Form::open(array('url' => url($type.'/import'), 'method' => 'post', 'class' => 'form-horizontal', 'files'=> true)) !!}
        <div class="fileinput fileinput-new" data-provides="fileinput">
        <span class="btn btn-default btn-sm btn-file">
            <span class="fileinput-new">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i> {{trans('subject.select_file')}}
            </span>
        <span class="fileinput-exists">{{trans('subject.change')}}</span>
            <input type="file" name="file">
            <span class="fileinput-filename"></span>
            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
        </div>
        <br>
        <button class="btn btn-sm btn-primary" type="submit">
            <i class="fa fa-upload"></i>
            {{trans('subject.upload_review')}}</button>
        <a class="btn btn-sm btn-primary" href="{{url($type.'/download-template')}}">
            <i class="fa fa-download" aria-hidden="true"></i>
            {{trans('subject.download_template')}}</a>
    {{Form::close()}}

@stop

{{-- Scripts --}}
@section('scripts')

@stop