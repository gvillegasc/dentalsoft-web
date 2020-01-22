<!DOCTYPE html>
<html lang="en-us">


<!-- Mirrored from fuse-bootstrap4-material.withinpixels.com/vertical-layout-below-toolbar-left-navigation/pages-auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jan 2018 23:35:05 GMT -->
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="description" content="">

    <!-- STYLESHEETS -->
    <style type="text/css">
            [fuse-cloak],
            .fuse-cloak {
                display: none !important;
            }
        </style>
    <!-- Icons.css -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/icons/fuse-icon-font/style.css')}}">
    <!-- Animate.css -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendor/animate.css/animate.min.css')}}">
    <!-- PNotify -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendor/pnotify/pnotify.custom.min.css')}}">
    <!-- Nvd3 - D3 Charts -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendor/nvd3/build/nv.d3.min.css')}}" />
    <!-- Perfect Scrollbar -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendor/perfect-scrollbar/css/perfect-scrollbar.min.css')}}" />
    <!-- Fuse Html -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendor/fuse-html/fuse-html.min.css')}}" />
    <!-- Main CSS -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <!-- / STYLESHEETS -->

    <!-- JAVASCRIPT -->
    <!-- jQuery -->
    <script type="text/javascript" src="{{asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
    <!-- Mobile Detect -->
    <script type="text/javascript" src="{{asset('assets/vendor/mobile-detect/mobile-detect.min.js')}}"></script>
    <!-- Perfect Scrollbar -->
    <script type="text/javascript" src="{{asset('assets/vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js')}}"></script>
    <!-- Popper.js -->
    <script type="text/javascript" src="{{asset('assets/vendor/popper.js/index.js')}}"></script>
    <!-- Bootstrap -->
    <script type="text/javascript" src="{{asset('assets/vendor/bootstrap/bootstrap.min.js')}}"></script>
    <!-- Nvd3 - D3 Charts -->
    <script type="text/javascript" src="{{asset('assets/vendor/d3/d3.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendor/nvd3/build/nv.d3.min.js')}}"></script>
    <!-- Data tables -->
    <script type="text/javascript" src="{{asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendor/datatables-responsive/js/dataTables.responsive.js')}}"></script>
    <!-- PNotify -->
    <script type="text/javascript" src="{{asset('assets/vendor/pnotify/pnotify.custom.min.js')}}"></script>
    <!-- Fuse Html -->
    <script type="text/javascript" src="{{asset('assets/vendor/fuse-html/fuse-html.min.js')}}"></script>
    <!-- Main JS -->
    <script type="text/javascript" src="{{asset('assets/js/main.js')}}"></script>
    <!-- / JAVASCRIPT -->
</head>

<body class="layout layout-vertical layout-left-navigation layout-below-toolbar">
    <main>
        <div id="wrapper" style="background: url('{{asset('assets/lpage/img/bg-banner2.jpg')}}') no-repeat fixed;
    background-size: cover;
    min-height: 650px;">
            
            <div class="content-wrapper">

                <div class="content">

                    <div id="login" class="p-8">

                        <div class="form-wrapper md-elevation-8 p-8">

                            <div class="logo" style="background-color: #125285">
                                <span>S</span>
                            </div>

                            <div class="title mt-4 mb-8">Ingresa a tu cuenta</div>

                            <form name="loginForm" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="form-group mb-4">
                                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Ingresa tu Email" value="{{ old('email') }}" />
                                    <label for="email">Email</label>
                                    
                                </div>

                                <div class="form-group mb-4">
                                    <input type="password" name="password" class="form-control" id="loginFormInputPassword" placeholder="Ingresa tu Contraseña" value="{{ old('password') }}" />
                                    <label for="password">Contraseña</label>
                                </div>

                                <div class="remember-forgot-password row no-gutters align-items-center justify-content-between pt-4">

                                    <div class="form-check remember-me mb-4">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" aria-label="Remember Me" />
                                            <span class="checkbox-icon"></span>
                                            <span class="form-check-description">Recordar Contraseña</span>
                                        </label>
                                    </div>

                                    <a href="#" class="forgot-password text-secondary mb-4">Olvidaste tu Contraseña?</a>
                                </div>

                                <button type="submit" class="submit-button btn btn-block my-4 mx-auto btn-secondary" style="background-color: #125285" aria-label="LOG IN">
                                    Iniciar Sesión
                                </button>

                            </form>

                            <div class="register d-flex flex-column flex-sm-row align-items-center justify-content-center mt-8 mb-6 mx-auto">
                                <span class="text mr-sm-2">¿No tienes una cuenta?</span>
                                <a class="link text-secondary" href="pages-auth-register.html">Crear una cuenta</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</body>


<!-- Mirrored from fuse-bootstrap4-material.withinpixels.com/vertical-layout-below-toolbar-left-navigation/pages-auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jan 2018 23:35:05 GMT -->
</html>