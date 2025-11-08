<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Comment\StoreCommentRequest;
use App\Http\Requests\User\Comment\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::where('userID', auth('api')->id())->get();
        return CommentResource::collection($comments);
    }

    public function store(StoreCommentRequest $request)
    {
        $data = $request->validated();
        $data['userID'] = auth('api')->id();
        $comment = Comment::create($data);
        return new CommentResource($comment);
    }

    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        if (auth('api')->id() !== $comment->userID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->update($request->validated());
        return new CommentResource($comment);
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
