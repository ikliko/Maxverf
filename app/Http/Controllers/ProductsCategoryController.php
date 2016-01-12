<?php

namespace App\Http\Controllers;

use App\ProductsCategory;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Input;
use Auth;
use Session;

class ProductsCategoryController extends Controller {

    public function getCategories($isTable = false) {
        $categories = $isTable ? ProductsCategory::where('parent_id', '=', '0')
            -> get() : ProductsCategory::where('parent_id', '=', '0')
            -> get(array('id', 'title'));
        $outputArr = [];
        if(!$isTable) $outputArr[0] = 'no category';
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if(!Auth::check()) return redirect() -> to('panel/login');
        $categories = self::getCategories(1);
        return view('panel.category.table', [
            'table' => $categories
        ]);
    }

    private function getPageData($title, $url, $current, $method = 'POST') {
        $outputArr = self::getCategories();

        return [
            'title' => $title,
            'url' => $url,
            'method' => $method,
            'categories' => $outputArr,
            'current' => $current
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if(!Auth::check()) return redirect() -> to('panel/login');

        $pageData = self::getPageData('Create new products category - general', 'panel/products/categories/new/general', 'general');
        return view('panel.category.general', $pageData);
    }

    public function translation() {
        if(!Auth::check()) return redirect() -> to('panel/login');

        $pageData = self::getPageData('Create new products category', 'panel/products/categories/new/general', 'translations');
        return view('panel.category.translation', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $categoryResponse = ProductsCategory::newRecord($request -> all());
//        var_dump($categoryResponse);
        switch($categoryResponse['type']) {
            case 'Unauthenticated':
                flash() -> error($categoryResponse['message']);
                if($categoryResponse['redirect'] === 'back') return redirect() -> back();
                return redirect() -> to($categoryResponse['redirect']);
            case 'InvalidData':
//                flash() -> error($categoryResponse['message']);
                if($categoryResponse['redirect'] === 'back') return redirect() -> back() -> withErrors($categoryResponse['messages']) -> withInput();
                return redirect() -> to($categoryResponse['redirect']);
            case 'SavingException':
                flash() -> error($categoryResponse['message']);
                if($categoryResponse['redirect'] === 'back') return redirect() -> back();
                return redirect() -> to($categoryResponse['redirect']);
            case 'Success':
                flash() -> success($categoryResponse['message']);
                if($categoryResponse['redirect'] === 'back') return redirect() -> back();
                return redirect() -> to($categoryResponse['redirect']);
            default:
                return redirect() -> to('panel/login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTranslation(Request $request) {
        if(!Auth::check()) return redirect() -> to('panel/login');

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!\Auth::check()) return redirect() -> to('/panel/login');
        $category = ProductsCategory::find($id);
        $existCheck = ProductsCategory::checkExisting($category, $id);
        if($existCheck['error']['code']) return view('panel.errors.404', $existCheck['error']['data']);
        $pageData = self::getPageData('Edit Category', 'panel/products/categories/' . $id, 'PUT');
        $pageData['category'] = $category;
        return view('panel.category-product-modify', $pageData);
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
        $validate = ProductsCategory::editRecord($id, $data);
        switch($validate['error']['type']) {
            case 'invalidData': return redirect() -> back() -> withInput() -> withErrors($validate['error']['responseMessages']);
            case 'noRecords':
            case 'noExist': return view('panel.errors.404', $validate['error']['data']);
        }
        Session::flash('success', $validate['success']);
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
        $category = ProductsCategory::find($id);
        $childs = $category -> childs;
        foreach($childs as $child) {
            $child -> delete();
        }
        $category -> delete();
        return redirect() -> back();
    }
}
