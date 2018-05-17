@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	<div class=" clearfix">
		@if ($user->inRole('super_admin') || $user->inRole('admin_super_admin'))
			<div class="pull-right">
				<a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
					<i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
			</div>
		@endif
	</div>
	<table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>{{ trans('table.title') }}</th>
				<th>{{ trans('schoolyear.id_code') }}</th>
				<th>{{ trans('schoolyear.school') }}</th>
                <th>{{ trans('table.actions') }}</th>
			</tr>
		</thead>
		<tfoot>
		<tr>
			<th>{{ trans('table.title') }}</th>
			<th>{{ trans('schoolyear.id_code') }}</th>
			<th>{{ trans('schoolyear.school') }}</th>
		</tr>
		</tfoot>
		<tbody>
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop