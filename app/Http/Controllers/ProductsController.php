<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index()
    {
        return view('home', array('title' => "Catalog App"));
    }

    public function product($sku)
    {
        $data = Storage::disk('local')->get('data.csv');
        $products = parse_csv($data);
        foreach ($products as $product) {
            if (intval($product['prod_sku']) == $sku) {
                return view('product', array('title' => $product['prod_name'], 'data' => $product));
            }
        }
        abort(404);
    }
}
