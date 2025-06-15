@extends('layouts.app')

@section('title')
EduSearch - Sala de Estudos
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')

@section('header_content')
<div class="col-md-8">
    <h1 class="dashboard-title">
        <i class="bi bi-door-open me-3"></i>Sala de Estudos: {{$room->name}}
    </h1>
    <p class="dashboard-subtitle">{{$room->description}}</p>
</div>
@endsection

<!-- Linha Principal com Informações, Membros, Tópicos e Chat -->
<div class="row mb-5">
    <!-- Coluna da Esquerda: Informações Gerais -->
    <div class="col-lg-4 mb-4">

        <!-- Card de Participantes -->
        <div class="stats-card-large info">
            <div class="stats-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="stats-content">
                <h3>12</h3>
                <p>Participantes</p>
                <!-- BOTÃO PARA ABRIR O MODAL DE LISTA DE MEMBROS -->
                <button class="btn btn-sm btn-outline-secondary mt-1" data-bs-toggle="modal" data-bs-target="#listMembersModal">
                    <i class="bi bi-eye me-1"></i>Ver todos
                </button>
            </div>
        </div>

        <!-- Lista de Membros -->
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Membros</h6>
                <!-- BOTÃO PARA ABRIR O MODAL DE ADICIONAR MEMBRO -->
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                    <i class="bi bi-person-plus-fill me-1"></i>Convidar
                </button>
            </div>
            <ul class="list-group">
                <li class="list-group-item d-flex align-items-center"><i class="bi bi-person-circle me-2"></i>João Silva</li>
                <li class="list-group-item d-flex align-items-center"><i class="bi bi-person-circle me-2"></i>Maria Souza</li>
                <li class="list-group-item d-flex align-items-center"><i class="bi bi-person-circle me-2"></i>Lucas Pereira</li>
            </ul>
        </div>

        <!-- Card de Tópicos de Estudo -->
        <div class="navigation-card mt-4">
            <div class="nav-card-header">
                <i class="bi bi-bookmarks-fill"></i>
                <h5>Tópicos de Estudo</h5>
            </div>
            <div class="nav-card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">Funções de 1º Grau<span class="badge bg-success rounded-pill">Concluído</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">Análise Combinatória<span class="badge bg-warning rounded-pill">Em Andamento</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">Logaritmos<span class="badge bg-secondary rounded-pill">A Estudar</span></li>
                </ul>
            </div>
        </div>

    </div>

    <!-- Coluna da Direita: Chat da Sala -->
    <div class="col-lg-8 mb-4">
        <div class="recent-activity-card" style="height: 100%;">
            <div class="card-header">
                <h5><i class="bi bi-chat-dots me-2"></i>Chat da Sala</h5>
            </div>
            <div class="card-body" style="height: calc(100% - 145px); overflow-y: auto;">
                <div class="activity-item">
                    <div class="activity-icon primary"><i class="bi bi-person"></i></div>
                    <div class="activity-content">
                        <h6>João Silva</h6>
                        <p>Alguém pode explicar a questão 12 da lista?</p>
                        <small class="text-muted">2 minutos atrás</small>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon success"><i class="bi bi-person"></i></div>
                    <div class="activity-content">
                        <h6>Maria Souza</h6>
                        <p>Claro! É sobre funções do 2º grau, né?</p>
                        <small class="text-muted">1 minuto atrás</small>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon info"><i class="bi bi-person"></i></div>
                    <div class="activity-content">
                        <h6>Lucas Pereira</h6>
                        <p>Acabei de enviar um PDF com a resolução.</p>
                        <small class="text-muted">agora mesmo</small>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <form class="d-flex">
                    <input type="text" class="form-control me-2" placeholder="Digite sua mensagem..." disabled>
                    <button type="button" class="btn btn-primary" disabled><i class="bi bi-send"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Linha Secundária com Arquivos e Progresso -->
