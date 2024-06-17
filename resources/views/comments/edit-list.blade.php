@php use Carbon\Carbon; @endphp

@extends('layout.app')

@section('title', 'Edit Comment')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Edit Comment
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-borderless">
            <thead>
            <tr>
                <th scope="col" class="col-1">By</th>
                <th scope="col" class="col-2">Comment</th>
                <th scope="col" class="col-2">Post Title</th>
                <th scope="col" class="col-1">Post Owner</th>
                <th scope="col" class="col-2 text-center">Created At</th>
                <th scope="col" colspan="2" class="col-2 text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @if($comments->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No Comments Data to Update</td>
                </tr>
            @else
                @foreach($comments as $comment)
                    <tr>
                        <td class="align-content-center d-flex align-items-center">
                            <img src="{{ url('storage/image/user/' . $comment->user->image) }}" class="inquiry-image-post mr-25"
                                 alt="{{ "content-image-" . $comment->user->name }}" loading="lazy">
                            {{ $comment->user->name }}
                        </td>
                        <td class="align-content-center">
                            {{ $comment->comment }}
                        </td>
                        <td class="align-content-center">
                            {{ $comment->post->title }}
                        </td>
                        <td class="align-content-center">
                            {{ $comment->post->user->name }}
                        </td>
                        <td class="text-center align-content-center">
                            <small>{{ Carbon::parse($comment->created_at)->format('d F Y - H:i') }}</small>
                        </td>
                        <td class="text-center align-content-center">
                            <a href="{{ route('post.view', $comment->post->id) }}" class="btn btn-sm btn-primary">View
                                Post</a>
                        </td>
                        <td class="text-center align-content-center">
                            <a href="{{ route('comment.edit', $comment->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $comments->links('pagination::bootstrap-4') }}
    </div>
@endsection
