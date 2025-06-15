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
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link" href="/home">
                                <i class="bi bi-house-door"></i>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>

                        <!-- Divisor -->
                        <li class="nav-divider"></li>

                        <!-- Gaveta de Estudos -->
                        <li class="nav-item nav-drawer">
                            <a class="nav-link drawer-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#estudosDrawer" aria-expanded="false">
                                <i class="bi bi-mortarboard"></i>
                                <span class="nav-text">Estudos</span>
                                <i class="bi bi-chevron-down drawer-arrow"></i>
                            </a>
                            <div class="collapse drawer-content" id="estudosDrawer">
                                <ul class="nav flex-column drawer-menu">
                                    <li class="nav-item">
                                        <a class="nav-link drawer-item" href="{{route('topic.index')}}">
                                            <i class="bi bi-folder2-open"></i>
                                            <span class="nav-text">Meus Tópicos</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link drawer-item" href="{{route('pdf.index')}}">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                            <span class="nav-text">Biblioteca de PDFs</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link drawer-item" href="/favoritos">
                                            <i class="bi bi-bookmark-heart"></i>
                                            <span class="nav-text">Favoritos</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Gaveta Colaborativa -->
                        <li class="nav-item nav-drawer">
                            <a class="nav-link drawer-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#colaborativoDrawer" aria-expanded="false">
                                <i class="bi bi-people"></i>
                                <span class="nav-text">Colaborativo</span>
                                <i class="bi bi-chevron-down drawer-arrow"></i>
                            </a>
                            <div class="collapse drawer-content" id="colaborativoDrawer">
                                <ul class="nav flex-column drawer-menu">
                                    <li class="nav-item">
                                        <a class="nav-link drawer-item" href="{{route('room.index')}}">
                                            <i class="bi bi-door-open"></i>
                                            <span class="nav-text">Salas de Estudo</span>
                                            <span class="badge bg-success ms-auto">3</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link drawer-item" href="/comunidade">
                                            <i class="bi bi-share"></i>
                                            <span class="nav-text">Comunidade</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link drawer-item" href="/grupos">
                                            <i class="bi bi-people-fill"></i>
                                            <span class="nav-text">Meus Grupos</span>
                                            <span class="badge bg-primary ms-auto">2</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Gaveta de Ferramentas -->
                        <li class="nav-item nav-drawer">
                            <a class="nav-link drawer-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#ferramentasDrawer" aria-expanded="false">
                                <i class="bi bi-tools"></i>
                                <span class="nav-text">Ferramentas</span>
                                <i class="bi bi-chevron-down drawer-arrow"></i>
                            </a>
                            <div class="collapse drawer-content" id="ferramentasDrawer">
                                <ul class="nav flex-column drawer-menu">
                                    <li class="nav-item">
                                        <a class="nav-link drawer-item" href="/chat-ia">
                                            <i class="bi bi-robot"></i>
                                            <span class="nav-text">Chat com IA</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link drawer-item" href="/resumos">
                                            <i class="bi bi-journal-text"></i>
                                            <span class="nav-text">Gerador de Resumos</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link drawer-item" href="/flashcards">
                                            <i class="bi bi-card-text"></i>
                                            <span class="nav-text">Flashcards</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Divisor -->
                        <li class="nav-divider"></li>

                        <!-- Configurações -->
                        <li class="nav-item">
                            <a class="nav-link" href="/perfil">
                                <i class="bi bi-person-circle"></i>
                                <span class="nav-text">Meu Perfil</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center" href="{{route('notifications')}}">
                                <div>
                                    <i class="bi bi-bell"></i>
                                    <span class="nav-text">Notificações</span>
                                </div>
                                <span class="badge bg-danger rounded-pill">3</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/configuracoes">
                                <i class="bi bi-gear"></i>
                                <span class="nav-text">Configurações</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/logout" id="logoutButton">
                                <i class="bi bi-box-arrow-right"></i>
                                <span class="nav-text">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
                @auth
                <div class="sidebar-footer">
                    <div class="user-profile">
                        <div class="user-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ auth()->user()->name ?? 'Usuário' }}</div>
                            <div class="user-email">{{ auth()->user()->email ?? '' }}</div>
                        </div>
                        <div class="user-actions">
                            <button class="btn btn-sm btn-outline-light" title="Configurações">
                                <i class="bi bi-gear"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
            <main id="main-content" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="dashboard-header">
                    <div class="row align-items-center">
                        @yield('header_content')
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
