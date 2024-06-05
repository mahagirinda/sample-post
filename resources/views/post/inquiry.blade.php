@extends('layout.app')

@section('title', 'Post Inquiry')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('post.home') }}">Post</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Inquiry
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped table-borderless">
        <thead>
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Content</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ $post->category }}</td>
                <td>{{ $post->content }}</td>
                <td>
                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
