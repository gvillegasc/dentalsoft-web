<!DOCTYPE html>
<html lang="en-us">


<!-- Mirrored from fuse-bootstrap4-material.withinpixels.com/vertical-layout-below-toolbar-left-navigation/user-interface-page-layouts-blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jan 2018 23:35:12 GMT -->
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
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
    @yield('css')
    <!-- / STYLESHEETS -->

    <!-- JAVASCRIPT -->
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
    
    @yield('javascript')

    <!-- / JAVASCRIPT -->
</head>

<body class="layout layout-vertical layout-left-navigation layout-below-toolbar">
    <main>
        <div id="wrapper">
            <aside id="impre aside" class="aside aside-left" data-fuse-bar="aside" data-fuse-bar-media-step="md" data-fuse-bar-position="left">
                <div class="aside-content-wrapper">

                    <div class="aside-content bg-primary-700 text-auto">

                        <div class="aside-toolbar">

                            <div class="logo">
                                <span class="logo-icon">D</span>
                                <span class="logo-text">DentalSoft</span>
                            </div>

                            <button id="toggle-fold-aside-button" type="button" class="btn btn-icon d-none d-lg-block" data-fuse-aside-toggle-fold>
                                <i class="icon icon-backburger"></i>
                            </button>

                        </div>

                        <ul class="nav flex-column custom-scrollbar" id="sidenav" data-children=".nav-item">

                            <li class="subheader">
                                <span>OPCIONES</span>
                            </li>

                            <li class="nav-item" role="tab" id="heading-dashboards">


                                <a class="nav-link ripple " href="/agenda">
                                    <i class="icon s-4 icon-calendar-clock"></i>
                                    <span>Agenda</span>
                                </a>

                                <a class="nav-link ripple " href="/pacientes">
                                    <i class="icon s-4 icon-account-multiple"></i>
                                    <span>Paciente</span>
                                </a>

                                <!--<a class="nav-link ripple with-arrow collapsed" data-toggle="collapse" data-target="#collapse-dashboards" href="#" aria-expanded="false" aria-controls="collapse-dashboards">

                                    <i class="icon s-4 icon-tile-four"></i>

                                    <span>Mantenimientos</span>
                                </a>
                                <ul id="collapse-dashboards" class='collapse ' role="tabpanel" aria-labelledby="heading-dashboards" data-children=".nav-item">

                                    <li class="nav-item">
                                        <a class="nav-link ripple " href="/admin/cementerio">
                                            <span>Estado</span>
                                        </a>
                                    </li>
                                </ul>
                                <a class="nav-link ripple " href="/admin/cementerio">
                                    <i class="icon s-4 icon-account-settings-variant"></i>
                                    <span>Administrador</span>
                                </a>-->

                                <a class="nav-link ripple " href="#">
                                    <i class="icon s-4 icon-library-books"></i>
                                    <span>Reportes</span>
                                </a>
                            </li>

                           

                        </ul>
                    </div>
                </div>
            </aside>
            <div class="content-wrapper">
                <nav id="toolbar" class="impre fixed-top bg-white">

                    <div class="row no-gutters align-items-center flex-nowrap">

                        <div class="col">

                            <div class="row no-gutters align-items-center flex-nowrap">

                                <button type="button" class="toggle-aside-button btn btn-icon d-block d-lg-none" data-fuse-bar-toggle="aside">
                                    <i class="icon icon-menu"></i>
                                </button>

                                <div class="toolbar-separator d-block d-lg-none"></div>

                                <div class="shortcuts-wrapper row no-gutters align-items-center px-0 px-sm-2">

                                    <div class="shortcuts row no-gutters align-items-center d-none d-md-flex">

                                        <a target="_blank" href="https://web.whatsapp.com" class="shortcut-button btn btn-icon mx-1">
                                            <i class="icon icon-hangouts"></i>
                                        </a>

                                        <!--<a href="apps-contacts.html" class="shortcut-button btn btn-icon mx-1">
                                            <i class="icon icon-account-box"></i>
                                        </a>-->

                                        <a target="_blank" href="https://mail.google.com/mail/u/0/?tab=wm#inbox" class="shortcut-button btn btn-icon mx-1">
                                            <i class="icon icon-email"></i>
                                        </a>

                                    </div>

                                    <div class="add-shortcut-menu-button dropdown px-1 px-sm-3">

                                        <div class="dropdown-toggle btn btn-icon" role="button" id="dropdownShortcutMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="icon icon-star text-amber-600"></i>
                                        </div>

                                        <!--<div class="dropdown-menu" aria-labelledby="dropdownShortcutMenu">

                                            <a class="dropdown-item" href="#">
                                                <div class="row no-gutters align-items-center justify-content-between flex-nowrap">
                                                    <div class="row no-gutters align-items-center flex-nowrap">
                                                        <i class="icon icon-calendar-today"></i>
                                                        <span class="px-3">Calendar</span>
                                                    </div>
                                                    <i class="icon icon-pin s-5 ml-2"></i>
                                                </div>
                                            </a>

                                            <a class="dropdown-item" href="#">
                                                <div class="row no-gutters align-items-center justify-content-between flex-nowrap">
                                                    <div class="row no-gutters align-items-center flex-nowrap">
                                                        <i class="icon icon-folder"></i>
                                                        <span class="px-3">File Manager</span>
                                                    </div>
                                                    <i class="icon icon-pin s-5 ml-2"></i>
                                                </div>
                                            </a>

                                            <a class="dropdown-item" href="#">
                                                <div class="row no-gutters align-items-center justify-content-between flex-nowrap">
                                                    <div class="row no-gutters align-items-center flex-nowrap">
                                                        <i class="icon icon-checkbox-marked"></i>
                                                        <span class="px-3">To-Do</span>
                                                    </div>
                                                    <i class="icon icon-pin s-5 ml-2"></i>
                                                </div>
                                            </a>

                                        </div>-->
                                    </div>
                                </div>

                                <div class="toolbar-separator"></div>

                            </div>
                        </div>

                        <div class="col-auto">

                            <div class="row no-gutters align-items-center justify-content-end">

                                <div class="user-menu-button dropdown">

                                    <div class="dropdown-toggle ripple row align-items-center no-gutters px-2 px-sm-4" role="button" id="dropdownUserMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <div class="avatar-wrapper">
                                            <img class="avatar" src="{{asset('assets/images/avatars/profile.jpg')}}">
                                            <i class="status text-green icon-checkbox-marked-circle s-4"></i>
                                        </div>
                                        <span class="username mx-3 d-none d-md-block">{{ Auth::user()->name }}</span>
                                    </div>

                                    <div class="dropdown-menu" aria-labelledby="dropdownUserMenu">

                                        <a class="dropdown-item" href="/miperfil">
                                            <div class="row no-gutters align-items-center flex-nowrap">
                                                <i class="icon-account"></i>
                                                <span class="px-3">Mi Perfil</span>
                                            </div>
                                        </a>

                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                            <div class="row no-gutters align-items-center flex-nowrap">
                                                <i class="icon-logout"></i>
                                                <span class="px-3">Cerrar Sesión</span>
                                            </div>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                              {{ csrf_field() }}
                                        </form>
                                    </div>
                                </div>

                                <div class="toolbar-separator"></div>

                                <!--<button type="button" class="search-button btn btn-icon">
                                    <i class="icon icon-magnify"></i>
                                </button>-->

                                <div class="toolbar-separator"></div>

                                <div class="language-button dropdown">

                                    <div class="dropdown-toggle ripple row align-items-center justify-content-center no-gutters px-0 px-sm-4" role="button" id="dropdownLanguageMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <div class="row no-gutters align-items-center">
                                            <img class="flag mr-2" src="{{asset('assets/images/flags/es.png')}}">
                                            <span class="d-none d-md-block">ES</span>
                                        </div>
                                    </div>

                                    <div class="dropdown-menu" aria-labelledby="dropdownLanguageMenu">

                                        <a class="dropdown-item" href="#">
                                            <div class="row no-gutters align-items-center flex-nowrap">
                                                <img class="flag" src="{{asset('assets/images/flags/us.png')}}">
                                                <span class="px-3">English</span>
                                            </div>
                                        </a>

                                        <a class="dropdown-item" href="#">
                                            <div class="row no-gutters align-items-center flex-nowrap">
                                                <img class="flag" src="{{asset('assets/images/flags/es.png')}}">
                                                <span class="px-3">Español</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="toolbar-separator"></div>

                                <!--<button type="button" class="quick-panel-button btn btn-icon" data-fuse-bar-toggle="quick-panel-sidebar">
                                    <i class="icon icon-format-list-bulleted"></i>
                                </button>-->
                            </div>
                        </div>
                    </div>
                </nav>
                @yield('content')
                
            </div>
            <div class="impre quick-panel-sidebar" fuse-cloak data-fuse-bar="quick-panel-sidebar" data-fuse-bar-position="right">
                <div class="list-group" class="date">

                    <div class="list-group-item subheader">TODAY</div>

                    <div class="list-group-item two-line">

                        <div class="text-muted">

                            <div class="h1"> Thursday</div>

                            <div class="h2 row no-gutters align-items-start">
                                <span> 1</span>
                                <span class="h6">th</span>
                                <span> Jan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="list-group">

                    <div class="list-group-item subheader">Events</div>

                    <div class="list-group-item two-line">

                        <div class="list-item-content">
                            <h3>Group Meeting</h3>
                            <p>In 32 Minutes, Room 1B</p>
                        </div>
                    </div>

                    <div class="list-group-item two-line">

                        <div class="list-item-content">
                            <h3>Public Beta Release</h3>
                            <p>11:00 PM</p>
                        </div>
                    </div>

                    <div class="list-group-item two-line">

                        <div class="list-item-content">
                            <h3>Dinner with David</h3>
                            <p>17:30 PM</p>
                        </div>
                    </div>

                    <div class="list-group-item two-line">

                        <div class="list-item-content">
                            <h3>Q&amp;A Session</h3>
                            <p>20:30 PM</p>
                        </div>
                    </div>

                </div>

                <div class="divider"></div>

                <div class="list-group">

                    <div class="list-group-item subheader">Notes</div>

                    <div class="list-group-item two-line">

                        <div class="list-item-content">
                            <h3>Best songs to listen while working</h3>
                            <p>Last edit: May 8th, 2015</p>
                        </div>
                    </div>

                    <div class="list-group-item two-line">

                        <div class="list-item-content">
                            <h3>Useful subreddits</h3>
                            <p>Last edit: January 12th, 2015</p>
                        </div>
                    </div>

                </div>

                <div class="divider"></div>

                <div class="list-group">

                    <div class="list-group-item subheader">Quick Settings</div>

                    <div class="list-group-item">

                        <div class="list-item-content">
                            <h3>Notifications</h3>
                        </div>

                        <div class="secondary-container">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" />
                                <span class="custom-control-indicator"></span>
                            </label>
                        </div>

                    </div>

                    <div class="list-group-item">

                        <div class="list-item-content">
                            <h3>Cloud Sync</h3>
                        </div>

                        <div class="secondary-container">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" />
                                <span class="custom-control-indicator"></span>
                            </label>
                        </div>

                    </div>

                    <div class="list-group-item">

                        <div class="list-item-content">
                            <h3>Retro Thrusters</h3>
                        </div>

                        <div class="secondary-container">

                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" />
                                <span class="custom-control-indicator"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
@yield('javascriptFinal')

<!-- Mirrored from fuse-bootstrap4-material.withinpixels.com/vertical-layout-below-toolbar-left-navigation/user-interface-page-layouts-blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jan 2018 23:35:12 GMT -->
</html>