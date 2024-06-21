@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('layout.app')

@section('title', Auth::user()->name)

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    My Profile
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-3 image-profile-wrapper">
                    <img
                        src="{{ url('storage/image/user/' . $user->image) }}"
                        alt="Generic placeholder image" class="img-fluid image-profile">
                </div>
                <div class="col-md-9 mt-5 mt-md-0">
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="mb-2 pb-1">{{ $user->email }}</p>
                    <div class="d-flex justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                        <div>
                            <p class="small text-muted mb-1">Posts</p>
                            <p class="mb-0">{{ $user->posts_count }}</p>
                        </div>
                        <div class="px-5">
                            <p class="small text-muted mb-1">Comments</p>
                            <p class="mb-0">{{ $user->comments_count }}</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" data-bs-toggle="modal" data-bs-target="#edit-profile">Edit Profile</button>
                </div>
            </div>
        </div>
    </div>

    <h2 class="p-2 mt-5 mb-2">
        My Posts
    </h2>
    <div class="card">
        <div class="card-body p-4">
            <div class="row row-cols-md-3 gy-md-4 row-cols-1 gy-3">
                @if ($user->posts->isEmpty())
                    <div class="col-md-12">
                        <div class="card p-5 text-center">
                            You have no post yet
                        </div>
                    </div>
                @else
                    @foreach($user->posts as $post)
                        <div class="col">
                            <div class="card">
                                <img src="{{ url('storage/image/post/' . $post->image) }}" loading="lazy"
                                     class="card-img-top"
                                     alt="{{ $post->title }}">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        {{ $post->title }}
                                        @if($post->created_at != $post->updated_at)
                                            &nbsp;<span class="badge bg-secondary">Edited</span>
                                        @endif
                                        @if($post->created_at != $post->updated_at)
                                            &nbsp;<span class="ml-2 badge bg-warning">On Draft</span>
                                        @endif
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted"><small>{{ $post->category->name }}</small>
                                    </h6>
                                    <p class="card-text mb-2">
                                        {{ Str::limit($post->contents) }}
                                    </p>
                                    <div class="text-muted text-xs">
                                        {{ Carbon::parse($post->created_at)->format('d F Y - H:i') }}
                                    </div>
                                    <a href="{{ route('post.view', ['id' => $post->id]) }}" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection

@section('additional-modal')
    <div class="modal fade" id="edit-profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data"
                          autocomplete="off" id="edit-user-form">

                        @csrf

                        @method('PUT')

                        <input type="hidden" name="id" value="{{ old('id', $user->id) }}">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                   name="name"
                                   value="{{ old('name', $user->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                   value="{{ old('email', $user->email) }}" disabled>
                            <small>Contact Admin to Update Your Email</small>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image (Optional)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                   name="image">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Password (Optional)</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password"
                                       value="" autocomplete="new-password">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Password Confirmation</label>
                                <input type="text"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       id="password_confirmation" name="password_confirmation"
                                       value="">
                                @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-primary"
                            onclick="event.preventDefault(); document.getElementById('edit-user-form').submit();">
                        Update
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
