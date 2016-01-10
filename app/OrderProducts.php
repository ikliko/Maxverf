<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cart;
use Auth;

class OrderProducts extends Model
{
    protected $table = 'orderproducts';

    public static $rules = [
        'user_id' => '',
        'order_id' => 'required',
        'product_id' => 'required',
        'current_price' => 'required',
        'discount' => '',
    ];

    public static function messages() {
        $messages = [
            'order_id.required' => '',
            'product_id.required' => '',
            'current_price.required' => '',
        ];
        return $messages;
    }

    public function order() {
        return $this -> belongsTo('\App\Order', 'order_id');
    }

    public function product() {
        return $this -> belongsTo('\App\Product', 'product_id');
    }

    public function size() {
        return $this -> belongsTo('\App\ProductSize', 'size_id');
    }

    public function color() {
        return $this -> belongsTo('\App\ProductColor', 'color_id');
    }

    public static function storeOrderCart($orderId) {
        $cart = Cart::instance('shopping') -> content();
        foreach($cart as $product) {
            $newRecord = new OrderProducts();
            if(Auth::check()) $newRecord -> user_id = Auth::user() -> id;
            $newRecord -> order_id = $orderId;
            $newRecord -> product_id = $product -> id;
            $newRecord -> current_price = $product -> price;
            $newRecord -> count = $product -> qty;
            $newRecord -> discount = $product -> options -> discount;
            $newRecord -> discount_type = $product -> options -> discount_type;
            if($product -> options -> size) $newRecord -> size_id = $product -> options -> size -> id;
            if($product -> options -> color) $newRecord -> color_id = $product -> options -> color -> id;
            $newRecord -> save();
        }

        Cart::instance('shopping') -> destroy();

        return [
            'error' => [
                'type' => 'none'
            ],
            'success' => 'Your order was successfully stored'
        ];
    }
}
