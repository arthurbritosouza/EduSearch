@extends('layouts.app')

@section('title', 'NotebookLM')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/topicos.css') }}">
<link rel="stylesheet" href="{{ asset('css/room.css') }}">
@endsection

@section('content')
@section('header_content')
<div class="col-md-8">
    <h1 class="dashboard-title">
        <i class="bi bi-door-open me-3"></i>Sala de Estudos:
    </h1>
    <p class="dashboard-subtitle">gffg</p>
    <!-- Botões de Ação no Header -->
    <div class="header-actions mt-2">
        <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#addMemberModal">
            <i class="bi bi-person-plus"></i> Adicionar Participante
        </button>
        <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#editModal">
            <i class="bi bi-pencil"></i> Editar
        </button>
        <button class="btn btn-outline-light me-2">
            <i class="bi bi-share"></i> Compartilhar
        </button>
        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteRoomModal">
            <i class="bi bi-trash"></i> Excluir Sala
        </button>

    </div>
</div>
@endsection
<div class="notebook-container">
    <!-- Header com logo e controles -->
    <div class="notebook-header">
        <div class="header-left">
            <div class="logo-container">
                <h1 class="notebook-title">NotebookLM</h1>
                <span class="experimental-badge">EXPERIMENTAL</span>
            </div>
        </div>
        <div class="header-right">
            <button class="header-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15Z" fill="currentColor" />
                    <path d="M19.4 15C19.2 15 19 14.8 18.8 14.6L17.8 13.6C17.6 13.4 17.6 13 17.8 12.8L18.8 11.8C19 11.6 19.2 11.4 19.4 11.4C19.6 11.4 19.8 11.6 20 11.8L21 12.8C21.2 13 21.2 13.4 21 13.6L20 14.6C19.8 14.8 19.6 15 19.4 15Z" fill="currentColor" />
                </svg>
                Settings
            </button>
            <button class="header-btn share-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M18 16.08C17.24 16.08 16.56 16.38 16.04 16.85L8.91 12.7C8.96 12.47 9 12.24 9 12C9 11.76 8.96 11.53 8.91 11.3L15.96 7.19C16.5 7.69 17.21 8 18 8C19.66 8 21 6.66 21 5C21 3.34 19.66 2 18 2C16.34 2 15 3.34 15 5C15 5.24 15.04 5.47 15.09 5.7L8.04 9.81C7.5 9.31 6.79 9 6 9C4.34 9 3 10.34 3 12C3 13.66 4.34 15 6 15C6.79 15 7.5 14.69 8.04 14.19L15.16 18.34C15.11 18.55 15.08 18.77 15.08 19C15.08 20.61 16.39 21.92 18 21.92C19.61 21.92 20.92 20.61 20.92 19C20.92 17.39 19.61 16.08 18 16.08Z" fill="currentColor" />
                </svg>
                Share
            </button>
        </div>
    </div>

    <!-- Conteúdo principal -->
    <div class="notebook-main">
        <!-- Sidebar com fontes -->
        <div class="notebook-sidebar">
            <div class="sources-section">
                <div class="sources-header">
                    <h3>Sources</h3>
                    <div class="sources-controls">
                        <button class="control-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M15.5 14H14.71L14.43 13.73C15.41 12.59 16 11.11 16 9.5C16 5.91 13.09 3 9.5 3C5.91 3 3 5.91 3 9.5C3 13.09 5.91 16 9.5 16C11.11 16 12.59 15.41 13.73 14.43L14 14.71V15.5L19 20.49L20.49 19L15.5 14ZM9.5 14C7.01 14 5 11.99 5 9.5C5 7.01 7.01 5 9.5 5C11.99 5 14 7.01 14 9.5C14 11.99 11.99 14 9.5 14Z" fill="currentColor" />
                            </svg>
                        </button>
                        <button class="control-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M3 18H21V16H3V18ZM3 13H21V11H3V13ZM3 6V8H21V6H3Z" fill="currentColor" />
                            </svg>
                        </button>
                        <button class="control-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M6 10C4.9 10 4 10.9 4 12C4 13.1 4.9 14 6 14C7.1 14 8 13.1 8 12C8 10.9 7.1 10 6 10ZM18 10C16.9 10 16 10.9 16 12C16 13.1 16.9 14 18 14C19.1 14 20 13.1 20 12C20 10.9 19.1 10 18 10ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10Z" fill="currentColor" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button class="add-source-btn" data-bs-toggle="modal" data-bs-target="#addSourceModal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z" fill="currentColor" />
                    </svg>
                    Add source
                </button>

                <div class="sources-list">
                    <div class="source-item">
                        <div class="source-checkbox">
                            <input type="checkbox" id="selectAll">
                            <label for="selectAll">Select all sources</label>
                        </div>
                    </div>
                    <!-- Fontes serão carregadas dinamicamente aqui -->
                </div>
            </div>
        </div>

        <!-- Área central - Chat/Notebook -->
        <div class="notebook-center">
            <div class="notebook-welcome" id="welcomeScreen">
                <div class="welcome-content">
                    <h2>Crie seu primeiro notebook</h2>
                    <p>NotebookLM é um assistente de pesquisa e escrita alimentado por IA que funciona melhor com as fontes que você carrega</p>

                    <div class="feature-cards">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M14 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.89 22 5.99 22H18C19.1 22 20 21.1 20 20V8L14 2ZM18 20H6V4H13V9H18V20Z" fill="currentColor" />
                                </svg>
                            </div>
                            <h3>Carregue seus documentos</h3>
                            <p>Faça upload de documentos e o NotebookLM responderá perguntas detalhadas ou destacará insights importantes</p>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M14 17H4V15H14V17ZM20 9H4V7H20V9ZM20 13H4V11H20V13Z" fill="currentColor" />
                                </svg>
                            </div>
                            <h3>Converta material complexo</h3>
                            <p>Transforme conteúdo complexo em formatos fáceis de entender como FAQs ou documentos de briefing</p>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M16 4C16.55 4 17 4.45 17 5V8.5C17 9.33 16.33 10 15.5 10C14.67 10 14 9.33 14 8.5V7H12V8.5C12 9.33 11.33 10 10.5 10C9.67 10 9 9.33 9 8.5V7H7V8.5C7 9.33 6.33 10 5.5 10C4.67 10 4 9.33 4 8.5V5C4 4.45 4.45 4 5 4H16ZM5 12H16C16.55 12 17 12.45 17 13V19C17 19.55 16.55 20 16 20H5C4.45 20 4 19.55 4 19V13C4 12.45 4.45 12 5 12Z" fill="currentColor" />
                                </svg>
                            </div>
                            <h3>Adicione recursos importantes</h3>
                            <p>Adicione recursos importantes a um notebook e compartilhe com sua organização para criar uma base de conhecimento em grupo</p>
                        </div>
                    </div>

                    <div class="welcome-actions">
                        <button class="create-btn">Create</button>
                        <button class="example-btn">Try an example notebook</button>
                    </div>
                </div>
            </div>

            <!-- Chat interface (inicialmente oculta) -->
            <div class="chat-interface" id="chatInterface" style="display: none;">
                <div class="chat-messages" id="chatMessages">
                    <!-- Mensagens aparecerão aqui -->
                </div>

                <div class="chat-input-container">
                    <div class="chat-input">
                        <textarea placeholder="Ask anything about your sources..." rows="1" id="messageInput"></textarea>
                        <button class="send-btn" id="sendBtn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M2.01 21L23 12L2.01 3L2 10L17 12L2 14L2.01 21Z" fill="currentColor" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Painel direito - Notebook guide -->
        <div class="notebook-guide">
            <div class="guide-header">
                <h3>Notebook guide</h3>
                <button class="guide-close">×</button>
            </div>

            <div class="guide-content">
                <div class="guide-buttons">
                    <button class="guide-btn active">Study guide</button>
                    <button class="guide-btn">Briefing doc</button>
                    <button class="guide-btn">FAQ</button>
                    <button class="guide-btn">Timeline</button>
                </div>

                <div class="guide-result">
                    <p>Adicione algumas fontes para gerar um guia de estudo personalizado baseado no seu conteúdo.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bootstrap para adicionar fonte (idêntico ao padrão de room_view, corrigido para separar tópicos e pdfs nas abas certas) -->
