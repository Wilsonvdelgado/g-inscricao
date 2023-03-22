<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Hound I Fast build Admin dashboard for any platform</title>
    <meta name="description" content="Hound is a Dashboard & Admin Site Responsive Template by hencework." />
    <meta name="keywords"
        content="admin, admin dashboard, admin template, cms, crm, Hound Admin, Houndadmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
    <meta name="author" content="hencework" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Data table CSS -->
    <link href="{{ url('template/bower_components/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Custom CSS -->
    <link href="{{ url('template/dist/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ url('template/jquery-confirm/jquery-confirm.css') }}" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
        integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!--Preloader-->
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <!--/Preloader-->
    <div class="wrapper theme-1-active pimary-color-red">

        <!-- Top Menu Items -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="mobile-only-brand pull-left">
                <div class="nav-header pull-left">
                    <div class="logo-wrap">
                        <a href="index.html">
                            <img class="brand-img" src="{{ URL::asset('template/dist/img/logo.png') }}"
                                alt="brand" />
                            <span class="brand-text">G-Inscritos</span>
                        </a>
                    </div>
                </div>
                <a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left"
                    href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
                <a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view"
                    href="javascript:void(0);"><i class="zmdi zmdi-search"></i></a>
                <a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i
                        class="zmdi zmdi-more"></i></a>

            </div>
            <div id="mobile_only_nav" class="mobile-only-nav pull-right">
                <ul class="nav navbar-right top-nav pull-right">
                    <li class="dropdown app-drp">
                        <a href="{{ url('/logout') }}" class="dropdown-toggle">
                            <i class="zmdi zmdi-power"></i>
                            <span>Sair</span>
                        </a>

                    </li>

                </ul>
            </div>
        </nav>
        <!-- /Top Menu Items -->

        <!-- Left Sidebar Menu -->
        <div class="fixed-sidebar-left">
            <ul class="nav navbar-nav side-nav nicescroll-bar nav-g-insc">
                <li class="navigation-header">
                    <span>Menu</span>
                    <i class="zmdi zmdi-more"></i>
                </li>

                <li>
                    <a href="{{ url('/inscritos') }}">
                        <div class="pull-left"><i class="zmdi zmdi-book mr-20"></i><span
                                class="right-nav-text">Inscritos</span></div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/financas') }}">
                        <div class="pull-left"><i class="zmdi zmdi-money mr-20"></i><span
                                class="right-nav-text">Finanças</span></div>
                        <div class="clearfix"></div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /Left Sidebar Menu -->

        <!-- Main Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('content')
                <!-- Footer -->
                <footer class="footer container-fluid pl-30 pr-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>2023 &copy; SDJ</p>
                        </div>
                    </div>
                </footer>
                <!-- /Footer -->
            </div>
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->

    <!-- JavaScript -->

    <!-- jQuery -->
    <script src="{{ url('template/bower_components/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ url('template/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Data table JavaScript -->
    <script src="{{ url('template/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('template/dist/js/dataTables-data.js') }}"></script>

    <!-- Slimscroll JavaScript -->
    <script src="{{ url('template/dist/js/jquery.slimscroll.js') }}"></script>

    <!-- Owl JavaScript -->
    <script src="{{ url('template/bower_components/owl.carousel/dist/owl.carousel.min.js') }}"></script>

    <!-- Switchery JavaScript -->
    <script src="{{ url('template/bower_components/switchery/dist/switchery.min.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ url('template/dist/js/dropdown-bootstrap-extended.js') }}"></script>

    <!-- Init JavaScript -->
    <script src="{{ url('template/dist/js/init.js') }}"></script>
    <script src="{{ url('template/validation/jquery.validate.js') }}"></script>
    {{-- <script src="{{ url('template/bower_components/bootstrap-validator/dist/validator.min.js"></script> --}}
    <script src="{{ url('template/jquery-confirm/jquery-confirm.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('page-js-files')

    <script>
        $(function() {
            const currentUrl = document.URL;
            $('.nav-g-insc li').each(function(el) {
                const ancora = $(this).children(":first");
                var ancoraUrl = $(ancora).attr('href');
                if (ancoraUrl === currentUrl) {
                    ancora.addClass('active');
                }
            });
        });
    </script>


</body>

</html>
