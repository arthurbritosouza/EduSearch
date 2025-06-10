@extends('layouts.app')

@section('title')
    EduSearch - Salas de Estudo
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
    <!-- Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="dashboard-title">
                    <i class="bi bi-door-open me-3"></i>Salas de Estudo
                </h1>
                <p class="dashboard-subtitle">Encontre, entre ou crie uma sala para estudar em grupo</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="user-welcome">
                    <span class="welcome-text">Bem-vindo, <strong>João Silva</strong></span>
                    <div class="current-time" id="currentTime"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botão para abrir modal -->
    <div class="mb-4 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#salaModal">
            <i class="bi bi-plus-circle me-2"></i>Criar/Entrar em Sala
        </button>
    </div>

    <!-- Lista de Salas -->
    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <div class="navigation-card estudos">
                <div class="nav-card-header">
                    <i class="bi bi-mortarboard"></i>
                    <h5>Matemática ENEM</h5>
                </div>
                <div class="nav-card-body">
                    <p>Estudo focado em questões de matemática para o ENEM.</p>
                    <span class="badge bg-success">12 participantes</span>
                    <span class="badge bg-primary ms-2">5 online</span>
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-primary btn-sm">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="navigation-card estudos">
                <div class="nav-card-header">
                    <i class="bi bi-mortarboard"></i>
                    <h5>Redação Nota 1000</h5>
                </div>
                <div class="nav-card-body">
                    <p>Troca de redações e dicas para melhorar a escrita.</p>
                    <span class="badge bg-success">8 participantes</span>
                    <span class="badge bg-primary ms-2">3 online</span>
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-primary btn-sm">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="navigation-card estudos">
                <div class="nav-card-header">
                    <i class="bi bi-mortarboard"></i>
                    <h5>Física Básica</h5>
                </div>
                <div class="nav-card-body">
                    <p>Discussão de conceitos e resolução de exercícios de física.</p>
                    <span class="badge bg-success">10 participantes</span>
                    <span class="badge bg-primary ms-2">4 online</span>
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-primary btn-sm">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Adicione mais cards de salas conforme necessário -->
    </div>

    <!-- Modal Criar/Entrar em Sala -->
    <div class="modal fade" id="salaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-door-open me-2"></i>Criar ou Entrar em Sala
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nome da Sala</label>
                            <input type="text" class="form-control" placeholder="Ex: Biologia Vestibular" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Senha (opcional)</label>
                            <input type="password" class="form-control" placeholder="Se a sala for privada">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ação</label>
                            <select class="form-select">
                                <option selected>Criar nova sala</option>
                                <option>Entrar em sala existente</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
@endsection
