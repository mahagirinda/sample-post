@extends('layout.app')

@section('title', 'Edit Post')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('post.user') }}">My Post</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $post->title }}
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <form action="{{ route('post.user.update', $post->id) }}" method="POST" enctype="multipart/form-data">

        @csrf

        @method('PUT')

        <input type="hidden" name="id" value="{{ old('id', $post->id) }}">

        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="draft" name="draft" @if($post->draft) checked @endif>
                <label class="form-check-label" for="flexSwitchCheckChecked">Set as Draft</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                   value="{{ old('title', $post->title) }}">
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image (Optional)</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <p class="d-inline-flex gap-1 pt-3">
                <button class="btn btn-sm btn-secondary" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseImage" aria-expanded="false" aria-controls="collapseImage">
                    Show Current Post Image
                </button>
            </p>
            <div class="collapse pt-2" id="collapseImage">
                <div class="card card-body">
                    <img src="{{ url('storage/image/post/' . $post->image) }}" alt="">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id"
                    required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                            @if($category->id == $post->category->id) selected @endif>{{ $category->name }} </option>
                @endforeach
            </select>
            @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="post_content" class="form-label">Content</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="post_content"
                      name="post_content" rows="5">{{ old('content', $post->contents) }}</textarea>
            @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
@endsection
