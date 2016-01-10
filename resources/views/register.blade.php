@extends('master')
@section('container')
<div class="container margin-top">
    <section id="sing_form">
        <h2>{{{ ucfirst(Lang::get('fields.register.title')) }}}</h2>

        {!! Form::open() !!}
        <div class="form-group">
            <label for="Email">@lang('fields.register.email.label'):</label>
            <input type="text" class="form-control" id="Email" placeholder="@lang('fields.register.email.placeholder')">
        </div>

        <div class="form-group">
            <label for="accountType" class="radio-block">{{{ ucfirst(Lang::get('fields.register.account_type.label')) }}}:</label>
            <div class="radio-inline">
                <label>
                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="1">
                    {{{ ucfirst(Lang::get('fields.register.account_type.radio.firm')) }}}
                </label>
            </div>
            <div class="radio-inline">
                <label>
                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="0">
                    {{{ ucfirst(Lang::get('fields.register.account_type.radio.personal')) }}}
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="Password">{{{ ucfirst(Lang::get('fields.register.password.label')) }}}:</label>
            <input type="password" class="form-control" id="Password" placeholder="{{{ ucfirst(Lang::get('fields.register.password.placeholder')) }}}">
        </div>

        <div class="form-group">
            <label for="RepeatPassword">{{{ ucfirst(Lang::get('fields.register.confirm_password.label')) }}}:</label>
            <input type="password" class="form-control" id="RepeatPassword" placeholder="{{{ ucfirst(Lang::get('fields.register.confirm_password.placeholder')) }}}">
        </div>

        <div class="text-center">
            <button class="btn btn-primary">{{{ strtoupper(Lang::get('fields.register.confirm_btn')) }}}</button>
        </div>

        {!! Form::close() !!}
    </section>
</div>
@stop