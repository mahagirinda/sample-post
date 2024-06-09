@extends('layout.app')

@section('title', 'Inquiry')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Post</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Inquiry
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <table class="table table-striped table-borderless">
        <thead>
        <tr>
            <th scope="col" class="col-2">Title</th>
            <th scope="col" class="col-1">Image</th>
            <th scope="col" class="col-1">Category</th>
            <th scope="col" class="col-5">Content</th>
            <th scope="col" class="col-2">Created At</th>
            <th scope="col" class="col-1">Updated</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td class="align-content-center">
                    {{ $post->title }}
                </td>
                <td class="align-content-center">
                    <img src="{{ url('storage/image/post/' . $post->image) }}" class="inquiry-image-post"
                         alt="{{ "content-image-".$post->id }}" loading="lazy">
                </td>
                <td class="align-content-center">
                    {{ $post->category }}
                </td>
                <td class="align-content-center">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="{{ "#content-collapse-".$post->id }}" aria-expanded="false"
                                        aria-controls="{{ "content-collapse-".$post->id }}">
                                    Show Content
                                </button>
                            </h2>
                            <div id="{{ "content-collapse-".$post->id }}" class="accordion-collapse collapse"
                                 data-bs-parent="{{ "content-".$post->id }}">
                                <div class="accordion-body">
                                    {{ $post->content }}
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center align-content-center">
                    <small>{{ $post->created_at }}</small>
                </td>
                <td class="text-center align-content-center">
                    @if($post->created_at == $post->updated_at)
                        <span class="text-success icon lni lni-checkmark-circle"></span>
                    @else
                        <span class="text-danger icon lni lni-circle-minus"></span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
