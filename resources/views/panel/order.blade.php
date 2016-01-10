@extends('panelViews::mainTemplate')
@section('page-wrapper')
<style>
    .clear {
        clear: both;
    }
    .bold {
        font-weight: bold;
    }
    .order {
        font-size: 20px;
    }
</style>
<h2 class="text-center">Order: <strong>{{{ $order -> first_name . ' ' . $order -> last_name }}}</strong></h2>
<hr/>
<div class="row order">
    @if($order -> user)
    <div class="row">
        <div class="col-lg-3">
            <span class="bold">User:</span>
        </div>
        <div class="col-lg-3">
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-2">
            <span class="bold pull-right">Full name:</span>
        </div>
        <div class="col-lg-6">
            {{{  $order -> first_name . ' ' . $order -> last_name }}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <span class="bold pull-right">Firm name:</span>
        </div>
        <div class="col-lg-6">
            {{{ $order -> firm }}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <span class="bold pull-right">Email:</span>
        </div>
        <div class="col-lg-6">
            {{{ $order -> email }}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <span class="bold pull-right">Phone:</span>
        </div>
        <div class="col-lg-6">
            {{{ $order -> phone }}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <span class="bold pull-right">KVK nummer:</span>
        </div>
        <div class="col-lg-6">
            {{{ $order -> kvk }}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <span class="bold pull-right">BTW nummer:</span>
        </div>
        <div class="col-lg-6">
            {{{ $order -> btw }}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <span class="bold pull-right">Address:</span>
        </div>
        <div class="col-lg-6">
            {{{ $order -> address }}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <span class="bold pull-right">Comment:</span>
        </div>
        <div class="col-lg-6">
            {{{ $order -> comment }}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <span class="bold pull-right">Total:</span>
        </div>
        <div class="col-lg-6">
            {{{ number_format($order -> total(), 2) . ' ' . config('shop.currency.eur.symbol') }}}
        </div>
    </div>

</div>
    <h2 class="text-center">Products</h2>
    <hr/>
    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>id</th>
            <th>Product</th>
            <th>Size</th>
            <th>Color</th>
            <th>Count</th>
            <th>Bought at price</th>
            <th>Discount</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order -> products as $row)
        <tr>
            <td>{{{ $row -> id }}}</td>
            <td>{{{ $row -> product -> name }}}</td>
            <td>{{{ $row -> size ? $row -> size -> size : 'no size' }}}</td>
            <td>
                {{{ $row -> color ? $row -> color -> color : 'no color' }}}
            </td>
            <td>{{{ $row -> count }}}</td>
            <td>{{{ $row -> current_price }}}</td>
            <td>{{{ $row -> discount }}} @if($row -> discount_type) % @else {{{ config('shop.currency.eur.symbol') }}} @endif</td>
            <td>{{{ $row -> created_at }}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@if(isset($isEdit) && $isEdit)
<div class="clear">&nbsp;</div>
<div class="clear">&nbsp;</div>
<div class="clear">&nbsp;</div>
<div class="clear">&nbsp;</div>
<div class="clear">&nbsp;</div>
<div class="clear">&nbsp;</div>
<h1 class="text-center">Accept or decline order?</h1>
{!! Form::open(['url' => 'panel/Order/' . $order -> id . '/decline', 'class' => 'col-lg-offset-2 col-lg-4']) !!}
{!! Form::submit('Decline', array('class' => 'btn btn-primary form-control')); !!}
{!! Form::close() !!}

{!! Form::open(['url' => 'panel/Order/' . $order -> id . '/accept', 'class' => 'col-lg-4']) !!}
{!! Form::submit('Accept', array('class' => 'btn btn-default form-control')); !!}
{!! Form::close() !!}
@endif
@stop