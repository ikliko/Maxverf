<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App;
use Session;
use App\Product;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function __construct() {
        App::setLocale(Session::get('lang', 'nl'));
    }

    /***
     * This method returns page data.
     * @param $current - for current page
     * @param $title - page title SEO
     * @param $description - description title SEO
     * @param $keywords - keywords SEO
     * @param bool $categories - if you want to get categories set true
     * @param bool $products - if you want to get products set true
     * @return array with data
     */
    protected function getPageElements($current, $title, $description, $keywords, $categories = false, $products = false, $promo = false, $currentCategory = null, $perPage = 12) {
        $data = [
            'current' => $current,
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'current_category' => $currentCategory,
        ];

        if( $categories ) $data['categories'] = App\ProductsCategory::where('parent_id', '=', 0) -> get();
        if( $products ) {
            $productsResponse = Product::paginate($perPage);
            $products = $productsResponse -> getCollection() -> all();
            $pages = $productsResponse -> render();
            $data['products'] = $products;
            $data['pages'] = $pages;
        }
        if( $promo ) $data['promo_products'] = Product::where('on_discount', '<>', 0) -> get() -> take(3);

        return $data;
    }
}
