@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {!! Form::open(array('url' => url($type.'/finish_import'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
    <table class="table books import-wrapper">
        <thead>
        <tr>
            <th>
                <input type="checkbox" id="checkAll" class="icheckgreen">
                {{trans('book.check_all')}}
            </th>
            <th>{{trans('book.internal')}}</th>
            <th>{{trans('book.title')}}</th>
            <th>{{trans('book.subject')}}</th>
            <th>{{trans('book.price')}}</th>
            <th>{{trans('book.isbn')}}</th>
            <th>{{trans('book.option_id_category')}}</th>
            <th>{{trans('book.publisher')}}</th>
            <th>{{trans('book.option_id_borrowing_period')}}</th>
            <th>{{trans('book.version')}}</th>
            <th>{{trans('book.author')}}</th>
            <th>{{trans('book.year')}}</th>
            <th>{{trans('book.quantity')}}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($books as $key => $item)
            <tr id="{{$key}}">
                <td>
                    <div class="input-group">
                        <label>
                            <input type="checkbox" name="import[]" value="{{$key}}" class='icheckgreen'>
                        </label>
                    </div>
                </td>
                <td>
                    {{ $item['internal'] }}
                    {!! Form::hidden('internal['.$key.']', $item['internal']) !!}
                </td>
                <td>
                    {{ $item['title'] }}
                    {!! Form::hidden('title['.$key.']', $item['title']) !!}
                </td>
                <td>
                    {!! Form::select('subject_id['.$key.']', $subjects, null, array('class' => 'form-control')) !!}
                </td>
                <td>
                    {{ $item['price'] }}
                    {!! Form::hidden('price['.$key.']', $item['price']) !!}
                </td>
                <td>
                    {{ $item['isbn'] }}
                    {!! Form::hidden('isbn['.$key.']', $item['isbn']) !!}
                </td>
                <td>
                    {!! Form::select('option_id_category['.$key.']', $book_categories, null, array('class' => 'form-control')) !!}
                </td>
                <td>
                    {{ $item['publisher'] }}
                    {!! Form::hidden('publisher['.$key.']', $item['publisher']) !!}
                </td>
                <td>
                    {!! Form::select('option_id_borrowing_period['.$key.']', $borrowing_periods, null, array('class' => 'form-control')) !!}
                </td>
                <td>
                    {{ $item['version'] }}
                    {!! Form::hidden('version['.$key.']', $item['version']) !!}
                </td>
                <td>
                    {{ $item['author'] }}
                    {!! Form::hidden('author['.$key.']', $item['author']) !!}
                </td>
                <td>
                    {{ $item['year'] }}
                    {!! Form::hidden('year['.$key.']', $item['year']) !!}
                </td>
                <td>
                    {{ $item['quantity'] }}
                    {!! Form::hidden('quantity['.$key.']', $item['quantity']) !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="form-group">
        <div class="controls">
            <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.cancel')}}</a>
            <button type="submit" class="btn btn-success btn-sm">{{trans('table.ok')}}</button>
        </div>
    </div>
    {!! Form::close() !!}
@stop

{{-- Scripts --}}
@section('scripts')
    <script>
        $(document).ready(function () {
            $("#checkAll").on('ifChecked', function () {
                $("input:checkbox").iCheck('check');
            });
            $('.icheckgreen').iCheck({
                checkboxClass: 'icheckbox_minimal-green',
                radioClass: 'iradio_minimal-green'
            });
        });
    </script>
@stop