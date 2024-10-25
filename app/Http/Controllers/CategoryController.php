<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        return view('Dashboard.modules.category.index');
    }

    public function fetchCategories()
    {
        $categories = Category::all();
        return response()->json([
            "categories" => $categories
        ]);
    }

    public function create()
    {
        return view('Dashboard.modules.category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        Category::create($request->all());
        return response()->json(['status' => 200, 'message' => 'Category Created Successfully']);
    }

    public function edit(Category $category)
    {
        if ($category) {
            return response()->json([
                'status' => 200,
                'category' => $category,
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => "Category Not Found!",
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => 404,
                'errors' => "Category not found",
            ]);
        }

        $category->name = $request->name;
        $category->save();

        return response()->json(['status' => 200, 'message' => 'Category Updated Successfully']);
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['status' => 200, 'message' => 'Category Deleted Successfully']);
    }
}
