<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('user');

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->has('tag') && $request->tag != '') {
            $query->whereJsonContains('tags', $request->tag);
        }
        $posts = $query->latest()->paginate(30)->withQueryString();

        return view('home', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::with(['user', 'comments.user'])->findOrFail($id);

        $post->increment('views');

        return view('posts.show', compact('post'));
    }

    public function react(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:like,dislike'
        ]);

        $post = Post::findOrFail($id);
        $type = $request->type;

        if ($type === 'like') {
            $post->increment('likes');
        } else {
            $post->increment('dislikes');
        }

        return response()->json([
            'success' => true,
            'likes' => $post->likes,
            'dislikes' => $post->dislikes
        ]);
    }
}
