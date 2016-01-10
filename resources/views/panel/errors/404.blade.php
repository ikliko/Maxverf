@extends('panelViews::mainTemplate')
@section('page-wrapper')
<style>
    .text-panel,
    .text-panel:active,
    .text-panel:hover,
    .text-panel:focus{
        border: none;
        box-shadow: none;
        border-radius: 0;
    }
</style>
<h1 class="text-center">Error 404: {{{ isset($message) ? $message : 'Page was not found'  }}}</h1>
@if(isset($links))
@foreach($links as $link)
<h3>
    @if($link['url'])
    <a href="{{{ url($link['url']) }}}" class="btn btn-link">{{{ $link['text'] }}}</a>
    @else
    <p class="btn text-panel" style="cursor: auto;">{{{ $link['text'] }}}</p>
    @endif
</h3>
@endforeach
@endif
@stop