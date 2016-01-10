<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductsCategory;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class ShopController extends Controller
{
    private $isUnderConstruction;
    public function __construct() {
        parent::__construct();
        $this -> isUnderConstruction = Session::get('access', 0);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if($this -> isUnderConstruction) return view('under-construction');

        $pageData = self::getPageElements('shop', 'Shop', '', '', true, true, true);
        return view('shop', $pageData);
    }

    public function getNew() {
        $pageData = self::getPageElements('new', 'Niew', '', '', true, false, true);
        $pageData['products'] = Product::latest();
        return view('shop', $pageData);
    }

    public function getPromo() {
        $pageData = self::getPageElements('promo', 'Promo', '', '', true, false, true);
        $productsResponse = Product::onDiscountPaginate();
        $pageData['products'] = $productsResponse -> getCollection() -> all();
        $pageData['pages'] = $productsResponse -> render();
        return view('shop', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    private function getProductsAsArray() {
        $products = Product::all();
        $arr = [];
        foreach($products as $product) {
            $arr[] = $product;
        }
        return $arr;
    }

    public function getCategory($id) {
        $category = ProductsCategory::find($id);
        if(!$category) return redirect() -> to('shop');
        $pageData = self::getPageElements($category -> title, $category -> title, '', '', true, false, false, $category -> mainParent() -> id);
        $products = $category -> products;
        $pageData['products'] = $products;
        $pageData['category'] = $category;

        return view('shop', $pageData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $product = Product::find($id);
        $pageData = self::getPageElements('shop', $product -> name, '', '', true);
        $pageData['product'] = $product;
        $products = self::getProductsAsArray();
        $products = array_slice((array)$products, count($products) - 3);
        $pageData['last'] = $products;
        $pageData['promo_products'] = Product::where('promo', '<>', 0) -> get() -> take(3);
        return view('product', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
