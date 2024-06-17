@php use Carbon\Carbon; @endphp

@extends('layout.app')

@section('title', 'Inquiry Category')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Inquiry Category
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
                <th scope="col" class="col-2">Name</th>
                <th scope="col" class="col-3">Detail</th>
                <th scope="col" class="col-1 text-center">Active</th>
                <th scope="col" class="col-2 text-center">Total Post</th>
                <th scope="col" class="col-2 text-center">Created At</th>
                <th scope="col" class="col-2 text-center">Updated</th>
            </tr>
            </thead>
            <tbody>
            @if($categories->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">No Post Data to Update</td>
                </tr>
            @else
                @foreach($categories as $category)
                    <tr>
                        <td>
                            {{ $category->name }}
                        </td>
                        <td>
                            {{ $category->detail }}
                        </td>
                        <td class="text-center align-content-center">
                            @if($category->status)
                                <span class="text-success icon lni lni-checkmark-circle"></span>
                            @else
                                <span class="text-danger icon lni lni-circle-minus"></span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $category->posts_count }}
                        </td>
                        <td class="text-center align-content-center">
                            <small>{{ Carbon::parse($category->created_at)->format('d F Y - H:i') }}</small>
                        </td>
                        <td class="text-center align-content-center">
                            @if($category->created_at != $category->updated_at)
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
        {{ $categories->links('pagination::bootstrap-4') }}
    </div>
@endsection
