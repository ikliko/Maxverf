<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ProductSize extends Model
{
    protected $table = 'product_sizes';
    protected $hidden = [
        'promo_type'
    ];
    public static function rules($isUpdate = false, $key = null) {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'size' => 'max:255',
            'price' => 'required'
        ];
        if($isUpdate) $rules['id'] = 'required|exists:product_sizes,id';
        if($key) return $rules[$key];

        return $rules;
    }

    public static function messages($isUpdate = false, $key = null) {
        $messages = [
            'product_id.required' => 'Choose product please',
            'size.max' => 'Size length is too long',
            'price.required' => 'Enter price please',
        ];
        if($isUpdate) {
            $messages['id.required'] = 'id is required';
            $messages['id.exists'] = 'id is not exist';
        }
        if($key) return $messages[$key];
        return $messages;
    }

    public function product() {
        return $this -> belongsTo('App\Product', 'product_id');
    }

    public function colors() {
        return $this -> hasMany('App\ProductColor', 'size_id');
    }

    public function promoPrice($asString = true, $currency = null) {
        if( !$this -> price || !($this -> promo * 1)) return 0;
        if($this -> on_discount) return 1;
        if( !$currency ) $currency = 'eur';
        if( $asString ) {
            $price = $this -> promo_type ?
                number_format($this -> price - ($this -> price * ($this -> promo / 100)), 2) . config('shop.currency.' . $currency . '.symbol') :
                number_format($this -> price - $this -> promo, 2) . config('shop.currency.' . $currency . '.symbol');
        } else {
            $price = $this -> promo_type ?
                number_format($this -> price - ($this -> price * ($this -> promo / 100)), 2) :
                number_format($this -> price - $this -> promo, 2);
        }

        return $price;
    }

    public static function manage($data, $id = null) {
        if($id) $data['id'] = $id;
        $rules = $id ? self::rules(true) : self::rules();
        $messages = $id ? self::messages(true) : self::messages();
        $validator = Validator::make($data, $rules, $messages);

        if($validator -> fails()) {
            return [
                'error' => [
                    'type' => 'validation',
                    'messages' => $validator
                ]
            ];
        }

        try {
            $size = $id ? ProductSize::find($id) : new ProductSize();
            $size -> size = $data['size'];
            $size -> price = $data['price'];
            $size -> product_id = $data['product_id'];
            $size -> price = $data['price'];
            $size -> promo_type = $data['promo_type'];
            $size -> promo = $data['promo'];
            $promo = $data['promo'] + 0;
            if($promo) {
                $product = Product::findOrFail($data['product_id']);
                $product -> setOnPromo();
                var_dump($product);
            }
            $size -> save();
        } catch(\Exception $ex) {
            return [
                'error' => [
                    'type' => 'saving',
                    'messages' => $ex -> getMessage(),
                    'trace' => $ex -> getTraceAsString()
                ]
            ];
        }

        return [
            'error' => [
                'type' => 'no',
            ],
            'success' => 'You successfully added size'
        ];
    }
}