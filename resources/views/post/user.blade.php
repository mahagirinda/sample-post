@php use Carbon\Carbon; @endphp

@extends('layout.app')

@section('title', 'My Post')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    My Post
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
                <th scope="col" class="col-2">Title</th>
                <th scope="col" class="col-1 text-center">Draft</th>
                <th scope="col" class="col-1">Image</th>
                <th scope="col" class="col-1">Category</th>
                <th scope="col" class="col-4">Content</th>
                <th scope="col" class="col-2 text-center">Created At</th>
                <th scope="col" class="col-1 text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @if($posts->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">You don't have any post yet</td>
                </tr>
            @else
                @foreach($posts as $post)
                    <tr>
                        <td class="align-content-center align-items-center">
                            {{ $post->title }}
                            @if(!$post->category->status)
                                <span class="text-warning icon lni lni-warning mx-2 fs-5"
                                      data-bs-toggle="tooltip"
                                      data-bs-placement="bottom"
                                      data-bs-title="This post is disable due to {{ $post->category->name }} category is disabled!">
                                </span>
                            @endif
                        </td>
                        <td class="text-center align-content-center">
                            @if($post->draft)
                                <span class="text-success icon lni lni-checkmark-circle"></span>
                            @else
                                <span class="text-danger icon lni lni-circle-minus"></span>
                            @endif
                        </td>
                        <td class="align-content-center">
                            <img src="{{ url('storage/image/post/' . $post->image) }}" class="inquiry-image-post"
                                 alt="{{ "content-image-".$post->id }}" loading="lazy">
                        </td>
                        <td class="align-content-center">
                            {{ $post->category->name }}
                        </td>
                        <td class="align-content-center">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="{{ "#content-collapse-".$post->id }}"
                                                aria-expanded="false"
                                                aria-controls="{{ "content-collapse-".$post->id }}">
                                            Show Content
                                        </button>
                                    </h2>
                                    <div id="{{ "content-collapse-".$post->id }}" class="accordion-collapse collapse"
                                         data-bs-parent="{{ "content-".$post->id }}">
                                        <div class="accordion-body">
                                            {{ $post->contents }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center align-content-center">
                            <small>{{ Carbon::parse($post->created_at)->format('d F Y - H:i') }}</small>
                        </td>
                        <td class="text-center align-content-center">
                            <a href="{{ route('post.view', $post->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
@endsection

@section('additional-script')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection
