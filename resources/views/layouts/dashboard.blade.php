<!DOCTYPE html>
<html lang="en">
<head>
    @include('commons.head')
</head>
<body>
    @include('commons.loader')
    @include('commons.alerts')

    @include('commons.header')

    <div id="header-card-container" class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="moduleTitle">@yield('title')</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        @yield('content')
    </div>

    @include('commons.foot')
</body>
</html>
