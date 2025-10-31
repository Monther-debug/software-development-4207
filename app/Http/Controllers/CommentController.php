<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::latest()->get();
        return CommentResource::collection($comments);
    }

    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->validated());
        
        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function update(StoreCommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(null, 204);
    }
}
