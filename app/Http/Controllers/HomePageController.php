<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function category()
    {
        $categories = Category::paginate(10);
        return view('Dashboard.modules.frontend.page-content.category', compact('categories'));
    }

    public function products($categoryId)
    {
        $category = Category::with(['products.images'])->findOrFail(id: $categoryId);
        $products = $category->products;

        return view('Dashboard.modules.frontend.page-content.products', compact('category', 'products'));
    }

    public function showAllProducts(){
        $products = Product::with(['images','categories'])->get();
    }

    public function productDetail($id)
    {
        $product = Product::with(['categories', 'images', 'comments.user', 'feedback.user'])->findOrFail($id);
        return view('Dashboard.modules.frontend.page-content.product-detail', compact('product'));
    }
}
