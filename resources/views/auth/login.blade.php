<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="{{ url("images/icon.png") }}" type="image/x-icon"/>
    <title>{{ config('app.name') }} - Login</title>

    <link rel="stylesheet" href="{{ url("css/bootstrap.min.css") }}"/>
    <link rel="stylesheet" href="{{ url("css/lineicons.css") }}" type="text/css"/>
    <link rel="stylesheet" href="{{ url("css/main.css") }}"/>
    <link rel="stylesheet" href="{{ url("css/additional.css") }}"/>
</head>

<body>
<div id="preloader">
    <div class="spinner"></div>
</div>

<div class="container-md">
    <section class="signin-section">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Simple Post</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        Login
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-0 auth-row">
                <div class="col-lg-6">
                    <div class="auth-cover-wrapper bg-primary-100">
                        <div class="auth-cover">
                            <div class="title text-center">
                                <h1 class="text-primary mb-10">Welcome Back</h1>
                                <p class="text-medium">
                                    Sign in to your Existing account to continue!
                                </p>
                            </div>
                            <div class="cover-image">
                                <img src="{{ url('images/auth/signin-image.svg') }}" alt=""/>
                            </div>
                            <div class="shape-image">
                                <img src="{{ url('images/auth/shape.svg') }}" alt=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-lg-6">
                    <div class="signin-wrapper">
                        <div class="form-wrapper">
                            <h6 class="mb-15">Log In Form</h6>
                            <p class="text-sm mb-25">
                                Let's create a post! Log in to the the app now!
                            </p>
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>Email Address</label>
                                            <input class="form-control @error('email') is-invalid @enderror"
                                                   type="email"
                                                   placeholder="Email" name="email"/>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>Password</label>
                                            <input type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="Password" name="password" required
                                                   autocomplete="current-password"/>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-lg-12 col-md-6">
                                        <div class="form-check checkbox-style mb-30">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                   id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="remember">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-lg-12 col-md-6">
                                        <div class="text-start text-md-end text-lg-start text-xxl-end mb-30">
                                            <a href="{{ route('password.request') }}" class="hover-underline">
                                                Forgot Password?
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="button-group d-flex justify-content-center flex-wrap">
                                            <button class="main-btn primary-btn btn-hover w-100 text-center">
                                                Log In
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="singin-option pt-40">
                                <p class="text-sm text-medium text-dark text-center">
                                    Don’t have any account yet?
                                    <a href="{{ route('register') }}">Create an account</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ url("js/bootstrap.bundle.min.js") }}"></script>
<script src="{{ url("js/main.js") }}"></script>
</body>

</html>
