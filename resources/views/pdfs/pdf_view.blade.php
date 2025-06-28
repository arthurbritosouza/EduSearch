@extends('layouts.app')

@section('title')
EduSearch - {{ $pdf_data->title ?? 'Visualizador de PDF' }}
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/pdf-viewer.css') }}">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/pdf-upload.css') }}">
<link rel="stylesheet" href="{{ asset('css/room-related.css') }}">
@endsection

@section('content')
@section('header_content')
<div class="col-md-8">
    <h1 class="dashboard-title">
        <i class="bi bi-file-earmark-pdf-fill me-2"></i>{{ $pdf->name }}
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
@endsection

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
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rooms-tab" data-bs-toggle="tab" data-bs-target="#rooms" type="button" role="tab">
                <i class="bi bi-house-door"></i>
                <span>Salas</span>
            </button>
        </li>
    </ul>
</div>

<div class="tab-content enhanced-tab-content" id="pdfTabsContent">
    <!-- Aba Visão Geral -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel">
        <div class="overview-container">
            <div class="row g-4">
                <!-- Resumo e Ações -->
                <div class="col-lg-8">
                    <div class="summary-card card mb-4">
                        <div class="card-header">
                            <h3><i class="bi bi-file-earmark-text me-2"></i>Visão Geral do Documento</h3>
                        </div>
                        <div class="card-body">
                            <div class="summary-content">
                                <p>{{ $pdf_data->summary ?? 'Este documento está pronto para interação com IA. Explore o conteúdo, faça perguntas ou utilize as ferramentas de estudo para maximizar seu aprendizado.' }}</p>
                            </div>
                            <div class="summary-actions mt-3">
                                <button class="btn btn-primary" onclick="switchToTab('chat-tab')">
                                    <i class="bi bi-chat-dots me-2"></i>Conversar com o Documento
                                </button>
                                <button class="btn btn-outline-secondary" onclick="switchToTab('study-tab')">
                                    <i class="bi bi-book me-2"></i>Ferramentas de Estudo
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Informações Técnicas Simplificadas -->
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
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-2">
                                        <strong>Idioma detectado:</strong>
                                        <span>{{ $pdf->language }}</span>
                                    </div>
                                    <div class="info-item mb-2">
                                        <strong>Data de processamento:</strong>
                                        <span>{{ \Carbon\Carbon::parse($pdf->created_at ?? now())->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar com Tópicos e Ações -->
                <div class="col-lg-4">
                    <div class="actions-sidebar">
                        <!-- Tópicos Principais -->
                        <div class="topics-widget card mb-4">
                            <div class="card-body">
                                <h4 class="widget-header">
                                    <i class="bi bi-tags me-2"></i>Tópicos Principais
                                </h4>
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
                                <h4 class="widget-header">
                                    <i class="bi bi-lightning me-2"></i>Ações Rápidas
                                </h4>
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
    <div class="tab-pane fade" id="rooms" role="tabpanel">
        <div class="rooms-container">
            <div class="rooms-header">
                <div class="header-info">
                    <h3>Salas de Estudo</h3>
                    <p>Explore salas de discussão e grupos de estudo relacionados a {{ $pdf->name }}</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPdfToRoomModal">
                    <i class="bi bi-plus-circle me-2"></i>Adicionar a Sala
                </button>
            </div>

            @if($rooms->count() > 0)
            <div class="rooms-grid">
                @foreach($rooms as $room)
                <div class="room-card">
                    <div class="room-icon">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>
                    <div class="room-info">
                        <h5 class="room-name">{{ $room->name }}</h5>
                        <p class="room-description">{{ $room->description }}</p>
                        <span class="room-meta">
                            <i class="bi bi-people"></i>
                            {{ \App\Models\Relation_room::where('room_id', $room->id)->count() }} Membros
                        </span>
                    </div>
                    <div class="room-actions">
                        <a href="{{ route('room.show', $room->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-house-door text-muted" style="font-size: 3rem;"></i>
                <h4 class="mt-3 text-muted">Nenhuma sala encontrada</h4>
                <p class="text-muted">Este PDF ainda não foi adicionado a nenhuma sala de estudo.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPdfToRoomModal">
                    <i class="bi bi-plus-circle me-2"></i>Adicionar a Sala
                </button>
            </div>
            @endif
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

<!-- Modal Adicionar PDF a Sala -->
<div class="modal fade" id="addPdfToRoomModal" tabindex="-1" aria-labelledby="addPdfToRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPdfToRoomModalLabel">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Adicionar {{ $pdf->name }} a Sala
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Navegação por Abas no Modal -->
                <ul class="nav nav-tabs" id="roomTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="my-rooms-tab" data-bs-toggle="tab" data-bs-target="#my-rooms" type="button" role="tab">
                            Minhas Salas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="create-room-tab" data-bs-toggle="tab" data-bs-target="#create-room" type="button" role="tab">
                            Criar Nova Sala
                        </button>
                    </li>
                </ul>
                <!-- Conteúdo das Abas -->
                <div class="tab-content mt-3" id="roomTabsContent">
                    <!-- Aba Minhas Salas -->
                    <div class="tab-pane fade show active" id="my-rooms" role="tabpanel">
                        <div class="list-group">
                            @if($userRooms->count() > 0)
                            @foreach($userRooms as $userRoom)
                            @php
                            $alreadyAdded = \App\Models\Room_content::where('room_id', $userRoom->id)
                            ->where('content_id', $pdf->id)
                            ->where('content_type', 2)
                            ->exists();
                            @endphp

                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $userRoom->name }}</strong>
                                    <small class="text-muted d-block">{{ $userRoom->description }}</small>
                                    <small class="text-muted">
                                        {{ \App\Models\Relation_room::where('room_id', $userRoom->id)->count() }} membros
                                    </small>
                                </div>
                                @if($alreadyAdded)
                                <span class="badge bg-success">Já adicionado</span>
                                @else
                                <a href="{{ route('room.addPdf', [$userRoom->id, $pdf->id]) }}" class="btn btn-sm btn-primary">
                                    Adicionar
                                </a>
                                @endif
                            </div>
                            @endforeach
                            @else
                            <div class="text-center py-3">
                                <i class="bi bi-house-door text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-2">Você ainda não participa de nenhuma sala.</p>
                                <p class="text-muted">Crie uma nova sala para adicionar este PDF.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- Aba Criar Nova Sala -->
                    <div class="tab-pane fade" id="create-room" role="tabpanel">
                        <form action="{{ route('room.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="roomName" class="form-label">Nome da Sala</label>
                                <input type="text" class="form-control" id="roomName" name="name" placeholder="Ex: Estudos de {{ $pdf->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="roomDescription" class="form-label">Descrição</label>
                                <textarea class="form-control" id="roomDescription" name="description" rows="3" placeholder="Descreva o objetivo da sala..." required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="roomPassword" class="form-label">Senha (opcional)</label>
                                <input type="password" class="form-control" id="roomPassword" name="password" placeholder="Se a sala for privada">
                            </div>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Após criar a sala, você poderá adicionar este PDF automaticamente.
                            </div>
                            <button type="submit" class="btn btn-primary">Criar Sala</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
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
