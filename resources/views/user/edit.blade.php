@extends('layout.app')

@section('title', 'Edit User')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('user.edit.list') }}">Edit</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $user->name }}
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data" autocomplete="off">

        @csrf

        @method('PUT')

        <input type="hidden" name="id" value="{{ old('id', $user->id) }}">

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                   value="{{ old('name', $user->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                   value="{{ old('email', $user->email) }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Profile Image (Optional)</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <p class="d-inline-flex gap-1 pt-3">
                <button class="btn btn-sm btn-secondary" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseImage" aria-expanded="false" aria-controls="collapseImage">
                    Show Current Profile Image
                </button>
            </p>
            <div class="collapse pt-2" id="collapseImage">
                <div class="card card-body">
                    <img src="{{ url('storage/image/user/' . $user->image) }}" alt="">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">User Role</label>
            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role"
                    required>
                <option value="user" @if($user->role == 'user') selected @endif>User</option>
                <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
            </select>
            @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Password (Optional)</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                       value="" autocomplete="new-password">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Password Confirmation</label>
                <input type="text" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation"
                       value="">
                @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Edit User</button>
    </form>
@endsection
