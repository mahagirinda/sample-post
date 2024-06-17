@php use Carbon\Carbon; @endphp

@extends('layout.app')

@section('title', 'Inquiry Comment')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Inquiry Comment
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
                <th scope="col" class="col-2">By</th>
                <th scope="col" class="col-1">Comment</th>
                <th scope="col" class="col-1">Post Title</th>
                <th scope="col" class="col-1">Post Owner</th>
                <th scope="col" class="col-2 text-center">Created At</th>
                <th scope="col" class="col-1 text-center">Updated</th>
            </tr>
            </thead>
            <tbody>
            @if($comments->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No Comments Data</td>
                </tr>
            @else
                @foreach($comments as $comment)
                    <tr>
                        <td class="align-content-center d-flex align-items-center">
                            <img src="{{ url('storage/image/user/' . $comment->user->image) }}" class="image-profile-md ml-15 mr-25"
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
                            @if($comment->created_at != $comment->updated_at)
                                <span class="text-success icon lni lni-checkmark-circle"></span>
                            @else
                                <span class="text-danger icon lni lni-circle-minus"></span>
                            @endif
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
