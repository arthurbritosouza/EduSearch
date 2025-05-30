@extends('layouts.app')

@section('title')
EduSearch - {{ $pdf_data->title ?? 'Visualizador de PDF' }}
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/pdf-viewer.css') }}">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/pdf-upload.css') }}">
@endsection

@section('content')
<!-- Overlay para mobile -->
<div class="overlay" id="overlay"></div>



<!-- Header da Página -->
<div class="pdf-header mb-4">
    <div class="header-content d-flex flex-wrap justify-content-between align-items-center">
        <div class="header-info">
            <div class="breadcrumb-nav">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="/home"><i class="bi bi-house"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="/biblioteca-pdf">Biblioteca PDF</a></li>
                        <li class="breadcrumb-item active">{{ $pdf_data->title ?? 'Documento PDF' }}</li>
                    </ol>
                </nav>
            </div>
            <h1 class="page-title mb-1">
                <i class="bi bi-file-earmark-pdf-fill me-2"></i>
                {{ $pdf->name ?? 'Documento PDF' }}
            </h1>
            <div class="pdf-meta mb-2">
                <span class="meta-item me-3">
                    <i class="bi bi-file-text me-1"></i>
                    {{ $pdf->pages ?? 0 }} páginas
                </span>
                <span class="meta-item me-3">
                    <i class="bi bi-calendar me-1"></i>
                    Processado em {{ \Carbon\Carbon::parse($pdf->created_at ?? now())->format('d/m/Y') }}
                </span>
                <span class="meta-item">
                    <i class="bi bi-robot me-1"></i>
                    IA Processada
                </span>
            </div>
        </div>
        <div class="header-actions d-flex align-items-center gap-2">
            <button class="btn btn-outline-light" id="downloadPdf">
                <i class="bi bi-download"></i> Download
            </button>
            <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#shareModal">
                <i class="bi bi-share"></i> Compartilhar
            </button>
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" id="printPdf"><i class="bi bi-printer me-2"></i>Imprimir</a></li>
                    <li><a class="dropdown-item" href="#" id="exportNotes"><i class="bi bi-journal-text me-2"></i>Exportar Anotações</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash me-2"></i>Excluir</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Alertas -->
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong><i class="bi bi-exclamation-triangle me-2"></i>Erro:</strong>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Navegação por Abas -->
<div class="tabs-container mb-3">
    <ul class="nav nav-tabs enhanced-tabs" id="pdfTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">
                <i class="bi bi-grid-3x3-gap"></i>
                <span>Visão Geral</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#content" type="button" role="tab" aria-controls="content" aria-selected="false">
                <i class="bi bi-file-text"></i>
                <span>Conteúdo Extraído</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="chat-tab" data-bs-toggle="tab" data-bs-target="#chat" type="button" role="tab" aria-controls="chat" aria-selected="false">
                <i class="bi bi-chat-dots"></i>
                <span>Chat com PDF</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="study-tab" data-bs-toggle="tab" data-bs-target="#study" type="button" role="tab" aria-controls="study" aria-selected="false">
                <i class="bi bi-book"></i>
                <span>Ferramentas de Estudo</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab" aria-controls="notes" aria-selected="false">
                <i class="bi bi-journal-text"></i>
                <span>Anotações</span>
            </button>
        </li>
    </ul>
</div>

