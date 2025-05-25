<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="32x32" href="{{ asset('logo_edusearch.png') }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSearch - Sua plataforma de estudos personalizada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <style>
    .card-header {
        position: relative;
        padding-right: 50px;
    }
    
    .dropdown-menu-toggle {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        cursor: pointer;
        padding: 8px;
        border-radius: 4px;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .dropdown-menu-toggle:hover {
        background-color: rgba(255, 255, 255, 0.15);
        color: white;
        transform: translateY(-50%) scale(1.1);
    }
    
    .dropdown-menu-toggle:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.4);
    }
    
    .card-header-content {
        display: block;
        font-weight: 600;
        font-size: 1rem;
        line-height: 1.3;
        margin: 0;
        padding-right: 10px;
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border-radius: 10px;
        overflow: hidden;
        min-width: 180px;
        padding: 8px 0;
    }
    
    .dropdown-item {
        padding: 10px 16px;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
        padding-left: 20px;
    }
    
    .dropdown-item i {
        width: 18px;
        text-align: center;
        margin-right: 8px;
    }
    
    .dropdown-divider {
        margin: 8px 0;
        border-color: #e9ecef;
    }
    
    .text-danger:hover {
        background-color: #fff5f5;
        color: #dc3545;
    }
    
    /* Melhorias nos cards */
    .folder-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }
    
    .folder-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .my-topic .card-header {
        background: linear-gradient(135deg, #0f4c81, #1a5b96);
    }
    
    .partner-topic .card-header {
        background: linear-gradient(135deg, #28a745, #20c997);
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .card-text {
        color: #6c757d;
        line-height: 1.6;
        font-size: 0.95rem;
    }
    
    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
    }
    
    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 6px;
        font-weight: 500;
    }
    </style>
</head>
<body>
    @include('include.sidebar')

    <!-- Overlay para mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Conteúdo Principal -->
    <div class="main-content" id="main-content">
        <div class="container-fluid">
            <!-- Botão toggle para sidebar em dispositivos móveis -->
            <button type="button" id="sidebarCollapse" class="btn btn-primary d-lg-none mb-4">
                <i class="bi bi-list"></i> Menu
            </button>

            <!-- Mensagem de boas-vindas -->
            <div class="welcome-message">
                <h2><i class="bi bi-mortarboard-fill me-2"></i>Bem-vindo ao EduSearch!</h2>
                <p class="mb-0">Seu assistente de estudos personalizado. Pesquise qualquer matéria e organize seus materiais de estudo em um só lugar.</p>
            </div>

            <!-- Alertas de erro -->
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="bi bi-exclamation-triangle me-2"></i>Ops! Algo deu errado:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Barra de pesquisa -->
            <div class="search-container">
                <h4 class="mb-4"><i class="bi bi-search me-2"></i>O que você quer aprender hoje?</h4>
                <form action="/new_topic_folder" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-10">
                            <input type="text" class="form-control search-input" name="topic" 
                                   placeholder="Digite uma matéria ou tópico (ex: Biologia, Equações de 2º grau, Literatura Brasileira...)" 
                                   required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn search-btn w-100">
                                <i class="bi bi-plus-circle me-1"></i>Pesquisar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Estatísticas -->
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
                                <span class="card-header-content">{{ $folder->name }} - {{ $folder->materia }}</span>
                                <div class="dropdown">
                                    <button class="dropdown-menu-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye"></i>Visualizar</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i>Editar</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-share"></i>Compartilhar</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-download"></i>Baixar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i>Excluir</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ Str::limit($folder->resumo, 120) }}</p>
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
                    <span class="badge bg-success">{{ count($relacionados) }}</span>
                </h4>
                <div class="row g-4">
                    @foreach($relacionados as $parceiro)
                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="folder-card card partner-topic">
                            <div class="card-header">
                                <span class="card-header-content">{{ $parceiro->name }} - {{ $parceiro->materia }}</span>
                                <div class="dropdown">
                                    <button class="dropdown-menu-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye"></i>Visualizar</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-bookmark"></i>Salvar nos Favoritos</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-download"></i>Baixar</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-share"></i>Compartilhar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-warning" href="#"><i class="bi bi-flag"></i>Reportar</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ Str::limit($parceiro->resumo, 120) }}</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="/topico/{{ $parceiro->id }}" class="btn btn-sm btn-success">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar em dispositivos móveis
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const overlay = document.getElementById('overlay');

            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    mainContent.classList.toggle('active');
                    overlay.classList.toggle('active');
                });
            }

            // Fechar sidebar quando clicar no overlay
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    mainContent.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }

            // Responsividade para dispositivos móveis
            function checkWidth() {
                if (window.innerWidth <= 991.98) {
                    sidebar.classList.remove('active');
                    mainContent.classList.remove('active');
                    overlay.classList.remove('active');
                } else {
                    sidebar.classList.remove('active');
                    mainContent.classList.remove('active');
                    overlay.classList.remove('active');
                }
            }

            window.addEventListener('resize', checkWidth);
            checkWidth();

            // Scroll suave para os links do índice
            document.querySelectorAll('.table-of-contents a').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    window.scrollTo({
                        top: targetElement.offsetTop - 100
                        , behavior: 'smooth'
                    });
                });
            });
        });

    </script>
</body>
</html>
