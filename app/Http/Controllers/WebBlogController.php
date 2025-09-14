<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebBlogController extends Controller
{
    public function index()
    {

        $data = Blog::latest()->take(9)->get();
        return view('frontend.blog.index', compact('data'));
    }

    public function detail($slug)
    {
        // If you’re using slug
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('frontend.blog.detail', compact('blog'));
    }
}
