@extends('panelViews::mainTemplate')
@section('page-wrapper')
<style>
    .clear {
        clear: both;
    }
</style>
<h2 class="text-center">Products categories</h2>
{!! HTML::link('/panel/products/categories/create', 'Add', ['class' => 'btn btn-primary btn-sm pull-right']) !!}
<div class="clear">&nbsp;</div>
<hr/>
@if(isset($table) && count($table))
<table class="table table-striped table-hover ">
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Tree</th>
        <th>Options</th>
    </tr>
    </thead>
    <tbody>
    @foreach($table as $key => $category)
    <tr>
        <td>{{{ $key }}}</td>
        <td>{{{ $category['title'] }}}</td>
        <td>{{{ $category['tree'] }}}</td>
        <td>
            <div>
                <a title="Show" href="" class="hidden"><span class="glyphicon glyphicon-list-alt"> </span></a>
                <a class="text-warning" title="Modify" href="{{{ url('panel/products/categories/' . $key . '/edit') }}}"><span class="fa fa-edit"> </span></a>
                <a class="delete text-danger" title="Delete" data-id=""><span class="glyphicon glyphicon-trash"> </span></a>
            </div>
            <div class="hidden">
                {!! Form::open(array('url' => 'panel/products/categories/' . $key, 'method' => 'delete')) !!}
                <p>Are you sure you want to delete category "{{{ $category['title'] }}}"?</p>
                {!! Form::button('Не', array('class' => 'btn btn-default btn-sm cancel')) !!}
                {!! Form::submit('Да', array('class' => 'btn btn-primary btn-sm')) !!}
                {!! Form::close() !!}
            </div>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
No categories added.
@endif
<script>
    $('.delete').on('click', function(evt) {
        var parent = evt.currentTarget.parentElement,
            nextElement = parent.nextElementSibling;
        $(parent).addClass('hidden');
        $(nextElement).removeClass('hidden');
    });

    $('.cancel').on('click', function(evt) {
        var parent = evt.currentTarget.parentElement.parentElement,
            nextElement = parent.previousElementSibling;
        $(parent).addClass('hidden');
        $(nextElement).removeClass('hidden');
    });
</script>
@stop