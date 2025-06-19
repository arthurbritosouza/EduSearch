@extends('layouts.app')

@section('title')
EduSearch - Sala de Estudos
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/topicos.css') }}">
@endsection

@section('content')

@section('header_content')
<div class="col-md-8">
    <h1 class="dashboard-title">
        <i class="bi bi-door-open me-3"></i>Sala de Estudos: {{$room->name}}
    </h1>
    <p class="dashboard-subtitle">{{$room->description}}</p>
    <!-- Botões de Ação no Header -->
    <div class="header-actions mt-2">
        <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#addMemberModal">
            <i class="bi bi-person-plus"></i> Adicionar Participante
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
    <ul class="nav nav-tabs enhanced-tabs" id="roomTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                <i class="bi bi-grid-3x3-gap"></i>
                <span>Visão Geral</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="chat-tab" data-bs-toggle="tab" data-bs-target="#chat" type="button" role="tab">
                <i class="bi bi-chat-dots"></i>
                <span>Chat</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="topics-tab" data-bs-toggle="tab" data-bs-target="#topics" type="button" role="tab">
                <i class="bi bi-bookmarks-fill"></i>
                <span>Tópicos</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pdfs-tab" data-bs-toggle="tab" data-bs-target="#pdfs" type="button" role="tab">
                <i class="bi bi-file-earmark-pdf"></i>
                <span>PDFs</span>
            </button>
        </li>
    </ul>
</div>

