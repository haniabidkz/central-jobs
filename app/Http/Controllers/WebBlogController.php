<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebBlogController extends Controller
{
    public function index()
    {

        $data = Blog::take(9)->get();
        return view('frontend.blog.index', compact('data'));
    }
}
