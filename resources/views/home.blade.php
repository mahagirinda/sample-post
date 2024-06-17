@php use Carbon\Carbon;use Illuminate\Support\Str; @endphp

@extends('layout.app')

@section('title', 'Home')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    Home
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="row row-cols-md-3 gy-md-4 row-cols-1 gy-3">
        @if ($posts->isEmpty())
            <div class="col-md-12">
                <div class="card p-5">
                    <p class="text-center">
                        No Post Yet
                    </p>
                    <small class="text-center text-muted my-3">
                        Hey there! We're looking for awesome people to help us create awesome content. Wanna join the fun?
                    </small>
                    <small class="text-center text-muted mb-3">
                        Share your thoughts, experiences, or expertise by creating a post below. Click the <b>Create Post</b> button to get started and join the conversation!
                    </small>
                    <a href="{{ route('post.create') }}" class="btn btn-lg btn-primary mt-4"> Create Post</a>
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
                            <p class="card-text mb-2">
                                {{ Str::limit($post->contents) }}
                            </p>
                            <small class="text-muted text-xs">
                                {{ Carbon::parse($post->created_at)->format('d F Y - H:i') }} <br>
                                Posted by <b>{{ $post->user->name }}</b>
                                @if($post->user->role == 'admin')
                                    &nbsp;<span class="badge bg-info">Admin</span>
                                @endif
                            </small>
                            <br>
                            <hr>
                            <small class="text-muted text-xs align-content-center">
                                <span class="icon lni lni-eye mx-1"></span> <b>{{ $post->visit_counts }}</b>
                                <span class="mx-2"></span>
                                <span class="icon lni lni-comments mx-1"></span> <b>{{ $post->comments_count  }}</b>
                            </small>
                            <a href="{{ route('post.view', ['id' => $post->id]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
@endsection
