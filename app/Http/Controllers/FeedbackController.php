<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        // Store the feedback
        Feedback::create([
            'user_id' => auth()->id(),
            'product_id' => $productId,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }
}

