@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	<div class=" clearfix">
		@if($user->authorized($type.'.create'))
			<div class="pull-right">
				<a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
					<i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
				<a href="{{ url($type.'/import') }}" class="btn btn-sm btn-success">
					<i class="fa fa-upload"></i> {{trans('teacher.import_teachers')}}
				</a>
                <a href="{{ url($type.'/export') }}" class="btn btn-sm btn-warning">
                    <i class="fa fa-download"></i> {{trans('dashboard.export')}}
                </a>
			</div>
		@endif
	</div>
	<table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>{{ trans('teacher.full_name') }}</th>
				<th>{{ trans('table.actions') }}</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop