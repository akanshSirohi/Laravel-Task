<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsApiController extends Controller
{
    public function index(Request $request)
    {
        $gender = $request->gender;
        $price = $request->price;
        $subcatg = $request->subcatg;
        $currentItems = $request->currentItems;
        $priceRange = explode(":", $request->priceRange);

        if (!in_array($gender, ['a', 'w', 'm']) || empty($subcatg)) {
            return response()->json(['error' => 'Invalid gender or subcategory.']);
        }

        $products = array();
        $all_products = $this->getAllProducts();
        $products = array_filter($all_products, function ($product) use ($gender, $subcatg, $priceRange) {
            if ($gender === 'a') {
                return ($subcatg === 'all' || str_contains($product['prod_subcategory'], $subcatg)) && (($product['price'] > $priceRange[0]) && ($product['price'] < $priceRange[1]));
            } else {
                return $product['prodmeta_section'] === ($gender === 'w' ? 'Womens' : 'Mens') &&
                    ($subcatg === 'all' || str_contains($product['prod_subcategory'], $subcatg)) && (($product['price'] > $priceRange[0]) && ($product['price'] < $priceRange[1]));
            }
        });
        if ($price == "lth") {
            $products = sortArrayOfObjects($products, "price", "asc");
        } else if ($price == "htl") {
            $products = sortArrayOfObjects($products, "price", "desc");
        }
        $products = array_values($products);

        if ($currentItems < count($products)) {
            $result = array_slice($products, $currentItems, $currentItems + 12);
            return response()->json(array("result" => $result, "total" => count($products)));
        } else {
            return response()->json(array("result" => [], "total" => 0));
        }

        // return response()->json($products);
    }

    public function getAllProducts()
    {
        $data = Storage::disk('local')->get('data.csv');
        return parse_csv($data);
    }

    public function getSubcategories()
    {
        $products = $this->getAllProducts();
        $subcategories = array();
        foreach ($products as $item) {
            $catg = explode(",", $item['prod_subcategory']);
            $subcategories = array_unique(array_merge($subcategories, $catg));
        }
        return array_values($subcategories);
    }
}
