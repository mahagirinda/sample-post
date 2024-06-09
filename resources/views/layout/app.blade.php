<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="{{ url("images/favicon.svg") }}" type="image/x-icon"/>
    <title>Simple Post - @yield('title')</title>

    <link rel="stylesheet" href="{{ url("css/bootstrap.min.css") }}"/>
    <link rel="stylesheet" href="{{ url("css/lineicons.css") }}" type="text/css"/>
    <link rel="stylesheet" href="{{ url("css/main.css") }}"/>
</head>

<body>
<div id="preloader">
    <div class="spinner"></div>
</div>

<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <h3>Simple Post</h3>
    </div>
    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item {{ Request::is('post/home') ? 'active' : '' }}">
                <a href="{{ route('post.home') }}" aria-expanded="false">
                    <span class="icon lni lni-home"></span>
                    <span class="text">Home</span>
                </a>
            </li>
            @if($role === 'admin')
                <li class="nav-item {{ Request::is('post/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" aria-expanded="false">
                        <span class="icon lni lni-pie-chart"></span>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
            @endif
            <li class="nav-item {{ Request::is('post/create') ? 'active' : '' }}">
                <a href="{{ route('post.create') }}" aria-expanded="false">
                    <span class="icon lni lni-creative-commons"></span>
                    <span class="text">Create Post</span>
                </a>
            </li>
            <span class="divider">
                <hr/>
            </span>
            <li class="nav-item">
                <a href="#">
                    <span class="icon lni lni-user"></span>
                    <span class="text">My Post</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <span class="icon lni lni-user"></span>
                    <span class="text">My Comments</span>
                </a>
            </li>
            @if($role === 'admin')
            <span class="divider">
            <hr/>
            </span>
            <li class="nav-item nav-item-has-children">
                <a href="#" class="{{ (Request::is('post/inquiry') || Request::is('post/update/*')) ? 'collapse' : 'collapsed' }}"
                   data-bs-toggle="collapse" data-bs-target="#post-menu"
                   aria-controls="post-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon lni lni-paperclip"></span>
                    <span class="text">Post</span>
                </a>
                <ul id="post-menu"
                    class="collapse {{ (Request::is('post/inquiry') || Request::is('post/update/*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('post.inquiry')  }}" class="{{ Request::is('post/inquiry') ? 'active' : '' }}"> Inquiry </a>
                    </li>
                    <li>
                        <a href="{{ route('post.create') }}"> Create </a>
                    </li>
                    <li>
                        <a href="{{ route('post.inquiry')  }}" class="{{ Request::is('post/update/*') ? 'active' : '' }}"> Update </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-item-has-children">
                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_2"
                   aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon lni lni-comments"></span>
                    <span class="text">Comments</span>
                </a>
                <ul id="ddmenu_2" class="collapse dropdown-nav">
                    <li>
                        <a href="#"> Inquiry </a>
                    </li>
                    <li>
                        <a href="#"> Create </a>
                    </li>
                    <li>
                        <a href="#"> Update </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-item-has-children">
                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_3"
                   aria-controls="ddmenu_3" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon lni lni-comments"></span>
                    <span class="text">Categories</span>
                </a>
                <ul id="ddmenu_3" class="collapse dropdown-nav">
                    <li>
                        <a href="#"> Inquiry </a>
                    </li>
                    <li>
                        <a href="#"> Create </a>
                    </li>
                    <li>
                        <a href="#"> Update </a>
                    </li>
                </ul>
            </li>
            @endif
            <span class="divider">
                <hr/>
            </span>
            <li class="nav-item">
                <a href="#">
                    <span class="icon lni lni-comments"></span>
                    <span class="text">Notifications</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
<div class="overlay"></div>

<main class="main-wrapper">
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-6">
                    <div class="header-left d-flex align-items-center">
                        <div class="menu-toggle-btn mr-15">
                            <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                                <i class="lni lni-chevron-left me-2"></i> Menu
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-6">
                    <div class="header-right">
                        <div class="profile-box ml-15">
                            <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="profile-info">
                                    <div class="info">
                                        <div class="image">
                                            <img src="{{ url("storage/image/profile/profile-image.png" )}}" alt=""/>
                                        </div>
                                        <div>
                                            <h6 class="fw-500">Adam Joe</h6>
                                            <p>Admin</p>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                                <li>
                                    <div class="author-info flex items-center !p-1">
                                        <div class="image">
                                            <img src="{{ url("storage/image/profile/profile-image.png" )}}" alt="image">
                                        </div>
                                        <div class="content">
                                            <h4 class="text-sm">Adam Joe</h4>
                                            <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs"
                                               href="#">Email@gmail.com</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#">
                                        <i class="lni lni-user"></i> View Profile
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#"> <i class="lni lni-exit"></i> Sign Out </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="section">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>@yield('title')</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @yield('breadcrumb')
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </section>

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 order-last order-md-first">
                    <div class="copyright text-center text-md-start">
                        <p class="text-sm">
                            Simple Project for
                            <a href="https://praktisimengajar.kampusmerdeka.kemdikbud.go.id/" rel="nofollow"
                               target="_blank">
                                Praktisi Mengajar
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="terms d-flex justify-content-center justify-content-md-end">
                        <span class="text-sm">Pemrograman Web</span>
                        <a href="https://pnb.ac.id/" class="text-sm ml-15">Politeknik Negeri Bali</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</main>

<script src="{{ url("js/bootstrap.bundle.min.js") }}"></script>
<script src="{{ url("js/main.js") }}"></script>
</body>

</html>