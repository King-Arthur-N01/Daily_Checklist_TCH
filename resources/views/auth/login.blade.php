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
    <link href="assets/lib/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="assets/lib/typicons.font/typicons.css" rel="stylesheet">
    <!-- azia CSS -->
    <link rel="stylesheet" href="assets/css/azia.css">
</head>

<body class="az-body">
    <div class="az-signin-wrapper">
        <div class="az-card-signin">
            <div class="az-signin-header">
                <h2>Welcome back!</h2>
                <h4>Please sign in to continue</h4>
                <form action="{{route('pushlogin')}}" method="post">
                @csrf
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" class="form-control" name="nik" placeholder="Enter your NIK">
                    </div>
                    @error('nik')
                        <strong>{{ $message }}</strong>
                    @enderror
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password">
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <button class="btn btn-az-primary btn-block">Sign In</button>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/lib/jquery/jquery.min.js"></script>
    <script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/ionicons/ionicons.js"></script>
    <script src="assets/js/azia.js"></script>
    <script>
        $(function() {
            'use strict'
        });
    </script>
</body>

</html>
