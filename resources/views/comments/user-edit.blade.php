@php use Illuminate\Support\Str; @endphp
@extends('layout.app')

@section('title', 'Edit Comment')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('comment.user') }}">My Comments</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Edit
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <form action="{{ route('comment.user.update', $comment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="id" value="{{ old('id', $comment->id) }}">

        <div class="mb-3">
            <label for="comment" class="form-label">Post</label>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $comment->post->title }}</h5>
                    <small class="card-subtitle text-xs">
                        by <b>{{ $comment->post->user->name }}</b>
                    </small>
                    <p class="card-text">
                        {{ Str::limit($comment->post->contents, 200) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Old Comment</label>
            <div class="card">
                <div class="card-body">
                    {{ $comment->comment }}
                </div>
            </div>
        </div>

        <input type="hidden" name="id value="{{ old('id', $comment->id) }}">

        <input type="hidden" name="post_id" value="{{ old('post_id', $comment->post->id) }}">

        <div class="mb-3">
            <label for="comment" class="form-label">New Comment</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="comment"
                      name="comment" rows="5">{{ old('comment', $comment->comment) }}</textarea>
            @error('comment')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Comment</button>
    </form>
@endsection
