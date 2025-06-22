@extends('layouts.app')

@section('title')
EduSearch - {{ $data_topic->name}}
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/topicos.css') }}">

<style>
    .rooms-container {
        padding: 1rem;
    }

    .rooms-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .rooms-header .header-info h3 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 600;
        color: #222;
    }

    .rooms-header .header-info p {
        margin: 0.25rem 0 0;
        color: #555;
        font-size: 0.95rem;
    }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.25rem;
    }

    /* Card das salas */
    .room-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 1rem 1.25rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        cursor: pointer;
    }

    .room-card:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        transform: translateY(-4px);
    }

    .room-icon {
        font-size: 2.25rem;
        color: #0d6efd;
        /* Azul Bootstrap primário */
        margin-bottom: 0.75rem;
        align-self: flex-start;
    }

    .room-info {
        flex-grow: 1;
    }

    .room-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #222;
        margin-bottom: 0.5rem;
    }

    .room-description {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .room-meta {
        font-size: 0.9rem;
        color: #666;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .room-meta i {
        font-size: 1.1rem;
        color: #0d6efd;
    }

    .room-actions {
        margin-top: auto;
        text-align: right;
    }

    .room-actions .btn {
        font-size: 0.85rem;
        padding: 0.35rem 0.75rem;
    }

</style>
@endsection

@section('content')
@section('header_content')
<div class="col-md-8">
    <h1 class="dashboard-title">
        <i class="bi bi-folder-check"></i> {{$data_topic->name}}
    </h1>
    <p class="dashboard-subtitle"></p>
    <div class="header-actions mt-2">
        <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="bi bi-trash"></i> Excluir
        </button>
        <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#editModal">
            <i class="bi bi-pencil"></i> Editar
        </button>
        <button class="btn btn-outline-light">
            <i class="bi bi-share"></i> Compartilhar
        </button>
    </div>
</div>
@endsection

<!-- Navegação por Abas -->
<div class="tabs-container">
    <ul class="nav nav-tabs enhanced-tabs" id="contentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                <i class="bi bi-grid-3x3-gap"></i>
                <span>Visão Geral</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="topics-tab" data-bs-toggle="tab" data-bs-target="#topics" type="button" role="tab">
                <i class="bi bi-book"></i>
                <span>Conteúdo</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="exercises-tab" data-bs-toggle="tab" data-bs-target="#exercises" type="button" role="tab">
                <i class="bi bi-puzzle"></i>
                <span>Exercícios</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="anotacao-tab" data-bs-toggle="tab" data-bs-target="#anotacao" type="button" role="tab">
                <i class="bi bi-journal-text"></i>
                <span>Anotações</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="partners-tab" data-bs-toggle="tab" data-bs-target="#partners" type="button" role="tab">
                <i class="bi bi-people"></i>
                <span>Parceiros</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rooms-tab" data-bs-toggle="tab" data-bs-target="#rooms" type="button" role="tab">
                <i class="bi bi-house-door"></i>
                <span>Salas</span>
            </button>
        </li>
    </ul>
</div>

<div class="tab-content enhanced-tab-content" id="contentTabsContent">
    <!-- Aba Visão Geral -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel">
        <div class="overview-container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="summary-card">
                        <div class="card-header">
                            <h3><i class="bi bi-info-circle me-2"></i>Resumo sobre {{ $data_topic->name }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="summary-content">
                                {!! $texto !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar com Materiais -->
                <div class="col-lg-4">
                    <div class="materials-sidebar">
                        <!-- Estatísticas Rápidas -->
                        <div class="stats-widget">
                            <h4>Estatísticas</h4>
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <i class="bi bi-file-text"></i>
                                    <span class="stat-number">{{ count($materials) }}</span>
                                    <span class="stat-label">Materiais</span>
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-puzzle"></i>
                                    <span class="stat-number">{{ count($arrayEx) }}</span>
                                    <span class="stat-label">Exercícios</span>
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-people"></i>
                                    <span class="stat-number">{{ count($parceiros) }}</span>
                                    <span class="stat-label">Parceiros</span>
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-journal"></i>
                                    <span class="stat-number">{{ count($anotacoes) }}</span>
                                    <span class="stat-label">Anotações</span>
                                </div>
                            </div>
                        </div>

                        <!-- Materiais por Nível -->
                        <div class="levels-widget">
                            <div class="widget-header">
                                <h4>Materiais por Nível</h4>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>

                            <div class="levels-accordion" id="levelsAccordion">
                                <!-- Iniciante -->
                                <div class="level-section">
                                    <div class="level-header" data-bs-toggle="collapse" data-bs-target="#levelBeginner">
                                        <span class="level-badge beginner">Iniciante</span>
                                        <span class="level-count">{{ $materials->where('level', 1)->count() }}
                                            materiais</span>
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                    <div id="levelBeginner" class="collapse" data-bs-parent="#levelsAccordion">
                                        <div class="level-content">
                                            @foreach ($materials->where('level', 1) as $material)
                                            <a href="{{ route('material.show', $material->id) }}" class="material-link">
                                                <i class="bi bi-file-earmark-text"></i>
                                                <span>{{ $material->name_material }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Intermediário -->
                                <div class="level-section">
                                    <div class="level-header" data-bs-toggle="collapse" data-bs-target="#levelIntermediate">
                                        <span class="level-badge intermediate">Intermediário</span>
                                        <span class="level-count">{{ $materials->where('level', 2)->count() }}
                                            materiais</span>
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                    <div id="levelIntermediate" class="collapse" data-bs-parent="#levelsAccordion">
                                        <div class="level-content">
                                            @foreach ($materials->where('level', 2) as $material)
                                            <a href="{{ route('material.show', $material->id) }}" class="material-link">
                                                <i class="bi bi-file-earmark-text"></i>
                                                <span>{{ $material->name_material }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Avançado -->
                                <div class="level-section">
                                    <div class="level-header" data-bs-toggle="collapse" data-bs-target="#levelAdvanced">
                                        <span class="level-badge advanced">Avançado</span>
                                        <span class="level-count">{{ $materials->where('level', 3)->count() }}
                                            materiais</span>
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                    <div id="levelAdvanced" class="collapse" data-bs-parent="#levelsAccordion">
                                        <div class="level-content">
                                            @foreach ($materials->where('level', 3) as $material)
                                            <a href="{{ route('material.show', $material->id) }}" class="material-link">
                                                <i class="bi bi-file-earmark-text"></i>
                                                <span>{{ $material->name_material }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aba Conteúdo -->
    <div class="tab-pane fade" id="topics" role="tabpanel">
        <div class="content-reader">
            <!-- Conteúdo Principal -->
            <div class="article-content" id="articleContent">
                <article class="content-article">
                    <header class="article-header">
                        <h1>{{ $data_topic->name }}</h1>
                        <div class="article-meta">
                            <span class="meta-item">
                                <i class="bi bi-book me-1"></i>{{ $data_topic->materia }}
                            </span>
                            <span class="meta-item">
                                <i class="bi bi-clock me-1"></i><span id="readingTime">5 min</span> de leitura
                            </span>
                            <span class="meta-item">
                                <i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($data_topic->created_at)->format('d/m/Y') }}
                            </span>
                        </div>
                    </header>

                    <div class="article-body">
                        {!! $topicFormatado !!}
                    </div>
                </article>
            </div>

        </div>
    </div>

    <!-- Aba Exercícios -->
    <div class="tab-pane fade" id="exercises" role="tabpanel">
        <div class="exercises-container">
            <div class="exercises-header">
                <div class="header-info">
                    <h3>Exercícios de {{ $data_topic->name }}</h3>
                    <p>Pratique seus conhecimentos com exercícios personalizados</p>
                </div>
                <div class="header-controls">
                    <select class="form-select" id="levelFilter">
                        <option value="">Todos os níveis</option>
                        <option value="iniciante">Iniciante</option>
                        <option value="intermediario">Intermediário</option>
                        <option value="avancado">Avançado</option>
                    </select>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exercicioModal">
                        <i class="bi bi-plus-circle me-2"></i>Gerar Exercícios
                    </button>
                </div>
            </div>


            @if(!empty($arrayEx))
            <div class="exercises-grid">
                @foreach ($arrayEx as $exercise)
                <div class="exercise-card" data-level="{{ $exercise['level'] }}">
                    <div class="exercise-header">
                        <span class="exercise-badge {{ $exercise['level'] }}">
                            {{ ucfirst($exercise['level']) }}
                        </span>
                        <div class="exercise-actions">
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                    </div>
                    <div class="exercise-body">
                        <h5>{{ $exercise['title'] }}</h5>
                        <p class="exercise-preview">Clique para resolver este exercício...</p>
                    </div>
                    <div class="exercise-footer">
                        <button class="btn btn-primary open-exercise-modal" data-exercise-id="{{ $exercise['id'] }}">
                            <i class="bi bi-play-circle me-2"></i>Resolver
                        </button>
                    </div>
                </div>
                <!-- Modal do Exercício -->
                <div class="modal fade exercise-modal" id="modal-{{ $exercise['id'] }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Exercício - {{ ucfirst($exercise['level']) }}</h5>
                                <button type="button" class="btn-close close-modal" data-exercise-id="{{ $exercise['id'] }}"></button>
                            </div>
                            <div class="modal-body">
                                <div class="exercise-question">
                                    <h6>{{ $exercise['title'] }}</h6>
                                </div>
                                <form id="answerForm-{{ $exercise['id'] }}">
                                    @csrf
                                    <input type="hidden" name="id_exercise" value="{{ $exercise['id'] }}">
                                    <div class="answer-options">
                                        @foreach ($exercise['alternatives'] as $index => $alternativa)
                                        <div class="form-check answer-option">
                                            <input class="form-check-input" type="radio" name="resposta" id="option-{{ $exercise['id'] }}-{{ $index }}" value="{{ $alternativa }}" required>
                                            <label class="form-check-label" for="option-{{ $exercise['id'] }}-{{ $index }}">
                                                {{ $alternativa }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close-modal" data-exercise-id="{{ $exercise['id'] }}">Cancelar</button>
                                <button type="button" class="btn btn-primary submit-answer" data-exercise-id="{{ $exercise['id'] }}">
                                    <i class="bi bi-check-circle me-2"></i>Responder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal de Feedback -->
                <div class="modal fade feedback-modal" id="feedback-modal-{{ $exercise['id'] }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Resultado</h5>
                                <button type="button" class="btn-close close-feedback-modal" data-exercise-id="{{ $exercise['id'] }}"></button>
                            </div>
                            <div class="modal-body">
                                <div id="feedback-message-{{ $exercise['id'] }}" class="alert"></div>
                                <div class="feedback-explanation">
                                    <h6>Explicação:</h6>
                                    <p id="resolucao-{{ $exercise['id'] }}"></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary close-feedback-modal" data-exercise-id="{{ $exercise['id'] }}">Continuar</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-puzzle text-muted" style="font-size: 3rem;"></i>
                <h4 class="mt-3 text-muted">Nenhum exercício encontrado</h4>
                <p class="text-muted">Você ainda não tem exercícios para este tópico.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exercicioModal">
                    <i class="bi bi-plus-circle me-2"></i>Gerar Exercícios
                </button>
            </div>
            @endif

        </div>
    </div>

    <!-- Aba Anotações -->
    <div class="tab-pane fade" id="anotacao" role="tabpanel">
        @if($anotacoes->count() > 0)
        <div class="notes-container">
            <div class="notes-header">
                <div class="header-info">
                    <h3>Minhas Anotações</h3>
                    <p>Organize suas anotações e insights sobre o tópico</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                    <i class="bi bi-plus-circle me-2"></i>Nova Anotação
                </button>
            </div>

            <div class="notes-grid">
                @foreach ($anotacoes as $anotacao)
                <div class="note-card" data-note-id="{{ $anotacao->id }}">
                    <div class="note-header">
                        <h5 class="note-title">{{ $anotacao->title }}</h5>
                        <div class="note-actions">
                            <button class="btn btn-sm btn-outline-secondary btn-view" data-bs-toggle="modal" data-bs-target="#viewNoteModal">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-info btn-fullscreen">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </button>
                            <a href="/excluir_anotacao/{{ $anotacao->id }}" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </div>
                    <div class="note-body">
                        <div class="note-content">
                            <p>{{ Str::limit($anotacao->annotation, 150) }}</p>
                        </div>
                        <div class="note-meta">
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($anotacao->created_at)->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-journal-text text-muted" style="font-size: 3rem;"></i>
            <h4 class="mt-3 text-muted">Nenhuma anotação encontrada</h4>
            <p class="text-muted">Você ainda não tem anotações para este tópico.</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                <i class="bi bi-plus-circle me-2"></i>Nova Anotação
            </button>
        </div>
        @endif
    </div>

    <!-- Aba Parceiros -->
    <div class="tab-pane fade" id="partners" role="tabpanel">
        @if($parceiros->count() > 0)
        <div class="partners-container">
            <div class="partners-header">
                <div class="header-info">
                    <h3>Parceiros de Estudo</h3>
                    <p>Colabore com outros estudantes interessados em {{ $data_topic->name }}</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addParceiroModall">
                    <i class="bi bi-person-plus me-2"></i>Adicionar Parceiro
                </button>
            </div>

            <div class="partners-grid">
                @foreach ($parceiros as $parceiro)
                <div class="partner-card">
                    <div class="partner-avatar">
                        <div class="avatar-placeholder">
                            {{ strtoupper(substr($parceiro->name, 0, 2)) }}
                        </div>
                    </div>
                    <div class="partner-info">
                        <h5 class="partner-name">{{ $parceiro->name }}</h5>
                        <p class="partner-email">{{ $parceiro->email }}</p>
                    </div>
                    <div class="partner-actions">
                        <a href="/excluir_parceiro/{{ $data_topic->id }}/{{ $parceiro->id }}" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-person-x"></i> Remover
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
            <h4 class="mt-3 text-muted">Nenhum parceiro encontrado</h4>
            <p class="text-muted">Você ainda não tem parceiros de estudo para este tópico.</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addParceiroModall">
                <i class="bi bi-person-plus me-2"></i>Adicionar Parceiro
            </button>
        </div>
        @endif
    </div>

    <div class="tab-pane fade" id="rooms" role="tabpanel">
        <div class="rooms-container">
            <div class="rooms-header">
                <div class="header-info">
                    <h3>Salas de Estudo</h3>
                    <p>Explore salas de discussão e grupos de estudo relacionados a {{ $data_topic->name }}</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                    <i class="bi bi-plus-circle me-2"></i>Criar Nova Sala
                </button>
            </div>

            <div class="rooms-grid">
                {{-- Dados Estáticos para Visualização --}}
                <div class="room-card">
                    <div class="room-icon">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>
                    <div class="room-info">
                        <h5 class="room-name">Sala de Estudo: Tópico X</h5>
                        <p class="room-description">Discussão aprofundada sobre conceitos fundamentais de {{ $data_topic->name }}. Ideal para iniciantes.</p>
                        <span class="room-meta">
                            <i class="bi bi-people"></i> 15 Membros
                        </span>
                    </div>
                    <div class="room-actions">
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                        </a>
                    </div>
                </div>

                <div class="room-card">
                    <div class="room-icon">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>
                    <div class="room-info">
                        <h5 class="room-name">Preparação para Provas</h5>
                        <p class="room-description">Grupo focado em resolver exercícios e revisar para as próximas avaliações. Nível intermediário.</p>
                        <span class="room-meta">
                            <i class="bi bi-people"></i> 23 Membros
                        </span>
                    </div>
                    <div class="room-actions">
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                        </a>
                    </div>
                </div>

                <div class="room-card">
                    <div class="room-icon">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>
                    <div class="room-info">
                        <h5 class="room-name">Desafios Avançados</h5>
                        <p class="room-description">Espaço para discussão de problemas complexos e tópicos avançados em {{ $data_topic->name }}.</p>
                        <span class="room-meta">
                            <i class="bi bi-people"></i> 8 Membros
                        </span>
                    </div>
                    <div class="room-actions">
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                        </a>
                    </div>
                </div>

                <div class="room-card">
                    <div class="room-icon">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>
                    <div class="room-info">
                        <h5 class="room-name">Recursos e Dicas</h5>
                        <p class="room-description">Compartilhamento de materiais adicionais, artigos e dicas de estudo para o tópico.</p>
                        <span class="room-meta">
                            <i class="bi bi-people"></i> 30 Membros
                        </span>
                    </div>
                    <div class="room-actions">
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                        </a>
                    </div>
                </div>
                {{-- Fim dos Dados Estáticos --}}
            </div>
        </div>
    </div>

</div>
</div>
@endsection

@section('modals')
@include('modals.modal-topicView')
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/topicos.js') }}"></script>
@endsection
