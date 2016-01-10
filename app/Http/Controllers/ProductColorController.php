<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductColor;
use App\ProductsCategory;
use App\ProductSize;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Validator;
use Input;

class ProductColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $colors = ProductColor::all();
        return view('panel.colors-products-table', [
            'table' => $colors
        ]);
    }

    private function getProductsAsArray() {
        $products = Product::where('price', '>', 0) -> get();
        $arr = [
            'no product selected'
        ];
        foreach($products as $product) {
            $arr[$product -> id] = $product -> name;
        }
        return $arr;
    }

    private function getSizessAsArray() {
        $sizes = ProductSize::all();
        $arr = [
            'no size selected'
        ];
        foreach($sizes as $size) {
            $arr[$size -> id] = $size -> size . ' of product ' . $size -> product -> name;
        }
        return $arr;
    }

    private function getPageData($title, $url, $method = 'POST') {
        $products = self::getProductsAsArray();
        $categories = self::getSizessAsArray();
        return [
            'title' => $title,
            'url' => $url,
            'method' => $method,
            'products' => $products,
            'sizes' => $categories
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $pageData = self::getPageData('Create color', 'panel/products/colors');
        return view('panel.color-product-modify', $pageData);
    }

    public function saveColor($data, $id = null) {
        if($id) $color = ProductColor::find($id);
        else $color = new ProductColor();
        $color -> color = $data['color'];
        if(array_key_exists('product_id', $data)) $color -> product_id = $data['product_id'];
        if(array_key_exists('size_id', $data)) $color -> size_id = $data['size_id'];
        $color -> save();
        return 0;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $data = Input::all();
        $color = new ProductColor();
        $validator = Validator::make($data, $color -> rules, $color -> messages());
        if($validator -> fails()) return redirect() -> back() -> withInput() -> withErrors($validator);
        if(!(array_key_exists('product_id', $data) ^ array_key_exists('size_id', $data))) return redirect() -> back() -> withInput();
        self::saveColor($data);
        return redirect() -> back();
    }

    private function isColorExist($color, $id) {
        if(!$color) {
            $colors = ProductColor::all();
            if(!$colors -> count()) {
                return [
                    'error' => true,
                    'data' => [
                        'message' => 'No color exist.',
                        'links' => [
                            [
                                'url' => 'panel/products/colors',
                                'text' => 'Go to table '
                            ]
                        ]
                    ]
                ];
            }
            $firstColor = $colors[0];
            $middleColor = $colors[intval((count($colors) - 1) / 2)];
            $lastColor = $colors[count($colors) - 1];

            $firstDiff = abs($firstColor -> id - $id);
            $middleDiff = abs($middleColor -> id - $id);
            $lastDiff = abs($lastColor -> id - $id);

            if($firstDiff < $middleDiff && $firstDiff < $lastDiff) $colorLF = $firstColor;
            else if($firstDiff > $middleDiff && $middleDiff < $lastDiff) $colorLF = $middleColor;
            else if($firstDiff > $lastDiff && $middleDiff > $lastDiff) $colorLF = $lastColor;
            else $colorLF = $firstColor;

            $links = [
                [
                    'url' => 'panel/products/colors',
                    'text' => 'Go to table'
                ],
                [
                    'url' => 'panel/products/colors/' . $colorLF -> id . '/edit',
                    'text' => 'May be you looking for "' . $colorLF -> color . '" color.'
                ]
            ];
            if($firstDiff != $middleDiff && $firstDiff != $lastDiff && $middleDiff != $lastDiff) {
                $links[2] = [
                    'url' => null,
                    'text' => 'Or you want other sizes?'
                ];
                $links[3] = [
                    'url' => 'panel/products/color/' . $firstColor -> id . '/edit',
                    'text' => '1. "' . $firstColor -> color . '" color.'
                ];
                $links[4] = [
                    'url' => 'panel/products/color/' . $middleColor -> id . '/edit',
                    'text' => '2. "' . $middleColor -> color . '" color.'
                ];
                $links[5] = [
                    'url' => 'panel/products/color/' . $lastColor -> id . '/edit',
                    'text' => '2. "' . $lastColor -> color . '" color.'
                ];
            }

            return [
                'error' => true,
                'data' => [
                    'message' => 'Color with this id does not exist.',
                    'links' => $links
                ]
            ];
        }
        return [
            'error' => false
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if(!Auth::check()) return redirect() -> to('panel/login');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $color = ProductColor::find($id);
        $existChecker = self::isColorExist($color, $id);
        if($existChecker['error']) return view('panel.errors.404', $existChecker['data']);
        $pageData = self::getPageData(
            'Edit color "<div style="width: 30px; height:20px; display: inline-block; background-color:' . $color -> color . '"></div>" of ' . ($color -> size ? 'size "' . $color -> size -> size . '" of product "' . $color -> size -> product -> name . '"' : 'product "' . $color -> product -> name . '"'),
            'panel/products/colors/' . $color -> id,
            'PUT'
        );
        $pageData['color'] = $color;
        return view('panel.color-product-modify', $pageData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $data = Input::all();
        $color = ProductColor::find($id);
        $existChecker = self::isColorExist($color, $id);
        if($existChecker['error']) return view('panel.errors.404', $existChecker['data']);
        $validator = Validator::make($data, $color -> rules, $color -> messages());
        if($validator -> fails()) return redirect() -> back() -> withInput() -> withErrors($validator);
        if(!(array_key_exists('product_id', $data) ^ array_key_exists('size_id', $data))) return redirect() -> back() -> withInput();
        self::saveColor($data, $id);
        return redirect() -> back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $color = ProductColor::find($id);
        $existChecker = self::isColorExist($color, $id);
        if($existChecker['error']) return view('panel.errors.404', $existChecker['data']);
        $color -> delete();
        return redirect() -> back();
    }
}