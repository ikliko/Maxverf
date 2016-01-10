@extends('panelViews::mainTemplate')
@section('page-wrapper')
<style>
    .clear {
        clear: both;
    }
</style>

<h1 class="text-center">{{{ $title }}}</h1>
<hr/>
{!! Form::open(['url' => $url, 'method' => $method, 'files' => true]) !!}
<fieldset>
    <div class="form-group">
        {!! Form::label('size', 'Name:', ['class' => 'col-lg-2 control-label text-right']) !!}
        <div class="col-lg-10">
            {!! Form::text('size', isset($size) ? $size -> size : null, ['id' => 'size', 'placeholder' => 'Name', 'class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="clear">&nbsp;</div>

    <div class="form-group">
        {!! Form::label('price', 'Price:', ['class' => 'col-lg-2 control-label text-right']) !!}
        <div class="col-lg-2">
            {!! Form::text('price', isset($size) ? $size -> price : null, ['id' => 'price', 'placeholder' => 'Price', 'class'=> 'form-control']) !!}
        </div>

        {!! Form::label('promo_type', 'Type:', ['class' => 'col-lg-2 control-label text-right']) !!}
        <div class="col-lg-2">
            {!! Form::select('promo_type', array(0 => 'price', 1 => 'percents'), isset($size) ? $size -> promo_type : 0, array('id' => 'promo_type', 'class'=> 'form-control')); !!}
        </div>

        {!! Form::label('promo', 'Promo:', ['class' => 'col-lg-2 control-label text-right']) !!}
        <div class="col-lg-2">
            {!! Form::text('promo', isset($size) ? $size -> promo : null, ['id' => 'promo', 'class'=> 'form-control', 'placeholder' => '0.00']) !!}
        </div>
    </div>
    <div class="clear">&nbsp;</div>

    <div class="form-group">
        {!! Form::label('product_id', 'Product:', ['class' => 'col-lg-2 control-label text-right']) !!}
        <div class="col-lg-10">
            {!! Form::select('product_id', $products, isset($size) && $size -> product ? $size -> product -> id : null, array('id' => 'product_id', 'class' => 'form-control')) !!}
        </div>
    </div>
    <div class="clear">&nbsp;</div>

    <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
            {!! Form::button('Reset', array('type' => 'reset','class' => 'btn btn-default')) !!}
            {!! Form::submit('Save', array('class' => 'btn btn-primary')) !!}
            {!! HTML::link('panel/products/sizes', 'go back', ['class' => 'btn btn-link pull-right']) !!}
        </div>
    </div>
</fieldset>
{!! Form::close() !!}
<div class="clear">&nbsp;</div>
@stop