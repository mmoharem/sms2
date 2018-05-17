<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($invoice))
            {!! Form::model($invoice, array('url' => url($type) . '/' . $invoice->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('invoice.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        @if (!isset($invoice))
            <div class="form-group {{ $errors->has('section_id') ? 'has-error' : '' }}">
                {!! Form::label('section_id', trans('student.section_id'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('section_id',  $sections,  null, array('id'=>'section_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('section_id', ':message') }}</span>
                </div>
            </div>
        @endif
        @if (!isset($invoice))
            <div class="form-group {{ $errors->has('fee_category_id') ? 'has-error' : '' }}">
                {!! Form::label('fee_category_id', trans('invoice.fee_category_id'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('fee_category_id', $fee_categories, null, array('id'=>'fee_category_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('fee_category_id', ':message') }}</span>
                </div>
            </div>
        @endif
        <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
            {!! Form::label('amount', trans('invoice.amount'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('amount', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('amount', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            {!! Form::label('description', trans('invoice.description'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
            </div>
        </div>
        @if (!isset($invoice))
            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                {!! Form::label('user_id', trans('invoice.students'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('user_id[]', [], null, array('id'=>'user_id', 'multiple'=>true, 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                    <input type="checkbox" id="select_all_students">{{trans('teachergroup.select_all_students')}}
                </div>
            </div>
        @endif
        <button type="button" class="btn btn-info btn-sm btn-ghost " id="add"><i
                    class="fa fa-plus"></i> {!! trans('invoice.add_item') !!}</button>
        <div class="row items">
            @if (isset($invoice) && !is_null($invoice->items))
                @foreach($invoice->items as $key=>$item)
                    <div id="form{{$key}}">
                        <div class="form-group {{ $errors->has('option_id') ? 'has-error' : '' }}">
                            {!! Form::label('option_id', trans('invoice.option_id'), array('class' => 'control-label required')) !!}
                            <div class="controls">
                                {!! Form::select('option_id[]', $invoice_items, null, array('id'=>'option_id', 'class' => 'form-control select2')) !!}
                                <span class="help-block">{{ $errors->first('option_id', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('quantity', trans('invoice.quantity'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('number','quantity[]', $item->quantity, array('class' => 'form-control required')) !!}
                            </div>
                            <a class="btn btn-danger btn-sm btn-small remove">
                                    <span class="fa fa-trash-o">
                                        {!! Form::hidden('remove', $item->id, array('class' => 'remove')) !!}
                                    </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
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
        $(document).ready(function () {
            $('.remove').click(function () {
                $(this).parent().parent().remove();
            });
            var count = {{isset($invoice->items)?count($invoice->items):'0'}};
            $("#add").click(function () {
                count++;
                var formfild = '<div class="form-group">' +
                    '<label class="control-label required" for="option_id">{!! trans('invoice.option_id')!!}</label>' +
                    '<div class="controls">\n' +
                    '{!! Form::select('option_id[]', $invoice_items, null, array('id'=>'option_id', 'class' => 'form-control select2')) !!}\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '<div class="form-group">\n' +
                    '{!! Form::label('quantity', trans('invoice.quantity'), array('class' => 'control-label')) !!}\n' +
                    '<div class="controls">\n' +
                    '{!! Form::input('number','quantity[]', 0, array('class' => 'form-control required')) !!}\n' +
                    '</div>\n' +
                    '</div>';

                $(".items").append(formfild);
            });
            $(".items").sortable();
        });
        $("#select_all_students").click(function () {
            if ($("#select_all_students").is(':checked')) {
                $("#user_id > option").prop("selected", "selected");
                $("#user_id").trigger("change");
            } else {
                $("#user_id > option").removeAttr("selected");
                $("#user_id").trigger("change");
            }
        });
        $('#section_id').change(function () {
            $('#user_id').empty();
            $.ajax({
                type: "GET",
                url: '{{ url('/schoolyear') }}/' + $(this).val() + '/get_students',
                success: function (result) {
                    $.each(result, function (val, text) {
                        $('#user_id').append($('<option></option>').val(val).html(text))
                    });
                }
            });
        });
    </script>
@endsection
