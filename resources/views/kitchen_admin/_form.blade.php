<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($kitchen_admin))
            {!! Form::model($kitchen_admin, array('url' => url($type) . '/' . $kitchen_admin->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', trans('kitchen_admin.email'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('email', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
            {!! Form::label('first_name', trans('kitchen_admin.first_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('first_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
            {!! Form::label('last_name', trans('kitchen_admin.last_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('last_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
            </div>
        </div>
            <div class="form-group {{ $errors->has('personal_no') ? 'has-error' : '' }}">
                {!! Form::label('personal_no', trans('kitchen_admin.personal_no'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::text('personal_no', null, array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('personal_no', ':message') }}</span>
                </div>
            </div>
        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
            {!! Form::label('address', trans('kitchen_admin.address'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('address', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('address', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
            {!! Form::label('mobile', trans('kitchen_admin.mobile'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('mobile', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
            {!! Form::label('gender', trans('kitchen_admin.gender'), array('class' => 'control-label required')) !!}
            <div class="controls radiobutton">
                {!! Form::label('gender', trans('kitchen_admin.female'), array('class' => 'control-label')) !!}
                {!! Form::radio('gender', '0',(isset($kitchen_admin->gender) && $kitchen_admin->gender==0)?true:false) !!}
                {!! Form::label('gender', trans('kitchen_admin.male'), array('class' => 'control-label')) !!}
                {!! Form::radio('gender', '1',(isset($kitchen_admin->gender) && $kitchen_admin->gender==1)?true:false) !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('birth_date') ? 'has-error' : '' }}">
            {!! Form::label('birth_date', trans('kitchen_admin.birth_date'), array('class' => 'control-label')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('birth_date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('birth_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('birth_city') ? 'has-error' : '' }}">
            {!! Form::label('birth_city', trans('kitchen_admin.birth_city'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('birth_city', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('birth_city', ':message') }}</span>
            </div>
        </div>
        @if (!isset($kitchen_admin))
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {!! Form::label('password', trans('kitchen_admin.password'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::text('password', "", array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                </div>
            </div>
        @endif
        <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
            {!! Form::label('image', trans('kitchen_admin.picture'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="controls row" v-image-preview>
                    <img src="{{ url(isset($kitchen_admin->picture)?$kitchen_admin->picture:"") }}"
                         class="img-l col-sm-2">
                    {!! Form::file('image_file', null, array('id'=>'image_file', 'class' => 'form-control')) !!}
                    <img id="image-preview" width="300">
                    <span class="help-block">{{ $errors->first('image_file', ':message') }}</span>
                </div>
            </div>
        </div>
        @if(Settings::get('kitchen_admin_one_school')=='yes')
            <div class="form-group  {{ $errors->has('school_id') ? 'has-error' : '' }}">
                {!! Form::label('school_id', trans('kitchen_admin.school_id'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::select('school_id', $all_schools, isset($kitchen_admin_schools)? $kitchen_admin_schools : [], array('class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('school_id', ':message') }}</span>
                </div>
            </div>
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