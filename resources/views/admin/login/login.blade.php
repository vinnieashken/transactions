<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name', 'Payments Portal Login') }}</title>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">

            <div class="d-flex vh-100">
                <div class="d-flex w-100 justify-content-center align-self-center">
                    <div class="card col-md-4 shadow bg-white">
                        <div class="card-header px-3">
                            <a  href="" target='_blank' class="d-flex align-items-baseline mw-100">
                                <h1 class="m-0 p-0">
                                    Login
                                </h1>
                            </a>

                        </div>
                        <div class="card-body">
                            <form action="{{ url('signin') }}" class='form form-horizontal' method ='post'>
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control rounded-0 border-top-0 border-right-0 border-left-0 bg-white p-0 @error('email') border-danger @enderror" name='email' placeholder="Email / Username">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group ">
                                    <input type="password" class="form-control rounded-0 border-top-0 border-right-0 border-left-0 bg-white p-0 @error('password') border-danger @enderror" name='password' placeholder="Password">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-row">
                                    <div class="col-8">
                                        <a href="{{ url("login/changepassword") }}">
                                            I forgot my password
                                        </a>
                                        <br>
                                        <small class="text text-center text-danger">

                                        </small>
                                    </div>
                                    <div class="col">
                                        <button type="submit" name="login" value="i" class="btn btn-primary btn-block btn-sm rounded-0">
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
  </body>
</html>