<div class="tab-content enhanced-tab-content" id="pdfTabsContent">
    <!-- Aba Visão Geral -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel">
        <div class="overview-container">
            <div class="row g-4">
                <!-- Resumo do PDF -->
                <div class="col-lg-8">
                    <div class="summary-card card mb-4">
                        <div class="card-header">
                            <h3><i class="bi bi-file-earmark-text me-2"></i>Resumo do Documento</h3>
                        </div>
                        <div class="card-body">
                            <div class="summary-content">
                                <p>{{ $pdf_data->summary ?? 'Este documento foi processado pela IA e está pronto para interação. Use o chat para fazer perguntas específicas sobre o conteúdo ou explore as ferramentas de estudo disponíveis.' }}</p>
                            </div>
                            <div class="summary-actions mt-3">
                                <button class="btn btn-primary" onclick="switchToTab('chat-tab')">
                                    <i class="bi bi-chat-dots me-2"></i>Conversar com PDF
                                </button>
                                <button class="btn btn-outline-secondary" onclick="switchToTab('study-tab')">
                                    <i class="bi bi-book me-2"></i>Ferramentas de Estudo
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Informações Técnicas -->
                    <div class="tech-info-card card">
                        <div class="card-header">
                            <h4><i class="bi bi-info-circle me-2"></i>Informações Técnicas</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-2">
                                        <strong>Tamanho do arquivo:</strong>
                                        <span>{{ $pdf->size ?? '2.5 MB' }}</span>
                                    </div>
                                    <div class="info-item mb-2">
                                        <strong>Número de páginas:</strong>
                                        <span>{{ $pdf->pages ?? '45' }} páginas</span>
                                    </div>
                                    <div class="info-item mb-2">
                                        <strong>Idioma detectado:</strong>
                                        <span>{{ $pdf->language }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-2">
                                        <strong>Processamento IA:</strong>
                                        <span class="badge bg-success">Concluído</span>
                                    </div>
                                    <div class="info-item mb-2">
                                        <strong>Palavras analisadas:</strong>
                                        <span>{{ $pdf->words ?? '2.5 MB' }}</span>
                                    </div>
                                    <div class="info-item mb-2">
                                        <strong>Data de pesquisa:</strong>
                                        <span>{{ \Carbon\Carbon::parse($pdf->created_at ?? now())->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar com Estatísticas -->
                <div class="col-lg-4">
                    <div class="stats-sidebar">
                        <!-- Estatísticas do PDF -->
                        <div class="stats-widget card mb-4">
                            <div class="card-body">
                                <h4>Estatísticas do Documento</h4>
                                <div class="stats-grid row row-cols-2 g-3 mt-2">
                                    <div class="stat-item col">
                                        <i class="bi bi-file-text"></i>
                                        <span class="stat-number">{{ $pdf_data->word_count ?? '12.5k' }}</span>
                                        <span class="stat-label">Palavras</span>
                                    </div>
                                    <div class="stat-item col">
                                        <i class="bi bi-chat-dots"></i>
                                        <span class="stat-number">{{ $pdf_data->chat_count ?? '0' }}</span>
                                        <span class="stat-label">Conversas</span>
                                    </div>
                                    <div class="stat-item col">
                                        <i class="bi bi-journal"></i>
                                        <span class="stat-number">{{ $pdf_data->notes_count ?? '0' }}</span>
                                        <span class="stat-label">Anotações</span>
                                    </div>
                                    <div class="stat-item col">
                                        <i class="bi bi-bookmark"></i>
                                        <span class="stat-number">{{ $pdf_data->bookmarks_count ?? '0' }}</span>
                                        <span class="stat-label">Marcadores</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tópicos Principais -->
                        <div class="topics-widget card mb-4">
                            <div class="card-body">
                                <h4 class="widget-header">Tópicos Principais</h4>
                                <div class="topics-list">
                                    @if(isset($pdf_data->main_topics))
                                    @foreach($pdf_data->main_topics as $topic)
                                    <div class="topic-item">
                                        <span class="topic-name">{{ $topic }}</span>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="topic-item">
                                        <span class="topic-name">Matemática Avançada</span>
                                    </div>
                                    <div class="topic-item">
                                        <span class="topic-name">Cálculo Diferencial</span>
                                    </div>
                                    <div class="topic-item">
                                        <span class="topic-name">Equações Diferenciais</span>
                                    </div>
                                    <div class="topic-item">
                                        <span class="topic-name">Análise Numérica</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Ações Rápidas -->
                        <div class="quick-actions-widget card">
                            <div class="card-body">
                                <h4 class="widget-header">Ações Rápidas</h4>
                                <div class="actions-list d-grid gap-2">
                                    <button class="action-btn btn btn-outline-primary" onclick="generateQuiz()">
                                        <i class="bi bi-question-circle"></i>
                                        <span>Gerar Quiz</span>
                                    </button>
                                    <button class="action-btn btn btn-outline-primary" onclick="createSummary()">
                                        <i class="bi bi-file-earmark-text"></i>
                                        <span>Criar Resumo</span>
                                    </button>
                                    <button class="action-btn btn btn-outline-primary" onclick="extractKeywords()">
                                        <i class="bi bi-tags"></i>
                                        <span>Palavras-chave</span>
                                    </button>
                                    <button class="action-btn btn btn-outline-primary" onclick="generateFlashcards()">
                                        <i class="bi bi-card-text"></i>
                                        <span>Flashcards</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aba Conteúdo Extraído -->
    <div class="tab-pane fade" id="content" role="tabpanel">
        <div class="content-viewer">
            <div class="content-body">
                @if(isset($content))
                {!! $content !!}
                @else
                <section id="section-0">
                    <h2>Introdução</h2>
                    <p>Este é o conteúdo extraído do PDF. A IA processou todo o documento e organizou o texto de forma estruturada para facilitar a leitura e compreensão.</p>
                    <p>O sistema de extração preserva a formatação original e identifica automaticamente títulos, parágrafos, listas e outros elementos estruturais do documento.</p>
                </section>
                <section id="section-1">
                    <h2>Conceitos Fundamentais</h2>
                    <p>Aqui estão os principais conceitos abordados no documento. A IA identificou e organizou as informações mais relevantes para facilitar o estudo.</p>
                    <ul>
                        <li>Conceito 1: Definição e aplicação</li>
                        <li>Conceito 2: Exemplos práticos</li>
                        <li>Conceito 3: Relações com outros tópicos</li>
                    </ul>
                </section>
                <section id="section-2">
                    <h2>Aplicações Práticas</h2>
                    <p>Esta seção apresenta as aplicações práticas dos conceitos apresentados no documento.</p>
                    <blockquote>
                        "A aplicação prática dos conceitos teóricos é fundamental para a compreensão completa do assunto."
                    </blockquote>
                </section>
                @endif
            </div>
        </div>
    </div>

    <!-- Aba Chat com PDF -->
    <div class="tab-pane fade" id="chat" role="tabpanel" aria-labelledby="chat-tab">
        <div class="chat-body">
            <div class="chat-messages" id="chatMessages">
                <div class="message ai-message">
                    <div class="message-avatar"><i class="bi bi-robot"></i></div>
                    <div class="message-content">
                        <div class="message-text">
                            Olá! Eu sou seu assistente de IA para este documento. Posso responder perguntas sobre o conteúdo, criar resumos, explicar conceitos e muito mais. Como posso ajudá-lo hoje?
                        </div>
                        <div class="message-time">Agora</div>
                    </div>
                </div>
            </div>
            <div class="suggested-questions" id="suggestedQuestions">
                <h5>Perguntas Sugeridas:</h5>
                <div class="suggestions-grid">
                    <button class="suggestion-btn" onclick="askQuestion('Qual é o tema principal deste documento?')">
                        Qual é o tema principal?
                    </button>
                    <button class="suggestion-btn" onclick="askQuestion('Faça um resumo dos pontos mais importantes')">
                        Resumir pontos principais
                    </button>
                    <button class="suggestion-btn" onclick="askQuestion('Quais são os conceitos-chave abordados?')">
                        Conceitos-chave
                    </button>
                    <button class="suggestion-btn" onclick="askQuestion('Crie uma lista de tópicos para estudo')">
                        Lista de estudos
                    </button>
                </div>
            </div>
        </div>
        <div class="chat-input">
            <div class="input-group">
                <input type="hidden" id="user_id" value="{{ auth()->id() }}">
                <input type="hidden" id="title" value="{{ $pdf->name }}">
                <input type="text" class="form-control" id="chatInput" placeholder="Digite sua pergunta sobre o documento..." maxlength="500">
                <button class="btn btn-primary" id="sendMessage" type="button">
                    <i class="bi bi-send"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Aba Ferramentas de Estudo -->
    <div class="tab-pane fade" id="study" role="tabpanel">
        <div class="study-tools-container">
            <div class="study-header">
                <h3><i class="bi bi-book me-2"></i>Ferramentas de Estudo</h3>
                <p>Use a IA para criar materiais de estudo personalizados baseados no PDF</p>
            </div>

            <div class="tools-grid">
                <!-- Gerador de Quiz -->
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="bi bi-question-circle-fill"></i>
                    </div>
                    <div class="tool-content">
                        <h4>Gerador de Quiz</h4>
                        <p>Crie questionários automáticos baseados no conteúdo do PDF</p>
                        <button class="btn btn-primary" onclick="generateQuiz()">
                            <i class="bi bi-play-circle me-2"></i>Gerar Quiz
                        </button>
                    </div>
                </div>

                <!-- Criador de Resumos -->
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <div class="tool-content">
                        <h4>Resumos Inteligentes</h4>
                        <p>Gere resumos automáticos de diferentes tamanhos e focos</p>
                        <button class="btn btn-primary" onclick="createSummary()">
                            <i class="bi bi-magic me-2"></i>Criar Resumo
                        </button>
                    </div>
                </div>

                <!-- Flashcards -->
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="bi bi-card-text"></i>
                    </div>
                    <div class="tool-content">
                        <h4>Flashcards</h4>
                        <p>Crie cartões de estudo para memorização eficiente</p>
                        <button class="btn btn-primary" onclick="generateFlashcards()">
                            <i class="bi bi-layers me-2"></i>Criar Flashcards
                        </button>
                    </div>
                </div>

                <!-- Mapa Mental -->
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                    <div class="tool-content">
                        <h4>Mapa Mental</h4>
                        <p>Visualize as conexões entre os conceitos do documento</p>
                        <button class="btn btn-primary" onclick="createMindMap()">
                            <i class="bi bi-share me-2"></i>Criar Mapa
                        </button>
                    </div>
                </div>

                <!-- Cronograma de Estudos -->
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div class="tool-content">
                        <h4>Cronograma</h4>
                        <p>Organize um plano de estudos baseado no conteúdo</p>
                        <button class="btn btn-primary" onclick="createStudyPlan()">
                            <i class="bi bi-calendar-plus me-2"></i>Criar Plano
                        </button>
                    </div>
                </div>

                <!-- Glossário -->
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="bi bi-book-half"></i>
                    </div>
                    <div class="tool-content">
                        <h4>Glossário</h4>
                        <p>Extraia e defina termos técnicos do documento</p>
                        <button class="btn btn-primary" onclick="createGlossary()">
                            <i class="bi bi-list-ul me-2"></i>Criar Glossário
                        </button>
                    </div>
                </div>
            </div>

            <!-- Área de Resultados -->
            <div class="results-area" id="studyResults" style="display: none;">
                <div class="results-header">
                    <h4 id="resultsTitle">Resultados</h4>
                    <button class="btn btn-outline-secondary btn-sm" onclick="closeResults()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="results-content" id="resultsContent">
                    <!-- Conteúdo dos resultados será inserido aqui -->
                </div>
                <div class="results-actions">
                    <button class="btn btn-primary" onclick="saveResults()">
                        <i class="bi bi-save me-2"></i>Salvar
                    </button>
                    <button class="btn btn-outline-secondary" onclick="exportResults()">
                        <i class="bi bi-download me-2"></i>Exportar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Aba Anotações -->
    <div class="tab-pane fade" id="notes" role="tabpanel">
        <div class="notes-container">
            <div class="notes-header">
                <div class="header-info">
                    <h3><i class="bi bi-journal-text me-2"></i>Anotações do PDF</h3>
                    <p>Organize suas anotações e insights sobre este documento</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                    <i class="bi bi-plus-circle me-2"></i>Nova Anotação
                </button>
            </div>

            <div class="notes-grid">
                <!-- Anotações serão carregadas aqui -->
                <div class="note-card sample-note">
                    <div class="note-header">
                        <h5 class="note-title">Conceitos Importantes</h5>
                        <div class="note-actions">
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="note-body">
                        <div class="note-content">
                            <p>Esta é uma anotação de exemplo sobre os conceitos importantes encontrados no documento.</p>
                        </div>
                        <div class="note-meta">
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                Hoje às 14:30 • Página 15
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- Modais -->
<div class="modal fade" id="addNoteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Anotação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="noteForm">
                    <div class="mb-3">
                        <label for="noteTitle" class="form-label">Título</label>
                        <input type="text" class="form-control" id="noteTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="noteContent" class="form-label">Conteúdo</label>
                        <textarea class="form-control" id="noteContent" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="notePage" class="form-label">Página de Referência</label>
                        <input type="number" class="form-control" id="notePage" min="1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveNote()">Salvar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/chat-pdf.js') }}"></script>
@endsection
