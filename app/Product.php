<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Image;

class Product extends Model
{
    protected $table = 'products';

    public static function rules($isUpdate = false, $key = null) {
        $rules = [
            'category_id' => 'required|regex:/[^0\sa-zA-Z]/',
            'name' => 'required|between:3,255',
            'image' => 'required',
            'intro' => 'required|max:255',
            'description' => 'required',
        ];
        if($isUpdate) {
            $rules['id'] = 'required';
            unset($rules['image']);
        }
        if($key) return $rules[$key];

        return $rules;
    }

    public static function messages($isUpdate = false, $key = null) {
        $messages = [
            'name.required' => 'Product name is required',
            'name.between' => 'Product name length between 3 and 255 symbols',
            'intro.required' => 'Product intro is required',
            'description.required' => 'Product description is required',
            'category_id.required' => 'Category is required',
            'category_id.regex' => 'Category is invalid',
        ];
        if($isUpdate) $messages['id.required'] = 'Invalid product';
        if($key) return $messages[$key];

        return $messages;
    }

    public function sizes() {
        return $this -> hasMany('App\ProductSize', 'product_id');
    }

    public function colors() {
        return $this -> hasMany('App\ProductColor', 'product_id');
    }

    public function category() {
        return $this -> belongsTo('App\ProductsCategory', 'category_id');
    }

    public function promoPrice($asString = true, $currency = null) {
        if(!$this -> on_discount) return 0;
        if( !$currency ) $currency = 'eur';
        if( $asString ) {
            $price = $this -> promo_type ?
                number_format($this -> price - ($this -> price * ($this -> promo / 100)), 2 , '.', '') . config('shop.currency.' . $currency . '.symbol') :
                number_format($this -> price - $this -> promo, 2 , '.', '') . config('shop.currency.' . $currency . '.symbol');
        } else {
            $price = $this -> promo_type ?
                number_format($this -> price - ($this -> price * ($this -> promo / 100)), 2 , '.', '') :
                number_format($this -> price - $this -> promo, 2 , '.', '');
        }

        return $price;
    }

    public function priceNoVat($string = true) {
        return $string ? number_format($this -> price / 1.21, 2 , '.', '') . config('shop.currency.eur.symbol') : number_format($this -> price / 1.21, 2 , '.', '');
    }

    public function promoNoVat($asString = true, $currency = null) {
        if(!$currency) $currency = 'eur';
        $price = number_format($this -> promoPrice(false) / 1.21, 2 , '.', '');
        if($asString) $price .= config('shop.currency.' . $currency . '.symbol');
        return $price;
    }

    public function setOnPromo() {
        $this -> on_discount = 1;
        $this -> save();
    }

    public function removeOnPromo() {
        $this -> on_discount = 0;
        $this -> save();
    }

    public function currentPrice($asString = false, $currency = 'eur') {
        $symbol = config('shop.currency.' . $currency . '.symbol');
        if(!$asString) $symbol = '';
        return $this -> on_discount ? $this -> promoPrice($asString) : number_format($this -> price, 2 , '.', '') . $symbol;
    }

    public function currentPriceNoVat($asString = true, $currency = 'eur') {
        return $this -> on_discount ? $this -> promoNoVat($asString) : $this -> priceNoVat(0) . config('shop.currency.' . $currency . '.symbol');
    }

    public static function onDiscount() {
        return Product::where('on_discount', '<>', 0) -> get();
    }

    public static function onDiscountPaginate($perPage = 12) {
        return Product::where('on_discount', '<>', 0) -> paginate($perPage);
    }

    public static function latest($count = 9) {
        return Product::orderBy('created_at', 'desc') -> get() -> take($count);
    }

    private static function saveImage($image, $width, $height, $picSize, $quality = 90) {
        $filename  = time() . '.' . $image -> getClientOriginalExtension();
        $path = 'uploads/images/products/' . $picSize . '/' . $filename;
        $path = str_replace('public', 'public_html', $path); // in production
        Image::make( $image )
            -> resize($width, $height)
            -> save($path, $quality);

        return $path;
    }

    public static function manage($data, $id = null) {
        if($id) $data['id'] = $id;
        $validator = Validator::make(
            $data,
            $id ? self::rules(true) : self::rules(),
            $id ? self::messages(true) : self::messages()
        );
        if($validator -> fails()) {
            return [
                'error' => [
                    'code' => 1,
                    'type' => 'validation',
                    'messages' => $validator
                ]
            ];
        }
        $product = $id ? Product::find($id) : new Product();
        if($id && !$product) {
            return [
                'error' => [
                    'code' => 1,
                    'type' => 'existing',
                    'messages' => 'Product does not exist'
                ]
            ];
        }
        $product -> name = $data['name'];
        $product -> category_id = $data['category_id'];
        $product -> description = $data['description'];
        $product -> intro = $data['intro'];
        $image = array_key_exists('image', $data) ? $data['image'] : null;
        if($image) {
            if($product -> image_large) {
                Image::make($product -> image_large) -> destroy();
                Image::make($product -> image_normal) -> destroy();
            }
            $product -> image_large = self::saveImage($image, 327, 378, 'lg');
            $product -> image_normal = self::saveImage($image, 255, 230, 'nm');
        }
        if(array_key_exists('price', $data)) $product -> price = $data['price'];
        if(array_key_exists('promo_type', $data)) $product -> promo_type = $data['promo_type'];
        if(array_key_exists('promo', $data)) $product -> promo = $data['promo'];
        if(array_key_exists('promo', $data) && $data['promo'] + 0) $product -> on_discount = 1;
        $product -> save();

        return [
            'error' => [
                'code' => 0,
                'type' => 'no'
            ],
            'success' => 'You created product "' . $product -> name . '" successfully'
        ];
    }
}
