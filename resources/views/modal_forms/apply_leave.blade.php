<div class="modal fade" id="newLeaveDay" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{trans('dashboard.apply_leave')}}</h4>
            </div>
            {!! Form::open(array('url' => url('staff_leave'), 'method' => 'post',  'class'=>'bootstrap-modal-form', 'autocomplete'=>'off')) !!}
            <div class="modal-body">
                <div class="form-group required">
                    {!! Form::label('date',trans('dashboard.date'), array('class'=>'required')) !!}
                    <span class="help-block"></span>
                    {!! Form::text('date', null, array('class' => 'form-control date', 'required'=>'required')) !!}
                </div>
                <div class="form-group required">
                    {!! Form::label('staff_leave_type_id', trans('dashboard.staff_leave_type'), array('class' => 'control-label required')) !!}
                    <span class="help-block"></span>
                    {!! Form::select('staff_leave_type_id', $staff_leave_types, null, array('id'=>'staff_leave_type_id', 'class' => 'form-control select2')) !!}
                </div>
                <div class="form-group required">
                    {!! Form::label('description',trans('dashboard.description')) !!}
                    <span class="help-block"></span>
                    {!! Form::text('description', null, array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">{{trans('dashboard.create_request')}}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('dashboard.close')}}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.date').datetimepicker({
            format: '{{ Settings::get('jquery_date') }}',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }
        });
    });
</script>