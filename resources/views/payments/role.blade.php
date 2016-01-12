@extends('master')
@section('container')
    <div class="container margin-top">
        <div id="sing_form">
            <h2>SELECT ROLE FORM</h2>
            {!! Form::open(['url' => 'payments/method/role']) !!}
                <div id="top">
                    <button class="btn btn-primary" name="role" value="newUser">Register</button>
                    <span>or</span>
                </div>
                <div id="bottom">
                    <button class="btn btn-primary" name="role" value="guest">Order like guest</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop