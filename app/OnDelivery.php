<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use App\Order;

class OnDelivery extends Model
{
    public static function storeOrder($data, $isFirm = false) {
        $validator = Validator::make($data, Order::rules($isFirm), Order::messages($isFirm));
        if($validator -> fails()) {
            return [
                'error' => [
                    'type' => 'validation',
                    'messages' => $validator
                ]
            ];
        }
        $order = new Order();
        if($isFirm) {
            $order -> firm = $data['firm'];
            $order -> kvk = $data['kvk'];
            $order -> btw = $data['btw'];
        }
        $order -> first_name = $data['first_name'];
        $order -> last_name = $data['last_name'];
        $order -> email = $data['email'];
        $order -> phone = $data['phone'];
        $order -> city = $data['city'];
        $order -> address = $data['address'];
        $order -> comment = $data['comment'];
        $order -> save();

        $cartResponse = OrderProducts::storeOrderCart($order -> id);
        return $cartResponse;
    }
}
