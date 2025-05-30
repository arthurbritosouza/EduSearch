@extends('layouts.app') {{-- 1. Estende o layout pai --}}

@section('title')
    EduSearch - Sua plataforma de estudos personalizada
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pdf-upload.css') }}">
@endsection

@section('content')
        <!-- Mensagem de boas-vindas -->
        <div class="welcome-message">
            <h2><i class="bi bi-mortarboard-fill me-2"></i>Bem-vindo ao EduSearch!</h2>
            <p class="mb-0">Seu assistente de estudos personalizado. Pesquise qualquer matéria e organize seus materiais de estudo em um só lugar.</p>
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
        <!-- Barra de pesquisa -->
        <div class="search-container">
            <h4 class="mb-4"><i class="bi bi-search me-2"></i>O que você quer aprender hoje?</h4>
            <form action="{{route('topic.store')}}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-8">
                        <input type="text" class="form-control search-input" name="topic" placeholder="Digite uma matéria ou tópico (ex: Biologia, Equações de 2º grau, Literatura Brasileira...)" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn search-btn w-100">
                            <i class="bi bi-plus-circle me-1"></i>Pesquisar
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#pdfUploadModal">
                            <i class="bi bi-file-earmark-pdf me-1"></i>Upload PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Seção de PDFs Estáticos -->
        <div class="pdf-library-section mb-5">
            <div class="row">
                <div class="col-12">
                    <div class="pdf-library-card">
                        <div class="library-header">
                            <h4><i class="bi bi-collection me-2"></i>Biblioteca de PDFs</h4>
                            <span class="badge bg-info">{{ isset($pdfs) ? count($pdfs) : 0 }} PDFs</span>
                        </div>
                        <div class="library-content">
                            <div class="row g-3">
                                @foreach($pdfs as $pdf)
                                <div class="col-md-4">
                                    <div class="pdf-item">
                                        <div class="pdf-icon">
                                            <i class="bi bi-file-earmark-pdf-fill"></i>
                                        </div>
                                        <div class="pdf-info">
                                            <h6>{{$pdf->name}}</h6>
                                            <p>{{$pdf->summary}}</p>
                                            <small class="text-muted">Processado pela IA • {{$pdf->pages}} páginas</small>
                                        </div>
                                        <div class="pdf-actions">
                                            <a href="/pdf/{{$pdf->id}}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-chat-dots"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-3 mb-4">
                <div class="stats-card">
                    <i class="bi bi-folder"></i>
                    <h3>{{ count($folders) }}</h3>
                    <p>Pastas criadas</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stats-card">
                    <i class="bi bi-journal-text"></i>
                    <h3>48</h3>
                    <p>Materiais salvos</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stats-card">
                    <i class="bi bi-clock"></i>
                    <h3>8h</h3>
                    <p>Tempo de estudo</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stats-card">
                    <i class="bi bi-share"></i>
                    <h3>{{ count($relacionados) }}</h3>
                    <p>Compartilhamentos</p>
                </div>
            </div>
        </div>

        <!-- Meus Tópicos -->
        @if(count($folders) > 0)
        <section class="my-topics-section">
            <h4 class="section-title">
                <i class="bi bi-folder2-open"></i>
                Meus Tópicos
                <span class="badge bg-primary">{{ count($folders) }}</span>
            </h4>
            <div class="row g-4">
                @foreach($folders as $folder)
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="folder-card card my-topic">
                        <div class="card-header">
                            <span class="card-header-content">{{ $folder->name }} - {{ $folder->matter }}</span>
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
                        <div class="card-body">
                            <p class="card-text">{{ Str::limit($folder->summary, 120) }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="/topico/{{ $folder->id }}" class="btn btn-sm btn-primary">
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
        </section>
        @endif

        <!-- Tópicos de Parceiros -->
        @if(count($relacionados) > 0)
        <section class="partner-topics-section">
            <h4 class="section-title">
                <i class="bi bi-people-fill"></i>
                Tópicos de Parceiros
                <span class="badge bg-primary">{{ count($relacionados) }}</span>
            </h4>
            <div class="row g-4">
                @foreach($relacionados as $parceiro)
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="folder-card card partner-topic">
                        <div class="card-header">
                            <span class="card-header-content">{{ $parceiro->name }} - {{ $parceiro->matter }}</span>
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
                        <div class="card-body">
                            <p class="card-text">{{ Str::limit($parceiro->summary, 120) }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="/topico/{{ $parceiro->id }}" class="btn btn-sm btn-primary">
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
            </section>
            @endif

            <!-- Estado Vazio -->
            @if(count($folders) === 0 && count($relacionados) === 0)
            <div class="empty-state">
                <i class="bi bi-folder-plus"></i>
                <h4>Nenhum tópico ainda</h4>
                <p>Comece pesquisando um assunto que você quer estudar!</p>
            </div>
            @endif
        </div>

    <!-- Modal Pdf -->
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
                        <!-- Título do PDF -->
                        <div class="mb-4">
                            <label for="pdfTitle" class="form-label">
                                <i class="bi bi-tag me-1"></i>Título do PDF
                            </label>
                            <input type="text" class="form-control" id="pdfTitle" name="pdf_title" placeholder="Ex: Matemática Básica" required>
                            <div class="form-text">Digite um título para identificar este PDF</div>
                        </div>

                        <!-- Upload de PDF -->
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

    <script src="{{ asset('js/pdf-upload.js') }}"></script>
    <script src="{{ asset('js/sidebar-mobile.js') }}"></script>
@endsection

