<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('Dashboard.modules.product.index', compact('categories'));
    }

    public function fetchProducts()
    {
        $products = Product::with('images')->get();
        return response()->json([
            "products" => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.modules.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category.*' => 'exists:categories,id',
            'files.*' => 'required|image|mimes:jpg,jpeg,png,gif',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->has('category')) {
            $product->categories()->attach($request->category);
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $image) {
                $path= ImageHelper::compressImage($image);
                $product->images()->create(['image_path' => $path]);
            }
        }

        return response()->json(['status' => 200, 'message' => 'Product created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if ($product) {
            $categories = Category::all();
            return response()->json([
                'status' => 200,
                'product' => $product->load('categories'),
                'categories' => $categories,
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => "Product not found!",
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category.*' => 'exists:categories,id',
            'files.*' => 'nullable|image|mimes:jpg,jpeg,png,gif',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->has('category')) {
            $product->categories()->sync($request->category);
        }

        if ($request->hasFile('files')) {
            $oldImages = $product->images;
            foreach ($oldImages as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            foreach ($request->file('files') as $image) {
                $path= ImageHelper::compressImage($image);
                $product->images()->create(['image_path' => $path]);
            }
        }

        return response()->json(['status' => 200, 'message' => 'Product updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $images = $product->images;
            foreach ($images as $image) {
                $imagePath = $image->image_path;
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $image->delete();
            }

            $product->delete();
            return response()->json(['status' => 200, 'message' => 'Product and associated images deleted successfully']);
        }

        return response()->json(['status' => 404, 'message' => 'Product not found']);
    }
}
