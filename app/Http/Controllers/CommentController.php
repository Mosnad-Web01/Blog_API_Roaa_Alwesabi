<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $validated = $request->validate([
            'content' => 'required',
            'language' => 'required|in:ar,en',
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),  // تم تعديل هنا
            'content' => $validated['content'],
            'language' => $validated['language'],
        ]);

        return response()->json(['message' => 'Comment added successfully', 'comment' => $comment], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (!$comment || $comment->user_id !== Auth::id()) { // تم تعديل هنا
            return response()->json(['error' => 'Unauthorized or Comment not found'], 403);
        }

        $validated = $request->validate([
            'content' => 'required',
        ]);

        $comment->update($validated);

        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment || $comment->user_id !== Auth::id()) { // تم تعديل هنا
            return response()->json(['error' => 'Unauthorized or Comment not found'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
}
