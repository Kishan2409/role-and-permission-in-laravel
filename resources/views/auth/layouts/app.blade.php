<!DOCTYPE html>
<html lang="en">

<head>
    @include('auth.files.head')
</head>

<body class="hold-transition login-page">
    @yield('main')
    @include('auth.files.script')
    @yield('script')
</body>

</html>
