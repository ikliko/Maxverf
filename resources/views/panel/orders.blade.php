@extends('panelViews::mainTemplate')
@section('page-wrapper')
<style>
    .clear {
        clear: both;
    }
    .bold {
        font-weight: bold;
    }
</style>
<h2 class="text-center">Orders</h2>
<div class="clear">&nbsp;</div>
@if($allBtn)
<a href="{{{ url('panel/Orders/all') }}}" class="btn btn-primary btn-sm">All</a>
@endif
@if($pendingBtn)
<a href="{{{ url('panel/Orders') }}}" class="btn btn-default btn-sm">Pending</a>
@endif
@if($acceptedBtn)
<a href="{{{ url('panel/Orders/accepted') }}}" class="btn btn-success btn-sm">Accepted</a>
@endif
@if($declinedBtn)
<a href="{{{ url('panel/Orders/declined') }}}" class="btn btn-danger btn-sm">Declined</a>
@endif
<hr/>
@if(isset($table) && count($table))
<table class="table table-striped table-hover ">
    <thead>
    <tr>
        <th>ID</th>
        <th>First name</th>
        <th>Firm</th>
        <th>Address</th>
        <th>Comment</th>
        <th>Price</th>
        <th>Options</th>
    </tr>
    </thead>
    <tbody>
    @foreach($table as $order)
    <tr>
        <td>{{{ $order -> id }}}</td>
        <td>{{{ $order -> first_name }}}</td>
        <td>{{{ $order -> firm }}}</td>
        <td>{{{ $order -> address }}}</td>
        <td>{{{ $order -> comment }}}</td>
        <td>{{{ number_format($order -> total(), 2) . ' ' . config('shop.currency.eur.symbol') }}}</td>
        <td>
            <a title="Show" href="{{{ url('panel/Orders/' . $order -> id) }}}"><span class="glyphicon glyphicon-list-alt"> </span></a>
            <a class="text-warning" title="Modify" href="{{{ url('panel/Orders/' . $order -> id . '/edit') }}}"><span class="fa fa-edit"> </span></a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
<label>{{{ isset($noRecordsMessage) ? $noRecordsMessage :   'No records' }}}</label>
@endif
@stop