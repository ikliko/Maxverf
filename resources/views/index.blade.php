@extends('master')
@section('container')

@if(isset($promo_products) && count($promo_products))
<section id="product-slider">
    <div class="carousel slide">
        <ol class="carousel-indicators">
            <?php $point = 0; ?>
            @foreach($promo_products as $slide)
            <li data-target="#product-slider" data-slide-to="{{{ $point }}}" @if(!$point) class="active" @endif></li>
            <?php $point++; ?>
            @endforeach

        </ol>
        <div class="carousel-inner">
            <?php $isFirst = 0; ?>
            @foreach($promo_products as $slide)
			<!-- Слайд -->
            <div class="item @if(!$isFirst) active @endif" style="background: #000">
                <?php $isFirst++; ?>
                <!--<div class="slide-desc"></div>-->
                <div class="container">
                    <div class="row">

                        <div class="col-sm-6 col-xs-12 animation animated-item">
                            <div class="slider-img">
                                {!! HTML::image(url($slide -> image_normal), 'product image', ['class' => 'img-responsive']) !!}
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="carousel-content">
                                <h1 class="animation animated-item-1">{{{ $slide -> name }}}</h1>

                                @if($slide -> price)
                                <h2 class="animation animated-item-2">{{{ $slide -> currentPriceNoVat() }}} </h2>
                                @endif
                                <a class="btn-slide animation animated-item-3" href="{{{ url('shop/' . $slide -> id) }}}"><i class="fa fa-info"></i> @lang('fields.slider.info_btn')</a>
                                @if($slide -> price)
                                {!! Form::open(['url' => 'cart', 'style' => 'display:inline;']) !!}
                                {!! Form::hidden('product_id', $slide -> id) !!}
                                <button type="submit" class="btn-slide animation animated-item-3">
                                    <i class="fa fa-shopping-cart"></i> @lang('fields.slider.buy_btn')
                                </button>
                                {!! Form::close() !!}
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Край на Слайд -->
            @endforeach

        </div>
    </div>
    <a class="prev hidden-xs" href="#product-slider" data-slide="prev"><i class="fa fa-angle-left"></i></a>
    <a class="next hidden-xs" href="#product-slider" data-slide="next"><i class="fa fa-angle-right"></i></a>
</section>
@endif


<section class="page-content">
<div class="container">

@if(0)
<div class="row hidden-xs">
    @if(isset($promo_products) && count($promo_products))
    @foreach($promo_products as $promoProduct)
    <div class="col-sm-4">
        <a href="{{{ url('shop/' . $promoProduct -> id) }}}">
            <div class="product-col">
                <div class="col-lg-9 col-md-10 col-sm-10 col-xs-10">
                    <h2>{{{ $promoProduct -> name }}}</h2>

                    <p class="price-product-promo">{{{ $promoProduct -> promoPrice() }}}</p>

                    <a href="{{{ url('shop/' . $promoProduct -> id) }}}">
                        <div class="btn btn-kopen"><i class="fa fa-info"></i> Details</div>
                    </a>
                    {!! Form::open(['url' => 'cart', 'style' => 'display:inline;']) !!}
                    {!! Form::hidden('product_id', $promoProduct -> id) !!}
                    <button type="submit" class="btn btn-kopen">
                        <i class="fa fa-shopping-cart"></i> Kopen
                    </button>
                    {!! Form::close() !!}
                </div>

                <div class="col-lg-3 col-md-2 col-sm-2 col-xs-2 no-padding">
               
                    {!! HTML::image(url($promoProduct -> image_normal), 'Product image'); !!}
                </div>
                <div class="clr"></div>
            </div>
        </a>
    </div>
    @endforeach
    @endif
</div>
@endif