<div class="modal fade" id="addSourceModal" tabindex="-1" aria-labelledby="addSourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addSourceModalLabel">
                    <i class="bi bi-plus-circle me-2"></i>Adicionar Fonte
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="sourceTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="topics-tab" data-bs-toggle="tab" data-bs-target="#topics" type="button" role="tab" aria-controls="topics" aria-selected="true">
                            <i class="bi bi-bookmarks-fill me-1"></i> Tópicos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pdfs-tab" data-bs-toggle="tab" data-bs-target="#pdfs" type="button" role="tab" aria-controls="pdfs" aria-selected="false">
                            <i class="bi bi-file-earmark-pdf me-1"></i> PDFs
                        </button>
                    </li>
                </ul>
                <div class="tab-content p-3 border border-top-0 rounded-bottom">
                    <div class="tab-pane fade show active" id="topics" role="tabpanel" aria-labelledby="topics-tab">
                        <ul class="list-group list-group-flush">
                            @forelse($topics as $topic)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-bookmark me-2 text-primary"></i>
                                    <span>{{ $topic->name }}</span>
                                </div>
                                <button class="btn btn-outline-primary btn-sm">Adicionar</button>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">Nenhum tópico encontrado.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="pdfs" role="tabpanel" aria-labelledby="pdfs-tab">
                        <ul class="list-group list-group-flush">
                            @forelse($pdfs as $pdf)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>
                                    <span>{{ $pdf->name }}</span>
                                </div>
                                <button class="btn btn-outline-primary btn-sm">Adicionar</button>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">Nenhum PDF encontrado.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');
        const chatMessages = document.getElementById('chatMessages');
        const welcomeScreen = document.getElementById('welcomeScreen');
        const chatInterface = document.getElementById('chatInterface');
        const createBtn = document.querySelector('.create-btn');
        const exampleBtn = document.querySelector('.example-btn');
        const addSourceBtn = document.querySelector('.add-source-btn');

        // Auto-resize textarea
        if (messageInput) {
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        }

        // Função para alternar para interface de chat
        function showChatInterface() {
            welcomeScreen.style.display = 'none';
            chatInterface.style.display = 'flex';

            // Adicionar mensagem de boas-vindas
            const welcomeMessage = document.createElement('div');
            welcomeMessage.className = 'message ai-message';
            welcomeMessage.innerHTML = `
            <div style="background: #f8f9fa; padding: 16px; border-radius: 12px; margin-bottom: 16px;">
                <p><strong>NotebookLM:</strong> Olá! Adicione algumas fontes para começar a fazer perguntas sobre elas. Você pode fazer upload de PDFs, documentos do Google, sites ou vídeos do YouTube.</p>
            </div>
        `;
            chatMessages.appendChild(welcomeMessage);
        }

        // Event listeners
        if (createBtn) {
            createBtn.addEventListener('click', showChatInterface);
        }

        if (exampleBtn) {
            exampleBtn.addEventListener('click', showChatInterface);
        }

        if (addSourceBtn) {
            // Removido o alert antigo para o popup, pois agora o modal Bootstrap é usado
        }

        function sendMessage() {
            if (!messageInput) return;

            const message = messageInput.value.trim();
            if (!message) return;

            // Adicionar mensagem do usuário
            const userMessage = document.createElement('div');
            userMessage.className = 'message user-message';
            userMessage.innerHTML = `
            <div style="background: #e3f2fd; padding: 12px 16px; border-radius: 18px; margin-bottom: 16px; margin-left: auto; max-width: 70%;">
                <p style="margin: 0; color: #1565c0;"><strong>Você:</strong> ${message}</p>
            </div>
        `;
            chatMessages.appendChild(userMessage);

            // Limpar input
            messageInput.value = '';
            messageInput.style.height = 'auto';

            // Simular resposta da IA
            setTimeout(() => {
                const aiMessage = document.createElement('div');
                aiMessage.className = 'message ai-message';
                aiMessage.innerHTML = `
                <div style="background: #f8f9fa; padding: 12px 16px; border-radius: 18px; margin-bottom: 16px; max-width: 70%;">
                    <p style="margin: 0; color: #3c4043;"><strong>NotebookLM:</strong> Para responder sua pergunta adequadamente, preciso que você adicione algumas fontes primeiro. Clique em "Add source" na barra lateral para fazer upload de documentos, PDFs ou adicionar links.</p>
                </div>
            `;
                chatMessages.appendChild(aiMessage);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 1000);

            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        if (sendBtn) {
            sendBtn.addEventListener('click', sendMessage);
        }

        if (messageInput) {
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
        }

        // Guide buttons functionality
        const guideBtns = document.querySelectorAll('.guide-btn');
        guideBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                guideBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const guideResult = document.querySelector('.guide-result');
                const type = this.textContent.toLowerCase();

                switch (type) {
                    case 'study guide':
                        guideResult.innerHTML = '<p>Adicione algumas fontes para gerar um guia de estudo personalizado baseado no seu conteúdo.</p>';
                        break;
                    case 'briefing doc':
                        guideResult.innerHTML = '<p>Crie um documento de briefing resumindo os pontos principais das suas fontes.</p>';
                        break;
                    case 'faq':
                        guideResult.innerHTML = '<p>Gere perguntas frequentes baseadas no conteúdo das suas fontes.</p>';
                        break;
                    case 'timeline':
                        guideResult.innerHTML = '<p>Crie uma linha do tempo dos eventos mencionados nas suas fontes.</p>';
                        break;
                }
            });
        });

        var addSourceModal = document.getElementById('addSourceModal');
        if (addSourceModal) {
            addSourceModal.addEventListener('show.bs.modal', function() {
                fetch('/notbook-lm/sources')
                    .then(response => response.json())
                    .then(data => {
                        // Tópicos
                        const topicsList = document.getElementById('topics-list');
                        if (data.topics && data.topics.length > 0) {
                            topicsList.innerHTML = data.topics.map(topic =>
                                `<div class='d-flex justify-content-between align-items-center mb-2'>
                                    <span>${topic.name}</span>
                                    <button class='btn btn-primary btn-sm'>Adicionar</button>
                                </div>`
                            ).join('');
                        } else {
                            topicsList.innerHTML = '<span class="text-muted">Nenhum tópico encontrado.</span>';
                        }
                        // PDFs
                        const pdfsList = document.getElementById('pdfs-list');
                        if (data.pdfs && data.pdfs.length > 0) {
                            pdfsList.innerHTML = data.pdfs.map(pdf =>
                                `<div class='d-flex justify-content-between align-items-center mb-2'>
                                    <span>${pdf.name}</span>
                                    <button class='btn btn-primary btn-sm'>Adicionar</button>
                                </div>`
                            ).join('');
                        } else {
                            pdfsList.innerHTML = '<span class="text-muted">Nenhum PDF encontrado.</span>';
                        }
                    });
            });
        }
    });

