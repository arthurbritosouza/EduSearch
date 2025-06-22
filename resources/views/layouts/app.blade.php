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
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    {{-- --}}
    @yield('style')
</head>
<body>

    <div class="overlay" id="overlay"></div>

    <button class="btn btn-primary d-lg-none position-fixed" style="top: 15px; left: 15px; z-index: 1060;" id="sidebarCollapse">
        <i class="bi bi-list"></i>
    </button>

    <div class="container-fluid">
        <div class="row">
            @include('include.sidebar')
            <main id="main-content" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="dashboard-header position-relative">
                    @if(url()->previous() !== url()->current())
                    <a href="{{ url()->previous() }}" class="btn position-absolute d-flex align-items-center justify-content-center" style="top: 12px; left: 15px; width: 32px; height: 32px; z-index: 10;
                  background: white; border: none;" title="Voltar">
                        <i class="fas fa-arrow-left" style="font-size: 14px; color: #495057;"></i>
                    </a>
                    @else
                    <a href="{{ route('home') }}" class="btn position-absolute d-flex align-items-center justify-content-center" style="top: 12px; left: 15px; width: 32px; height: 32px; z-index: 10;
                  background: white; border: none;" title="Dashboard">
                        <i class="fas fa-home" style="font-size: 14px; color: #495057;"></i>
                    </a>
                    @endif

                    <div class="row align-items-center">
                        <div class="col-md-8 ps-5">
                            @yield('header_content')
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="user-welcome">
                                <span class="welcome-text">Bem-vindo, <strong>{{auth()->user()->name}}</strong></span>
                                <div class="current-time" id="currentTime"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Alertas -->
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @yield('modals')

    <script>
        // Atualizar horário em tempo real
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('pt-BR');
            const dateString = now.toLocaleDateString('pt-BR');
            document.getElementById('currentTime').innerHTML = `${dateString} - ${timeString}`;
        }

        setInterval(updateTime, 1000);
        updateTime();

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    {{-- <script src="{{ asset('js/sidebar-mobile.js') }}"></script> --}}
    @yield('scripts')
</body>
</html>
