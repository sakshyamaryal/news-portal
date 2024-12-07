<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'content' => 'required|max:500',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'article_id' => $request->article_id,
            'content' => $request->content,
        ]);

        $comment->load('user');

        return response()->json([
            'message' => 'Comment added successfully!',
            'comment' => $comment,
            'username' => $comment->user->name,
        ], 201);
    }

    public function update(Request $request, Comment $comment)
    {

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'required|max:500',
        ]);

        $comment->update(['content' => $request->content]);

        return response()->json(['message' => 'Comment updated successfully!', 'comment' => $comment]);
    }

    public function destroy(Comment $comment)
    {
        // Ensure the user owns the comment
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully!']);
    }
}
