@extends('panel.category.create-master')
@section('form')
{!! Form::open(['url' => $url, 'method' => $method]) !!}
    <fieldset>

        <div class="form-group">
            {!! Form::label('parent', 'Parent:', ['class' => 'col-lg-2 control-label text-right']) !!}
            <div class="col-lg-10">
                {!! Form::select('parent', $categories, isset($category) && $category -> parent ? $category -> parent -> id : null, array('id' => 'parent', 'class' => 'form-control')) !!}
            </div>
            @if($errors -> first('parent') != '')
            <div class="clear">&nbsp;</div>
            <div class="col-lg-offset-2 col-lg-10">
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{{ $errors -> first('parent') }}}
                </div>
            </div>
            @endif
        </div>
        <div class="clear">&nbsp;</div>

        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                {!! Form::button('Reset', array('type' => 'reset','class' => 'btn btn-default')) !!}
                {!! Form::submit('Save', array('class' => 'btn btn-primary')) !!}
                {!! HTML::link('panel/products/categories', 'go back', ['class' => 'btn btn-link pull-right']) !!}
            </div>
        </div>
    </fieldset>
{!! Form::close() !!}
@stop