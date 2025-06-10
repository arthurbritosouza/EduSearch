@extends('layouts.app')

@section('title')
    EduSearch - Dashboard Principal
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
                    <i class="bi bi-speedometer2 me-3"></i>Dashboard Principal
                </h1>
                <p class="dashboard-subtitle">Central de controle do seu ambiente de estudos</p>
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
                    <h3>12</h3>
                    <p>Tópicos Criados</p>
                    <small class="text-muted">+3 esta semana</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card-large success">
                <div class="stats-icon">
                    <i class="bi bi-file-earmark-pdf"></i>
                </div>
                <div class="stats-content">
                    <h3>8</h3>
                    <p>PDFs Processados</p>
                    <small class="text-muted">156 páginas total</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card-large warning">
                <div class="stats-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stats-content">
                    <h3>5</h3>
                    <p>Salas Ativas</p>
                    <small class="text-muted">23 participantes</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card-large info">
                <div class="stats-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stats-content">
                    <h3>24h</h3>
                    <p>Tempo de Estudo</p>
                    <small class="text-muted">Esta semana</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="quick-actions-section mb-5">
        <h4 class="section-title mb-4">
            <i class="bi bi-lightning-charge me-2"></i>Ações Rápidas
        </h4>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="quick-action-card" onclick="openCreateTopicModal()">
                    <div class="action-icon">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <h5>Criar Tópico</h5>
                    <p>Pesquise um novo assunto para estudar</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="quick-action-card" onclick="openPdfUploadModal()">
                    <div class="action-icon">
                        <i class="bi bi-file-earmark-pdf"></i>
                    </div>
                    <h5>Upload PDF</h5>
                    <p>Processe um novo PDF com IA</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="quick-action-card" onclick="window.location.href='/salas-estudo'">
                    <div class="action-icon">
                        <i class="bi bi-door-open"></i>
                    </div>
                    <h5>Entrar em Sala</h5>
                    <p>Junte-se a uma sala de estudos</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="quick-action-card" onclick="window.location.href='/chat-ia'">
                    <div class="action-icon">
                        <i class="bi bi-robot"></i>
                    </div>
                    <h5>Chat com IA</h5>
                    <p>Tire suas dúvidas instantaneamente</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navegação por Seções -->
    <div class="navigation-sections mb-5">
        <h4 class="section-title mb-4">
            <i class="bi bi-compass me-2"></i>Explorar Sistema
        </h4>
        <div class="row g-4">
            <!-- Seção Estudos -->
            <div class="col-lg-4">
                <div class="navigation-card estudos">
                    <div class="nav-card-header">
                        <i class="bi bi-mortarboard"></i>
                        <h5>Estudos</h5>
                    </div>
                    <div class="nav-card-body">
                        <a href="/topicos" class="nav-link-item">
                            <i class="bi bi-folder2-open"></i>
                            <span>Meus Tópicos</span>
                            <span class="badge bg-primary">12</span>
                        </a>
                        <a href="/pdfs" class="nav-link-item">
                            <i class="bi bi-file-earmark-pdf"></i>
                            <span>Biblioteca de PDFs</span>
                            <span class="badge bg-success">8</span>
                        </a>
                        <a href="/favoritos" class="nav-link-item">
                            <i class="bi bi-bookmark-heart"></i>
                            <span>Favoritos</span>
                            <span class="badge bg-warning">15</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Seção Colaborativa -->
            <div class="col-lg-4">
                <div class="navigation-card colaborativo">
                    <div class="nav-card-header">
                        <i class="bi bi-people"></i>
                        <h5>Colaborativo</h5>
                    </div>
                    <div class="nav-card-body">
                        <a href="/salas-estudo" class="nav-link-item">
                            <i class="bi bi-door-open"></i>
                            <span>Salas de Estudo</span>
                            <span class="badge bg-success">5 ativas</span>
                        </a>
                        <a href="/comunidade" class="nav-link-item">
                            <i class="bi bi-share"></i>
                            <span>Comunidade</span>
                            <span class="badge bg-info">234 posts</span>
                        </a>
                        <a href="/grupos" class="nav-link-item">
                            <i class="bi bi-people-fill"></i>
                            <span>Meus Grupos</span>
                            <span class="badge bg-primary">3</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Seção Ferramentas -->
            <div class="col-lg-4">
                <div class="navigation-card ferramentas">
                    <div class="nav-card-header">
                        <i class="bi bi-tools"></i>
                        <h5>Ferramentas</h5>
                    </div>
                    <div class="nav-card-body">
                        <a href="/chat-ia" class="nav-link-item">
                            <i class="bi bi-robot"></i>
                            <span>Chat com IA</span>
                            <span class="badge bg-success">Online</span>
                        </a>
                        <a href="/resumos" class="nav-link-item">
                            <i class="bi bi-journal-text"></i>
                            <span>Gerador de Resumos</span>
                        </a>
                        <a href="/flashcards" class="nav-link-item">
                            <i class="bi bi-card-text"></i>
                            <span>Flashcards</span>
                            <span class="badge bg-warning">12 sets</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Atividades Recentes -->
    <div class="row">
        <div class="col-lg-8">
            <div class="recent-activity-card">
                <div class="card-header">
                    <h5><i class="bi bi-clock-history me-2"></i>Atividades Recentes</h5>
                </div>
                <div class="card-body">
                    <div class="activity-item">
                        <div class="activity-icon success">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <div class="activity-content">
                            <h6>PDF "Matemática Básica" processado</h6>
                            <p>45 páginas analisadas pela IA</p>
                            <small class="text-muted">2 horas atrás</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon primary">
                            <i class="bi bi-folder-plus"></i>
                        </div>
                        <div class="activity-content">
                            <h6>Novo tópico "Física Quântica" criado</h6>
                            <p>Conteúdo gerado automaticamente</p>
                            <small class="text-muted">5 horas atrás</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon warning">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="activity-content">
                            <h6>Entrou na sala "Matemática ENEM"</h6>
                            <p>12 participantes ativos</p>
                            <small class="text-muted">1 dia atrás</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="progress-card">
                <div class="card-header">
                    <h5><i class="bi bi-graph-up me-2"></i>Progresso Semanal</h5>
                </div>
                <div class="card-body">
                    <div class="progress-item">
                        <div class="progress-label">
                            <span>Tópicos Estudados</span>
                            <span class="progress-value">8/10</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-label">
                            <span>PDFs Lidos</span>
                            <span class="progress-value">5/8</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: 62.5%"></div>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-label">
                            <span>Tempo de Estudo</span>
                            <span class="progress-value">24h/30h</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: 80%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Criar Tópico Rápido -->
    <div class="modal fade" id="quickTopicModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>Criar Tópico Rápido
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('topic.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="quickTopic" class="form-label">Assunto para estudar</label>
                            <input type="text" class="form-control" id="quickTopic" name="topic"
                                   placeholder="Ex: Equações de 2º grau, Revolução Francesa..." required>
                            <div class="form-text">A IA irá gerar conteúdo automaticamente</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-magic me-1"></i>Criar com IA
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Upload PDF Rápido -->
    <div class="modal fade" id="quickPdfModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Upload PDF Rápido
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('pdf.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="quickPdfTitle" class="form-label">Título do PDF</label>
                            <input type="text" class="form-control" id="quickPdfTitle" name="pdf_title"
                                   placeholder="Ex: Matemática Básica" required>
                        </div>
                        <div class="mb-3">
                            <label for="quickPdfFile" class="form-label">Arquivo PDF</label>
                            <input type="file" class="form-control" id="quickPdfFile" name="pdf_file"
                                   accept=".pdf" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cloud-upload me-1"></i>Processar
                        </button>
                    </div>
                </form>
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

        // Funções para abrir modais
        function openCreateTopicModal() {
            new bootstrap.Modal(document.getElementById('quickTopicModal')).show();
        }

        function openPdfUploadModal() {
            new bootstrap.Modal(document.getElementById('quickPdfModal')).show();
        }

        // Animações nos cards
        document.querySelectorAll('.quick-action-card, .navigation-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
@endsection
