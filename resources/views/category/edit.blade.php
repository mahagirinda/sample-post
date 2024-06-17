@extends('layout.app')

@section('title', 'Update Category')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ url()->previous() }}">Edit Category</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $category->name }}
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <form action="{{ route('category.update') }}" method="POST">

        @csrf

        @method('PUT')

         <input type="hidden" name="id" value="{{ old('id', $category->id) }}">

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                   value="{{ old('name', $category->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="detail" class="form-label">Category Detail</label>
            <textarea class="form-control @error('detail') is-invalid @enderror" id="detail"
                      name="detail" rows="5">{{ old('name', $category->detail) }}</textarea>
            @error('detail')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" @if($category->status) checked @endif>
                 <label class="form-check-label" for="flexSwitchCheckChecked">Show related post at <b>Home Page</b></label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
@endsection
