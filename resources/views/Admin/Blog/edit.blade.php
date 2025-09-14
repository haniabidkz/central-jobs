@extends('layouts.admin')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>{{ $pageTitle }}</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin/blogs') }}">Blogs</a></li>
                    <li class="breadcrumb-item active">Edit Blog</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ url('admin/blogs/update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ old('title', $blog->title) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="featured_image">Featured Image</label>
                                <input type="file" name="featured_image" id="featured_image" class="form-control-file">
                                @if($blog->featured_image)
                                <div class="mt-2">
                                    <img src="{{ asset($blog->featured_image) }}" width="120" alt="Current Image">
                                </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="Draft" {{ old('status', $blog->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="Published" {{ old('status', $blog->status) == 'Published' ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea name="content" class="form-control editor" rows="8">{{ old('content', $blog->content) }}</textarea>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Update Blog</button>
                                <a href="{{ url('admin/blogs') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        $('.editor').summernote({
            height: 300,
            placeholder: 'Write your content here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>
@endsection