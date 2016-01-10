<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $table = 'orders';

    public static function rules($isFirm = false) {
        $rules = [
            'first_name' => 'required|alpha_dash|between:3,50',
            'last_name' => 'required|alpha|between:3,50',
            'email' => 'required|email|between:6,150',
            'phone' => 'required',
            'address' => 'required|between:4,255',
            'comment' => ''
        ];
        if($isFirm) {
            $rules['firm'] = 'required|between:3,255';
            $rules['kvk'] = 'required|between:3,255';
            $rules['btw'] = 'required|between:3,255';
        }
        return $rules;
    }

    public static function messages($isFirm = false) {
        $messages = [
            'first_name' => '',
            'firm' => '',
            'kvk' => '',
            'btw' => '',
            'last_name' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
            'comment' => ''
        ];
        return $messages;
    }

    public function products() {
        return $this -> hasMany('App\OrderProducts', 'order_id');
    }

    public function user() {
        return $this -> belongsTo('\App\User', 'user_id');
    }

    public function accept() {
        $this -> status = 1;
        $this -> save();
    }

    public function decline() {
        $this -> status = -1;
        $this -> save();
    }

    public function total() {
        $price = 0;
        foreach($this -> products as $product) {
            $price += $product -> current_price;
        }
        return $price;
    }
}
