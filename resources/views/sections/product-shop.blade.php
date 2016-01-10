<div class="col-sm-4">
    <div class="product-image-wrapper">
        <div class="single-products">
            <div class="productinfo text-center">
                @if($product -> promoPrice())
			    <div class="product-promotion"></div>
                @endif
                <a href="{{{ url('shop/' . $product -> id) }}}">{!! HTML::image($product -> image_normal) !!}</a>
                    @if($product -> price)
                    @if($product -> promoPrice())
					<h2 class="price-product-old">{{{ $product -> priceNoVat() }}}</h2>
					<h2 class="price-product-promo">{{{ $product -> promoNoVat() }}}</h2>
                    @else
                    <h2 class="price-product-old"></h2>
                    <h2 class="price"> {{{ $product -> priceNoVat() }}} </h2>
                    @endif
                    @else
                    <h2 class="price-product-old"></h2>
                    <h2 class="price"></h2>
                    @endif
                <p>{{{ $product -> name }}}</p>
                @if($product -> price)
                {!! Form::open(['url' => 'cart', 'style' => 'display:inline;']) !!}
                {!! Form::hidden('product_id', $product -> id) !!}
                <button type="submit" class="btn btn-default add-to-cart"> <i class="fa fa-shopping-cart"></i> {{{ ucfirst(Lang::get('fields.shop.buy_btn')) }}}</button>
                {!! Form::close() !!}
                @else
                <a href="{{{ url('shop/' . $product -> id) }}}" class="btn btn-default add-to-cart"><i class="fa fa-info"></i> {{{ ucfirst(Lang::get('fields.shop.info_btn')) }}}</a>
                @endif
            </div>
        </div>
    </div>
</div>