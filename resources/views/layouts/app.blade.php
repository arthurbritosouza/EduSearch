{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="32x32" href="{{ asset('logo_edusearch.png') }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Meu Aplicativo Laravel')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    @yield('style')
</head>
<body>

    <div class="overlay" id="overlay"></div>

    <button class="btn btn-primary d-lg-none position-fixed" style="top: 15px; left: 15px; z-index: 1060;" id="sidebarCollapse">
        <i class="bi bi-list"></i>
    </button>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar" id="sidebar">
                <div>
                    <div class="logo">
                        <i class="bi bi-book"></i> EduSearch
                    </div>
                    <ul class="nav flex-column mt-4">
                        <li class="nav-item">
                            <a class="nav-link" href="/home">
                                <i class="bi bi-folder"></i> Minhas Pastas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout" id="logoutButton">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
                @auth
                <div class="sidebar-footer">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div>
                            <small>{{ auth()->user()->name ?? 'Usuário' }}</small>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
            <main id="main-content" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('modals')



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/sidebar-mobile.js') }}"></script>
    @yield('scripts')
</body>
</html>