<div class="row">
    <!-- Coluna de Arquivos Compartilhados -->
    <div class="col-lg-6 mb-4">
        <div class="navigation-card estudos">
            <div class="nav-card-header">
                <i class="bi bi-file-earmark-pdf"></i>
                <h5>Arquivos Compartilhados</h5>
            </div>
            <div class="nav-card-body">
                <a href="#" class="nav-link-item">
                    <i class="bi bi-file-earmark"></i><span>Lista_Exercicios_ENEM.pdf</span>
                    <span class="badge bg-success ms-auto">enviado há 10 min</span>
                </a>
                <a href="#" class="nav-link-item">
                    <i class="bi bi-file-earmark"></i><span>Funcoes_2grau_resolucao.pdf</span>
                    <span class="badge bg-success ms-auto">enviado há 2 min</span>
                </a>
                <form class="mt-3">
                    <div class="input-group">
                        <input type="file" class="form-control" disabled>
                        <button type="button" class="btn btn-secondary" disabled>Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Coluna de Progresso da Sala -->
    <div class="col-lg-6 mb-4">
        <div class="progress-card">
            <div class="card-header">
                <h5><i class="bi bi-graph-up me-2"></i>Progresso da Sala</h5>
            </div>
            <div class="card-body">
                <div class="progress-item">
                    <div class="progress-label"><span>Tópicos Estudados</span><span class="progress-value">3/5</span></div>
                    <div class="progress"><div class="progress-bar bg-primary" style="width: 60%"></div></div>
                </div>
                <div class="progress-item">
                    <div class="progress-label"><span>PDFs Lidos</span><span class="progress-value">2/4</span></div>
                    <div class="progress"><div class="progress-bar bg-success" style="width: 50%"></div></div>
                </div>
                <div class="progress-item">
                    <div class="progress-label"><span>Tempo de Estudo</span><span class="progress-value">6h/10h</span></div>
                    <div class="progress"><div class="progress-bar bg-warning" style="width: 60%"></div></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- =================================================================== -->
<!-- ======================= MODAIS (POP-UPS) ========================== -->
<!-- =================================================================== -->

<!-- Modal: Adicionar Novo Membro -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel"><i class="bi bi-person-plus-fill me-2"></i>Convidar para a Sala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('create_notification')}}" method="POST">
                    @csrf
                    <input type="hidden" name="room_id" value="{{$room->id}}">
                    <div class="mb-3">
                        <label for="memberEmail" class="form-label">E-mail do Convidado</label>
                        <input type="email" class="form-control" name="email" placeholder="exemplo@email.com" required>
                    </div>
                    <div class="alert alert-info d-flex align-items-center mt-3" role="alert">
                      <i class="bi bi-info-circle-fill me-2"></i>
                      <div>
                        O usuário receberá um convite por e-mail para se juntar à sala.
                      </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="addMemberForm" class="btn btn-primary"><i class="bi bi-send me-1"></i>Enviar Convite</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Listar Todos os Membros -->
<div class="modal fade" id="listMembersModal" tabindex="-1" aria-labelledby="listMembersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listMembersModalLabel"><i class="bi bi-people-fill me-2"></i>Membros da Sala: {{$room->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Cargo</th>
                                <th scope="col" class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Exemplo de como iterar com dados do backend --}}
                            {{-- @foreach($room->users as $user) --}}
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-circle fs-4 me-2"></i>
                                        <div>
                                            <div class="fw-bold">João Silva</div>
                                            <div class="text-muted small">joao.silva@exemplo.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-danger">Administrador</span></td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil-square me-2"></i>Editar Cargo</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-shield-check me-2"></i>Tornar Admin</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Remover da Sala</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-circle fs-4 me-2"></i>
                                        <div>
                                            <div class="fw-bold">Maria Souza</div>
                                            <div class="text-muted small">maria.souza@exemplo.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-warning">Gerente</span></td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil-square me-2"></i>Editar Cargo</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Remover da Sala</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-circle fs-4 me-2"></i>
                                        <div>
                                            <div class="fw-bold">Lucas Pereira</div>
                                            <div class="text-muted small">lucas.p@exemplo.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary">Convidado</span></td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil-square me-2"></i>Editar Cargo</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Remover da Sala</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    // Atualizar horário em tempo real no header
    function updateTime() {
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            const now = new Date();
            const timeString = now.toLocaleTimeString('pt-BR');
            const dateString = now.toLocaleDateString('pt-BR');
            timeElement.innerHTML = `${dateString} - ${timeString}`;
        }
    }

    setInterval(updateTime, 1000);
    updateTime();

</script>
@endsection
