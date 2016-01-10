<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductsCategory;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Validator;
use Input;
use Image;
use Mockery\CountValidator\Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $products = Product::all();
        return view('panel.products-table', [
            'table' => $products
        ]);
    }

    public function getCategories($isTable = false) {
        $categories = $isTable ? ProductsCategory::where('parent_id', '=', '0')
            -> get() : ProductsCategory::where('parent_id', '=', '0')
            -> get(array('id', 'title'));
        $outputArr = [
            0 => 'no category'
        ];
        foreach($categories as $category) {
            $title = $category -> title;
            if($isTable) {
                $outputArr[$category -> id]['title'] = $title;
                $outputArr[$category -> id]['tree'] = $title;
            } else {
                $outputArr[$category -> id] = $title;
            }
            $childs = $category -> childs;
            foreach($childs as $child) {
                $titleChild = $title . ' > ' . $child -> title;
                if($isTable) {
                    $outputArr[$child -> id]['title'] = $child -> title;
                    $outputArr[$child -> id]['tree'] = $titleChild;
                } else {
                    $outputArr[$child -> id] = $titleChild;
                }
                $grandChilds = $child -> childs;
                foreach($grandChilds as $grandChild) {
                    $titleGrandChild = $titleChild . ' > ' . $grandChild -> title;
                    if($isTable) {
                        $outputArr[$grandChild -> id]['title'] = $grandChild -> title;
                        $outputArr[$grandChild -> id]['tree'] = $titleGrandChild;
                    } else {
                        $outputArr[$grandChild -> id] = $titleGrandChild;
                    }
                }
            }
        }
        return $outputArr;
    }

    public function getPageData($title, $url, $method = 'POST') {
        $categories = self::getCategories();
        return [
            'title' => $title,
            'url' => $url,
            'method' => $method,
            'categories' => $categories
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $pageData = self::getPageData('Create product', 'panel/products');
        return view('panel.product-modify', $pageData);
    }

    private function saveImage($image, $width, $height, $picSize, $quality = 90) {
        $filename  = time() . '.' . $image -> getClientOriginalExtension();
        $path = 'uploads/images/products/' . $picSize . '/' . $filename;
        $path = str_replace('public', 'public_html', $path); // in production
        \Image::make( $image )
            -> resize($width, $height)
            -> save($path, $quality);

        return $path;
    }

    private function saveProduct($data, $id = null) {
        if($id) $product = Product::find($id);
        else $product = new Product();
        $image = array_key_exists('image', $data)? $data['image'] : null;
        $product -> name = $data['name'];
        if($image) {
            if($product -> image_large) {
                Image::make($product -> image_large) -> destroy();
                Image::make($product -> image_normal) -> destroy();
            }
            $product -> image_large = self::saveImage($image, 327, 378, 'lg');
            $product -> image_normal = self::saveImage($image, 255, 230, 'nm');
        }
        $product -> description = $data['description'];
        $product -> intro = $data['intro'];
        $product -> category_id = $data['category_id'];
        $product -> price = null;
        if(array_key_exists('price', $data)) $product -> price = $data['price'];
        $product -> save();
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
        $productResponse = Product::manage($request -> all());
        switch($productResponse['error']['type']) {
            case 'validation':
                return redirect() -> back() -> withInput() -> withErrors($productResponse['error']['messages']);
            default:
                return redirect() -> back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    private function isProductExist($product, $id) {
        if(!$product) {
            $products = Product::all();
            if(!$products -> count()) {
                return [
                    'error' => true,
                    'data' => [
                        'message' => 'No products exist.',
                        'links' => [
                            [
                                'url' => 'panel/products',
                                'text' => 'Go to table '
                            ]
                        ]
                    ]
                ];
            }
            $firstProduct = $products[0];
            $middleProduct = $products[intval((count($products) - 1) / 2)];
            $lastProduct = $products[count($products) - 1];

            $firstDiff = abs($firstProduct -> id - $id);
            $middleDiff = abs($middleProduct -> id - $id);
            $lastDiff = abs($lastProduct -> id - $id);

            if($firstDiff < $middleDiff && $firstDiff < $lastDiff) $productLF = $firstProduct;
            else if($firstDiff > $middleDiff && $middleDiff < $lastDiff) $productLF = $middleProduct;
            else if($firstDiff > $lastDiff && $middleDiff > $lastDiff) $productLF = $lastProduct;
            else $productLF = $firstProduct;

            $links = [
                [
                    'url' => 'panel/products',
                    'text' => 'Go to table'
                ],
                [
                    'url' => 'panel/products/' . $productLF -> id . '/edit',
                    'text' => 'May be you looking for "' . $productLF -> name . '" product.'
                ]
            ];
            if($firstDiff != $middleDiff && $firstDiff != $lastDiff && $middleDiff != $lastDiff) {
                $links[2] = [
                    'url' => null,
                    'text' => 'Or you want other products?'
                ];
                $links[3] = [
                    'url' => 'panel/products/' . $firstProduct -> id . '/edit',
                    'text' => '1. "' . $firstProduct -> name . '" product.'
                ];
                $links[4] = [
                    'url' => 'panel/products/' . $middleProduct -> id . '/edit',
                    'text' => '2. "' . $middleProduct -> name . '" product.'
                ];
                $links[5] = [
                    'url' => 'panel/products/' . $lastProduct -> id . '/edit',
                    'text' => '2. "' . $lastProduct -> name . '" product.'
                ];
            }

            return [
                'error' => true,
                'data' => [
                    'message' => 'Product with this id does not exist.',
                    'links' => $links
                ]
            ];
        }
        return [
            'error' => false
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $product = Product::find($id);
        $existChecker = self::isProductExist($product, $id);
        if($existChecker['error']) return view('panel.errors.404', $existChecker['data']);
        $pageData = self::getPageData(
            'Edit product: ' . $product -> name,
            'panel/products/' . $product -> id,
            'PUT'
        );
        $pageData['product'] = $product;
        return view('panel.product-modify', $pageData);
    }

    public function update(Request $request, $id) {
        if(!Auth::check()) return redirect() -> to('panel/login');
//        var_dump($request -> all());
        $productResponse = Product::manage($request -> all(), $id);
        switch($productResponse['error']['type']) {
            case 'validation':
                return redirect() -> back() -> withInput() -> withErrors($productResponse['error']['messages']);
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
        $product = Product::find($id);
        if(!$product) return redirect() -> to('panel/products');
        $sizes = $product -> sizes;
        foreach($sizes as $size) {
            $size -> delete();
        }
        $colors = $product -> colors;
        foreach($colors as $color) {
            $color -> delete();
        }
        $product -> delete();
        return redirect() -> back();
    }
}
