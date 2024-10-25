<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::paginate(10);
        return new CategoryCollection($categories);
    }
}
