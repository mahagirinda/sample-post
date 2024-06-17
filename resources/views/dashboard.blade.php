@php use Carbon\Carbon;use Illuminate\Support\Str; @endphp

@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <h2 class="mb-3 mt-4 mt-md-0">Summary</h2>
    <div class="row row-cols-md-3 gy-md-4 row-cols-1 gy-3">
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="card-title">{{ $dashboard->user }}</h1>
                    <h6 class="card-subtitle mb-2 text-body-secondary">User Registered</h6>
                    <p class="card-text text-muted text-xs">
                        New user registered! Welcome to our community!
                    </p>
                    <a href="{{ route('user.inquiry') }}" class="link-info mt-2 text-xs">View Registered User</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="card-title">{{ $dashboard->post }}</h1>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Post Created</h6>
                    <p class="card-text text-muted text-xs">
                        New post created! Check it out on the app now!
                    </p>
                    <a href="{{ route('post.inquiry') }}" class="link-info mt-2 text-xs">View Created Post</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="card-title">{{ $dashboard->comment }}</h1>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Total Comments</h6>
                    <p class="card-text text-muted text-xs">
                        New comments created on each post! Check them out!
                    </p>
                    <a href="{{ route('comment.inquiry') }}" class="link-info mt-2 text-xs">View Comments</a>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-3 mt-5">Recent Comments</h2>
    <div class="row row-cols-md-4 gy-md-4 row-cols-1 gy-3">
        @if ($comments->isEmpty())
            <div class="col-md-12">
                <div class="card p-5">
                    <p class="text-center">
                        No Comments Yet
                    </p>
                </div>
            </div>
        @else
            @foreach($comments as $comment)
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="align-content-center d-flex align-items-center">
                                <img src="{{ url('storage/image/user/' . $comment->user->image) }}" class="image-profile-sm mr-10"
                                     alt="{{ "content-image-" . $comment->user->name }}" loading="lazy">
                                {{ $comment->user->name }}
                            </div>
                            <p class="card-text mt-3">
                                 {{ $comment->comment }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <h2 class="mb-3 mt-5">Recent Post</h2>
    <div class="row row-cols-md-3 gy-md-4 row-cols-1 gy-3">
        @if ($posts->isEmpty())
            <div class="col-md-12">
                <div class="card p-5">
                    <p class="text-center">
                        No Post Yet
                    </p>
                </div>
            </div>
        @else
            @foreach($posts as $post)
                <div class="col">
                    <div class="card">
                        <img src="{{ url('storage/image/post/' . $post->image) }}" loading="lazy" class="card-img-top"
                             alt="{{ $post->title }}">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $post->title }}
                                @if($post->created_at != $post->updated_at)
                                    &nbsp;<span class="badge bg-secondary">Edited</span>
                                @endif
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted"><small>{{ $post->category->name }}</small></h6>
                            <p class="card-text mb-0">
                                {{ Str::limit($post->contents) }}
                            </p>
                            <a href="{{ route('post.view', ['id' => $post->id]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
