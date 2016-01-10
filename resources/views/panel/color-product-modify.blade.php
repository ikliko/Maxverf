@extends('panelViews::mainTemplate')
@section('page-wrapper')
<style>
    .clear {
        clear: both;
    }
</style>

<h1 class="text-center">{!! $title !!}</h1>
<hr/>
{!! Form::open(['url' => $url, 'method' => $method, 'files' => true]) !!}
<fieldset>
    <div class="form-group">
        {!! Form::label('color', 'Color:', ['class' => 'col-lg-2 control-label text-right']) !!}
        <div class="col-lg-10">
            {!! Form::text('color', isset($color) ? $color -> color : null, array('class' => 'form-control form-control colorpicker-element', 'id' => 'inputColor')) !!}
        </div>
    </div>
    <div class="clear">&nbsp;</div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <a id="addProduct" class="btn btn-default">Add Product</a>
            or
            <a id="addSize" class="btn btn-default">Add Size</a>
        </div>
    </div>
    <div class="clear">&nbsp;</div>

    <div class="form-group choosen-elm-box hidden">
        {!! Form::label('product_id', 'Product:', ['id' => 'choosen-elm-label', 'class' => 'col-lg-2 control-label text-right']) !!}
        <div class="col-lg-10 choosen-elm-select">

        </div>
    </div>
    <div class="clear choosen-elm-box hidden">&nbsp;</div>

    <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
            {!! Form::button('Reset', array('type' => 'reset','class' => 'btn btn-default')) !!}
            {!! Form::submit('Save', array('class' => 'btn btn-primary')) !!}
            {!! HTML::link('panel/products/colors', 'go back', ['class' => 'btn btn-link pull-right']) !!}
        </div>
    </div>
</fieldset>
{!! Form::close() !!}
<div class="clear">&nbsp;</div>
<script src="{{{ url('packages/zofe/rapyd/assets/colorpicker/js/bootstrap-colorpicker.min.js') }}}"></script>
<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $('#inputColor').colorpicker({
            format: 'hex'
        });
        $('#addProduct').on('click', initProducts);
        function initProducts() {
            var products = '<select id="product_id" class="form-control" name="product_id">';
            @foreach($products as $key => $product)
            products += '<option value="{{{ $key }}}" @if(isset($color) && $color -> product && $key == $color -> product -> id) {{{ 'selected'}}} @endif>{{{ $product }}}</option>'
            @endforeach
            products += '</select>';
            var label = {
                forElm: 'product_id',
                title: 'Product:'
            };
            addElement(label, products);
        }
        $('#addSize').on('click', initSizes);
        function addElement(label, selectHTML) {
            $('#choosen-elm-label').attr('for', label.forElm).text(label.title);
            $('.choosen-elm-box').removeClass('hidden');
            $('.choosen-elm-select').html(selectHTML);
        }

        function initSizes() {
            var sizes = '<select id="size_id" class="form-control" name="size_id">';
            @foreach($sizes as $key => $size)
            sizes += '<option value="{{{ $key }}}" @if(isset($color) && $color -> size && $key == $color -> size -> id) {{{ 'selected'}}} @endif>{{{ $size }}}</option>'
            @endforeach
            sizes += '</select>';
            var label = {
                forElm: 'product_id',
                title: 'Sizes:'
            };
            addElement(label, sizes);
        }
        (function() {
            var init = '';
            @if(isset($color) && $color -> product)
            init = '{{{ 'initProducts' }}}';
            @elseif(isset($color) && $color -> size)
            init = '{{{ 'initSizes' }}}';
            @else
            init = '';
            @endif
            switch (init) {
                case'initProducts': initProducts();
                    break;
                case 'initSizes': initSizes();
                    break;
                default:
                    break;
            }
        })();
    });
</script>
<div class="colorpicker dropdown-menu colorpicker-hidden">
    <div class="colorpicker-saturation" style="background-color: rgb(0, 0, 0);"><i style="top: 100px; left: 0px;"><b></b></i></div>
    <div class="colorpicker-hue"><i style="top: 100px;"></i></div>
    <div class="colorpicker-alpha" style="background-color: rgb(0, 0, 0);"><i style="top: 0px;"></i></div>
    <div class="colorpicker-color" style="background-color: rgb(0, 0, 0);">
        <div style="background-color: rgb(0, 0, 0);"></div>
    </div>
</div>
@stop