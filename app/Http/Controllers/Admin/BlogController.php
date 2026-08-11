<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = \DB::table('blogs')->latest()->paginate(15);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'required|in:draft,published',
        ]);

        $data = [
            'title'      => $request->title,
            'slug'       => \Str::slug($request->title),
            'content'    => $request->content,
            'status'     => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        \DB::table('blogs')->insert($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created!');
    }

    public function edit($id)
    {
        $blog = \DB::table('blogs')->find($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'required|in:draft,published',
        ]);

        $data = [
            'title'      => $request->title,
            'slug'       => \Str::slug($request->title),
            'content'    => $request->content,
            'status'     => $request->status,
            'updated_at' => now(),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        \DB::table('blogs')->where('id', $id)->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated!');
    }

    public function destroy($id)
    {
        \DB::table('blogs')->delete($id);
        return back()->with('success', 'Blog post deleted!');
    }
}