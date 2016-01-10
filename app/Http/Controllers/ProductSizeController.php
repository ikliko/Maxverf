<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductSize;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Validator;
use Input;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $sizes = ProductSize::all();
        return view('panel.sizes-products-table', [
            'table' => $sizes
        ]);
    }

    private function getProductsAsArray() {
        $products = Product::where('price', '=', null) -> get();
        $arr = [
            'no product selected'
        ];
        foreach($products as $product) {
            $arr[$product -> id] = $product -> name;
        }
        return $arr;
    }

    private function getPageData($title, $url, $method = 'POST') {
        $products = self::getProductsAsArray();
        return [
            'title' => $title,
            'url' => $url,
            'method' => $method,
            'products' => $products
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $pageData = self::getPageData('Create size', 'panel/products/sizes');
        return view('panel.size-product-modify', $pageData);
    }

    private function saveSize($data, $id = null) {
        if($id) $size = ProductSize::find($id);
        else $size = new ProductSize();
        $size -> size = $data['size'];
        $size -> price = $data['price'];
        $size -> product_id = $data['product_id'];
        $size -> save();
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
//        var_dump($request -> all());
        $sizeResponse = ProductSize::manage($request -> all());
        switch($sizeResponse['error']['type']) {
            case 'validation':
                return redirect() -> back() -> withInput() -> withErrors($sizeResponse['error']['messages']);
            case 'saving':
                return redirect() -> back() -> withInput();
            default:
                return redirect() -> back();
        }
    }

    private function isSizeExist($size, $id) {
        if(!$size) {
            $sizes = ProductSize::all();
            if(!$sizes -> count()) {
                return [
                    'error' => true,
                    'data' => [
                        'message' => 'No sizes exist.',
                        'links' => [
                            [
                                'url' => 'panel/products/sizes',
                                'text' => 'Go to table '
                            ]
                        ]
                    ]
                ];
            }
            $firstSize = $sizes[0];
            $middleSize = $sizes[intval((count($sizes) - 1) / 2)];
            $lastSize = $sizes[count($sizes) - 1];

            $firstDiff = abs($firstSize -> id - $id);
            $middleDiff = abs($middleSize -> id - $id);
            $lastDiff = abs($lastSize -> id - $id);

            if($firstDiff < $middleDiff && $firstDiff < $lastDiff) $sizeLF = $firstSize;
            else if($firstDiff > $middleDiff && $middleDiff < $lastDiff) $sizeLF = $middleSize;
            else if($firstDiff > $lastDiff && $middleDiff > $lastDiff) $sizeLF = $lastSize;
            else $sizeLF = $firstSize;

            $links = [
                [
                    'url' => 'panel/products/sizes',
                    'text' => 'Go to table'
                ],
                [
                    'url' => 'panel/products/sizes/' . $sizeLF -> id . '/edit',
                    'text' => 'May be you looking for "' . $sizeLF -> size . '" size.'
                ]
            ];
            if($firstDiff != $middleDiff && $firstDiff != $lastDiff && $middleDiff != $lastDiff) {
                $links[2] = [
                    'url' => null,
                    'text' => 'Or you want other sizes?'
                ];
                $links[3] = [
                    'url' => 'panel/products/sizes/' . $firstSize -> id . '/edit',
                    'text' => '1. "' . $firstSize -> size . '" size.'
                ];
                $links[4] = [
                    'url' => 'panel/products/sizes/' . $middleSize -> id . '/edit',
                    'text' => '2. "' . $middleSize -> size . '" size.'
                ];
                $links[5] = [
                    'url' => 'panel/products/sizes/' . $lastSize -> id . '/edit',
                    'text' => '2. "' . $lastSize -> size . '" size.'
                ];
            }

            return [
                'error' => true,
                'data' => [
                    'message' => 'Size with this id does not exist.',
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
        $size = ProductSize::find($id);
        $existChecker = self::isSizeExist($size, $id);
        if($existChecker['error']) return view('panel.errors.404', $existChecker['data']);
        $pageData = self::getPageData(
            'Edit size "' . $size -> size . '" of product "' . $size -> product -> name . '"',
            'panel/products/sizes/' . $size -> id,
            'PUT'
        );
        $pageData['size'] = $size;
        return view('panel.size-product-modify', $pageData);
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
        $sizeResponse = ProductSize::manage($request -> all(), $id);
        switch($sizeResponse['error']['type']) {
            case 'validation':
                return redirect() -> back() -> withInput() -> withErrors($sizeResponse['error']['messages']);
            case 'saving':
                return redirect() -> back() -> withInput();
            default:
                return redirect() -> back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $size = ProductSize::find($id);
        $existChecker = self::isSizeExist($size, $id);
        if($existChecker['error']) return view('panel.errors.404', $existChecker['data']);
        $colors = $size -> colors();
        foreach($colors as $color) {
            $color -> delete();
        }
        $size -> delete();
        return redirect() -> back();
    }
}
