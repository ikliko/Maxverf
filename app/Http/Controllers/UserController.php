<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Lang;

class UserController extends Controller {

    public function register() {
        return view('register');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $userResponse = User::register($request -> all());
        switch($userResponse['error']['type']) {
            case 'validation':
                return redirect() -> back() -> withInput() -> withErrors($userResponse['error']['messages']);
            case 'saving':
                flash() -> error($userResponse['error']['message']);
                return redirect() -> back() -> withInput();
            default:
                Auth::loginUsingId($userResponse['success']['data'] -> id);
                flash() -> success($userResponse['success']['message']);
                return redirect() -> to('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        if(!Auth::check()) return redirect() -> to('/login');

        return view('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        if(!Auth::check()) return redirect() -> to('/login');
        $updateResponse = Auth::user() -> edit($request -> all());
        switch($updateResponse['error']['type']) {
            case 'validation':
            case 'password':
                return redirect() -> back() -> withInput() -> withErrors($updateResponse['error']['messages']);
            case 'saving':
                flash() -> error($updateResponse['error']['message']);
                return redirect() -> back() -> withInput();
            default:
                flash() -> success($updateResponse['success']['message']);
                return redirect() -> back();
        }
    }

    public function login() {
        if(!Auth::check()) return view('login');

        return redirect() -> to('/profile/'  . Auth::user() -> id . '/edit');
    }

    public function doLogin(Request $request) {
        if(Auth::check()) return redirect() -> to('/login');
        $loginResponse = User::login($request -> all());
        switch($loginResponse['error']['type']) {
            case 'invalid':
                flash() -> warning($loginResponse['error']['message']);
                return redirect() -> back() -> withInput();
            default:
                flash() -> success($loginResponse['success']['message']);
                return redirect() -> to('/');
        }
    }

    public function logout() {
        if(!Auth::check()) return redirect() -> to('login');
        $logoutResponse = Auth::user() -> logout();
        switch($logoutResponse['error']['type']) {
            case 'logout':
                flash() -> error($logoutResponse['error']['message']);
                return redirect() -> to('/');
            default:
                flash() -> success($logoutResponse['success']['message']);
                return redirect() -> to('login');
        }
    }

    public function changePassword(Request $request) {
        if(!Auth::check()) return redirect() -> to('/login');
        $passwordChangeResponse = Auth::user() -> changePassword($request -> all());
        switch($passwordChangeResponse['error']['type']) {
            case 'validation':
            case 'password':
                return redirect() -> back() -> withErrors($passwordChangeResponse['error']['messages']);
            case 'saving':
                flash() -> error($passwordChangeResponse['error']['message']);
                return redirect() -> back();
            default:
                flash() -> success($passwordChangeResponse['success']['message']);
                return redirect() -> back();
        }
    }
}
