<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $productId)
    {


        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        // Store the comment
        $created = Comment::create([
            'user_id' => auth()->id(),
            'product_id' => $productId,
            'content' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
