@php use Carbon\Carbon; @endphp

@extends('layout.app')

@section('title', 'My Comments')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    My Comments
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-borderless table-responsive">
            <thead>
            <tr>
                <th scope="col" class="col-2">Post</th>
                <th scope="col" class="col-1">Creator</th>
                <th scope="col" class="col-5">Comments</th>
                <th scope="col" class="col-2 text-center">Created At</th>
                <th scope="col" colspan="2" class="col-2 text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @if($comments->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">You don't have any comment to a post yet</td>
                </tr>
            @else
                @foreach($comments as $comment)
                    <tr>
                        <td class="align-content-center">
                            {{ $comment->post->title }}
                        </td>
                        <td class="align-content-center">
                            {{ $comment->post->user->name }}
                        </td>
                        <td class="align-content-center">
                            {{ $comment->comment }}
                        </td>
                        <td class="text-center align-content-center">
                            <small>{{ Carbon::parse($comment->created_at)->format('d F Y - H:i') }}</small>
                        </td>
                        <td class="text-center align-content-center">
                            <a href="{{ route('post.view', $comment->post->id) }}" class="btn btn-sm btn-primary">View
                                Post</a>
                        </td>
                        <td class="text-center align-content-center">
                            <a href="{{ route('comment.user.edit', $comment->id) }}" class="btn btn-sm btn-primary">Edit</a>
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
