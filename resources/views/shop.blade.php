 @extends('master')
@section('container')
<section class="page-content">
    <div class="container">
	
		<div class="row hidden-xs">
			@if(isset($promo_products) && count($promo_products))
			@foreach($promo_products as $promoProduct)
			<div class="col-sm-4">
				<a href="{{{ url('shop/' . $promoProduct -> id) }}}">
					<div class="product-col">
						<div class="col-lg-9 col-md-10 col-sm-10 col-xs-10">
							<h2>{{{ $promoProduct -> name }}}</h2>

                            @if($promoProduct -> promoPrice(0) + 0)
							<p class="price-product-old">{{{ $promoProduct -> priceNoVat() }}}</p>
							<p class="price-product-promo">{{{ $promoProduct -> currentPriceNoVat() }}}</p>
                            @endif

							<a href="{{{ url('shop/' . $promoProduct -> id) }}}">
								<div class="btn btn-kopen"><i class="fa fa-info"></i> {{{ ucfirst(Lang::get('fields.shop.info_btn')) }}}</div>
							</a>
							{!! Form::open(['url' => 'cart', 'style' => 'display:inline;']) !!}
							{!! Form::hidden('product_id', $promoProduct -> id) !!}
							<button type="submit" class="btn btn-kopen">
                                <i class="fa fa-shopping-cart"></i>
                                {{{ ucfirst(Lang::get('fields.shop.buy_btn')) }}}
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


        <div class="row">
            @if(isset($categories))
            <div class="col-md-3 col-sm-4">
                <div class="left-sidebar">
                    <h2>{{{ strtoupper(Lang::get('fields.categories.title')) }}}</h2>

                    @include('sections.categories')

                </div>
            </div>
            @endif

            @if(isset($products))
            <div class="col-md-9 col-sm-8 page-content">

                <div class="box-head">
                    <p>{{{ strtoupper(Lang::get('fields.shop.title')) }}}</p>
                </div>

                <div class="box-page">


                    <div class="row">
                        @foreach($products as $product)
                        @include('sections.product-shop', ['product' => $product])
                        @endforeach
                        @include('sections.category-childs')
                    </div>

                </div>

            </div>

            {!! isset($pages) ? $pages : '' !!}
            @endif
        </div>
		
		
		<div class="row hidden-lg hidden-md hidden-sm">
			@if(isset($promo_products) && count($promo_products))
			@foreach($promo_products as $promoProduct)
			<div class="col-sm-4">
				<a href="{{{ url('shop/' . $promoProduct -> id) }}}">
					<div class="product-col">
						<div class="col-lg-9 col-md-10 col-sm-10 col-xs-10">
							<h2>{{{ $promoProduct -> name }}}</h2>

							<p class="price-product-old">{{{ $promoProduct -> price }}}</p>
							<p class="price-product-promo">{{{ $promoProduct -> promoPrice() }}}</p>

							<a href="{{{ url('shop/' . $promoProduct -> id) }}}">
								<div class="btn btn-kopen"><i class="fa fa-info"></i> {{{ strtoupper(Lang::get('fields.shop.info_btn')) }}}</div>
							</a>
							{!! Form::open(['url' => 'cart', 'style' => 'display:inline;']) !!}
							{!! Form::hidden('product_id', $promoProduct -> id) !!}
							<button type="submit" class="btn btn-kopen">
								<i class="fa fa-shopping-cart"></i>
                                {{{ strtoupper(Lang::get('fields.shop.buy_btn')) }}}
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