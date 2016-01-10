<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageController extends Controller {
    public function getTerms() {
        return view('info', self::getPageElements('conditional-terms', 'info', 'info page', null, true));
    }
	
    public function getHome() {
        $pageData = self::getPageElements('/', null, 'index page', null, true, true, true);
        $pageData['last'] = Product::orderBy('id', 'desc') -> get() -> take(3);
        return view('index', $pageData);
    }
}