@php use Carbon\Carbon; @endphp

@extends('layout.app')

@section('title', 'Edit User')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Edit User
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
                <th scope="col" class="col-1">Image</th>
                <th scope="col" class="col-4 text-center">Name</th>
                <th scope="col" class="col-1">Role</th>
                <th scope="col" class="col-2">Email</th>
                <th scope="col" class="col-2 text-center">Registered At</th>
                <th scope="col" class="col-2 text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @if($users->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No User Data to Update</td>
                </tr>
            @else
                @foreach($users as $user)
                    <tr>
                        <td class="align-content-center">
                            <img src="{{ url('storage/image/user/' . $user->image) }}" class="inquiry-image-post"
                                 alt="{{ "content-image-".$user->id }}" loading="lazy">
                        </td>
                        <td class="text-center align-content-center">
                            {{ $user->name }}
                        </td>
                        <td class="align-content-center">
                            {{ $user->role }}
                        </td>
                        <td class="align-content-center">
                            {{ $user->email }}
                        </td>
                        <td class="text-center align-content-center">
                            {{ Carbon::parse($user->created_at)->format('d F Y - H:i') }}
                        </td>
                        <td class="text-center align-content-center">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $users->links('pagination::bootstrap-4') }}
    </div>
@endsection
