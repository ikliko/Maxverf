@extends('layouts.default')
@section('body')
<div class="col-lg-offset-3 col-lg-6">
    @include('flash::message')
</div>
<div id="wrapper">
    <header id="header"><!--header-->
        <div class="header_top"><!--header_top-->
            <div class="container">
                <div class="row">

                    <div class="pull-left phone hidden-xs">
					   
					   <i class="fa fa-phone"></i> + 31 75 615 2379, <i class="fa fa-mobile"></i> +316 11 53 03 53
					
                    </div>
					
					<div class="dropdown lang-dropdown">
					  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{{ Session::get('lang', 'nl') }}}
					  <span class="fa fa-angle-down"></span></button>
					  <ul class="dropdown-menu dropdown-right">
						<li><a href="{{{ url('lang/nl') }}}">NL</a></li>
						<li><a href="{{{ url('lang/en') }}}">EN</a></li>
					  </ul>
					</div>	
					
					<ul class="user-buttons">
					   <li><a href="{{{ url('login') }}}">@lang('fields.login.title')</a></li>
					   <li><a href="{{{ url('register') }}}">@lang('fields.register.title')</a></li>
					</ul>
	
                </div>
            </div>
        </div>
        <!--/header_top-->

        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">

                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href="{{{ url() }}}"><img src="{{{ url(config('panel.logo')) }}}" alt=""/></a>
                        </div>
                    </div>

                    <div class="col-sm-4 col-xs-12 no-padding" ng-controller="searchController">
                        <form>
                            <div class="input-group stylish-input-group">
                                <input type="text" class="form-control" placeholder="{{{ ucfirst(Lang::get('fields.search.placeholder')) }}}"  ng-model="searchInput" ng-change="searchQuery(searchInput)">
								<span class="input-group-addon" style="padding: 0;">
									<button type="submit" type="button" class="btn btn-search"><span
                                            class="fa fa-search"></span></button>
								</span>
                            </div>
                        </form>

                        <div class="searchCustomResults" ng-show="hasResults && searchInput">
                            <ul>
                                <li ng-repeat="result in searchResults.data">
                                    <a href="<% result.url %>">
                                        <img src="<% result.picture %>" alt="" class="col-lg-2 col-md-2 col-sm-1 col-xs-2"/><% result.name %>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-sm-3 col-xs-5 pull-right no-padding shop-cart">

                        <div class="col-lg-5 col-md-5 col-xs-6  pull-right no-padding text-center">
                            <p>@lang('fields.cart.title'): <a href="{{{ url('cart') }}}" >{{{ number_format(Cart::instance('shopping') -> total(), 2) . (Session::get('lang', 'nl') == 'nl' ?  config('shop.currency.eur.symbol') : config('shop.currency.usd.symbol')) }}}</a></p>
                        </div>

                        <div class="col-lg-2 col-md-3 col-xs-6  pull-right no-padding shoping-cart">
                            <a href="{{{ url('cart') }}}" class="btn btn-cart">
                                <div class="cart-numer">{{{ Cart::instance('shopping') -> count() }}}</div>
                            </a>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <!--/header-middle-->

        <div class="header-bottom" style="position: relative;"><!--header-bottom-->
            <div class="container">
                
				
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                    data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li class="hidden-xs">
                                    <a href="{{{ url() }}}" @if(isset($current) && $current === '/') class="active" @endif><i class="fa fa-home"></i></a>
                                </li>
                                <li class="hidden-lg hidden-md hidden-sm">
                                    <a href="{{{ url() }}}" @if(isset($current) && $current === '/') class="active" @endif>@lang('fields.menu.index')</a>
                                </li>
                                <li>
                                    <a href="{{{ url('shop') }}}" @if(isset($current) && $current === 'shop') class="active" @endif>@lang('fields.menu.shop')</a>
                                </li>
                                <li>
                                    <a href="{{{ url('promo') }}}" @if(isset($current) && $current === 'promo') class="active" @endif>@lang('fields.menu.promotions')</a>
                                </li>
                                <li>
                                    <a href="{{{ url('new') }}}" @if(isset($current) && $current === 'new') class="active" @endif>@lang('fields.menu.news')</a>
                                </li>
								<li>
                                    <a href="{{{ url('conditional-terms') }}}" @if(isset($current) && $current === 'conditional-terms') class="active" @endif>@lang('fields.menu.conditional_terms')</a>
                                </li>
                            </ul>
                        </div>
                  
            </div>
        </div>
        <!--/header-bottom-->
    </header>
    <!--/header-->
    @yield('container')
    <footer id="footer"><!--Footer-->

        <div class="footer-top">
            <div class="container">

                <div class="col-md-16 col-sm-2 col-xs-6">
                    <img src="{{{ asset('images/parthners/anza.png') }}}"/>
                </div>

                <div class="col-md-16 col-sm-2 col-xs-6">
                    <img src="{{{ asset('images/parthners/ceresit.png') }}}"/>
                </div>

                <div class="col-md-16 col-sm-2 col-xs-6">
                    <img src="{{{ asset('images/parthners/deko.png') }}}"/>
                </div>

                <div class="col-md-16 col-sm-2 col-xs-6">
                    <img src="{{{ asset('images/parthners/expert.png') }}}"/>
                </div>

                <div class="col-md-16 col-sm-2 col-xs-6">
                    <img src="{{{ asset('images/parthners/knauf.png') }}}"/>
                </div>

                <div class="col-md-16 col-sm-2 col-xs-6">
                    <img src="{{{ asset('images/parthners/leko.png') }}}"/>
                </div>
				
                <div class="col-md-16 col-sm-2 col-xs-6">
                    <img src="{{{ asset('images/parthners/orgachim.png') }}}"/>
                </div>

            </div>
        </div>


        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="text-center">© {{{ date('Y') }}} {{{ str_replace('http://', '', url()) }}}. {{{ ucfirst(Lang::get('fields.copyright')) }}}</p>
					<p class="text-center"><a href="https://www.facebook.com/MAX-Verfgroothandel-BV-373874569469017/" class="btn-social" target="_blank"><i class="fa fa-facebook"></i></a></p>
                </div>
            </div>
        </div>

    </footer>
    <!--/Footer-->
</div>
@stop