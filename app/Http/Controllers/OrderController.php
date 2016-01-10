<?php

namespace App\Http\Controllers;

use App\OnDelivery;
use App\Order;
use App\OrderProducts;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cart;
use Illuminate\Http\Response;
use Input;
use Auth;
use Session;

class OrderController extends Controller
{
    private function orderPageData($current, $allBtn = false, $pendingBtn = false, $accBtn = false, $decBtn = false) {
        return [
            'current' => $current,
            'allBtn' => $allBtn,
            'pendingBtn' => $pendingBtn,
            'acceptedBtn' => $accBtn,
            'declinedBtn' => $decBtn
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $orders = Order::where('status', '=', '0') -> get();
        $pageData = self::orderPageData('pending', 1, 0, 1, 1);
        $pageData['table'] = $orders;
        return view('panel.orders', $pageData);
    }

    public function getAll() {
        $orders = Order::all();
        $pageData = self::orderPageData('pending', 0, 1, 1, 1);
        $pageData['table'] = $orders;
        return view('panel.orders', $pageData);
    }

    public function getAccepted() {
        $orders = Order::whereStatus(1) -> get();
        $pageData = self::orderPageData('pending', 1, 1, 0, 1);
        $pageData['table'] = $orders;
        return view('panel.orders', $pageData);
    }

    public function getDeclined() {
        $orders = Order::whereStatus(-1) -> get();
        $pageData = self::orderPageData('pending', 1, 1, 1, 0);
        $pageData['table'] = $orders;
        return view('panel.orders', $pageData);
    }

    public function selectPayment() {
        if(!Cart::instance('shopping') -> count()) return redirect() -> to('shop');

        $isLogged = Auth::check();
        if($isLogged) Session::put('userType', 'authUser');

        $hasUserType = Session::get('userType', null);
        if(!$hasUserType) {
            //redirect to choose type
        }

        if($hasUserType === 'newUser') return redirect() -> to('register');

        return view('payments.select');
    }

    public function storeOnDelivery(Request $request) {
        if(!Cart::instance('shopping') -> count()) return redirect() -> to('cart');
        $orderResponse = OnDelivery::storeOrder($request -> all());
        if($orderResponse['error']['code']) {
            switch($orderResponse['error']['type']) {
                case 'validation':
                    return redirect() -> back() -> withInput() -> withErrors($orderResponse['error']['messages']);
            }
        }
        Cart::instance('shopping') -> destroy();
        return redirect() -> back();
    }

    public function storeOnDeliveryFirm(Request $request) {
        if(!Cart::instance('shopping') -> count()) return redirect() -> to('cart');
        $orderResponse = OnDelivery::storeOrder($request -> all(), true);
//        var_dump($orderResponse['error']['messages'] -> errors());
        switch($orderResponse['error']['type']) {
            case 'validation':
                return redirect() -> back() -> withInput() -> withErrors($orderResponse['error']['messages']);
            default:
                flash($orderResponse['success']);
                return redirect() -> back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
//        var_dump($order);
        return view('panel.order', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $order = Order::findOrFail($id);
        return view('panel.order', [
            'order' => $order,
            'isEdit' => 1
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function acceptOrder($id) {
        $order = Order::findOrFail($id);
        $order -> accept();
        return redirect() -> to('panel/Orders');
    }

    public function declineOrder($id) {
        $order = Order::findOrFail($id);
        $order -> decline();
        return redirect() -> to('panel/Orders');
    }

    public function saveOrder(Request $request) {

    }
}