<!-- Conteúdo das Abas -->
<div class="tab-content enhanced-tab-content" id="roomTabsContent">
    <!-- Aba Visão Geral -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel">
        <div class="overview-container">
            <div class="row g-4">
                <!-- Resumo da Sala -->
                <div class="col-lg-8">
                    <div class="summary-card">
                        <div class="card-header">
                            <h3><i class="bi bi-info-circle me-2"></i>Resumo da Sala</h3>
                        </div>
                        <div class="card-body">
                            <div class="summary-content">
                                <p>Esta sala é um ambiente colaborativo para estudar {{ $room->name }}. Participe do chat, compartilhe arquivos e acompanhe o progresso do grupo.</p>
                                <div class="alert alert-info mt-3" role="alert">
                                    <h4 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Bem-vindo!</h4>
                                    <p>Utilize as abas acima para navegar entre o chat, tópicos de estudo e arquivos compartilhados.</p>
                                </div>
                                <!-- Informações Adicionais -->
                                <div class="additional-info mt-4">
                                    <h5><i class="bi bi-calendar-check me-2"></i>Data de Criação</h5>
                                    <p>Criada em {{ \Carbon\Carbon::parse($room->created_at)->format('d/m/Y') }} por {{ $room->creator->name ?? 'Administrador' }}.</p>

                                    <h5><i class="bi bi-target me-2"></i>Objetivos da Sala</h5>
                                    <p>{{ $room->objectives ?? 'Aprofundar o conhecimento em ' . $room->name . ' através de estudos colaborativos e troca de materiais.' }}</p>

                                    <h5><i class="bi bi-clock-history me-2"></i>Atividade Recente</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Último tópico concluído: Funções de 1º Grau (há 3 dias)</li>
                                        <li><i class="bi bi-file-earmark-arrow-up text-primary me-2"></i>Último arquivo enviado: Funcoes_2grau_resolucao.pdf (há 2 min)</li>
                                        <li><i class="bi bi-chat-dots text-info me-2"></i>Última mensagem no chat: Lucas Pereira (agora mesmo)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar com Estatísticas -->
                <div class="col-lg-4">
                    <div class="materials-sidebar">
                        <!-- Estatísticas Rápidas -->
                        <div class="stats-widget">
                            <h4>Estatísticas</h4>
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <i class="bi bi-people"></i>
                                    <span class="stat-number">{{ $participants->count() }}</span>
                                    <span class="stat-label">Participantes</span>
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-bookmarks-fill"></i>
                                    <span class="stat-number">3</span>
                                    <span class="stat-label">Tópicos</span>
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                    <span class="stat-number">2</span>
                                    <span class="stat-label">Arquivos</span>
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-clock-history"></i>
                                    <span class="stat-number">6h</span>
                                    <span class="stat-label">Tempo de Estudo</span>
                                </div>
                            </div>
                            <!-- Informações Adicionais nas Estatísticas -->
                            <div class="mt-3 text-center">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#listMembersModal">
                                    <i class="bi bi-eye me-1"></i>Ver Membros
                                </button>
                            </div>
                        </div>
                        <!-- Progresso da Sala -->
                        <div class="progress-card mt-4">
                            <div class="card-header">
                                <h5><i class="bi bi-graph-up me-2"></i>Progresso da Sala</h5>
                            </div>
                            <div class="card-body">
                                <div class="progress-item">
                                    <div class="progress-label"><span>Tópicos Estudados</span><span class="progress-value">3/5</span></div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" style="width: 60%"></div>
                                    </div>
                                </div>
                                <div class="progress-item">
                                    <div class="progress-label"><span>PDFs Lidos</span><span class="progress-value">2/4</span></div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 50%"></div>
                                    </div>
                                </div>
                                <div class="progress-item">
                                    <div class="progress-label"><span>Tempo de Estudo</span><span class="progress-value">6h/10h</span></div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" style="width: 60%"></div>
                                    </div>
                                </div>
                                <!-- Detalhes Adicionais no Progresso -->
                                <div class="mt-3 small text-muted">
                                    <p>Meta semanal: 10 tópicos concluídos e 15h de estudo.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Aba Chat -->
    <div class="tab-pane fade" id="chat" role="tabpanel">
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

    <!-- Aba Tópicos -->
    <div class="tab-pane fade" id="topics" role="tabpanel">
        <div class="navigation-card estudos">
            <div class="nav-card-header">
                <i class="bi bi-bookmarks-fill"></i>
                <h5>Tópicos de Estudo</h5>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addTopicModal">
                    <i class="bi bi-plus-circle me-1"></i>Adicionar Tópico
                </button>
            </div>
            <div class="nav-card-body">
                <ul class="list-group list-group-flush">
                    @foreach($related_topics as $topic)
                    <li class="list-group-item d-flex justify-content-between align-items-center topic-item">
                        <a href="{{ route('topic.show', $topic->id) }}" class="topic-link">
                            <div class="topic-info">
                                <strong>{{$topic->name}}</strong>
                                <small class="text-muted d-block">Dono: {{$topic->user_name}}</small>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="mt-3 text-center">
                    <a href="{{ route('topic.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-right-circle me-1"></i>Ver Todos os Tópicos
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- Aba PDFs -->
    <div class="tab-pane fade" id="pdfs" role="tabpanel">
        <div class="navigation-card estudos">
            <div class="nav-card-header">
                <i class="bi bi-file-earmark-pdf"></i>
                <h5>Arquivos Compartilhados</h5>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addPdfModal">
                    <i class="bi bi-upload me-1"></i>Enviar Arquivo
                </button>
            </div>
            <div class="nav-card-body">
                <ul class="list-group list-group-flush">
                    @foreach($related_pdfs as $pdf)
                    <li class="list-group-item d-flex justify-content-between align-items-center topic-item">
                        <a href="{{ route('pdf.show', $pdf->id) }}" class="topic-link">
                            <div class="topic-info">
                                <strong>{{$pdf->name}}</strong>
                                <small class="text-muted d-block">Dono: {{$pdf->user_name}}</small>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="mt-3 text-center">
                    <a href="{{ route('pdf.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-right-circle me-1"></i>Ver Todos os Pdfs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    <input type="hidden" name="type" value=2>
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

