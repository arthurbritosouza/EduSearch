
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="32x32" href="{{ asset('logo_edusearch.png') }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSearch - {{$pdf_data->title ?? 'Visualizador de PDF'}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pdf-viewer.css') }}">
</head>
<body>
    @include('include.sidebar')

    <!-- Overlay para mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Conteúdo Principal -->
    <div class="main-content" id="main-content">
        <div class="container-fluid">
            <!-- Header Mobile -->
            <button type="button" id="sidebarCollapse" class="btn btn-primary d-lg-none mb-4">
                <i class="bi bi-list"></i> Menu
            </button>

            <!-- Header da Página -->
            <div class="pdf-header">
                <div class="header-content">
                    <div class="header-info">
                        <div class="breadcrumb-nav">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/home"><i class="bi bi-house"></i> Home</a></li>
                                    <li class="breadcrumb-item"><a href="/biblioteca-pdf">Biblioteca PDF</a></li>
                                    <li class="breadcrumb-item active">{{$pdf_data->title ?? 'Documento PDF'}}</li>
                                </ol>
                            </nav>
                        </div>
                        <h1 class="page-title">
                            <i class="bi bi-file-earmark-pdf-fill me-2"></i>
                            {{$pdf->name ?? 'Documento PDF'}}
                        </h1>
                        <div class="pdf-meta">
                            <span class="meta-item">
                                <i class="bi bi-file-text me-1"></i>
                                {{$pdf->pages ?? 0}} páginas
                            </span>
                            <span class="meta-item">
                                <i class="bi bi-calendar me-1"></i>
                                Processado em {{ \Carbon\Carbon::parse($pdf->created_at ?? now())->format('d/m/Y') }}
                            </span>
                            <span class="meta-item">
                                <i class="bi bi-robot me-1"></i>
                                IA Processada
                            </span>
                        </div>
                    </div>
                    <div class="header-actions">
                        <div class="action-buttons">
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
            <div class="tabs-container">
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

            <!-- Conteúdo das Abas -->
            <div class="tab-content enhanced-tab-content" id="pdfTabsContent">
                <!-- Aba Visão Geral -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <div class="overview-container">
                        <div class="row g-4">
                            <!-- Resumo do PDF -->
                            <div class="col-lg-8">
                                <div class="summary-card">
                                    <div class="card-header">
                                        <h3><i class="bi bi-file-earmark-text me-2"></i>Resumo do Documento</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="summary-content">
                                            <p>{{$pdf_data->summary ?? 'Este documento foi processado pela IA e está pronto para interação. Use o chat para fazer perguntas específicas sobre o conteúdo ou explore as ferramentas de estudo disponíveis.'}}</p>
                                        </div>
                                        <div class="summary-actions">
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
                                <div class="tech-info-card mt-4">
                                    <div class="card-header">
                                        <h4><i class="bi bi-info-circle me-2"></i>Informações Técnicas</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-item">
                                                    <strong>Tamanho do arquivo:</strong>
                                                    <span>{{$pdf->size ?? '2.5 MB'}}</span>
                                                </div>
                                                <div class="info-item">
                                                    <strong>Número de páginas:</strong>
                                                    <span>{{$pdf->pages ?? '45'}} páginas</span>
                                                </div>
                                                <div class="info-item">
                                                    <strong>Idioma detectado:</strong>
                                                    <span>{{$pdf->language}}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-item">
                                                    <strong>Processamento IA:</strong>
                                                    <span class="badge bg-success">Concluído</span>
                                                </div>
                                                <div class="info-item">
                                                    <strong>Palavras analisadas:</strong>
                                                    <span>{{$pdf->words ?? '2.5 MB'}}</span>
                                                </div>
                                                <div class="info-item">
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
                                    <div class="stats-widget">
                                        <h4>Estatísticas do Documento</h4>
                                        <div class="stats-grid">
                                            <div class="stat-item">
                                                <i class="bi bi-file-text"></i>
                                                <span class="stat-number">{{$pdf_data->word_count ?? '12.5k'}}</span>
                                                <span class="stat-label">Palavras</span>
                                            </div>
                                            <div class="stat-item">
                                                <i class="bi bi-chat-dots"></i>
                                                <span class="stat-number">{{$pdf_data->chat_count ?? '0'}}</span>
                                                <span class="stat-label">Conversas</span>
                                            </div>
                                            <div class="stat-item">
                                                <i class="bi bi-journal"></i>
                                                <span class="stat-number">{{$pdf_data->notes_count ?? '0'}}</span>
                                                <span class="stat-label">Anotações</span>
                                            </div>
                                            <div class="stat-item">
                                                <i class="bi bi-bookmark"></i>
                                                <span class="stat-number">{{$pdf_data->bookmarks_count ?? '0'}}</span>
                                                <span class="stat-label">Marcadores</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tópicos Principais -->
                                    <div class="topics-widget">
                                        <div class="widget-header">
                                            <h4>Tópicos Principais</h4>
                                        </div>
                                        <div class="topics-list">
                                            @if(isset($pdf_data->main_topics))
                                            @foreach($pdf_data->main_topics as $topic)
                                            <div class="topic-item">
                                                <span class="topic-name">{{$topic}}</span>
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

                                    <!-- Ações Rápidas -->
                                    <div class="quick-actions-widget">
                                        <div class="widget-header">
                                            <h4>Ações Rápidas</h4>
                                        </div>
                                        <div class="actions-list">
                                            <button class="action-btn" onclick="generateQuiz()">
                                                <i class="bi bi-question-circle"></i>
                                                <span>Gerar Quiz</span>
                                            </button>
                                            <button class="action-btn" onclick="createSummary()">
                                                <i class="bi bi-file-earmark-text"></i>
                                                <span>Criar Resumo</span>
                                            </button>
                                            <button class="action-btn" onclick="extractKeywords()">
                                                <i class="bi bi-tags"></i>
                                                <span>Palavras-chave</span>
                                            </button>
                                            <button class="action-btn" onclick="generateFlashcards()">
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

                <!-- Aba Chat com PDF (CORRIGIDA) -->
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
<!-- Adicione o marked.js -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
// Configura o marked para renderizar quebras de linha simples como <br>
marked.setOptions({
  breaks: true
});

