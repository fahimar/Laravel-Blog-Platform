<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->get();
        $response = [
            'status' => 'success',
            'message' => 'Data loaded successfully',
            'data' => $posts,
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:250',
            'body' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $post = new Post;
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->body = $request->body;

        // Handle image upload and set image attribute using Laravel Storage
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $post->image = $path;
        }

        $post->save();

        $response = [
            'status' => 'success',
            'message' => 'Post added successfully.',
            'data' => $post,
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $response = [
            'status' => 'success',
            'message' => 'Data loaded successfully',
            'data' => $post,
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): \Illuminate\Http\JsonResponse
    {
        // Ensure the user is the owner of the post
        if ($post->user_id !== Auth::id()) {
            return response()->json(['status' => 'failed', 'message' => 'Unauthorized'], 403);
        }

        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:250',
            'body' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $post->title = $request->title;
        $post->body = $request->body;

        // Handle image upload and replace the old image
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image && Storage::exists('public/' . $post->image)) {
                Storage::delete('public/' . $post->image);
            }

            $path = $request->file('image')->store('images', 'public');
            $post->image = $path;
        }

        $post->save();

        $response = [
            'status' => 'success',
            'message' => 'Post updated successfully.',
            'data' => $post,
        ];

        return response()->json($response, 200);  // 200 for update
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Ensure the user is the owner of the post
        if ($post->user_id !== Auth::id()) {
            return response()->json(['status' => 'failed', 'message' => 'Unauthorized'], 403);
        }

        // Delete post image if exists
        if ($post->image && Storage::exists('public/' . $post->image)) {
            Storage::delete('public/' . $post->image);
        }

        $post->delete();

        $response = [
            'status' => 'success',
            'message' => 'Post deleted successfully.',
            'data' => $post,
        ];
        return response()->json($response, 200);
    }
}
