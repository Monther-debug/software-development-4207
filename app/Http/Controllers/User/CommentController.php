<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::where('userID', auth('api')->id())->get();
        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'schoolID' => 'required|exists:schools,id',
            'comment' => 'required|string',
        ]);

        $validatedData['userID'] = auth('api')->id();
        $comment = Comment::create($validatedData);
        return response()->json($comment, 201);
    }

    public function show(Comment $comment)
    {
        return response()->json($comment);
    }

    public function update(Request $request, Comment $comment)
    {
        if (auth('api')->id() !== $comment->userID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'comment' => 'sometimes|string',
        ]);

        $comment->update($validatedData);
        return response()->json($comment);
    }

    public function destroy(Comment $comment)
    {
        if (auth('api')->id() !== $comment->userID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $comment->delete();
        return response()->json(null, 204);
    }
}
