@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
	{{trans('studentgroup.subjects_info')}}
	{!! Form::label('student_group', $studentGroup->title, array('class' => 'control-label')) !!}
		@if(isset($subjects[0]))
			<table class="table table-condensed">
				<tbody>
				<tr>
					<th width="5%">#</th>
					<th width="25%">{{trans('studentgroup.subjects')}}</th>
					<th width="70%">{{trans('studentgroup.teachers')}}</th>
				</tr>
				@foreach($subjects[0] as $key=>$subject)
					<tr>
						<td>{{$key+1}}.</td>
						<td>{{$subject->title}}</td>
						<td>
                            {!! Form::model($subject, array('url' => url($type) . '/' . $subject->id. '/' . $studentGroup->id.'/addeditsubject', 'method' => 'put', 'id' => 'bf-'.$subject->id, 'files'=> true)) !!}
                            {!! Form::select('teachers_select[]', $teachers, $teacher_subject[0][$subject->id], array
                            ('id'=>'teachers_select'.$subject->id, 'multiple'=>true, 'class' => 'form-control select2')) !!}
                            {!! Form::hidden('semester_id', 0) !!}
                            {!! Form::close() !!}
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@else
			@foreach($subjects as $id=>$subject_collection)
				@if(isset($semesters[$id]))
					<br> {{$semesters[$id]->title}}
				@endif
			<table class="table table-condensed">
				<tbody>
				<tr>
					<th width="5%">#</th>
					<th width="25%">{{trans('studentgroup.subjects')}}</th>
					<th width="70%">{{trans('studentgroup.teachers')}}</th>
				</tr>
				@foreach($subject_collection as $key=>$subject)
					<tr>
						<td>{{$key+1}}.</td>
						<td>{{$subject->title}}</td>
						<td>
							{!! Form::model($subject, array('url' => url($type) . '/' . $subject->id. '/' . $studentGroup->id.'/addeditsubject', 'method' => 'put', 'id' => 'bf-'.$subject->id, 'files'=> true)) !!}
							{!! Form::select('teachers_select[]', $teachers, $teacher_subject[$id][$subject->id], array
							('id'=>'teachers_select'.$subject->id, 'multiple'=>true, 'class' => 'form-control select2')) !!}
                            @if(isset($semesters[$id]))
                                {!! Form::hidden('semester_id', $semesters[$id]->id) !!}
                            @else
                                {!! Form::hidden('semester_id', 0) !!}
                            @endif
							{!! Form::close() !!}
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			@endforeach
		@endif
	<div class="form-group">
		<div class="controls">
			<a href="{{ url('/section/'.$section->id.'/groups') }}" class="btn btn-warning btn-sm">{{trans('table.back')}}</a>
		</div>
	</div>
{!! Form::close() !!}
@stop

@section('scripts')
    <script>
        $("[id^='teachers_select']").on("select2:select select2:unselect", function(e) {
            var $form_id = $(this).parent();
            $.ajax({
                type: "POST",
                url: $form_id.attr('action'),
                data: $form_id.serialize(),
                success: function (response) {
                }
            });
        });
    </script>
@endsection

