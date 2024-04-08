<!DOCTYPE html>
<html lang="en">

<head>
    @include('files.head')
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed layout-footer-fixed">
    <div class="wrapper">
        @include('files.navbar')

        @include('files.sidebar')

        @yield('main')

        @include('files.footer')

    </div>
    <!-- ./wrapper -->
    @include('files.script')
    @yield('script')
</body>

</html>
