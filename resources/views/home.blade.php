@extends('layout.app')

@section('title', 'Home')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Post</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Home
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="row row-cols-md-3 gy-md-4 row-cols-1 gy-3">
        @foreach($posts as $post)
            <div class="col">
                <div class="card">
                    <img src="{{ url('storage/image/post/' . $post->image) }}" loading="lazy" class="card-img-top"
                         alt="Pemandangan Alam">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted"><small>Category : {{ $post->category }}</small></h6>
                        <p class="card-text">
                            {{ $post->content }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
@endsection
