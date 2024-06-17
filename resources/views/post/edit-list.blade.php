@extends('layout.app')

@section('title', 'Edit Post')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Edit Post
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
                <th scope="col" class="col-2">Title</th>
                <th scope="col" class="col-1 text-center">Draft</th>
                <th scope="col" class="col-1">Category</th>
                <th scope="col" class="col-7">Content</th>
                <th scope="col" class="col-1 text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @if($posts->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">No Post Data to Update</td>
                </tr>
            @else
                @foreach($posts as $post)
                    <tr>
                        <td class="align-content-center">
                            {{ $post->title }}
                        </td>
                        <td class="text-center align-content-center">
                            @if($post->draft)
                                <span class="text-success icon lni lni-checkmark-circle"></span>
                            @else
                                <span class="text-danger icon lni lni-circle-minus"></span>
                            @endif
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
                            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary btn-sm">Edit</a>
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
