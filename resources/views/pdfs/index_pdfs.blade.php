@extends('layouts.app')

@section('title')
    EduSearch - Biblioteca de PDFs
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pdf-upload.css') }}">
@endsection

@section('header_content')
    <div class="col-md-8">
        <h1 class="dashboard-title">
            <i class="bi bi-file-earmark-pdf me-3"></i>Biblioteca de PDFs
        </h1>
        <p class="dashboard-subtitle">Gerencie seus PDFs e explore materiais compartilhados pela comunidade</p>
    </div>
@endsection

@section('content')
    <!-- Barra de pesquisa -->
    <div class="search-container">
        <h4 class="mb-4"><i class="bi bi-search me-2"></i>Pesquisar PDFs</h4>
        <div class="row g-3">
            <div class="col-md-8">
                <input type="text" class="form-control search-input" placeholder="Digite o nome do PDF ou conteúdo que procura...">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn search-btn w-100">
                    <i class="bi bi-search me-1"></i>Buscar
                </button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#pdfUploadModal">
                    <i class="bi bi-file-earmark-pdf me-1"></i>Upload PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="row mb-5">
        <div class="col-md-3 mb-4">
            <div class="stats-card">
                <i class="bi bi-file-earmark-pdf"></i>
                <h3>5</h3>
                <p>Meus PDFs</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stats-card">
                <i class="bi bi-people"></i>
                <h3>18</h3>
                <p>PDFs Compartilhados</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stats-card">
                <i class="bi bi-bookmark"></i>
                <h3>12</h3>
                <p>Favoritos</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stats-card">
                <i class="bi bi-download"></i>
                <h3>156</h3>
                <p>Downloads</p>
            </div>
        </div>
    </div>

    <!-- Seção de PDFs Meus -->
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

    <!-- PDFs da Comunidade -->
    <div class="pdf-library-section mb-5">
        <div class="row">
            <div class="col-12">
                <div class="pdf-library-card">
                    <div class="library-header">
                        <h4><i class="bi bi-people-fill me-2"></i>PDFs da Comunidade</h4>
                        <span class="badge bg-success">18 PDFs</span>
                    </div>
                    <div class="library-content">
                        <div class="row g-3">
                            <!-- PDF Compartilhado 1 -->
                            <div class="col-md-4">
                                <div class="pdf-item">
                                    <div class="pdf-icon">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </div>
                                    <div class="pdf-info">
                                        <h6>Literatura - Modernismo Brasileiro</h6>
                                        <p>Movimento modernista brasileiro, principais autores, obras e características literárias do período histórico.</p>
                                        <small class="text-muted">Por Maria Silva • Processado pela IA • 124 páginas</small>
                                    </div>
                                    <div class="pdf-actions">
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-chat-dots"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- PDF Compartilhado 2 -->
                            <div class="col-md-4">
                                <div class="pdf-item">
                                    <div class="pdf-icon">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </div>
                                    <div class="pdf-info">
                                        <h6>Geografia - Climatologia</h6>
                                        <p>Estudo dos climas mundiais, fatores climáticos e mudanças climáticas globais com mapas e gráficos.</p>
                                        <small class="text-muted">Por Carlos Lima • Processado pela IA • 89 páginas</small>
                                    </div>
                                    <div class="pdf-actions">
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-chat-dots"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- PDF Compartilhado 3 -->
                            <div class="col-md-4">
                                <div class="pdf-item">
                                    <div class="pdf-icon">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </div>
                                    <div class="pdf-info">
                                        <h6>Inglês - Gramática Avançada</h6>
                                        <p>Estruturas gramaticais avançadas, tempos verbais complexos e expressões idiomáticas para fluência.</p>
                                        <small class="text-muted">Por Ana Costa • Processado pela IA • 156 páginas</small>
                                    </div>
                                    <div class="pdf-actions">
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-chat-dots"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- PDF Compartilhado 4 -->
                            <div class="col-md-4">
                                <div class="pdf-item">
                                    <div class="pdf-icon">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </div>
                                    <div class="pdf-info">
                                        <h6>Filosofia - Ética e Moral</h6>
                                        <p>Conceitos fundamentais de ética, moral e filosofia prática com análise de grandes pensadores clássicos.</p>
                                        <small class="text-muted">Por João Santos • Processado pela IA • 98 páginas</small>
                                    </div>
                                    <div class="pdf-actions">
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-chat-dots"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- PDF Compartilhado 5 -->
                            <div class="col-md-4">
                                <div class="pdf-item">
                                    <div class="pdf-icon">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </div>
                                    <div class="pdf-info">
                                        <h6>Sociologia - Teorias Sociais</h6>
                                        <p>Principais teorias sociológicas, estruturas sociais e análise crítica da sociedade contemporânea.</p>
                                        <small class="text-muted">Por Pedro Oliveira • Processado pela IA • 134 páginas</small>
                                    </div>
                                    <div class="pdf-actions">
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-chat-dots"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- PDF Compartilhado 6 -->
                            <div class="col-md-4">
                                <div class="pdf-item">
                                    <div class="pdf-icon">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </div>
                                    <div class="pdf-info">
                                        <h6>Economia - Microeconomia</h6>
                                        <p>Fundamentos de microeconomia, oferta e demanda, elasticidade e estruturas de mercado explicadas.</p>
                                        <small class="text-muted">Por Laura Mendes • Processado pela IA • 87 páginas</small>
                                    </div>
                                    <div class="pdf-actions">
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-chat-dots"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <div class="modal-body">
                    <!-- Título do PDF -->
                    <div class="mb-4">
                        <label for="pdfTitle" class="form-label">
                            <i class="bi bi-tag me-1"></i>Título do PDF
                        </label>
                        <input type="text" class="form-control" id="pdfTitle" name="pdf_title" placeholder="Ex: Matemática Básica">
                        <div class="form-text">Digite um título para identificar este PDF</div>
                    </div>

                    <!-- Upload de PDF -->
                    <div class="mb-4">
                        <label for="pdfFile" class="form-label">
                            <i class="bi bi-cloud-upload me-1"></i>Selecionar PDF
                        </label>
                        <input type="file" class="form-control" id="pdfFile" name="pdf_file" accept=".pdf">
                        <div class="form-text">Selecione um arquivo PDF (máximo 50MB)</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="bi bi-cloud-upload me-2"></i>Enviar PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/pdf-upload.js') }}"></script>
    <script src="{{ asset('js/sidebar-mobile.js') }}"></script>
@endsection
