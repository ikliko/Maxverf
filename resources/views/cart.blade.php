@extends('master')
@section('container')
<style>
    .btn-elm-cart {
        display: inline;
    }
</style>
<section class="page-content">
    <div class="container">
        <table id="cart" class="table table-condensed">
            <thead>
            <tr>
                <th style="width:50%">{{{ ucfirst(Lang::get('fields.cart.product')) }}}</th>
                <th style="width:10%">{{{ ucfirst(Lang::get('fields.cart.size')) }}}</th>
                <th style="width:10%">{{{ ucfirst(Lang::get('fields.cart.color')) }}}</th>
                <th style="width:10%">{{{ ucfirst(Lang::get('fields.cart.price')) }}}</th>
                <th style="width:8%">{{{ ucfirst(Lang::get('fields.cart.qty')) }}}</th>
                <th style="width:22%" class="text-center">{{{ ucfirst(Lang::get('fields.cart.subtotal')) }}}</th>
                <th style="width:10%"></th>
            </tr>
            </thead>

            @foreach(Cart::instance('shopping') -> content() as $product)
            <tbody>
            <tr>
                <td data-th="Product">
                    <div class="row">
                        <div class="col-md-2 col-sm-4 col-xs-12">
                            {!! HTML::image($product -> options -> product -> image_normal, null, ['class' => 'img-responsive']); !!}
                        </div>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <h4 class="nomargin">{{{ $product -> name }}}</h4>
                            <p>{!! $product -> options -> product -> intro !!}</p>
                        </div>
                    </div>
                </td>
                <td data-th="Maat: ">{{{ $product -> options -> size ? $product -> options -> size -> size : 'no size' }}}</td>
                <td data-th="Kleur: " style="background-color: {{{ $product -> options -> color ? $product -> options -> color -> color : '' }}};">{{{ $product -> options -> color ? '' : 'no color' }}}</td>
                <td data-th="Prijs: " class="price">{{{ $product -> price . config('shop.currency.eur.symbol') }}}</td>
                <td data-th="Aantal: ">
                    <?php
                    Form::macro('number', function($name, $steps, $value, $classes)
                    {
                        return '<input type="number" step="'. $steps . '" name="'. $name . '" value="' . $value . '" class="' . $classes . '"/>';
                    });
                    ?>
                    {!! Form::open(['url' => '/cart/' .  $product -> rowid, 'method' => 'PUT']) !!}
                    {!! Form::number('newQty', 1, $product -> qty, 'form-control text-center') !!}
                    <button type="submit" class="btn btn-default btn-sm btn-refresh-number"><i class="fa fa-refresh"></i></button>
                    {!! Form::close() !!}
                </td>
                <td data-th="Subtotaal: " class="text-center">{{{ number_format($product -> subtotal, 2) . config('shop.currency.eur.symbol') }}}</td>
                <td class="actions  text-center" data-th="">
                    {!! Form::open(['url' => '/cart/' . $product -> rowid, 'method' => 'DELETE', 'class' => 'btn-elm-cart']) !!}
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                    {!! Form::close() !!}
                </td>
            </tr>
            </tbody>
            @endforeach

            <tfoot>
            <tr class="visible-xs">
                <td class="text-center"><strong>{{{ ucfirst(Lang::get('fields.cart.total')) }}} {{{ number_format(Cart::instance('shopping') -> total(), 2) . config('shop.currency.eur.symbol') }}}</strong></td>
            </tr>
            <tr>
                <td><a href="{{{ url('shop') }}}" class="btn btn-cart2"><i class="fa fa-angle-left"></i> {{{ ucfirst(Lang::get('fields.cart.back_btn')) }}}</a></td>
                <td colspan="4" class="hidden-xs"></td>
                <td class="hidden-xs text-center"><strong>{{{ ucfirst(Lang::get('fields.cart.total')) }}} {{{ number_format(Cart::instance('shopping') -> total(), 2) . config('shop.currency.eur.symbol') }}}</strong></td>
                <td><a href="{{{ url('payments/method') }}}" class="btn btn-cart2">{{{ ucfirst(Lang::get('fields.cart.continue_btn')) }}} <i class="fa fa-angle-right"></i></a></td>
            </tr>
            </tfoot>
        </table>
    </div>
</section>
@stop