// Função para processar texto com escape de caracteres
function processText(text) {
    // Remove aspas do início e final
    text = text.trim();
    if ((text.startsWith('"') && text.endsWith('"')) || 
        (text.startsWith("'") && text.endsWith("'"))) {
        text = text.slice(1, -1);
    }
    
    // Converte \n literal em quebras de linha reais
    return text.replace(/\\n/g, '\n')
               .replace(/\\t/g, '\t')
               .replace(/\\r/g, '\r');
}

// Função para adicionar mensagem ao chat (com Markdown)
function addMessage(text, isUser = false) {
    const chatMessages = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'message ' + (isUser ? 'user-message' : 'ai-message');

    const avatarIcon = isUser ? 'bi-person' : 'bi-robot';
    const now = new Date();
    const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    // Processa o texto para converter escapes e depois renderiza o Markdown
    const processedText = processText(text);
    const htmlContent = marked.parse(processedText);

    messageDiv.innerHTML = `
        <div class="message-avatar"><i class="bi ${avatarIcon}"></i></div>
        <div class="message-content">
            <div class="message-text">${htmlContent}</div>
            <div class="message-time">${timeString}</div>
        </div>
    `;

    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Função para enviar mensagem
async function sendMessage() {
    const input = document.getElementById('chatInput');
    const msg = input.value.trim();
    if (!msg) return;

    addMessage(msg, true);
    input.value = '';

    // Pega o user_id e o title dos inputs hidden
    const user_id = document.getElementById('user_id').value;
    const title = document.getElementById('title').value;

    // Valida se os valores existem
    if (!user_id || !title) {
        addMessage('Erro: user_id ou title não definidos.');
        return;
    }

    // Monta a URL da API
    const apiUrl = `http://127.0.0.1:8001/chat_file/${encodeURIComponent(msg)}/${encodeURIComponent(user_id)}/${encodeURIComponent(title)}`;

    // Envia para a API
    try {
        const response = await fetch(apiUrl);
        if (!response.ok) throw new Error('Erro na API');
        const data = await response.text();
        addMessage(data);
    } catch (error) {
        console.error('Erro ao enviar mensagem:', error);
        addMessage('Desculpe, ocorreu um erro ao enviar sua mensagem.');
    }
}

// Envia mensagem ao clicar no botão
document.getElementById('sendMessage').addEventListener('click', sendMessage);

// Envia mensagem ao pressionar Enter
document.getElementById('chatInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

// Função para perguntas sugeridas (opcional)
function askQuestion(question) {
    const input = document.getElementById('chatInput');
    input.value = question;
    // Opcional: envia automaticamente
    // sendMessage();
}
</script>



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

    <!-- Scripts -->
    <!-- ... (Todo o HTML anterior permanece igual) ... -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript corrigido para o chat
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar sidebar
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const overlay = document.getElementById('overlay');

            if (sidebarCollapse && sidebar && mainContent && overlay) {
                sidebarCollapse.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    mainContent.classList.toggle('active');
                    overlay.classList.toggle('active');
                });

                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    mainContent.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }

            // Inicializar chat
            const chatInput = document.getElementById('chatInput');
            const sendButton = document.getElementById('sendMessage');
            const chatMessages = document.getElementById('chatMessages');
            const clearChatBtn = document.getElementById('clearChat');
            const suggestedQuestions = document.getElementById('suggestedQuestions');

            if (chatInput && sendButton && chatMessages) {
                // Funções do chat
                const sendMessage = () => {
                    const message = chatInput.value.trim();
                    if (!message) return;

                    // Adicionar mensagem do usuário
                    addUserMessage(message);
                    chatInput.value = '';

                    // Simular resposta da IA
                    setTimeout(() => {
                        addAIMessage(message);
                    }, 1000);
                };

                const addUserMessage = (message) => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'message user-message';
                    messageDiv.innerHTML = `
                        <div class="message-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="message-content">
                            <div class="message-text">${escapeHtml(message)}</div>
                            <div class="message-time">${getCurrentTime()}</div>
                        </div>
                    `;
                    chatMessages.appendChild(messageDiv);
                    scrollToBottom();
                };

                const addAIMessage = (userMessage) => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'message ai-message';
                    messageDiv.innerHTML = `
                        <div class="message-avatar">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div class="message-content">
                            <div class="message-text">${generateAIResponse(userMessage)}</div>
                            <div class="message-time">${getCurrentTime()}</div>
                        </div>
                    `;
                    chatMessages.appendChild(messageDiv);
                    scrollToBottom();
                };

                const generateAIResponse = (message) => {
                    const lowerMessage = message.toLowerCase();
                    if (lowerMessage.includes('resumo')) return '📋 Este é um resumo gerado pela IA...';
                    if (lowerMessage.includes('tema')) return '🎯 O tema principal é...';
                    return '🤖 Entendi sua pergunta. Aqui está a resposta...';
                };

                const scrollToBottom = () => {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                };

                const getCurrentTime = () => {
                    return new Date().toLocaleTimeString('pt-BR', {
                        hour: '2-digit'
                        , minute: '2-digit'
                    });
                };

                const escapeHtml = (text) => {
                    return text
                        .replace(/&/g, "&amp;")
                        .replace(/</g, "&lt;")
                        .replace(/>/g, "&gt;")
                        .replace(/"/g, "&quot;")
                        .replace(/'/g, "&#039;");
                };

                // Event listeners
                sendButton.addEventListener('click', sendMessage);
                chatInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        sendMessage();
                    }
                });

                if (clearChatBtn) {
                    clearChatBtn.addEventListener('click', () => {
                        chatMessages.innerHTML = `
                            <div class="message ai-message">
                                <div class="message-avatar">
                                    <i class="bi bi-robot"></i>
                                </div>
                                <div class="message-content">
                                    <div class="message-text">
                                        Olá! Como posso ajudá-lo hoje?
                                    </div>
                                    <div class="message-time">${getCurrentTime()}</div>
                                </div>
                            </div>
                        `;
                    });
                }
            }

            // Garantir que a aba do chat recebe foco
            const chatTab = document.getElementById('chat-tab');
            if (chatTab) {
                chatTab.addEventListener('shown.bs.tab', () => {
                    setTimeout(() => {
                        const chatInput = document.getElementById('chatInput');
                        if (chatInput) chatInput.focus();
                    }, 100);
                });
            }
        });

        // Função global para perguntas sugeridas
        window.askQuestion = (question) => {
            const chatInput = document.getElementById('chatInput');
            if (chatInput) {
                chatInput.value = question;
                document.getElementById('sendMessage').click();
            }
        };

    </script>
</body>
</html>
