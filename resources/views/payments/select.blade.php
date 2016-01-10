@extends('master')
@section('container')
<div class="container">

    <div class="row">


        <div class="col-md-12">

            <div class="payment-details">
                {!! Form::open(array('url' => 'payments/method')) !!}

                <h2>@lang('fields.order.title'):</h2>

                <div class="payment-detail">
                    <input type="radio" name="payment" id="payment1" value="card">

                    <label for="payment1">
                        <div class="col-sm-8 col-xs-12 text-left-lg text-left-md text-left-xs">
                            <h4>@lang('fields.order.card.title')</h4>
                            <p>@lang('fields.order.card.description.0')</p>
                            <p>@lang('fields.order.card.description.1')</p>
                        </div>

                        <div class="col-sm-4 col-xs-12 payment-img text-right-lg text-right-md text-right-xs">
                            <img src="{{{ url('images/cards/cards.png') }}}">
                        </div>

                    </label>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12 text-right-lg text-right-md text-right-sm text-right-xs no-padding payment-details-btn">
                    <a href="{{{ url('shop') }}}" class="btn">@lang('fields.order.back_btn')</a>
                    <button type="submit" class="btn">@lang('fields.order.continue_btn')</button>
                </div>

                {!! Form::close() !!}
            </div>




        </div>


    </div>

</div>
@stop