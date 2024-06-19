<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="{{ url("images/icon.png") }}" type="image/x-icon"/>
    <title>{{ env('APP_NAME') }} - Verify Your Email Address</title>

    <link rel="stylesheet" href="{{ url("css/bootstrap.min.css") }}"/>
    <link rel="stylesheet" href="{{ url("css/lineicons.css") }}" type="text/css"/>
    <link rel="stylesheet" href="{{ url("css/main.css") }}"/>
    <link rel="stylesheet" href="{{ url("css/additional.css") }}"/>
</head>

<body>
<div id="preloader">
    <div class="spinner"></div>
</div>

<div class="container-md mt-50">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center">{{ __('click here to request another') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ url("js/bootstrap.bundle.min.js") }}"></script>
<script src="{{ url("js/main.js") }}"></script>
</body>

</html>
