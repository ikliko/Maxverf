@extends('master')
@section('container')
<div class="container margin-top">
    <section id="sing_form">
        <h2>@lang('fields.login.title')</h2>

        {!! Form::open() !!}

        <div class="form-group">
            <label for="Email">@lang('fields.login.email.label'):</label>
            <input type="text" class="form-control" id="Email" placeholder="@lang('fields.login.email.placeholder')">
        </div>
        <div class="form-group">
            <label for="Password">@lang('fields.login.password.label'):</label>
            <input type="password" class="form-control" id="Password" placeholder="@lang('fields.login.password.placeholder')">
        </div>


        <div class="text-center">
            <button class="btn btn-primary">@lang('fields.login.submit_btn')</button>
        </div>

        {!! Form::close() !!}

    </section>
</div>
@stop