@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('layout.app')

@section('title', $user->name)

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $user->name }}
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-3">
                    <img
                        src="{{ url('storage/image/user/' . $user->image) }}"
                        alt="Generic placeholder image" class="img-fluid image-profile">
                </div>
                <div class="col-md-9 mt-5 mt-md-0">
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="mb-2 pb-1">{{ $user->email }}</p>
                    <div class="d-flex justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                        <div>
                            <p class="small text-muted mb-1">Posts</p>
                            <p class="mb-0">{{ $user->posts_count }}</p>
                        </div>
                        <div class="px-5">
                            <p class="small text-muted mb-1">Comments</p>
                            <p class="mb-0">{{ $user->comments_count }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2 class="p-2 mt-5 mb-2">
        {{ $user->name }}'s Posts
    </h2>
    <div class="card">
        <div class="card-body p-4">
            <div class="row row-cols-md-3 gy-md-4 row-cols-1 gy-3">
                @if ($user->posts->isEmpty())
                    <div class="col-md-12">
                        <div class="card p-5 text-center">
                            {{ $user->name }} has no post yet
                        </div>
                    </div>
                @else
                    @foreach($user->posts as $post)
                        <div class="col">
                            <div class="card">
                                <img src="{{ url('storage/image/post/' . $post->image) }}" loading="lazy"
                                     class="card-img-top"
                                     alt="{{ $post->title }}">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        {{ $post->title }}
                                        @if($post->created_at != $post->updated_at)
                                            &nbsp;<span class="badge bg-secondary">Edited</span>
                                        @endif
                                        @if($post->draft)
                                            &nbsp;<span class="ml-2 badge bg-warning">On Draft</span>
                                        @endif
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted"><small>{{ $post->category->name }}</small>
                                    </h6>
                                    <p class="card-text mb-2">
                                        {{ Str::limit($post->contents) }}
                                    </p>
                                    <div class="text-muted text-xs">
                                        {{ Carbon::parse($post->created_at)->format('d F Y - H:i') }}
                                    </div>
                                    <a href="{{ route('post.view', ['id' => $post->id]) }}" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
