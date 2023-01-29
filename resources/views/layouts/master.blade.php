<!doctype html>
<html lang="en">

<head>
    <title>Studio - Santri Baja Indonesia</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images/logo.png?v='.filemtime(public_path('assets/images/logo.png'))) }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/images/logo.png?v='.filemtime(public_path('assets/images/logo.png'))) }}">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/linearicons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome-pro-master/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">
    {{-- Datatime picker --}}
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.datetimepicker.min.css') }}">
    <!-- Env Color -->
    <link rel="stylesheet" href="{{ asset('assets/css/envColor.css?v='.filemtime(public_path('assets/css/envColor.css'))) }}">
    <script src="{{ asset('assets/scripts/envColor.js?v='.filemtime(public_path('assets/scripts/envColor.js'))) }}"></script>
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css?v='.filemtime(public_path('assets/css/main.css'))) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css?v='.filemtime(public_path('assets/css/custom.css'))) }}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="brand">
                <a href="/dashboard">
                    <img src="{{ asset('assets/images/logo.png?v='.filemtime(public_path('assets/images/logo.png'))) }}" class="img-responsive logo">
                </a>
            </div>
            <div class="container-fluid">
                <div class="navbar-btn">
                    <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
                </div>
                <div id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('assets/images/admin.png') }}" class="img-circle" alt="Avatar"> <span></span> <i class="icon-submenu lnr lnr-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#" data-toggle="modal" data-target="#modalChangePassword"><i class="fal fa-cog"></i> <span>Change Password</span></a></li>
                                <li><a href="/logout"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="sidebar-nav" class="sidebar">
            <div class="sidebar-scroll">
                <nav>
                    <ul class="nav">
                        <li>
                            <a href="/dashboard" class="{{ Request::is('dashboard') ? 'active' : '' }}">
                                <i class="lnr lnr-home"></i> <span>Dashboard</span>
                            </a>
						</li>
                        <li>
                            <a href="/product" class="{{ Request::is('product') ? 'active' : '' }}">
                                <i class="fal fa-hand-holding-box"></i> <span>Product</span>
                            </a>
						</li>
                        <li>
                            <a href="/album" class="{{ Request::is('album') ? 'active' : '' }}">
                                <i class="fal fa-album-collection"></i> <span>Album</span>
                            </a>
						</li>
                        <li>
                            <a href="/gallery" class="{{ Request::is('gallery') ? 'active' : '' }}">
                                <i class="fal fa-camera"></i> <span>Gallery</span>
                            </a>
						</li>
                        <li>
                            <a href="/distributor" class="{{ Request::is('distributor') ? 'active' : '' }}">
                                <i class="fal fa-project-diagram"></i> <span>Distributor</span>
                            </a>
						</li>
                        <li>
                            <a href="/article" class="{{ Request::is('article') ? 'active' : '' }}">
                                <i class="fal fa-newspaper"></i> <span>Article</span>
                            </a>
						</li>
                        <li>
							<a href="#contentManager" data-toggle="collapse"
                                class="{{ Request::is('content-manager/*') ? 'active' : 'collapsed' }}"
                                aria-expanded="{{ Request::is('content-manager/*') ? 'true' : 'false' }}">
                                <i class="fal fa-cog"></i> <span>Content Manager</span> <i class="icon-submenu lnr lnr-chevron-left"></i>
                            </a>
							<div id="contentManager" class="{{ Request::is('content-manager/*') ? 'collapse in' : 'collapse' }}"
                                aria-expanded="{{ Request::is('content-manager/*') ? 'true' : 'false' }}">
								<ul class="nav">
									<li><a href="/content-manager/information" class="{{ Request::is('content-manager/information') ? 'active' : '' }}">Information</a></li>
									<li><a href="/content-manager/main-banner" class="{{ Request::is('content-manager/main-banner') ? 'active' : '' }}">Main Banner</a></li>
									<li><a href="/content-manager/other-banner" class="{{ Request::is('content-manager/other-banner') ? 'active' : '' }}">Other Banner</a></li>
									<li><a href="/content-manager/section" class="{{ Request::is('content-manager/section') ? 'active' : '' }}">Section</a></li>
								</ul>
							</div>
						</li>
                        <li>
                            <a href="/mailbox" class="{{ Request::is('mailbox') ? 'active' : '' }}">
                                <i class="fal fa-envelope"></i> <span>Mailbox</span>
                            </a>
						</li>
                    </ul>
                </nav>
            </div>
        </div>
        
        <div class="main">
            <div class="main-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        
        <div class="clearfix"></div>
        <footer>
            <div class="container-fluid">
                <p class="copyright">&copy; {{ date('Y') }}. PT. Santri Baja Indonesia | App Version 1.0</p>
            </div>
        </footer>
    </div>

    <div class="modal fade" id="modalChangePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Change Password</h4>
                </div>
                <div class="modal-body" id="change-password">
                    <div class="custom-input-group">
                        <p>Old Password</p>
                        <input type="password" id="old-pass" class="form-control required">
                        <span class="input-invalid-message">Old password is wrong</span>
                    </div>
                    <div class="custom-input-group">
                        <p>New Password</p>
                        <input type="password" id="new-pass" class="form-control required">
                        <span class="input-invalid-message"></span>
                    </div>
                    <div class="custom-input-group">
                        <p>Confirm Password</p>
                        <input type="password" id="confirm-pass" class="form-control">
                        <span class="input-invalid-message">Password doesn't match</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-change-password" disabled>Submit</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/scripts/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/klorofil-common.js') }}"></script>
    <script src="{{ asset('assets/vendor/ElementQueries.js') }}"></script>
    <script src="{{ asset('assets/vendor/ResizeSensor.js') }}"></script>
    

    <script src="{{ asset('assets/scripts/main.js?v='.filemtime(public_path('assets/scripts/main.js'))) }}"></script>

    @if (Request::is('dashboard'))
        <script src="{{ asset('assets/scripts/dashboard.js?v='.filemtime(public_path('assets/scripts/dashboard.js'))) }}"></script>
    @endif

    @if (Request::is('product'))
        <script src="{{ asset('assets/scripts/product.js?v='.filemtime(public_path('assets/scripts/product.js'))) }}"></script>
    @endif

    @if (Request::is('album'))
        <script src="{{ asset('assets/scripts/album.js?v='.filemtime(public_path('assets/scripts/album.js'))) }}"></script>
    @endif

    @if (Request::is('gallery'))
        <script src="{{ asset('assets/scripts/gallery.js?v='.filemtime(public_path('assets/scripts/gallery.js'))) }}"></script>
    @endif

    @if (Request::is('distributor'))
        <script src="{{ asset('assets/scripts/distributor.js?v='.filemtime(public_path('assets/scripts/distributor.js'))) }}"></script>
    @endif

    @if (Request::is('article'))
        <script src="{{ asset('assets/scripts/article.js?v='.filemtime(public_path('assets/scripts/article.js'))) }}"></script>
    @endif

    @if (Request::is('content-manager/information'))
        <script src="{{ asset('assets/scripts/information.js?v='.filemtime(public_path('assets/scripts/information.js'))) }}"></script>
    @endif

    @if (Request::is('content-manager/main-banner'))
        <script src="{{ asset('assets/scripts/main-banner.js?v='.filemtime(public_path('assets/scripts/main-banner.js'))) }}"></script>
    @endif

    @if (Request::is('content-manager/other-banner'))
        <script src="{{ asset('assets/scripts/other-banner.js?v='.filemtime(public_path('assets/scripts/other-banner.js'))) }}"></script>
    @endif

    @if (Request::is('content-manager/section'))
        <script src="{{ asset('assets/scripts/section.js?v='.filemtime(public_path('assets/scripts/section.js'))) }}"></script>
    @endif

    @if (Request::is('mailbox'))
        <script src="{{ asset('assets/scripts/mailbox.js?v='.filemtime(public_path('assets/scripts/mailbox.js'))) }}"></script>
    @endif

    @yield('scripts')
</body>

</html>
