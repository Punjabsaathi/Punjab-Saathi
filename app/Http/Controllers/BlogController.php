<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts      = Blog::published()->with(['author', 'category'])->latest('published_at')->paginate(9);
        $featured   = Blog::published()->featured()->latest('published_at')->take(3)->get();
        $categories = BlogCategory::withCount(['blogs' => fn ($q) => $q->published()])->get();
        $recent     = Blog::published()->latest('published_at')->take(5)->get();
        $popular    = Blog::published()->orderByDesc('views')->take(5)->get();

        return view('blogs.index', compact('posts', 'featured', 'categories', 'recent', 'popular'));
    }

    public function show(string $slug)
    {
        $post = Blog::published()->with(['author', 'category'])->where('slug', $slug)->firstOrFail();
        $post->incrementViews();

        $comments = BlogComment::where('blog_id', $post->id)
            ->approved()
            ->topLevel()
            ->with('replies')
            ->latest()
            ->get();

        $related = Blog::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $categories = BlogCategory::withCount(['blogs' => fn ($q) => $q->published()])->get();
        $recent     = Blog::published()->latest('published_at')->take(5)->get();
        $popular    = Blog::published()->orderByDesc('views')->take(5)->get();

        return view('blogs.show', compact('post', 'comments', 'related', 'categories', 'recent', 'popular'));
    }

    public function category(string $slug)
    {
        $category   = BlogCategory::where('slug', $slug)->firstOrFail();
        $posts      = Blog::published()->where('category_id', $category->id)->with(['author', 'category'])->latest('published_at')->paginate(9);
        $categories = BlogCategory::withCount(['blogs' => fn ($q) => $q->published()])->get();
        $recent     = Blog::published()->latest('published_at')->take(5)->get();
        $popular    = Blog::published()->orderByDesc('views')->take(5)->get();

        return view('blogs.category', compact('category', 'posts', 'categories', 'recent', 'popular'));
    }

    public function storeComment(Request $request, string $slug)
    {
        $post = Blog::published()->where('slug', $slug)->firstOrFail();

        if (!$post->allow_comments) {
            return back()->with('error', 'Comments are disabled for this post.');
        }

        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|max:150',
            'comment'   => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:blog_comments,id',
        ]);

        BlogComment::create([
            'blog_id'    => $post->id,
            'parent_id'  => $request->parent_id ?: null,
            'name'       => strip_tags($request->name),
            'email'      => $request->email,
            'comment'    => strip_tags($request->comment),
            'status'     => 'pending',
            'ip_address' => $request->ip(),
        ]);

        return back()->with('comment_success', 'Your comment has been submitted and is awaiting approval. Thank you!');
    }
}