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
                <h2>Bem-vindo ao EduSearch!</h2>
                <p class="mb-0">Seu assistente de estudos personalizado. Pesquise qualquer matéria e organize seus materiais de estudo em um só lugar.</p>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-- Barra de pesquisa -->
            <div class="search-container">
                <h4 class="mb-4">O que você quer aprender hoje?</h4>
                <div class="row g-3">
                    <form action="/new_topic_folder" method="POST">
                        @csrf
                        <div class="col-md-10">
                            <input type="text" class="form-control search-input" name="topic" placeholder="Digite uma matéria ou tópico (ex: Biologia, Equações de 2º grau, Literatura Brasileira...)">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn search-btn w-100">Pesquisar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="row mb-4">
                <div class="col-md-3 mb-4">
                    <div class="stats-card">
                        <i class="bi bi-folder"></i>
                        <h3>12</h3>
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
                        <h3>5</h3>
                        <p>Compartilhamentos</p>
                    </div>
                </div>
            </div>


            <!-- Pastas recentes -->
            <div class="row g-4">
                @foreach($folders as $folder)
                <div class="col-md-4 mb-4">
                    <div class="folder-card card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>{{ $folder->name }} - {{ $folder->materia }}</span>
                            <i class="bi bi-three-dots-vertical"></i>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $folder->resumo }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="/topico/{{ $folder->id }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-folder-symlink"></i> Abrir
                            </a>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-share"></i> Compartilhar
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pastas recentes -->
            <div class="row g-4">
                @foreach($relacionados as $parceiro)
                <div class="col-md-4 mb-4">
                    <div class="folder-card card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>{{ $parceiro->name }} - {{ $parceiro->materia }}</span>
                            <i class="bi bi-three-dots-vertical"></i>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $parceiro->resumo }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="/topico/{{ $parceiro->id }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-folder-symlink"></i> Abrir
                            </a>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-share"></i> Compartilhar
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
</body>
</html>
