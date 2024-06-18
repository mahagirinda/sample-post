@php use Carbon\Carbon; @endphp

@extends('layout.app')

@section('title', 'Inquiry User')

@section('breadcrumb')
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Inquiry User
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
                <th scope="col" class="col-3 text-center">User</th>
                <th scope="col" class="col-1">Role</th>
                <th scope="col" class="col-2">Email</th>
                <th scope="col" class="col-3 text-center">Registered At</th>
                <th scope="col" class="col-3 text-center">Last Update At</th>
            </tr>
            </thead>
            <tbody>
            @if($users->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">No User Data</td>
                </tr>
            @else
                @foreach($users as $user)
                    <tr>
                        <td class="align-content-center d-flex align-items-center">
                            <img src="{{ url('storage/image/user/' . $user->image) }}" class="image-profile-md ml-15 mr-25"
                                 alt="{{ "content-image-" . $user->name }}" loading="lazy">
                            {{ $user->name }}
                        </td>
                        <td class="align-content-center">
                            @if($user->role == 'admin')
                                <span class="badge bg-info">Admin</span>
                            @else
                                <span class="badge bg-secondary">User</span>
                            @endif
                        </td>
                        <td class="align-content-center">
                            {{ $user->email }}
                        </td>
                        <td class="text-center align-content-center">
                            {{ Carbon::parse($user->created_at)->format('d F Y - H:i') }}
                        </td>
                        <td class="text-center align-content-center">
                            {{ Carbon::parse($user->updated_at)->format('d F Y - H:i') }}
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
