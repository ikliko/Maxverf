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
<h2 class="text-center">Colors (Products)</h2>
{!! HTML::link('/panel/products/colors/create', 'Add', ['class' => 'btn btn-primary btn-sm pull-right']) !!}
<div class="clear">&nbsp;</div>
<hr/>
@if(isset($table) && count($table))
<table class="table table-striped table-hover ">
    <thead>
    <tr>
        <th>ID</th>
        <th>Color</th>
        <th>Product/size</th>
        <th>Options</th>
    </tr>
    </thead>
    <tbody>
    @foreach($table as $color)
    <tr>
        <td>{{{ $color -> id }}}</td>
        <td>{{{ $color -> color }}}</td>
        <td>{!! $color -> product ? '<span class="bold">Product:</span> ' . $color -> product -> name : '<span class="bold">Size:</span> ' . $color -> size -> size . ' of <span class="bold">product</span> ' . $color -> size -> product -> name !!}</td>
        <td>
            <div>
                <a title="Show" href="" class="hidden"><span class="glyphicon glyphicon-list-alt"> </span></a>
                <a class="text-warning" title="Modify" href="{{{ url('panel/products/colors/' . $color -> id . '/edit') }}}"><span class="fa fa-edit"> </span></a>
                <a class="delete text-danger" title="Delete" data-id=""><span class="glyphicon glyphicon-trash"> </span></a>
            </div>
            <div class="hidden">
                {!! Form::open(array('url' => 'panel/products/colors/' . $color -> id, 'method' => 'delete')) !!}
                <p>Are you sure you want to delete category "{{{ $color -> name  }}}"?</p>
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
No products added yet.
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