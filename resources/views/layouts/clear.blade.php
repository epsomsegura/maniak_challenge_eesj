<!DOCTYPE html>
<html lang="en">
<head>
    @include('commons.head')
</head>
<body>
    @include('commons.alerts')
    @include('commons.loader')

    @yield('content')

    @include('commons.foot')
</body>
</html>
