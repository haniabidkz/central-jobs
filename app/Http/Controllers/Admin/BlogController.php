<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $activeModule = 'blogs';
        $pageTitle = 'Blogs';
        $data = Blog::with([
            'user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }
        ])->paginate(20);

        return view('Admin.Blog.index', compact('activeModule', 'pageTitle', 'data'));
    }
    public function add()
    {
        $activeModule = 'blogs';
        $pageTitle = 'Add Blog';
        return view('Admin.Blog.add', compact('activeModule', 'pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255|unique:blogs,title',
            'content'        => 'required|string',
            'status'         => 'required|string|in:Draft,Published',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $blog = new Blog();
        $blog->title   = $request->title;
        $blog->slug    = Str::slug($request->title); // clean slug
        $blog->content = $request->content;
        $blog->status  = $request->status;
        $blog->user_id = auth()->id(); // set logged-in admin user

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $file      = $request->file('featured_image');
            $filename  = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/blogs'), $filename);
            $blog->featured_image = 'upload/blogs/' . $filename;
        }

        $blog->save();

        return redirect()->to('admin/blogs')->with('success', 'Blog created successfully.');
    }


    public function edit($id)
    {
        $activeModule = 'blogs';
        $pageTitle    = 'Edit Blog';
        $blog         = Blog::findOrFail($id);

        return view('Admin.Blog.edit', compact('activeModule', 'pageTitle', 'blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title'          => 'required|string|max:255|unique:blogs,title,' . $blog->id,
            'content'        => 'required|string',
            'status'         => 'required|string|in:Draft,Published',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $blog->title   = $request->title;
        $blog->slug    = \Illuminate\Support\Str::slug($request->title);
        $blog->content = $request->content;
        $blog->status  = $request->status;
        $blog->user_id = auth()->id();

        // Replace image if uploaded
        if ($request->hasFile('featured_image')) {
            $file      = $request->file('featured_image');
            $filename  = time() . '_' . \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/blogs'), $filename);
            $blog->featured_image = 'upload/blogs/' . $filename;
        }

        $blog->save();

        return redirect()->to('admin/blogs')->with('success', 'Blog updated successfully.');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Optional: delete image if stored locally
        if ($blog->featured_image && file_exists(public_path($blog->featured_image))) {
            @unlink(public_path($blog->featured_image));
        }

        $blog->delete();

        return redirect()->to('admin/blogs')->with('success', 'Blog deleted successfully.');
    }
}
