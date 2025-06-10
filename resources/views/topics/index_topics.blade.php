@extends('layouts.app')

@section('title')
    EduSearch - Meus Tópicos
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
    <!-- Header Principal -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="dashboard-title">
                    <i class="bi bi-folder2-open me-3"></i>Meus Tópicos
                </h1>
                <p class="dashboard-subtitle">Organize, pesquise e acesse seus tópicos de estudo</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="user-welcome">
                    <span class="welcome-text">Bem-vindo, <strong>{{ auth()->user()->name }}</strong></span>
                    <div class="current-time" id="currentTime"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Estatísticas Rápidas -->
    <div class="row mb-5">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card-large primary">
                <div class="stats-icon">
                    <i class="bi bi-folder2-open"></i>
                </div>
                <div class="stats-content">
                    <h3>{{ count($folders) }}</h3>
                    <p>Tópicos Criados</p>
                    <small class="text-muted">+3 esta semana</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card-large success">
                <div class="stats-icon">
                    <i class="bi bi-journal-text"></i>
                </div>
                <div class="stats-content">
                    <h3>48</h3>
                    <p>Materiais Salvos</p>
                    <small class="text-muted">Total</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card-large warning">
                <div class="stats-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stats-content">
                    <h3>8h</h3>
                    <p>Tempo de Estudo</p>
                    <small class="text-muted">Hoje</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card-large info">
                <div class="stats-icon">
                    <i class="bi bi-share"></i>
                </div>
                <div class="stats-content">
                    <h3>{{ count($relacionados) }}</h3>
                    <p>Compartilhamentos</p>
                    <small class="text-muted">Total</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Barra de Pesquisa de Tópicos -->
    <div class="quick-actions-section mb-5">
        <h4 class="section-title mb-4">
            <i class="bi bi-search me-2"></i>Pesquisar Novo Tópico
        </h4>
        <form action="{{ route('topic.store') }}" method="POST">
            @csrf
            <div class="row g-3 align-items-center">
                <div class="col-md-8">
                    <input type="text" class="form-control search-input" name="topic" placeholder="Digite uma matéria ou tópico..." required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn search-btn w-100 text-white" style="background-color: var(--primary-color);">
                        <i class="bi bi-plus-circle me-1"></i>Pesquisar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Navegação por Seções -->
    <div class="navigation-sections mb-5">
        @if(count($folders) > 0)
        <h4 class="section-title mb-4">
            <i class="bi bi-folder2-open me-2"></i>Meus Tópicos
            <span class="badge bg-primary">{{ count($folders) }}</span>
        </h4>
        <div class="row g-4">
            @foreach($folders as $folder)
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="navigation-card estudos">
                    <div class="nav-card-header">
                        <i class="bi bi-folder"></i>
                        <h5>{{ $folder->name }} - {{ $folder->matter }}</h5>
                        <div class="dropdown">
                            <button class="dropdown-menu-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-eye"></i>Visualizar</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i>Editar</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-share"></i>Compartilhar</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-download"></i>Baixar</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i>Excluir</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="nav-card-body">
                        <p>{{ Str::limit($folder->summary, 120) }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('topic.show', $folder->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-folder-symlink me-1"></i>Abrir
                        </a>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-share me-1"></i>Compartilhar
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(count($relacionados) > 0)
        <h4 class="section-title mb-4">
            <i class="bi bi-people-fill me-2"></i>Tópicos de Parceiros
            <span class="badge bg-info">{{ count($relacionados) }}</span>
        </h4>
        <div class="row g-4">
            @foreach($relacionados as $parceiro)
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="navigation-card colaborativo">
                    <div class="nav-card-header">
                        <i class="bi bi-folder"></i>
                        <h5>{{ $parceiro->name }} - {{ $parceiro->matter }}</h5>
                        <div class="dropdown">
                            <button class="dropdown-menu-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-eye"></i>Visualizar</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-bookmark"></i>Salvar nos Favoritos</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-download"></i>Baixar</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-share"></i>Compartilhar</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-warning" href="#"><i class="bi bi-flag"></i>Reportar</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="nav-card-body">
                        <p>{{ Str::limit($parceiro->summary, 120) }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('topic.show', $parceiro->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-folder-symlink me-1"></i>Visualizar
                        </a>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-bookmark me-1"></i>Salvar
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(count($folders) === 0 && count($relacionados) === 0)
        <div class="empty-state">
            <i class="bi bi-folder-plus"></i>
            <h4>Nenhum tópico ainda</h4>
            <p>Comece pesquisando um assunto que você quer estudar!</p>
        </div>
        @endif
    </div>

    <!-- Modal Upload PDF -->
    <div class="modal fade" id="pdfUploadModal" tabindex="-1" aria-labelledby="pdfUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfUploadModalLabel">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Upload de PDFs para IA
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pdf.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="pdfTitle" class="form-label">
                                <i class="bi bi-tag me-1"></i>Título do PDF
                            </label>
                            <input type="text" class="form-control" id="pdfTitle" name="pdf_title" placeholder="Ex: Matemática Básica" required>
                            <div class="form-text">Digite um título para identificar este PDF</div>
                        </div>
                        <div class="mb-4">
                            <label for="pdfFile" class="form-label">
                                <i class="bi bi-cloud-upload me-1"></i>Selecionar PDF
                            </label>
                            <input type="file" class="form-control" id="pdfFile" name="pdf_file" accept=".pdf" required>
                            <div class="form-text">Selecione um arquivo PDF (máximo 50MB)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cloud-upload me-2"></i>Enviar PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
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
