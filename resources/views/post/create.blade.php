@extends('layout.app')

@section('title', 'Create')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Post</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Create
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="draft" name="draft">
                <label class="form-check-label" for="flexSwitchCheckChecked">Set as Draft</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                   value="{{ old('title') }}">
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id"
                    required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="post_content" class="form-label">Content</label>
            <textarea class="form-control @error('post_content') is-invalid @enderror" id="post_content"
                      name="post_content" rows="5">{{ old('post_content') }}</textarea>
            @error('post_content')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save Post</button>
    </form>
@endsection
