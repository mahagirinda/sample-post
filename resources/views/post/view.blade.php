@extends('layout.app')

@section('title', $post->title)

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Post</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ url()->previous() }}">Home</a>
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
        <div class="card">
            <div class="card-body">
                <div class="row row-cols-1">
                    <div class="col">
                        <img src="{{ url('storage/image/post/' . $post->image) }}" loading="lazy" class="img-fluid"
                             alt="{{ $post->title }}">
                    </div>
                    <div class="col mt-4 m-2">
                        <small class="text-muted">{{ $post->category }}</small>
                        <p class="text-black">
                            {{ $post->content }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
