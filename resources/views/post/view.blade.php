@php use Carbon\Carbon; @endphp

@extends('layout.app')

@section('title', $post->title)

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ url()->previous() }}">Post</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $post->title }}
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container-fluid m-0 p-0">
        <div class="card p-2">
            <div class="card-body">
                <div class="row row-cols-1">
                    <div class="col">
                        <img src="{{ url('storage/image/post/' . $post->image) }}" loading="lazy"
                             class="img-fluid w-100 rounded"
                             alt="{{ $post->title }}">
                    </div>
                    <div class="col mt-4 m-2">
                        <h4 class="text-muted lh-1">
                            <span class="badge bg-secondary" data-bs-toggle="tooltip"
                                  data-bs-placement="right" data-bs-title="{{ $post->category->detail }}">
                                {{ $post->category->name }}
                            </span>
                        </h4>
                        <div class="align-content-center d-flex align-items-center text-muted text-xs my-3 mt-4">
                            <img src="{{ url('storage/image/user/' . $post->user->image) }}"
                                 class="image-profile-sm mr-10"
                                 alt="{{ "content-image-" . $post->user->name }}" loading="lazy">
                            {{ $post->user->name }}
                            @if($post->user->role == 'admin')
                                &nbsp;<span class="badge bg-info">Admin</span>
                            @endif
                        </div>
                        <small class="text-muted text-xs">{{ Carbon::parse($post->created_at)->format('d F Y - H:i') }}</small>
                        <p class="text-black mt-2">
                            {{ $post->contents }}
                        </p>
                    </div>
                </div>

                <div class="m-2 mt-4">
                    <form action="{{ route('comment.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ old('id', $post->id) }}">

                        <div class="mb-3">
                            <label for="post_content" class="form-label">Your Comment</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment"
                                      name="comment" rows="2">{{ old('comment') }}</textarea>
                            @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Send Comment</button>
                    </form>
                </div>
            </div>
        </div>

        <h2 class="p-2 mt-5">
            Comments
        </h2>
        <div class="row row-cols-1 mt-2 gy-2">
            @if ($post->comments->isEmpty())
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            No Comments yet on this post.
                        </div>
                    </div>
                </div>
            @else
                @foreach($post->comments as $comment)
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title mb-3">
                                    <div class="align-content-center d-flex align-items-center">
                                        <img src="{{ url('storage/image/user/' . $comment->user->image) }}"
                                             class="image-profile-sm mr-10"
                                             alt="{{ "content-image-" . $comment->user->name }}" loading="lazy">
                                        {{ $comment->user->name }}
                                        @if($comment->user->id == $post->user->id)
                                            &nbsp;<span class="badge bg-success ml-5">Owner</span>
                                        @endif
                                        @if($comment->created_at != $comment->updated_at)
                                            &nbsp;<span class="badge bg-secondary ml-5">Edited</span>
                                        @endif
                                        @if($post->user->role == 'admin')
                                            &nbsp;<span class="badge bg-info ml-5">Admin</span>
                                        @endif
                                    </div>
                                </div>
                                <h6 class="card-subtitle mb-2 text-xs">{{ Carbon::parse($comment->created_at)->format('d F Y - H:i') }}</h6>
                                <p class="card-text">
                                    {{ $comment->comment }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
