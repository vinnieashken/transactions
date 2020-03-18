<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>@yield('title')</title>

    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">

</head>

<body>
<main class="main h-100 w-100">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">

                        <p class="lead">
                            Sign in to your account to continue
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">

                                <form>
                                    @csrf
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
                                        <small>
                                            <a href="pages-reset-password.html">Forgot password?</a>
                                        </small>
                                    </div>
                                    <div>
                                        <div class="custom-control custom-checkbox align-items-center">
                                            <input type="checkbox" class="custom-control-input" value="remember-me" name="remember-me" checked>
                                            <label class="custom-control-label text-small">Remember me next time</label>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <a href="index-2.html" class="btn btn-lg btn-primary">Sign in</a>
                                        <!-- <button type="submit" class="btn btn-lg btn-primary">Sign in</button> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
