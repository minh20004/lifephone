<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    @include('admin.layout.partials.css')
</head>
<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
    <header id="page-topbar">
        @include('admin.layout.partials.header')
    </header>
<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    @include('admin.layout.partials.removeNotificationModal')
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            @include('admin.layout.partials.appMenu')
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            @yield('content')
            <!-- End Page-content -->
            <footer class="footer">
                @include('admin.layout.partials.footer')
            </footer>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->
    <!--preloader-->
    @include('admin.layout.partials.preloader')
    <!-- Theme Settings -->
    @include('admin.layout.partials.themeSettings')
    <!-- JAVASCRIPT -->
    @include('admin.layout.partials.js')
</body>
</html>