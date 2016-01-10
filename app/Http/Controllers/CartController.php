<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductColor;
use App\ProductSize;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('cart');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $request -> all();
        $product = Product::find($data['product_id']);
        if(!$product) return redirect() -> back();//exc.: no exist product
        if(!$product -> price && !array_key_exists('size_id', $data)) return redirect() -> back();//exc. no size selected
        if($product -> price && count($product -> colors) && !array_key_exists('color_id', $data)) return redirect() -> back(); //exc. no color selected

        $options = [
            'discount' => 0,
            'product' => $product
        ];

        if(count($product -> colors)) {
            $color = ProductColor::find($data['color_id']);
            if(!$color) return redirect() -> back(); //exc. no exist color echo 'error no exist color'; //
            $options['color'] = $color;
        }

        if(count($product -> sizes)) {
            $size = ProductSize::find($data['size_id']);
            if(!$size) return redirect() -> back(); //exc. no exist size echo 'error no exist size'; //
            $options['size'] = $size;

            if(count($size -> colors)) {
                if(!array_key_exists('color_id', $data)) return redirect() -> back(); //exc. no color selected
                $color = ProductColor::find($data['color_id']);
                if(!$color) return redirect() -> back(); //exc. no exist color echo 'error no exist color in size'; //
                $options['color'] = $color;
            }
        }

        if(isset($size)) $options['size'] = $size;
        if(isset($color)) $options['color'] = $color;
        if($product -> promoPrice()+0){
            $options['discount'] = $product -> promo;
            $options['discount_type'] = $product -> promo_type;
        }
        $price = $product -> currentPrice(0);

        Cart::instance('shopping')
            ->add(
                $product -> id,
                $product -> name,
                array_key_exists('qty', $data) ? $data['qty'] : 1,
                $price,
                $options
            );

        return redirect() -> back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rowId) {
        $data = $request -> all();
        $rules = [
            'newQty' => 'required|integer'
        ];
        $messages = [
            'newQty.required' => 'Please enter number',
            'newQty.integer' => 'Please enter number',
        ];
        $validator = \Validator::make($data, $rules, $messages);

        if($validator -> fails()) return redirect() -> back() -> withInput() -> withErrors($validator);
        Cart::instance('shopping') -> update($rowId, $data['newQty']);

        return redirect() -> back() -> with('responseMsg', 'Cart Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        Cart::instance('shopping') -> remove($rowId);
        return redirect() -> back();
    }
}
