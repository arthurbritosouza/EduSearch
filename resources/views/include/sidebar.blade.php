<div class="sidebar" id="sidebar">
    <div>
        <div class="logo d-flex align-items-center justify-content-center py-3">
            <i class="bi bi-book fs-3 me-2"></i>
            <span class="fw-bold fs-4">EduSearch</span>
        </div>
        <ul class="nav flex-column mt-4">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="/home">
                    <i class="bi bi-house-door"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
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
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Gaveta Ferramentas -->
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

            <li class="nav-divider"></li>

            <!-- Perfil e Configurações -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('profile.index')}}">
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
                    @if(isset($notificationCount) && $notificationCount > 0)
                    <span class="badge bg-danger">{{ $notificationCount }}</span>
                    @endif
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
    <div class="sidebar-footer mt-auto p-3 border-top">
        <div class="user-profile d-flex align-items-center gap-2">
            <div class="user-avatar bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-person-circle fs-4"></i>
            </div>
            <div class="user-info flex-grow-1">
                <div class="user-name fw-bold small">{{ auth()->user()->name ?? 'Usuário' }}</div>
                <div class="user-email text-muted small">{{ auth()->user()->email ?? '' }}</div>
            </div>
            <a href="{{route('profile.index')}}" class="btn btn-sm btn-outline-primary" title="Perfil">
                <i class="bi bi-person"></i>
            </a>
        </div>
    </div>
    @endauth
</div>
