<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model {
    protected $table = 'product_colors';

    public $rules = [
        'product_id' => '',
        'size_id' => '',
        'color' => 'required|regex:/\#[a-fA-F0-9]{6}/',
    ];

    public function messages($key = null) {
        $messages = [
            'color.required' => 'Choose color please',
            'color.regex' => 'Invalid color',
        ];
        if($key) return $messages[$key];
        return $messages;
    }

    public function size() {
        return $this -> belongsTo('App\ProductSize', 'size_id');
    }

    public function product() {
        return $this -> belongsTo('App\Product', 'product_id');
    }
}