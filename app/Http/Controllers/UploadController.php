<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(public_path('images'), $imageName);

        $imageUrl = url('images/' . $imageName);

        $response = [
            'status' => 'success',
            'message' => 'image uploaded successfully!',
            'url' => $imageUrl
        ];
        return response()->json($response, 200);
    }
}
