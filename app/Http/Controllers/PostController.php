<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['category', 'author', 'media'])->paginate(10);
        return response()->json($posts, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'tags' => 'nullable|string|max:255',
            'language' => 'required|in:ar,en',
            'category_id' => 'required|exists:categories,id',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mp3',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'tags' => $validated['tags'] ?? null,
            'author_id' => Auth::id(),  // تم تعديل هنا
            'language' => $validated['language'],
            'category_id' => $validated['category_id'],
        ]);

        // حفظ الوسائط
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                Media::create([
                    'post_id' => $post->id,
                    'file_path' => $file->store('media'),
                    'file_type' => $file->getClientOriginalExtension(),
                ]);
            }
        }

        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::with(['category', 'author', 'comments', 'media'])->find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json($post, 200);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post || $post->author_id !== Auth::id()) { // تم تعديل هنا
            return response()->json(['error' => 'Unauthorized or Post not found'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|max:255',
            'content' => 'sometimes|required',
            'tags' => 'nullable|string|max:255',
            'language' => 'sometimes|required|in:ar,en',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        $post->update($validated);

        return response()->json(['message' => 'Post updated successfully', 'post' => $post], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post || $post->author_id !== Auth::id()) { // تم تعديل هنا
            return response()->json(['error' => 'Unauthorized or Post not found'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
