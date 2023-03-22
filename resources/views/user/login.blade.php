<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>G-Inscrição | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('login/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('login/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>G</b>-Inscritos JMJ</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Gestão de Inscritos JMJ</p>

                <form action="{{ url('/handleLogin') }}" class="signin-form" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group mb-3">
                            <input id="email" name="email" type="email" class="form-control form-control-lg"
                                placeholder="Email" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" id="password" name="password" class="form-control form-control-lg"
                                placeholder="Password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        @if (isset($errors) && count($errors) > 0)
                            <span id="terms-error" class="error invalid-feedback p-2" style="display: inline;">
                                @foreach ($errors->all() as $erro)
                                    {{ $erro }}<br>
                                @endforeach
                            </span>
                        @endif

                        @if (session('error'))
                            <span id="terms-error" class="error invalid-feedback p-2" style="display: inline;">
                                {{ session('error') }}
                            </span>
                        @endif

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-login">Entrar</button>
                        </div>
                    </div>
                </form>

                <div class="social-auth-links text-center mb-3" style="min-height: 7em"></div>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ url('login/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('login/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('login/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