</script>

<style>
    * {
        box-sizing: border-box;
    }

    .notebook-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Google Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        padding: 0;
        margin: 0;
    }

    /* Header */
    .notebook-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 12px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .logo-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .notebook-title {
        font-size: 1.5rem;
        font-weight: 400;
        color: #1a73e8;
        margin: 0;
    }

    .experimental-badge {
        background: #f1f3f4;
        color: #5f6368;
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 12px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .header-right {
        display: flex;
        gap: 8px;
    }

    .header-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: transparent;
        border: 1px solid #dadce0;
        border-radius: 20px;
        color: #3c4043;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .header-btn:hover {
        background: #f8f9fa;
        border-color: #1a73e8;
    }

    .share-btn {
        background: #1a73e8;
        color: white;
        border-color: #1a73e8;
    }

    .share-btn:hover {
        background: #1557b0;
    }

    /* Main Layout */
    .notebook-main {
        display: grid;
        grid-template-columns: 260px 1fr 320px;
        /* Sidebar menor */
        height: calc(100vh - 60px);
        gap: 0;
    }

    /* Sidebar */
    .notebook-sidebar {
        background: white;
        border-right: 1px solid #e8eaed;
        padding: 20px 10px 20px 20px;
        /* Reduz o padding à direita */
        overflow-y: auto;
        width: 260px;
        /* Reduz a largura do sidebar */
    }

    .sources-list {
        margin-right: 0;
        /* Remove margem extra */
    }

    .sources-section {
        margin-right: 0;
        /* Remove margem extra */
    }

    .sources-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .sources-header h3 {
        font-size: 1.1rem;
        font-weight: 500;
        color: #3c4043;
        margin: 0;
    }

    .sources-controls {
        display: flex;
        gap: 4px;
    }

    .control-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: transparent;
        border-radius: 4px;
        color: #5f6368;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    .control-btn:hover {
        background: #f1f3f4;
    }

    .add-source-btn {
        width: 100%;
        padding: 12px;
        background: transparent;
        border: 2px dashed #dadce0;
        border-radius: 8px;
        color: #5f6368;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        margin-bottom: 16px;
    }

    .add-source-btn:hover {
        border-color: #1a73e8;
        color: #1a73e8;
        background: rgba(26, 115, 232, 0.04);
    }

    .source-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 0;
    }

    .source-checkbox input[type="checkbox"] {
        width: 16px;
        height: 16px;
    }

    .source-checkbox label {
        font-size: 14px;
        color: #5f6368;
        cursor: pointer;
    }

    /* Center Area */
    .notebook-center {
        background: white;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .notebook-welcome {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .welcome-content {
        text-align: center;
        max-width: 600px;
    }

    .welcome-content h2 {
        font-size: 2rem;
        font-weight: 400;
        color: #3c4043;
        margin-bottom: 16px;
    }

    .welcome-content>p {
        font-size: 1.1rem;
        color: #5f6368;
        line-height: 1.5;
        margin-bottom: 40px;
    }

    .feature-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 40px;
    }

    .feature-card {
        text-align: center;
        padding: 24px 16px;
    }

    .feature-icon {
        width: 48px;
        height: 48px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: #5f6368;
    }

    .feature-card h3 {
        font-size: 1rem;
        font-weight: 500;
        color: #3c4043;
        margin-bottom: 8px;
    }

    .feature-card p {
        font-size: 0.9rem;
        color: #5f6368;
        line-height: 1.4;
        margin: 0;
    }

    .welcome-actions {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .create-btn {
        background: #1a73e8;
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 24px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
    }

    .create-btn:hover {
        background: #1557b0;
    }

    .example-btn {
        background: transparent;
        color: #1a73e8;
        border: none;
        font-size: 14px;
        cursor: pointer;
        text-decoration: underline;
    }

    .example-btn:hover {
        color: #1557b0;
    }

    /* Chat Interface */
    .chat-interface {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .chat-messages {
        flex: 1;
        padding: 24px;
        overflow-y: auto;
    }

    .chat-input-container {
        padding: 16px 24px;
        border-top: 1px solid #e8eaed;
    }

    .chat-input {
        display: flex;
        gap: 12px;
        align-items: flex-end;
        max-width: 800px;
        margin: 0 auto;
    }

    .chat-input textarea {
        flex: 1;
        border: 1px solid #dadce0;
        border-radius: 24px;
        padding: 12px 16px;
        resize: none;
        font-family: inherit;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
        min-height: 44px;
    }

    .chat-input textarea:focus {
        border-color: #1a73e8;
    }

    .send-btn {
        width: 44px;
        height: 44px;
        background: #1a73e8;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    .send-btn:hover {
        background: #1557b0;
    }

    /* Right Panel */
    .notebook-guide {
        background: white;
        border-left: 1px solid #e8eaed;
        padding: 20px;
        overflow-y: auto;
    }

    .guide-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .guide-header h3 {
        font-size: 1.1rem;
        font-weight: 500;
        color: #3c4043;
        margin: 0;
    }

    .guide-close {
        width: 24px;
        height: 24px;
        border: none;
        background: transparent;
        color: #5f6368;
        cursor: pointer;
        font-size: 18px;
    }

    .guide-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 20px;
    }

    .guide-btn {
        padding: 8px 12px;
        border: 1px solid #dadce0;
        background: white;
        border-radius: 20px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        color: #5f6368;
    }

    .guide-btn:hover {
        background: #f8f9fa;
    }

    .guide-btn.active {
        background: #1a73e8;
        color: white;
        border-color: #1a73e8;
    }

    .guide-result {
        color: #5f6368;
        font-size: 14px;
        line-height: 1.5;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .notebook-main {
            grid-template-columns: 1fr;
            grid-template-rows: auto 1fr auto;
        }

        .notebook-sidebar,
        .notebook-guide {
            display: none;
        }

        .feature-cards {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }

    @media (max-width: 768px) {
        .notebook-header {
            padding: 8px 16px;
        }

        .header-btn {
            padding: 6px 12px;
            font-size: 13px;
        }

        .welcome-content {
            padding: 20px;
        }

        .welcome-content h2 {
            font-size: 1.5rem;
        }

        .feature-cards {
            gap: 12px;
        }
    }

</style>
@endsection
