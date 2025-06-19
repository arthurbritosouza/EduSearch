@extends('layouts.app')

@section('title')
    EduSearch - Meu Perfil
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> {{-- Reutiliza o CSS global [1] --}}
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        /* Estilos específicos para a tela de perfil, mantendo o minimalismo e as cores do sistema */
        .profile-header-section {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-color, #0f4c81);
            margin-bottom: 15px;
        }
        .profile-name {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        .profile-email {
            font-size: 1.1rem;
            color: #666;
        }

        .profile-info-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .info-item .info-icon {
            font-size: 1.5rem;
            color: var(--primary-color, #0f4c81);
            margin-right: 15px;
            width: 30px; /* Garante alinhamento */
            text-align: center;
        }
        .info-item .info-label {
            font-weight: 600;
            color: #555;
            min-width: 120px;
        }
        .info-item .info-value {
            color: #333;
            flex-grow: 1;
        }

        .btn-custom {
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 6px;
            transition: all 0.3s;
        }
        .btn-custom-primary {
            background: var(--primary-color, #0f4c81);
            color: #fff;
            border: none;
        }
        .btn-custom-primary:hover {
            background: #0a3a60;
            color: #fff;
        }
        .btn-custom-outline {
            border: 1px solid var(--primary-color, #0f4c81);
            color: var(--primary-color, #0f4c81);
            background: transparent;
        }
        .btn-custom-outline:hover {
            background: rgba(15,76,129,0.07);
            color: #0f4c81;
        }

        /* Estilos para a seção de Atividades Recentes e Progresso, baseados na home [1] */
        .recent-activity-card, .progress-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 30px;
            height: 100%; /* Garante que os cards tenham a mesma altura em uma linha */
        }
        .card-header-profile {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }
        .card-header-profile i {
            margin-right: 10px;
            font-size: 1.8rem;
            color: var(--primary-color, #0f4c81);
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 18px;
            padding-bottom: 18px;
            border-bottom: 1px dashed #eee;
        }
        .activity-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .activity-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-right: 15px;
            flex-shrink: 0;
        }
        .activity-icon.primary { background-color: rgba(var(--primary-color-rgb, 15, 76, 129), 0.1); color: var(--primary-color, #0f4c81); }
        .activity-icon.success { background-color: rgba(40, 167, 69, 0.1); color: #28a745; }
        .activity-icon.warning { background-color: rgba(255, 193, 7, 0.1); color: #ffc107; }
        .activity-content h6 {
            margin-bottom: 3px;
            font-weight: 600;
            color: #333;
        }
        .activity-content p {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 3px;
        }
        .activity-content small {
            font-size: 0.8rem;
            color: #999;
        }

        .progress-item {
            margin-bottom: 25px;
        }
        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 0.95rem;
        }
        .progress {
            height: 8px;
            border-radius: 5px;
            background-color: #e9ecef;
        }
        .progress-bar {
            border-radius: 5px;
        }
        .bg-primary { background-color: var(--primary-color, #0d6efd) !important; }
        .bg-success { background-color: #198754 !important; }
        .bg-warning { background-color: #ffc107 !important; }

        .credit-card {
            background: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 20px 30px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .credit-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .credit-label {
            font-size: 1rem;
            color: #666;
        }
        .credit-value {
            font-size: 2rem;
            font-weight: 700;
            color: #0f4c81;
        }
        .credit-spent {
            font-size: 1rem;
            color: #dc3545;
            margin-top: 5px;
        }
    </style>
@endsection

@section('header_content')
    <div class="col-md-8">
        <h1 class="dashboard-title">
            <i class="bi bi-person-circle me-3"></i>Meu Perfil
        </h1>
        <p class="dashboard-subtitle">Gerencie suas informações e acompanhe seu progresso</p>
    </div>
@endsection

@section('content')
    <div class="container-fluid"> {{-- Usar container-fluid para corresponder ao layout da home [1] --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="profile-header-section">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'U') }}&background=0f4c81&color=fff&size=150" alt="Avatar" class="profile-avatar">
                    <h2 class="profile-name">{{ $user->name ?? 'Usuário EduSearch' }}</h2>
                    <p class="profile-email">{{ $user->email ?? 'usuario@edusearch.com' }}</p>
                    <div class="d-flex justify-content-center gap-3 mt-3 flex-wrap">
                        <button type="button" class="btn btn-custom btn-custom-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="bi bi-pencil-square me-2"></i> Editar Perfil
                        </button>
                        <button type="button" class="btn btn-custom btn-custom-outline" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="bi bi-key me-2"></i> Alterar Senha
                        </button>
                        <button type="button" class="btn btn-custom btn-success" data-bs-toggle="modal" data-bs-target="#rechargeCreditsModal">
                            <i class="bi bi-cash-coin me-2"></i> Recarregar Créditos
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="credit-card">
                    <div class="credit-info">
                        <span class="credit-label">Créditos Disponíveis</span>
                        <span class="credit-value">{{ $user->credits ?? 0 }}</span>
                    </div>
                    <div class="credit-info">
                        <span class="credit-label">Créditos Gastos</span>
                        <span class="credit-spent">{{ $user->credits_spent ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stats-card-large primary">
                    <div class="stats-icon"><i class="bi bi-folder2-open"></i></div>
                    <div class="stats-content">
                        <h3>{{ $user->topics_count ?? 0 }}</h3>
                        <p>Tópicos Criados</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stats-card-large success">
                    <div class="stats-icon"><i class="bi bi-file-earmark-pdf"></i></div>
                    <div class="stats-content">
                        <h3>{{ $user->pdfs_count ?? 0 }}</h3>
                        <p>PDFs Processados</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="stats-card-large info">
                    <div class="stats-icon"><i class="bi bi-clock-history"></i></div>
                    <div class="stats-content">
                        <h3>{{ $user->study_time ?? '0h' }}</h3>
                        <p>Tempo de Estudo</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="profile-info-card h-100">
                    <h4 class="card-header-profile mb-4"><i class="bi bi-info-circle"></i>Minhas Informações</h4>
                    <div class="info-item mb-3"><strong>Nome:</strong> <span class="ms-2">{{ $user->name ?? 'Não Definido' }}</span></div>
                    <div class="info-item mb-3"><strong>Email:</strong> <span class="ms-2">{{ $user->email ?? 'Não Definido' }}</span></div>
                    <div class="info-item mb-3"><strong>Membro desde:</strong> <span class="ms-2">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Data Indisponível' }}</span></div>
                    <div class="info-item mb-3"><strong>Tópicos Criados:</strong> <span class="ms-2">{{ $user->topics_count ?? 0 }}</span></div>
                    <div class="info-item mb-3"><strong>PDFs Processados:</strong> <span class="ms-2">{{ $user->pdfs_count ?? 0 }}</span></div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="recent-activity-card h-100">
                    <h4 class="card-header-profile mb-4"><i class="bi bi-clock-history"></i>Atividades Recentes</h4>
                    @if(isset($activities) && count($activities))
                        @foreach($activities as $activity)
                            <div class="activity-item mb-3">
                                <div class="activity-icon {{ $activity['type'] ?? 'primary' }}">
                                    <i class="{{ $activity['icon'] ?? 'bi bi-info-circle' }}"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>{{ $activity['title'] }}</h6>
                                    <p>{{ $activity['description'] }}</p>
                                    <small class="text-muted">{{ $activity['time'] }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-muted">Nenhuma atividade recente.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="progress-card">
                    <h4 class="card-header-profile mb-4"><i class="bi bi-graph-up"></i>Seu Progresso Geral</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Tópicos Estudados</span>
                                    <span class="progress-value">{{ $user->topics_studied ?? 0 }}/{{ $user->topics_goal ?? 10 }}</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" style="width: {{ isset($user->topics_studied, $user->topics_goal) && $user->topics_goal > 0 ? ($user->topics_studied/$user->topics_goal)*100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>PDFs Lidos</span>
                                    <span class="progress-value">{{ $user->pdfs_read ?? 0 }}/{{ $user->pdfs_goal ?? 8 }}</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: {{ isset($user->pdfs_read, $user->pdfs_goal) && $user->pdfs_goal > 0 ? ($user->pdfs_read/$user->pdfs_goal)*100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Tempo de Estudo</span>
                                    <span class="progress-value">{{ $user->study_time ?? '0h' }}/{{ $user->study_time_goal ?? '30h' }}</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" style="width: 80%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Perfil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-white border-bottom">
                    <h5 class="modal-title d-flex align-items-center" id="editProfileModalLabel">
                        <i class="bi bi-pencil-square me-2" style="color: #495057;"></i> Editar Perfil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="editName" class="form-label fw-bold">Nome Completo</label>
                            <input type="text" class="form-control" id="editName" value="{{ $user->name ?? '' }}" placeholder="Seu nome completo">
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" id="editEmail" value="{{ $user->email ?? '' }}" readonly>
                            <div class="form-text">O email não pode ser alterado diretamente por aqui.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Alterar Senha -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-white border-bottom">
                    <h5 class="modal-title d-flex align-items-center" id="changePasswordModalLabel">
                        <i class="bi bi-key me-2" style="color: #495057;"></i> Alterar Senha
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label fw-bold">Senha Atual</label>
                            <input type="password" class="form-control" id="currentPassword" placeholder="Digite sua senha atual">
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label fw-bold">Nova Senha</label>
                            <input type="password" class="form-control" id="newPassword" placeholder="Digite a nova senha">
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label fw-bold">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirme a nova senha">
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Salvar Nova Senha</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Recarregar Créditos -->
    <div class="modal fade" id="rechargeCreditsModal" tabindex="-1" aria-labelledby="rechargeCreditsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-white border-bottom">
                    <h5 class="modal-title d-flex align-items-center" id="rechargeCreditsModalLabel">
                        <i class="bi bi-cash-coin me-2" style="color: #495057;"></i> Recarregar Créditos
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="creditAmount" class="form-label fw-bold">Quantidade de Créditos</label>
                            <input type="number" class="form-control" id="creditAmount" min="1" placeholder="Digite a quantidade de créditos">
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Adicionar Créditos</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    {{-- Se houver outros modals globais que você inclui na home, eles podem ser incluídos aqui também, se necessário. --}}
    {{-- @include('modals.modal-profile-specific') --}}
@endsection

@section('scripts')
    {{-- Bootstrap JS para modais e componentes --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
