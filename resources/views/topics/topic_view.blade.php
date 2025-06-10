@extends('layouts.app')

@section('title')
EduSearch - {{ $data_topic->name}}
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/topicos.css') }}">
@endsection

@section('content')
<!-- Overlay para mobile -->
<div class="overlay" id="overlay"></div>

<!-- Conteúdo Principal -->
<div class="container-fluid">
    <!-- Header Mobile -->
    <button type="button" id="sidebarCollapse" class="btn btn-primary d-lg-none mb-4">
        <i class="bi bi-list"></i> Menu
    </button>

    <!-- Header da Página -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <div class="breadcrumb-nav">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/home"><i class="bi bi-house"></i> Home</a></li>
                            <li class="breadcrumb-item"><span>{{ $data_topic->materia }}</span></li>
                            <li class="breadcrumb-item active">{{ $data_topic->name }}</li>
                        </ol>
                    </nav>
                </div>
                <h1 class="page-title">{{ $data_topic->name }}</h1>
                <p class="page-subtitle">{{ $data_topic->materia }} • Criado em
                    {{ \Carbon\Carbon::parse($data_topic->created_at)->format('d/m/Y') }}</p>
            </div>
            <div class="header-actions">
                <div class="action-buttons">
                    <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                    <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash"></i> Excluir
                    </button>
                    <button class="btn btn-outline-light">
                        <i class="bi bi-share"></i> Compartilhar
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-download me-2"></i>Exportar
                                    PDF</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-printer me-2"></i>Imprimir</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash me-2"></i>Excluir</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Tópico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('topic.update', $data_topic->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="topicName" class="form-label">Nome do Tópico</label>
                            <input type="text" class="form-control" id="topicName" name="name" value="{{ $data_topic->name }}" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Excluir Tópico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir o tópico <strong>{{ $data_topic->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('topic.destroy', $data_topic->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
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
        </ul>
    </div>

    <!-- Conteúdo das Abas -->
    <div class="tab-content enhanced-tab-content" id="contentTabsContent">
        <!-- Aba Visão Geral -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel">
            <div class="overview-container">
                <div class="row g-4">
                    <!-- Resumo Principal -->
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
                                                <a href="/conteudo/{{ $data_topic->id }}/{{ $material->id }}/2" class="material-link">
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
                                                <a href="/conteudo/{{ $data_topic->id }}/{{ $material->id }}/3" class="material-link">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                    <span>{{ $material->name_material }}</span>
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addMaterialModalLabel">Adicionar Material</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('material.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id_topic" value="{{ $data_topic->id }}">
                                                <input type="hidden" name="name_topic" value="{{ $data_topic->name }}">
                                                <div class="mb-3">
                                                    <label for="materialTitulo" class="form-label">Título</label>
                                                    <input type="text" class="form-control" id="materialTitulo" name="title" placeholder="Digite o título">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="materialDescricao" class="form-label">Descrição</label>
                                                    <textarea class="form-control" id="materialDescricao" rows="3" name="descricao" placeholder="Digite a descrição"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="materialNivel" class="form-label">Nível</label>
                                                    <select class="form-select" name="level" id="materialNivel">
                                                        <option value="iniciante">Iniciante</option>
                                                        <option value="intermediario">Intermediário</option>
                                                        <option value="avancado">Avançado</option>
                                                    </select>
                                                </div>
                                                <!-- Aqui você pode adicionar outros campos conforme necessário -->

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>
                                        </form>
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
                <!-- Modal Gerar Exercícios -->
                <div class="modal fade" id="exercicioModal" tabindex="-1" aria-labelledby="exercicioModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exercicioModalLabel">
                                    <i class="bi bi-puzzle me-2"></i>Gerar Exercícios
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <form action="/exercise_generator" method="POST" id="exercicioForm">
                                @csrf
                                <input type="hidden" name="topic" value="{{ $data_topic->name }}">
                                <input type="hidden" name="id_topic" value="{{ $data_topic->id }}">

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="quantidade" class="form-label">
                                            <i class="bi bi-hash me-1"></i>Quantidade de Exercícios
                                        </label>
                                        <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" max="15" value="0" required>
                                        <div class="form-text">Insira um número entre 1 e 15 exercícios.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dificuldade" class="form-label">
                                            <i class="bi bi-speedometer2 me-1"></i>Nível de Dificuldade
                                        </label>
                                        <select class="form-select" id="dificuldade" name="level" required>
                                            <option value="">Selecione o nível</option>
                                            <option value="iniciante">
                                                <span class="badge bg-success">Iniciante</span> - Conceitos básicos
                                            </option>
                                            <option value="intermediario">
                                                <span class="badge bg-warning">Intermediário</span> - Aplicação prática
                                            </option>
                                            <option value="avancado">
                                                <span class="badge bg-danger">Avançado</span> - Desafios complexos
                                            </option>
                                        </select>
                                        <div class="form-text">Escolha o nível adequado ao seu conhecimento.</div>
                                    </div>

                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <div>
                                            Os exercícios serão gerados automaticamente com base no conteúdo de
                                            <strong>{{ $data_topic->name }}</strong>.
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle me-2"></i>Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="generateBtn">
                                        <i class="bi bi-gear me-2"></i>Gerar Exercícios
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Adicionar Parceiro -->
                <div class="modal fade" id="addPartnerModal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPartnerModalLabel">Adicionar Parceiro de Estudo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/relacione" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <input type="hidden" name="id_topic" value="{{ $data_topic->id }}">
                                        <label for="partnerEmail" class="form-label">Email do Parceiro</label>
                                        <input type="email" class="form-control" name="email" placeholder="email@exemplo.com">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Enviar Convite</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

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
            </div>
        </div>

        <!-- Aba Anotações -->
        <div class="tab-pane fade" id="anotacao" role="tabpanel">
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
                <!-- Modal Adicionar Anotação -->
                <div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addNoteModalLabel">Nova Anotação</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <form action="/add_anotacao" method="POST">
                                @csrf
                                <input type="hidden" name="topic_id" value="{{ $data_topic->id }}">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="noteTitle" class="form-label">Título</label>
                                        <input type="text" class="form-control" id="noteTitle" name="title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="noteContent" class="form-label">Conteúdo</label>
                                        <textarea class="form-control" id="noteContent" rows="5" style="height: 200px;" name="annotation" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Salvar Anotação</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
        </div>

        <!-- Aba Parceiros -->
        <div class="tab-pane fade" id="partners" role="tabpanel">
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
        </div>
    </div>
</div>


<!-- Modal Adicionar Parceiro -->
<div class="modal fade" id="addParceiroModall" tabindex="-1" aria-labelledby="addParceiroModallLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addParceiroModallLabel">Adicionar Parceiro de Estudo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/relations" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id_topic" value="{{ $data_topic->id }}">
                        <label for="partnerEmail" class="form-label">Email do Parceiro</label>
                        <input type="email" class="form-control" name="email" placeholder="email@exemplo.com">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Convite</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/topicos.js') }}"></script>
@endsection
