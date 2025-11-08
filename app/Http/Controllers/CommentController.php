<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function index()
    {
        // Only show comments created by the authenticated user
        $comments = Comment::where('userID', auth()->id())->latest()->get();
        return CommentResource::collection($comments);
    }

    public function store(StoreCommentRequest $request)
    {
        // Automatically set the authenticated user's ID
        $data = $request->validated();
        $data['userID'] = auth()->id();
        
        $comment = Comment::create($data);
        
        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Comment $comment)
    {
        // Ensure user can only view their own comment
        if ($comment->userID !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        return new CommentResource($comment);
    }

    public function update(StoreCommentRequest $request, Comment $comment)
    {
        // Ensure user can only update their own comment
        if ($comment->userID !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $comment->update($request->validated());

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        // Ensure user can only delete their own comment
        if ($comment->userID !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $comment->delete();
        return response()->json(null, 204);
    }
}
