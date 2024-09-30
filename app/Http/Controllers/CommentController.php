<?php

namespace App\Http\Controllers;

use App\Models\Commend;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->exists('post_id')) {
            $data = Commend::where([
                ['post_id', '=', $request->post_id],
                ['commend_id', '=', null], // Root comments (no replies)
            ])->latest()->get();
        } else {
            $data = Commend::all();
        }

        $response = [
            'status' => 'success',
            'message' => 'Data loaded successfully',
            'data' => $data,
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'message' => 'required|string|max:250',
            'post_id' => 'required|exists:posts,id',
            'commend_id' => 'nullable|int|exists:commends,id',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $object = new Commend();
        $object->user_id = Auth::id();
        $object->message = $request->message;
        $object->post_id = $request->post_id;
        if ($request->filled('commend_id')) {
            $object->commend_id = $request->commend_id; // This makes it a reply to another commend
        }

        $object->save();

        $response = [
            'status' => 'success',
            'message' => 'Commend added successfully.',
            'data' => $object,
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Commend $commend)
    {
        $response = [
            'status' => 'success',
            'message' => 'Data loaded successfully',
            'data' => $commend,
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commend $commend): \Illuminate\Http\JsonResponse
    {
        // Ensure the user is the owner of the commend
        if ($commend->user_id !== Auth::id()) {
            return response()->json(['status' => 'failed', 'message' => 'Unauthorized'], 403);
        }

        $validate = Validator::make($request->all(), [
            'message' => 'required|string|max:250',
            'post_id' => 'required|exists:posts,id',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $commend->message = $request->message;
        $commend->post_id = $request->post_id;

        $commend->save();

        $response = [
            'status' => 'success',
            'message' => 'Commend updated successfully.',
            'data' => $commend,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commend $commend)
    {
        // Ensure the user is the owner of the commend
        if ($commend->user_id !== Auth::id()) {
            return response()->json(['status' => 'failed', 'message' => 'Unauthorized'], 403);
        }

        $commend->delete();

        $response = [
            'status' => 'success',
            'message' => 'Commend deleted successfully.',
            'data' => $commend,
        ];
        return response()->json($response, 200);
    }
}
