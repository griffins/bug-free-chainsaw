@extends('layouts.layout')
@section('body')
    <div class="navbar-expand-md">
        <div class="collapse navbar-collapse d-print-none" id="navbar-menu">
            <div class="navbar navbar-light">
                <div class="container-xl">
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                        <img src="{{ asset('logo.png') }}" height="32" alt="Logo" class="navbar-brand-image">
                        <span>
                            &nbsp; {{ config('app.name') }}
                        </span>
                    </h1>
                    <div class="collapse navbar-collapse">
                        <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                            <ul class="navbar-nav">
                                {!! sidebar_list_item('match','Upcoming Matches','calendar-stats') !!}
                                {!! sidebar_list_item('match.ended','Finished Matches','calendar-event') !!}
                                {!! sidebar_list_drop_down('Administration','adjustments', [['Users','user.index','users']]) !!}
                            </ul>
                        </div>
                    </div>
                    <div class="navbar-nav flex-row order-md-last">
                        <a href="javascript: void(0)" class="nav-link mx-2 hide-theme-dark" onclick="toggleTheme('dark')" title="Enable dark mode">@icon('moon')</a>
                        <a href="javascript: void(0)" class="nav-link mx-2 hide-theme-light" onclick="toggleTheme('light')" title="Enable light mode">@icon('sun')</a>

                        <div class="nav-item dropdown dropdown-menu-arrow">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu" aria-expanded="false">
                                    <span class="avatar avatar-sm"
                                        style="background-image: url(https://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?d=retro)"></span>
                                <div class="d-none d-xl-block mx-1">
                                    <div class="text-muted">{{ auth()->user()->name }}</div>
                                    <div>{{ auth()->user()->email }}</div>
                                </div>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                                <a href="#" onclick="document.getElementById('logout-form').submit();"
                                class="dropdown-item">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-wrapper">
        <div class="content">
            <main class="container-xl">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="page-pretitle">
                                @yield('page-pretitle')
                            </div>
                            <h2 class="page-title">
                                @yield('title')
                            </h2>
                        </div>
                        <div class="col-auto ms-auto">
                            @yield('page-header-actions')
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    @if(session()->has('success'))
                        @php $message = isset($message) ? $message : session()->pull('success') @endphp
                    @endif
                    @if(session()->has('error'))
                        @php $error = isset($error)? $error : session()->pull('error') @endphp
                    @endif
                    @if(isset($message))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-success alert-dismissible" data-dismiss="alert"
                                     role="alert">
                                    {{ __($message) }}
                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($error))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible" data-dismiss="alert" role="alert">
                                    {!! __($error) !!}
                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="page-body">
                    @yield('content')
                </div>
            </main>

            <div class="mb-n3 mt-7 d-print-none">
                <footer class="footer">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                                Crafted with <span class="text-red icon-filled">{!! paste_icon('heart') !!}</span> by <a
                                        href="" class="link-secondary">
                                    Loopy Labs Ltd.
                                </a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
@endsection
