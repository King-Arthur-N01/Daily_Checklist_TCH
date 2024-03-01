<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="BootstrapDash">

    <title>Azia Responsive Bootstrap 4 Dashboard Template</title>

    <!-- vendor css -->
    {{-- <link rel="stylesheet" href="{{asset('assets/lib/fontawesome-free/css/all.min.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/lib/ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lib/typicons.font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lib/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/flag-icon-css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/azia.css') }}">
    @stack('style')
</head>

<body>
    <div class="az-header">
        <div class="container">
            <div class="az-header-left">
                <a href="{{route('home')}}" class="az-logo"><span></span>CONCEPT</a>
                <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
            </div><!-- az-header-left -->
            <div class="az-header-menu">
                <div class="az-header-menu-header">
                    <a href="{{route('home')}}" class="az-logo"><span></span>CONCEPT</a>
                    <a href="" class="close">&times;</a>
                </div><!-- az-header-menu-header -->
                <ul class="nav">
                    <li class="nav-item active show">
                        <a href="{{route('home')}}" class="nav-link"><i class="typcn typcn-chart-area-outline"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link with-sub"><i class="typcn typcn-document"></i> Pages</a>
                        <nav class="az-menu-sub">
                            <a href="page-signin.html" class="nav-link">Sign In</a>
                            <a href="page-signup.html" class="nav-link">Sign Up</a>
                        </nav>
                    </li>
                    <li class="nav-item">
                        <a href="chart-chartjs.html" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i>Charts</a>
                    </li>
                    <li class="nav-item">
                        <a href="form-elements.html" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i>Forms</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link with-sub"><i class="typcn typcn-book"></i> Components</a>
                        <div class="az-menu-sub">
                            <div class="container">
                                <div>
                                    <nav class="nav">
                                        <a href="elem-buttons.html" class="nav-link">Buttons</a>
                                        <a href="elem-dropdown.html" class="nav-link">Dropdown</a>
                                        <a href="elem-icons.html" class="nav-link">Icons</a>
                                        <a href="table-basic.html" class="nav-link">Table</a>
                                    </nav>
                                </div>
                            </div><!-- container -->
                        </div>
                    </li>
                </ul>
            </div><!-- az-header-menu -->
            <div class="az-header-right">
                <div class="dropdown az-profile-menu">
                    <a href="" class="az-img-user"><img src="{{asset('assets/icons/avatar-1.png')}}" alt=""></a>
                    <div class="dropdown-menu">
                        <div class="az-dropdown-header d-sm-none">
                            <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                        </div>
                        <div class="az-header-profile">
                            <div class="az-img-user">
                                <img src="{{asset('assets/icons/avatar-1.png')}}" alt="">
                            </div><!-- az-img-user -->
                            <h6>Selamat Datang {{Auth::user()->name}}</h6>
                            {{-- <span>Premium Member</span> --}}
                        </div><!-- az-header-profile -->

                        <a href="" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
                        <a href="" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a>
                        <a href="" class="dropdown-item"><i class="typcn typcn-time"></i> Activity Logs</a>
                        <a href="" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account Settings</a>
                        <a href="{{route('logout')}}" class="dropdown-item"><i class="typcn typcn-power-outline"></i>Sign Out</a>
                    </div><!-- dropdown-menu -->
                </div>
            </div><!-- az-header-right -->
        </div><!-- container -->
    </div><!-- az-header -->

    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                @yield('content')
            </div><!-- az-content-body -->
        </div>
    </div><!-- az-content -->
    <div class="az-footer ht-40">
        <div class="container ht-100p pd-t-0-f">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com
                2020</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a
                    href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin
                    templates</a> from Bootstrapdash.com</span>
        </div><!-- container -->
    </div><!-- az-footer -->

    <script src="assets/lib/jquery/jquery.min.js"></script>
    <script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/ionicons/ionicons.js"></script>
    <script src="assets/lib/jquery.flot/jquery.flot.js"></script>
    <script src="assets/lib/jquery.flot/jquery.flot.resize.js"></script>
    <script src="assets/lib/chart.js/Chart.bundle.min.js"></script>
    <script src="assets/lib/peity/jquery.peity.min.js"></script>

    <script src="assets/js/azia.js"></script>
    <script src="assets/js/chart.flot.sampledata.js"></script>
    <script src="assets/js/dashboard.sampledata.js"></script>
    {{-- <script src="assets/js/jquery.cookie.js" type="text/javascript"></script> --}}

    @stack('script')
    {{-- <=========================BATAS HARDCODED JAVASCRIPT!!!!=========================> --}}

    {{-- <=======================BATAS HARDCODED JAVASCRIPT END!!!!=======================> --}}
</body>
</html>