<div class="row">

    @if(isset($categories))
    <div class="col-md-3 col-sm-4">
        <div class="left-sidebar">
            <h2>@lang('fields.categories.title')</h2>

            @include('sections.categories')

        </div>
    </div>
    @endif

    <div class="col-md-9 col-sm-8 col-xs-12 page-content">

        <div class="box-head">
            <p>Welkom bij Max Verfgroothandel!</p>
        </div>

        <div class="box-page">

            <p>
                @lang('fields.index.text.0')
                <br><br>
                @lang('fields.index.text.1')
            </p>

        </div>


		<div class="row">
		
        <div class="category-tab shop-details-tab"><!--category-tab-->
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#laatst" data-toggle="tab"> @lang('fields.last_section.title')</a></li>
                    <li><a href="#promotie" data-toggle="tab">@lang('fields.promotion_section.title')</a></li>
                </ul>
            </div>
            <div class="tab-content">

                <div class="tab-pane fade active in" id="laatst">
				  <div class="row">
                    @if(isset($last))
                    @foreach($last as $l_product)
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    {!! HTML::image($l_product -> image_normal) !!}
                                    <h2>
                                        @if($l_product -> price)
                                        {{{ $l_product -> price }}}€
                                        @else
                                        &nbsp;
                                        @endif
                                    </h2>

                                    <p>{{{ substr($l_product -> name, 0, 33) }}}</p>

                                    @if($l_product -> price)
                                    {!! Form::open(['url' => 'cart', 'style' => 'display:inline;']) !!}
                                    {!! Form::hidden('product_id', $l_product -> id) !!}
                                    <button type="submit" class="btn btn-default add-to-cart">
                                        <i class="fa fa-shopping-cart"></i> @lang('fields.last_section.buy_btn')
                                    </button>
                                    {!! Form::close() !!}
                                    @else
                                    <a href="{{{ url('shop/' . $l_product -> id) }}}" class="btn btn-default add-to-cart"><i
                                            class="fa fa-info"></i>@lang('fields.last_section.info_btn')</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
				   </div>
                </div>

                <div class="tab-pane fade" id="promotie">
			
				  <div class="row">
                    @if(isset($promo_products))
                    @foreach($promo_products as $promo_product)
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <a href="{{{ url('shop/' . $promo_product -> id) }}}">
                                        {!! HTML::image($promo_product -> image_normal, 'Product image'); !!}
                                    </a>

                                    <h2 class="price">
                                        <a href="{{{ url('shop/' . $promo_product -> id) }}}" style="color: #e01f1f; font-family: 'Lato', sans-serif;">{{{ $promo_product -> promoPrice() }}}</a>
                                    </h2>

                                    <p>{{{ $promo_product -> name }}}</p>

                                    @if($promo_product -> price)
                                    {!! Form::open(['url' => 'cart', 'style' => 'display:inline;']) !!}
                                    {!! Form::hidden('product_id', $promo_product -> id) !!}
                                    <button type="submit" class="btn btn-default add-to-cart">
                                        <i class="fa fa-shopping-cart"></i> @lang('fields.promotion_section.buy_btn')
                                    </button>
                                    {!! Form::close() !!}
                                    @else
                                    <a href="{{{ url('shop/' . $promo_product -> id) }}}" class="btn btn-default add-to-cart"><i
                                            class="fa fa-info"></i>@lang('fields.promotion_section.info_btn')</a>
                                    @endif
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
        <!--/category-tab-->
		
		</div>


    </div>


</div>


<div class="row hidden-lg hidden-md hidden-sm">
    @if(isset($promo_products) && count($promo_products))
    @foreach($promo_products as $promoProduct)
    <div class="col-sm-4">
        <a href="{{{ url('shop/' . $promoProduct -> id) }}}">
            <div class="product-col">
                <div class="col-lg-9 col-md-10 col-sm-10 col-xs-10">
                    <h2>{{{ $promoProduct -> name }}}</h2>

                    <p class="price-product-promo">{{{ $promoProduct -> promoPrice() }}}</p>

                    <a href="{{{ url('shop/' . $promoProduct -> id) }}}">
                        <div class="btn btn-kopen"><i class="fa fa-info"></i> Details</div>
                    </a>
                    {!! Form::open(['url' => 'cart', 'style' => 'display:inline;']) !!}
                    {!! Form::hidden('product_id', $promoProduct -> id) !!}
                    <button type="submit" class="btn btn-kopen">
                        <i class="fa fa-shopping-cart"></i> Kopen
                    </button>
                    {!! Form::close() !!}
                </div>

                <div class="col-lg-3 col-md-2 col-sm-2 col-xs-2 no-padding">
               
                    {!! HTML::image(url($promoProduct -> image_normal), 'Product image'); !!}
                </div>
                <div class="clr"></div>
            </div>
        </a>
    </div>
    @endforeach
    @endif
</div>


</div>
</section>

@stop