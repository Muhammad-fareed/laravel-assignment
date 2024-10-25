<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::paginate(10);
        return new ProductCollection($products);
    }
}
