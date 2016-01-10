<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Response;

class SearchController extends Controller
{ public function appendValue($data, $type, $element)
{
    // operate on the item passed by reference, adding the element and type
    foreach ($data as $key => & $item) {
        $item[$element] = $type;
    }
    return $data;
}

    public function appendURL($data, $prefix)
    {
        // operate on the item passed by reference, adding the url based on slug
        foreach ($data as $key => & $item) {
            $item['url'] = url($prefix.'/'.$item['id']);
        }
        return $data;
    }

    public function pictureURL($data, $prefix) {
        // operate on the item passed by reference, adding the url based on slug
        foreach ($data as $key => & $item) {
            $item['picture'] = url($prefix.'/'.$item['image_normal']);
            unset($item['image_normal']);
        }
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Retrieve the user's input and escape it
        $query = e(Input::get('q',''));

        // If the input is empty, return an error response
        if(!$query && $query == '') return Response::json(array(), 403);

        $products = Product::where('name','like','%'.$query.'%')
            ->orderBy('name','asc')
            ->take(5)
            ->get(array('id', 'name','image_normal'))
            ->toArray();

//        // Data normalization
        $products 	= $this->appendURL($products, 'shop');
        $products 	= $this->pictureURL($products, '');
//
//        // Add type of data to each item of each set of results
        $products = $this->appendValue($products, 'product', 'type');

        // Merge all data into one array
        $data = array_merge($products);

        return Response::json(array(
            'data' => $data
        ));
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