<!-- Modal: Editar Sala -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Sala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('room.update', $room->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="roomName" class="form-label">Nome da Sala</label>
                        <input type="text" class="form-control" id="roomName" name="name" value="{{ $room->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="roomDescription" class="form-label">Descrição</label>
                        <textarea class="form-control" id="roomDescription" name="description" rows="3" required>{{ $room->description }}</textarea>
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

<!-- Modal: Adicionar Tópico -->
<div class="modal fade" id="addTopicModal" tabindex="-1" aria-labelledby="addTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTopicModalLabel"><i class="bi bi-bookmarks-fill me-2"></i>Adicionar Tópico à Sala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Navegação por Abas no Modal -->
                <ul class="nav nav-tabs" id="topicTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="my-topics-tab" data-bs-toggle="tab" data-bs-target="#my-topics" type="button" role="tab">
                            Meus Tópicos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="create-topic-tab" data-bs-toggle="tab" data-bs-target="#create-topic" type="button" role="tab">
                            Criar Novo Tópico
                        </button>
                    </li>
                </ul>
                <!-- Conteúdo das Abas -->
                <div class="tab-content mt-3" id="topicTabsContent">
                    <!-- Aba Meus Tópicos -->
                    <div class="tab-pane fade show active" id="my-topics" role="tabpanel">
                        <div class="list-group">
                            @foreach($topics as $topic)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{$topic->name}}</strong>
                                    <small class="text-muted d-block">Criado em {{ \Carbon\Carbon::parse($topic->created_at)->format('d/m/Y') }}</small>
                                </div>
                                <a href="{{route('room.addTopic', [$room->id,$topic->id])}}" class="btn btn-sm btn-primary">Adicionar</a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Aba Criar Novo Tópico -->
                    <div class="tab-pane fade" id="create-topic" role="tabpanel">
                        <form action="{{ route('room.createTopicRoom') }}" method="POST">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <div class="mb-3">
                                <label for="topicName" class="form-label">Nome do Tópico</label>
                                <input type="text" class="form-control" id="topicName" name="topic" placeholder="Digite o nome do tópico">
                            </div>
                            <button type="submit" class="btn btn-primary">Criar e Adicionar</button>
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

<!-- Modal: Adicionar PDF -->
<div class="modal fade" id="addPdfModal" tabindex="-1" aria-labelledby="addPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPdfModalLabel"><i class="bi bi-file-earmark-pdf me-2"></i>Adicionar PDF à Sala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Navegação por Abas no Modal -->
                <ul class="nav nav-tabs" id="pdfTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="my-pdfs-tab" data-bs-toggle="tab" data-bs-target="#my-pdfs" type="button" role="tab">
                            Meus PDFs
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="upload-pdf-tab" data-bs-toggle="tab" data-bs-target="#upload-pdf" type="button" role="tab">
                            Enviar Novo PDF
                        </button>
                    </li>
                </ul>
                <!-- Conteúdo das Abas -->
                <div class="tab-content mt-3" id="pdfTabsContent">
                    <!-- Aba Meus PDFs -->
                    <div class="tab-pane fade show active" id="my-pdfs" role="tabpanel">
                        <div class="list-group">
                            @foreach($pdfs as $pdf)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{$pdf->name}}.pdf</strong>
                                    <small class="text-muted d-block">Enviado em {{ \Carbon\Carbon::parse($pdf->created_at)->format('d/m/Y') }}</small>
                                </div>
                                <a href="{{route('room.addPdf',[$room->id,$pdf->id])}}" class="btn btn-sm btn-primary">Adicionar</a>
                            </div>
                            @endforeach
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Exercicios_Geometria.pdf</strong>
                                    <small class="text-muted d-block">Enviado em 03/06/2025</small>
                                </div>
                                <button class="btn btn-sm btn-primary">Adicionar</button>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Probabilidade_Apostila.pdf</strong>
                                    <small class="text-muted d-block">Enviado em 01/06/2025</small>
                                </div>
                                <button class="btn btn-sm btn-primary">Adicionar</button>
                            </div>
                        </div>
                    </div>
                    <!-- Aba Enviar Novo PDF -->
                    <div class="tab-pane fade" id="upload-pdf" role="tabpanel">
                        <form action="{{ route('room.createPdfRoom') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <div class="mb-3">
                                <label class="form-label">Selecionar Arquivo PDF</label>
                                <input type="file" class="form-control" id="pdfFile" name="pdf_file" accept=".pdf">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Titulo pdf</label>
                                <textarea class="form-control" id="pdfDescription" name="pdf_title" placeholder="Digite o nome do pdf"></textarea>
                            </div>
                            <button type="submmit" class="btn btn-primary">Enviar e Adicionar</button>
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

<!-- Modal: Listar Membros -->
<div class="modal fade" id="listMembersModal" tabindex="-1" aria-labelledby="listMembersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listMembersModalLabel"><i class="bi bi-people me-2"></i>Membros da Sala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    @foreach($participants as $participant)
                    <div class="list-group-item d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <strong>{{ $participant->name }}</strong>
                            <small class="text-muted d-block">{{ $participant->email }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endsection
