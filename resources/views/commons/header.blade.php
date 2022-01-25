<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{url('/home')}}">
            <i class="fas fa-book"></i>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{url('/home')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/library')}}">Library</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administration
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="{{url('/users')}}">Users</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{url('/categories')}}">Categories</a></li>
                        <li><a class="dropdown-item" href="{{url('/books')}}">Books</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="sessionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user"></i> {{Auth::user()->name}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="sessionDropdown">
                        <li><a class="dropdown-item" href="{{url('/logout')}}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
