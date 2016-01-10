@extends('panelViews::mainTemplate')
@section('page-wrapper')
<style>
    .clear {
        clear: both;
    }
</style>
@if(Session::has('success'))
<div class="col-lg-offset-2 col-lg-8 line">
    <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{{ Session::get('success') }}}
    </div>
</div>
@endif
<div class="clear">&nbsp;</div>
<h1 class="text-center">{{{ isset($category)? $title . ': ' . $category -> title : $title }}}</h1>
<a href="{{{ url('/panel/products/categories/new/general') }}}" class="btn btn-{{{ isset($current) && $current == 'general' ? 'primary' : 'default' }}}">General</a>
<a href="{{{ url('/panel/products/categories/new/translation') }}}" class="btn btn-{{{ isset($current) && $current == 'translations' ? 'primary' : 'default' }}}">Translations</a>
<a href="{{{ url('/panel/products/categories/new/options') }}}" class="btn btn-{{{ isset($current) && $current == 'options' ? 'primary' : 'default' }}}">Options</a>
<hr/>
@yield('form')
@stop