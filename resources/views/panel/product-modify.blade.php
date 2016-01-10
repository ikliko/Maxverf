@extends('panelViews::mainTemplate')
@section('page-wrapper')
<style>
    .clear {
        clear: both;
    }
</style>
<h1 class="text-center">{{{ $title }}}</h1>
<hr/>
{!! Form::open(['url' => $url, 'method' => $method, 'files' => true]) !!}
    <fieldset>
        <div class="form-group">
            {!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label text-right']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', isset($product) ? $product -> name : null, ['id' => 'name', 'placeholder' => 'Name', 'class'=> 'form-control']) !!}
            </div>
        </div>
        @if($errors -> first('name'))
        @include('sections.errors.alert', ['type' => 'danger', 'message' => $errors -> first('name')])
        @endif
        <div class="clear">&nbsp;</div>

        <div class="form-group">
            {!! Form::label('image', 'Image:', ['class' => 'col-lg-2 control-label text-right']) !!}
            <div class="col-lg-10">
                {!! Form::file('image', array('class' => 'form-control', 'id' => 'image')) !!}
            </div>
            @if($errors -> first('name'))
            @include('sections.errors.alert', ['type' => 'danger', 'message' => $errors -> first('name')])
            @endif
            @if(isset($product) && $product -> image_large)
            <div class="clear">&nbsp;</div>
            <img src="{{{ url($product -> image_large) }}}" alt="" class="col-lg-offset-2 col-lg-5"/>
            @endif
        </div>
        <div class="clear">&nbsp;</div>

        <div class="form-group">
            {!! Form::label('description', 'Description:', ['class' => 'col-lg-2 control-label text-right']) !!}
            <div class="col-sm-10">
                {!! Form::textarea('description', isset($product)? $product -> description : null, array('class' => 'form-control', 'id' => 'description', 'rows' => '13')) !!}
            </div>
            @if($errors -> first('name'))
            @include('sections.errors.alert', ['type' => 'danger', 'message' => $errors -> first('name')])
            @endif
        </div>
        <div class="clear">&nbsp;</div>

        <div class="form-group" ng-controller="introController">
            {!! Form::label('intro', 'Intro:', ['class' => 'col-lg-2 control-label text-right']) !!}
            <div class="col-lg-8">
                {!! Form::text('intro', isset($product) ? $product -> intro : '', ['id' => 'intro', 'placeholder' => 'Intro', 'class'=> 'form-control', 'maxlength' => '255']) !!}
            </div>
            <div class="col-lg-2 symbols-counter-msg"></div>
            @if($errors -> first('name'))
            @include('sections.errors.alert', ['type' => 'danger', 'message' => $errors -> first('name')])
            @endif
        </div>
        <div class="clear">&nbsp;</div>

        <div class="form-group">
            {!! Form::label('category_id', 'Category:', ['class' => 'col-lg-2 control-label text-right']) !!}
            <div class="col-lg-10">
                {!! Form::select('category_id', $categories, isset($product) && $product -> category ? $product -> category -> id : null, array('id' => 'category_id', 'class' => 'form-control')) !!}
            </div>
            @if($errors -> first('name'))
            @include('sections.errors.alert', ['type' => 'danger', 'message' => $errors -> first('name')])
            @endif
        </div>
        <div class="clear">&nbsp;</div>

        <div class="form-group price-elm price-container hidden"></div>
        <div class="clear price-elm hidden">&nbsp;</div>

        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                {!! Form::button('Reset', array('type' => 'reset','class' => 'btn btn-default')) !!}
                {!! Form::submit('Save', array('class' => 'btn btn-primary')) !!}
                <a class='btn btn-info pull-right btn-set-price'>add price(if no sizes)</a>
                {!! HTML::link('panel/products', 'go back', ['class' => 'btn btn-link pull-right']) !!}
            </div>
        </div>
    </fieldset>
{!! Form::close() !!}
<div class="clear">&nbsp;</div>
<script type="text/javascript" src="{{{ url('tinymce/js/tinymce/tinymce.min.js') }}}"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        templates: []
    });
    var isSetPrice = false;
    $('.btn-set-price').on('click', setPriceField);
    function setPriceField() {
        if(!isSetPrice) {
            var priceHTML = '<div class="form-group price-elm price-container "><label for="price" class="col-lg-2 control-label text-right">Price:</label><div class="col-lg-2"><input id="price" value="{{{ isset($product) && $product -> price? $product -> price : null }}}" placeholder="Price" class="form-control" name="price" type="text"></div><label for="promo_type" class="col-lg-2 control-label text-right">Type:</label><div class="col-lg-2"><select id="promo_type" class="form-control" name="promo_type"><option value="0" @if(isset($product) && !$product -> promo_type) selected="selected" @endif>price</option><option value="1" @if(isset($product) && $product -> promo_type) selected="selected" @endif>percents</option></select></div><label for="promo" class="col-lg-2 control-label text-right">Promo:</label><div class="col-lg-2"><input id="promo" value="{{{ isset($product) && $product -> promo ? $product -> promo : null }}}" class="form-control" name="promo" type="text"></div></div>';
            $('.price-elm').removeClass('hidden');
            $('.price-container').html(priceHTML);
            $('.btn-set-price').text('remove price field');
        } else {
            $('.price-container').html('');
            $('.price-elm').addClass('hidden');
            $('.btn-remove-price').addClass('btn-set-price').removeClass('btn-remove-price').text('add price(if no sizes)');
        }
        isSetPrice = !isSetPrice;
    }
    @if(isset($product) && $product -> price)
    setPriceField();
    @endif
    $('#intro').on('keydown', setSymbolsMessage);
    function setSymbolsMessage() {
        var text = 'symbols: ';
        text += $('#intro').val().length;
        text += ' out of 255';
        $('.symbols-counter-msg').text(text);
    }
    setSymbolsMessage();
</script>
@stop