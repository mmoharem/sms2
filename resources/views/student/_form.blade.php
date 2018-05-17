<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($student))
            {!! Form::model($student, array('url' => url($type) . '/' . $student->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('student.title'), array('class' => 'control-label')) !!}
            <div class="controls radiobutton">
                {!! Form::label('title', trans('student.ms'), array('class' => 'control-label')) !!}
                {!! Form::radio('title', 'ms',((isset($student->user->title) && $student->user->title=='ms')?true:null))
                 !!}
                {!! Form::label('title', trans('student.mr'), array('class' => 'control-label')) !!}
                {!! Form::radio('title', 'mr',((isset($student->user->title) && $student->user->title=='mr')?true:null))
                 !!}
                {!! Form::label('title', trans('student.mrs'), array('class' => 'control-label')) !!}
                {!! Form::radio('title', 'mrs',((isset($student->user->title) && $student->user->title=='mrs')?true:null))
                 !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', trans('student.email'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('email', (isset($student->user->email)?$student->user->email:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
            {!! Form::label('first_name', trans('student.first_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('first_name', (isset($student->user->first_name)?$student->user->first_name:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('middle_name') ? 'has-error' : '' }}">
            {!! Form::label('middle_name', trans('student.middle_name'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('middle_name', (isset($student->user->middle_name)?$student->user->middle_name:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('middle_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
            {!! Form::label('last_name', trans('student.last_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('last_name', (isset($student->user->last_name)?$student->user->last_name:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('personal_no') ? 'has-error' : '' }}">
            {!! Form::label('personal_no', trans('student.personal_no'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('personal_no', (isset($student->user->personal_no)?$student->user->personal_no:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('personal_no', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
            {!! Form::label('address', trans('student.address'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('address', (isset($student->user->address)?$student->user->address:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('address', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
            {!! Form::label('mobile', trans('student.mobile'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('mobile', (isset($student->user->mobile)?$student->user->mobile:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
            {!! Form::label('phone', trans('student.phone'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('phone', (isset($student->user->phone)?$student->user->phone:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
            {!! Form::label('gender', trans('student.gender'), array('class' => 'control-label required')) !!}
            <div class="controls radiobutton">
                {!! Form::label('gender', trans('student.female'), array('class' => 'control-label')) !!}
                {!! Form::radio('gender', '0',(isset($student->user->gender) && $student->user->gender==0)?true:false) !!}
                {!! Form::label('gender', trans('student.male'), array('class' => 'control-label')) !!}
                {!! Form::radio('gender', '1',(isset($student->user->gender) && $student->user->gender==1)?true:false) !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('birth_date') ? 'has-error' : '' }}">
            {!! Form::label('birth_date', trans('student.birth_date'), array('class' => 'control-label')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('birth_date', (isset($student->user->birth_date)?$student->user->birth_date:null), array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('birth_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('birth_city') ? 'has-error' : '' }}">
            {!! Form::label('birth_city', trans('student.birth_city'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('birth_city', (isset($student->user->birth_city)?$student->user->birth_city:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('birth_city', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
            {!! Form::label('country_id', trans('student.country'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('country_id', $countries, null, array('id'=>'country_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('country_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('session_id') ? 'has-error' : '' }}">
            {!! Form::label('session_id', trans('student.session'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('session_id', $sessions, null, array('id'=>'session_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('session_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('section_id') ? 'has-error' : '' }}">
            {!! Form::label('section_id', trans('student.section_id'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('section_id',  $sections,  null, array('id'=>'section_id', 'class' => 'form-control select2', 'placeholder'=>trans('student.select_section'))) !!}
                <span class="help-block">{{ $errors->first('section_id', ':message') }}</span>
            </div>
        </div>
            @if (!isset($student))
        <div class="form-group {{ $errors->has('student_group_id') ? 'has-error' : '' }}">
            {!! Form::label('student_group_id', trans('student.student_group'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('student_group_id', [], null, array('id'=>'student_group_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('student_group_id', ':message') }}</span>
            </div>
        </div>
            @endif
        <div class="form-group {{ $errors->has('level_of_adm') ? 'has-error' : '' }}">
            {!! Form::label('level_of_adm', trans('student.levelOfAdmission'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('level_of_adm', $levels, null, array('id'=>'level_of_adm', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('level_of_adm', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('level_id') ? 'has-error' : '' }}">
            {!! Form::label('level_id', trans('student.level'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('level_id', $levels, null, array('id'=>'level_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('level_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('intake_period_id') ? 'has-error' : '' }}">
            {!! Form::label('intake_period_id', trans('student.intakePeriod'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('intake_period_id', $intakeperiods, null, array('id'=>'intake_period_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('intake_period_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('entry_mode_id') ? 'has-error' : '' }}">
            {!! Form::label('entry_mode_id', trans('student.entrymode'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('entry_mode_id', $entrymodes, (isset($student->user->entry_mode_id)?$student->user->entry_mode_id:null), array('id'=>'entry_mode_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('entry_mode_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('marital_status_id') ? 'has-error' : '' }}">
            {!! Form::label('marital_status_id', trans('student.maritalStatus'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('marital_status_id', $maritalStatus, (isset($student->user->marital_status_id)?$student->user->marital_status_id:null), array('id'=>'marital_status_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('marital_status_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('no_of_children') ? 'has-error' : '' }}">
            {!! Form::label('no_of_children', trans('student.noOfChildren'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('no_of_children', (isset($student->user->no_of_children)?$student->user->no_of_children:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('no_of_children', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('religion_id') ? 'has-error' : '' }}">
            {!! Form::label('religion_id', trans('student.religion'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('religion_id', $religion, (isset($student->user->religion_id)?$student->user->religion_id:null), array('id'=>'religion_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('religion_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('denomination_id') ? 'has-error' : '' }}">
            {!! Form::label('denomination_id', trans('student.denomination'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('denomination_id', $denominations, (isset($student->user->denomination_id)?$student->user->denomination_id:null), array('id'=>'denomination_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('denomination_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('dormitory_id') ? 'has-error' : '' }}">
            {!! Form::label('dormitory_id', trans('student.dormitory'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('dormitory_id', $dormitories, (isset($student->dormitory_id)?$student->dormitory_id:null), array('id'=>'dormitory_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('dormitory_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('order') ? 'has-error' : '' }}">
            {!! Form::label('order', trans('student.order'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('order', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('order', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('disability') ? 'has-error' : '' }}">
            {!! Form::label('disability', trans('student.disability'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('disability', (isset($student->user->disability)?$student->user->disability:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('disability', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('contact_relation') ? 'has-error' : '' }}">
            {!! Form::label('contact_relation', trans('student.contactRelation'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('contact_relation', (isset($student->user->contact_relation)?$student->user->contact_relation:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('contact_relation', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('contact_name') ? 'has-error' : '' }}">
            {!! Form::label('contact_name', trans('student.contactName'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('contact_name',  (isset($student->user->contact_name)?$student->user->contact_name:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('contact_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('contact_address') ? 'has-error' : '' }}">
            {!! Form::label('contact_address', trans('student.contactAddress'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('contact_address',  (isset($student->user->contact_address)?$student->user->contact_address:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('contact_address', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('contact_phone') ? 'has-error' : '' }}">
            {!! Form::label('contact_phone', trans('student.contactPhone'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('contact_phone',  (isset($student->user->contact_phone)?$student->user->contact_phone:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('contact_phone', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('contact_email') ? 'has-error' : '' }}">
            {!! Form::label('contact_email', trans('student.contact_email'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::email('contact_email',  (isset($student->user->contact_email)?$student->user->contact_email:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('contact_email', ':message') }}</span>
            </div>
        </div>
        @if (!isset($student))
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {!! Form::label('password', trans('student.password'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::password('password', array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                </div>
            </div>
        @endif
        <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
            {!! Form::label('image', trans('accountant.picture'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="controls row">
                    <img src="{{ url(isset($student->user->picture)?$student->user->picture:"") }}"
                         class="img-l col-sm-2">
                    {!! Form::file('image_file', null, array('id'=>'image_file', 'class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('image_file', ':message') }}</span>
                </div>
            </div>
        </div>
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
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success btn-sm">{{trans('table.ok')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@section('scripts')
    <script>
        $('#session_id').change(function () {
            $('#section_id').empty();
            $.ajax({
                type: "GET",
                url: '{{url('/student')}}/' + $(this).val() + '/sections',
                success: function (response) {
                    $('#section_id').append($('<option></option>').val(null).html('{{trans('student.select_section')}}'));
                    $.each(response.sections, function (val, text) {
                        $('#section_id').append($('<option></option>').val(text.id).html(text.title));
                    });
                }
            });
        });
        $('#section_id').change(function () {
            $('#level_id').empty();
            $('#student_group_id').empty();
            $.ajax({
                type: "GET",
                url: '{{url('/student')}}/' + $(this).val() + '/levels',
                success: function (response) {
                    $('#level_id').append($('<option></option>').val(null).html('{{trans('student.select_level')}}'));
                    $('#student_group_id').append($('<option></option>').val(null).html('{{trans('student.select_group')}}'));
                    $.each(response.levels, function (val, text) {
                        $('#level_id').append($('<option></option>').val(text.id).html(text.name));
                    });
                    $.each(response.student_groups, function (val, text) {
                        $('#student_group_id').append($('<option></option>').val(text.id).html(text.title));
                    });
                }
            });
        });
    </script>
@endsection