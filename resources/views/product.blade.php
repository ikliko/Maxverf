@extends('master')
@section('container')
    <section class="page-content" ng-controller="sizeController">
        <div class="container">
            <div class="row">
                @if(isset($categories))
                    <div class="col-md-3 col-sm-4">
                        <div class="left-sidebar">
                            <h2>{{{ strtoupper(Lang::get('fields.categories.title')) }}}</h2>
                            @include('sections.categories')
                        </div>
                    </div>
                @endif
                <div class="col-md-9 col-sm-8 padding-right">
                    <div class="product-details"><!--product-details-->
                        <div class="col-md-5 col-sm-6">
                            <div class="view-product hidden-lg hidden-md">
                                {!! HTML::image($product -> image_large) !!}
                            </div>
                            <div class="view-product hidden-sm hidden-xs">
                                {!! HTML::image($product -> image_large, null, ['id' => 'zoom_02']) !!}
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-6">
                            <div class="product-information"><!--/product-information-->
                                <h2>{{{ $product -> name }}}</h2>
                                <span class="hidden">
                                    <span id="priceHolder"></span>
                                </span>
                                {!! Form::open(['url' => 'cart']) !!}
                                {!! Form::hidden('product_id', $product -> id) !!}
                                <div class="col-md-7 col-sm-12 col-xs-12 no-padding">
                                    <span>
                                        @if(!$product -> price)
                                            <?php
                                            $sizes = $product->sizes;
                                            $colors = $product->colors;
                                            ?>
                                            @if(count($sizes))
                                                <label>{{{ ucfirst(Lang::get('fields.product.size')) }}}:</label>
                                                <select class="form-control" id="select" ng-model="size" ng-change="selectedSize(size)"
                                                        name="size_id">
                                                    @foreach($sizes as $size)
                                                        <option value="{{{ $size -> id }}}">
                                                            @if($size -> promoPrice(0) + 0)
                                                                {{{ $size -> size . ' ' . $size -> promoPrice() }}}
                                                            @else
                                                                {{{ $size -> size . ' ' . number_format($size -> price / 1.21, 2) .
                                                                config('shop.currency.eur.symbol') }}}
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @elseif(count($colors))
                                                <label>{{{ ucfirst(Lang::get('fields.product.color')) }}}:</label>
                                                <select class="form-control" id="select" name="color_id">
                                                    @foreach($colors as $color)
                                                        <option>{{{ $color -> color }}}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        @else
                                            <font @if($product -> promoPrice()) style="text-decoration: line-through" @endif >
                                                {{{ strtoupper(Lang::get('fields.product.excl')) }}}: {{{ $product -> priceNoVat() }}} <br/>
                                                {{{ strtoupper(Lang::get('fields.product.incl')) }}}: {{{ $product -> price . config('shop.currency.eur.symbol') }}} <br/>
                                            </font>
                                            @if($product -> promoPrice())
                                                <span class="promotion-price">{{{ strtoupper(Lang::get('fields.product.promo.excl')) }}}: {{{ $product -> promoNoVat()  }}}</span>
                                                <span class="promotion-price">{{{ strtoupper(Lang::get('fields.product.promo.incl')) }}}: {{{ $product -> promoPrice()  }}}</span>
                                            @endif
                                        @endif
                                        <div id="colors"></div>
                                    </span>
                                </div>
                                <div class="col-md-5 col-sm-12 col-xs-12 no-padding">
                                     <span>
                                        <label>{{{ ucfirst(Lang::get('fields.product.qty')) }}}:</label>
                                        <input type="text" value="1" name="qty"/>
                                        <button type="submit" class="btn add-to-cart2">
                                            <i class="fa fa-shopping-cart"></i>
                                            {{{ strtoupper(Lang::get('fields.product.buy_btn')) }}}
                                        </button>
                                      </span>
                                </div>
                                <div style="clear: both;"></div>
                                <p><b>{{{ ucfirst(Lang::get('fields.product.description')) }}}:</b> {!! $product -> description !!}</p>
                                {!! Form::close() !!}
                            </div>
                            <!--/product-information-->
                        </div>
                    </div>
                    <!--/product-details-->
                </div>
                <div class="row">
                    <div class="category-tab shop-details-tab col-xs-12"><!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#laatst" data-toggle="tab">latste</a></li>
                                <li><a href="#promotie" data-toggle="tab">promotie</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="laatst">
                                <div class="row">
                                    @foreach($last as $l_product)
                                        <div class="col-sm-3">
                                            <div class="product-image-wrapper">
                                                <div class="single-products">
                                                    <div class="productinfo text-center">
                                                        <a href="{{{ url('shop/' . $l_product -> id) }}}">
                                                            {!! HTML::image($l_product -> image_normal) !!}
                                                        </a>
                                                        <h2>
                                                            @if($l_product -> price)
                                                                {{{ $l_product -> price . config('shop.currency.eur.symbol') }}}
                                                            @else
                                                                &nbsp;
                                                            @endif
                                                        </h2>
                                                        <p>{{{ substr($l_product -> name, 0, 33) }}}</p>
                                                        @if($l_product -> price)
                                                            <a href="#" class="btn btn-default add-to-cart"><i
                                                                        class="fa fa-shopping-cart"></i>Add
                                                                to cart</a>
                                                        @else
                                                            <a href="{{{ url('shop/' . $l_product -> id) }}}"
                                                               class="btn btn-default add-to-cart"><i
                                                                        class="fa fa-info"></i>Details</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="promotie">
                                <div class="row">
                                    @if(isset($promo_products))
                                        @foreach($promo_products as $promo_product)
                                            <div class="col-sm-3">
                                                <div class="product-image-wrapper">
                                                    <div class="single-products">
                                                        <div class="productinfo text-center">
                                                            <a href="{{{ url('shop/' . $promo_product -> id) }}}">
                                                                {!! HTML::image($promo_product -> image_normal, 'Product image'); !!}
                                                            </a>
                                                            <h2 class="price">
                                                                <a href="{{{ url('shop/' . $promo_product -> id) }}}"
                                                                   style="color: #e01f1f; font-family: 'Lato', sans-serif;">{{{ $promo_product -> promoPrice() }}}</a>
                                                            </h2>
                                                            <p>{{{ $promo_product -> name }}}</p>
                                                            {!! Form::open(['url' => 'cart', 'style' => 'display:inline']); !!}
                                                            {!! Form::hidden('product_id', $promo_product -> id); !!}
                                                            <button type="submit" class="btn btn-default add-to-cart"><i
                                                                        class="fa fa-shopping-cart"></i> in winkelwagen
                                                            </button>
                                                            {!! Form::close(); !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop