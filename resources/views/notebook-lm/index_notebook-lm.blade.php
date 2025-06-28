@extends('layouts.app')

@section('content')
<style>
    :root {
        /* Variáveis de cores - Tema claro */
        --bg-primary: #f8fafc;
        --bg-secondary: #ffffff;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-muted: #94a3b8;
        --border-color: #e2e8f0;
        --accent-primary: #3b82f6;
        --accent-secondary: #8b5cf6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
    }

    /* Tema escuro */
    [data-theme="dark"] {
        --bg-primary: #0f172a;
        --bg-secondary: #1e293b;
        --bg-tertiary: #334155;
        --text-primary: #f8fafc;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --border-color: #334155;
        --accent-primary: #60a5fa;
        --accent-secondary: #a78bfa;
    }

    * {
        box-sizing: border-box;
    }

    body {
        background: var(--bg-primary);
        color: var(--text-primary);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .container-fluid {
        background: var(--bg-primary) !important;
        min-height: 100vh;
        padding: 0;
    }

    /* Header Principal */
    .main-header {
        background: var(--bg-secondary);
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem 0;
        position: sticky;
        top: 0;
        z-index: 100;
        backdrop-filter: blur(10px);
        box-shadow: var(--shadow-sm);
    }

    .header-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .notebook-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary);
        text-align: center;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.025em;
        background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .notebook-subtitle {
        color: var(--text-secondary);
        text-align: center;
        margin: 0 0 1.5rem 0;
        font-size: 1.125rem;
        font-weight: 500;
    }

    /* Estatísticas */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--accent-primary);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Controles e Filtros */
    .controls-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-sm);
    }

    .controls-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .search-container {
        position: relative;
        flex: 1;
        min-width: 300px;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--accent-primary);
        box-shadow: 0 0 0 3px rgb(59 130 246 / 0.1);
    }

    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 1rem;
    }

    .btn-create {
        background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
        color: white;
        font-weight: 600;
        border-radius: var(--radius-lg);
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-create::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-create:hover::before {
        left: 100%;
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
        text-decoration: none;
    }

    .theme-toggle {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-secondary);
    }

    .theme-toggle:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
    }

    /* Filtros */
    .filters-container {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-select {
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--accent-primary);
    }

    .view-toggle {
        display: flex;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .view-toggle button {
        padding: 0.5rem 0.75rem;
        border: none;
        background: transparent;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .view-toggle button.active {
        background: var(--accent-primary);
        color: white;
    }

    /* Container Principal */
    .main-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* Grid de Cards */
    .topics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .topic-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    .topic-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .topic-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .topic-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .topic-card:nth-child(4) {
        animation-delay: 0.4s;
    }

    .topic-card:nth-child(5) {
        animation-delay: 0.5s;
    }

    .topic-card:nth-child(6) {
        animation-delay: 0.6s;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .topic-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .topic-card:hover::before {
        transform: scaleX(1);
    }

    .topic-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: var(--accent-primary);
    }

    .card-header {
        padding: 1.5rem 1.5rem 1rem 1.5rem;
        position: relative;
    }

    .topic-category {
        display: inline-block;
        background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-md);
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .topic-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .topic-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .topic-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .progress-bar {
        width: 100%;
        height: 4px;
        background: var(--bg-tertiary);
        border-radius: var(--radius-sm);
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--success-color), var(--accent-primary));
        border-radius: var(--radius-sm);
        transition: width 0.3s ease;
    }

    .card-footer {
        padding: 0 1.5rem 1.5rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        background: var(--bg-primary);
        color: var(--text-secondary);
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .btn-action:hover {
        background: var(--accent-primary);
        color: white;
        border-color: var(--accent-primary);
        text-decoration: none;
    }

    .btn-primary {
        background: var(--accent-primary);
        color: white;
        border-color: var(--accent-primary);
    }

    .btn-primary:hover {
        background: var(--accent-secondary);
        border-color: var(--accent-secondary);
    }

    .collaborators {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .avatar-group {
        display: flex;
        margin-left: -0.5rem;
    }

    .avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid var(--bg-secondary);
        background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.625rem;
        font-weight: 600;
        margin-left: -0.5rem;
        transition: transform 0.2s ease;
    }

    .avatar:hover {
        transform: scale(1.1);
        z-index: 10;
    }

    /* Loading States */
    .skeleton {
        background: linear-gradient(90deg, var(--bg-tertiary) 25%, var(--border-color) 50%, var(--bg-tertiary) 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }

    .skeleton-card {
        height: 280px;
        border-radius: var(--radius-xl);
    }

    /* Paginação */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        margin-top: 2rem;
    }

    .pagination {
        display: flex;
        gap: 0.25rem;
    }

    .page-btn {
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        background: var(--bg-secondary);
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .page-btn:hover,
    .page-btn.active {
        background: var(--accent-primary);
        color: white;
        border-color: var(--accent-primary);
        text-decoration: none;
    }

    /* Modal Melhorado */
    .modal-content {
        border: none;
        border-radius: var(--radius-xl);
        background: var(--bg-secondary);
        color: var(--text-primary);
        box-shadow: var(--shadow-xl);
    }

    .modal-header {
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem;
    }

    .modal-title {
        font-weight: 700;
        color: var(--text-primary);
    }

    .modal-body {
        padding: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        background: var(--bg-primary);
        color: var(--text-primary);
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--accent-primary);
        box-shadow: 0 0 0 3px rgb(59 130 246 / 0.1);
        background: var(--bg-secondary);
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .header-content {
            padding: 0 1rem;
        }

        .main-content {
            padding: 1rem;
        }

        .notebook-title {
            font-size: 2rem;
        }

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .topics-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .controls-header {
            flex-direction: column;
            align-items: stretch;
        }

        .search-container {
            min-width: auto;
        }

        .filters-container {
            justify-content: center;
        }
    }

    /* Estados vazios */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .empty-description {
        font-size: 1rem;
        margin-bottom: 2rem;
    }

    /* Animações de hover para ícones */
    .icon-hover {
        transition: transform 0.2s ease;
    }

    .icon-hover:hover {
        transform: scale(1.1);
    }

    /* Tooltips */
    .tooltip-trigger {
        position: relative;
        cursor: help;
    }

    .tooltip-trigger:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: var(--text-primary);
        color: var(--bg-secondary);
        padding: 0.5rem;
        border-radius: var(--radius-md);
        font-size: 0.75rem;
        white-space: nowrap;
        z-index: 1000;
        margin-bottom: 0.5rem;
    }

</style>

<div class="container-fluid">
    <!-- Header Principal -->
    <div class="main-header">
        <div class="header-content">
            <h1 class="notebook-title">NotebookLM Pro</h1>
            <p class="notebook-subtitle">Gerencie seus estudos com inteligência artificial avançada</p>

            <!-- Estatísticas -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Estudos Ativos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">47</div>
                    <div class="stat-label">Fontes Analisadas</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">8.5h</div>
                    <div class="stat-label">Tempo de Estudo</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">94%</div>
                    <div class="stat-label">Progresso Médio</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="main-content">
        <!-- Controles e Filtros -->
        <div class="controls-section">
            <div class="controls-header">
                <div class="search-container">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Pesquisar estudos..." id="searchInput">
                </div>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <a href="#" class="btn-create" id="openCreateStudyModal">
                        <i class="bi bi-plus-circle"></i>
                        Criar Estudo
                    </a>
                    <button class="theme-toggle" id="themeToggle" data-tooltip="Alternar tema">
                        <i class="bi bi-moon-fill"></i>
                    </button>
                </div>
            </div>

            <div class="filters-container">
                <div class="filter-group">
                    <label for="categoryFilter" style="color: var(--text-secondary); font-size: 0.875rem;">Categoria:</label>
                    <select class="filter-select" id="categoryFilter">
                        <option value="">Todas</option>
                        <option value="tecnologia">Tecnologia</option>
                        <option value="matematica">Matemática</option>
                        <option value="ciencias">Ciências</option>
                        <option value="negocios">Negócios</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sortFilter" style="color: var(--text-secondary); font-size: 0.875rem;">Ordenar:</label>
                    <select class="filter-select" id="sortFilter">
                        <option value="recent">Mais Recentes</option>
                        <option value="alphabetical">Alfabética</option>
                        <option value="progress">Progresso</option>
                        <option value="sources">Nº de Fontes</option>
                    </select>
                </div>

                <div class="view-toggle">
                    <button class="active" data-view="grid">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </button>
                    <button data-view="list">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Grid de Estudos -->
        <div class="topics-grid" id="topicsGrid">
            <!-- Card 1 -->
            <div class="topic-card" data-category="tecnologia">
                <div class="card-header">
                    <span class="topic-category">Tecnologia</span>
                    <h3 class="topic-title">Métodos Ágeis: Revisão de Princípios</h3>
                    <p class="topic-description">Estudo abrangente sobre metodologias ágeis, incluindo Scrum, Kanban e práticas de desenvolvimento moderno.</p>
                    <div class="topic-meta">
                        <span class="meta-item">
                            <i class="bi bi-calendar3"></i>
                            11 de jun. de 2025
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-file-text"></i>
                            3 fontes
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-clock"></i>
                            2.5h
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 75%"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card-actions">
                        <a href="#" class="btn-action btn-primary">
                            <i class="bi bi-play-fill"></i>
                            Continuar
                        </a>
                        <a href="#" class="btn-action">
                            <i class="bi bi-share"></i>
                            Compartilhar
                        </a>
                    </div>
                    <div class="collaborators">
                        <div class="avatar-group">
                            <div class="avatar">JD</div>
                            <div class="avatar">MS</div>
                            <div class="avatar">+2</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="topic-card" data-category="matematica">
                <div class="card-header">
                    <span class="topic-category">Matemática</span>
                    <h3 class="topic-title">Lógica Matemática e Teoria dos Conjuntos</h3>
                    <p class="topic-description">Fundamentos da lógica proposicional, predicados e operações com conjuntos para ciência da computação.</p>
                    <div class="topic-meta">
                        <span class="meta-item">
                            <i class="bi bi-calendar3"></i>
                            8 de jun. de 2025
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-file-text"></i>
                            5 fontes
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-clock"></i>
                            3.2h
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 60%"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card-actions">
                        <a href="#" class="btn-action btn-primary">
                            <i class="bi bi-play-fill"></i>
                            Continuar
                        </a>
                        <a href="#" class="btn-action">
                            <i class="bi bi-bookmark"></i>
                            Favoritar
                        </a>
                    </div>
                    <div class="collaborators">
                        <div class="avatar-group">
                            <div class="avatar">AL</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="topic-card" data-category="tecnologia">
                <div class="card-header">
                    <span class="topic-category">Tecnologia</span>
                    <h3 class="topic-title">Introdução ao NotebookLM</h3>
                    <p class="topic-description">Guia completo para utilização da plataforma NotebookLM, incluindo recursos avançados de IA.</p>
                    <div class="topic-meta">
                        <span class="meta-item">
                            <i class="bi bi-calendar3"></i>
                            5 de dez. de 2023
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-file-text"></i>
                            7 fontes
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-clock"></i>
                            1.8h
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 100%"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card-actions">
                        <a href="#" class="btn-action">
                            <i class="bi bi-check-circle"></i>
                            Concluído
                        </a>
                        <a href="#" class="btn-action">
                            <i class="bi bi-download"></i>
                            Exportar
                        </a>
                    </div>
                    <div class="collaborators">
                        <div class="avatar-group">
                            <div class="avatar">VC</div>
                            <div class="avatar">RN</div>
                            <div class="avatar">TM</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="topic-card" data-category="ciencias">
                <div class="card-header">
                    <span class="topic-category">Ciências</span>
                    <h3 class="topic-title">Física Quântica Aplicada</h3>
                    <p class="topic-description">Conceitos fundamentais de mecânica quântica e suas aplicações em tecnologias modernas.</p>
                    <div class="topic-meta">
                        <span class="meta-item">
                            <i class="bi bi-calendar3"></i>
                            15 de jun. de 2025
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-file-text"></i>
                            12 fontes
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-clock"></i>
                            4.7h
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 30%"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card-actions">
                        <a href="#" class="btn-action btn-primary">
                            <i class="bi bi-play-fill"></i>
                            Iniciar
                        </a>
                        <a href="#" class="btn-action">
                            <i class="bi bi-people"></i>
                            Colaborar
                        </a>
                    </div>
                    <div class="collaborators">
                        <div class="avatar-group">
                            <div class="avatar">EH</div>
                            <div class="avatar">NB</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="topic-card" data-category="negocios">
                <div class="card-header">
                    <span class="topic-category">Negócios</span>
                    <h3 class="topic-title">Estratégias de Marketing Digital</h3>
                    <p class="topic-description">Análise de tendências e estratégias eficazes para marketing digital em 2025.</p>
                    <div class="topic-meta">
                        <span class="meta-item">
                            <i class="bi bi-calendar3"></i>
                            20 de jun. de 2025
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-file-text"></i>
                            8 fontes
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-clock"></i>
                            2.1h
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 45%"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card-actions">
                        <a href="#" class="btn-action btn-primary">
                            <i class="bi bi-play-fill"></i>
                            Continuar
                        </a>
                        <a href="#" class="btn-action">
                            <i class="bi bi-chat-dots"></i>
                            Discutir
                        </a>
                    </div>
                    <div class="collaborators">
                        <div class="avatar-group">
                            <div class="avatar">LK</div>
                            <div class="avatar">PM</div>
                            <div class="avatar">SJ</div>
                            <div class="avatar">+3</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="topic-card" data-category="tecnologia">
                <div class="card-header">
                    <span class="topic-category">Tecnologia</span>
                    <h3 class="topic-title">Inteligência Artificial e Machine Learning</h3>
                    <p class="topic-description">Fundamentos de IA, algoritmos de ML e aplicações práticas em diversos setores.</p>
                    <div class="topic-meta">
                        <span class="meta-item">
                            <i class="bi bi-calendar3"></i>
                            25 de jun. de 2025
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-file-text"></i>
                            15 fontes
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-clock"></i>
                            6.3h
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 85%"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card-actions">
                        <a href="#" class="btn-action btn-primary">
                            <i class="bi bi-play-fill"></i>
                            Finalizar
                        </a>
                        <a href="#" class="btn-action">
                            <i class="bi bi-star"></i>
                            Avaliar
                        </a>
                    </div>
                    <div class="collaborators">
                        <div class="avatar-group">
                            <div class="avatar">AI</div>
                            <div class="avatar">ML</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paginação -->
        <div class="pagination-container">
            <div class="pagination">
                <a href="#" class="page-btn">&laquo;</a>
                <a href="#" class="page-btn active">1</a>
                <a href="#" class="page-btn">2</a>
                <a href="#" class="page-btn">3</a>
                <a href="#" class="page-btn">&raquo;</a>
            </div>
        </div>
    </div>

    <!-- Modal de criação de estudo melhorado -->
    <div class="modal fade" id="createStudyModal" tabindex="-1" aria-labelledby="createStudyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createStudyModalLabel">
                        <i class="bi bi-plus-circle me-2"></i>
                        Criar Novo Estudo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form id="createStudyForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="studyName" class="form-label">Nome do estudo</label>
                                    <input type="text" class="form-control" id="studyName" name="studyName" required maxlength="100" placeholder="Ex: Fundamentos de React.js">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="studyCategory" class="form-label">Categoria</label>
                                    <select class="form-control" id="studyCategory" name="studyCategory" required>
                                        <option value="">Selecione...</option>
                                        <option value="tecnologia">Tecnologia</option>
                                        <option value="matematica">Matemática</option>
                                        <option value="ciencias">Ciências</option>
                                        <option value="negocios">Negócios</option>
                                        <option value="outros">Outros</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="studyDescription" class="form-label">Descrição (opcional)</label>
                            <textarea class="form-control" id="studyDescription" name="studyDescription" rows="3" placeholder="Descreva brevemente o que você pretende estudar..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="studyGoal" class="form-label">Meta de tempo (horas)</label>
                                    <input type="number" class="form-control" id="studyGoal" name="studyGoal" min="1" max="100" placeholder="Ex: 10">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="studyDeadline" class="form-label">Prazo (opcional)</label>
                                    <input type="date" class="form-control" id="studyDeadline" name="studyDeadline">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-create">
                            <i class="bi bi-plus-circle me-1"></i>
                            Criar Estudo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementos
        const modal = new bootstrap.Modal(document.getElementById('createStudyModal'));
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const sortFilter = document.getElementById('sortFilter');
        const topicsGrid = document.getElementById('topicsGrid');
        const themeToggle = document.getElementById('themeToggle');
        const viewToggleButtons = document.querySelectorAll('.view-toggle button');

        // Tema
        let currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', currentTheme);
        updateThemeIcon();

        function updateThemeIcon() {
            const icon = themeToggle.querySelector('i');
            if (currentTheme === 'dark') {
                icon.className = 'bi bi-sun-fill';
                themeToggle.setAttribute('data-tooltip', 'Modo claro');
            } else {
                icon.className = 'bi bi-moon-fill';
                themeToggle.setAttribute('data-tooltip', 'Modo escuro');
            }
        }

        themeToggle.addEventListener('click', function() {
            currentTheme = currentTheme === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', currentTheme);
            localStorage.setItem('theme', currentTheme);
            updateThemeIcon();
        });

        // Modal
        document.getElementById('openCreateStudyModal').addEventListener('click', function(e) {
            e.preventDefault();
            modal.show();
        });

        document.getElementById('createStudyForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Simular criação do estudo
            const formData = new FormData(this);
            const studyData = Object.fromEntries(formData);

            // Aqui você enviaria os dados para o servidor
            console.log('Criando estudo:', studyData);

            // Fechar modal e redirecionar
            modal.hide();

            // Simular redirecionamento
            setTimeout(() => {
                window.location.href = '/notebook-lm/study/' + Date.now();
            }, 500);
        });

        // Pesquisa
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterCards();
        });

        // Filtros
        categoryFilter.addEventListener('change', filterCards);
        sortFilter.addEventListener('change', filterCards);

        function filterCards() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value;
            const sortBy = sortFilter.value;
            const cards = Array.from(document.querySelectorAll('.topic-card'));

            // Filtrar
            cards.forEach(card => {
                const title = card.querySelector('.topic-title').textContent.toLowerCase();
                const description = card.querySelector('.topic-description').textContent.toLowerCase();
                const category = card.getAttribute('data-category');

                const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
                const matchesCategory = !selectedCategory || category === selectedCategory;

                if (matchesSearch && matchesCategory) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.3s ease forwards';
                } else {
                    card.style.display = 'none';
                }
            });

            // Ordenar
            const visibleCards = cards.filter(card => card.style.display !== 'none');

            if (sortBy === 'alphabetical') {
                visibleCards.sort((a, b) => {
                    const titleA = a.querySelector('.topic-title').textContent;
                    const titleB = b.querySelector('.topic-title').textContent;
                    return titleA.localeCompare(titleB);
                });
            } else if (sortBy === 'progress') {
                visibleCards.sort((a, b) => {
                    const progressA = parseFloat(a.querySelector('.progress-fill').style.width);
                    const progressB = parseFloat(b.querySelector('.progress-fill').style.width);
                    return progressB - progressA;
                });
            }

            // Reordenar no DOM
            visibleCards.forEach(card => {
                topicsGrid.appendChild(card);
            });
        }

        // Alternância de visualização
        viewToggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                viewToggleButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const view = this.getAttribute('data-view');
                if (view === 'list') {
                    topicsGrid.style.gridTemplateColumns = '1fr';
                } else {
                    topicsGrid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(320px, 1fr))';
                }
            });
        });

        // Animações de entrada
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        });

        document.querySelectorAll('.topic-card').forEach(card => {
            observer.observe(card);
        });

        // Ações dos cards
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-action')) {
                e.preventDefault();
                const action = e.target.closest('.btn-action');
                const card = action.closest('.topic-card');
                const title = card.querySelector('.topic-title').textContent;

                // Simular ações
                if (action.textContent.includes('Continuar') || action.textContent.includes('Iniciar')) {
                    console.log('Abrindo estudo:', title);
                    // Aqui você redirecionaria para a página do estudo
                } else if (action.textContent.includes('Compartilhar')) {
                    console.log('Compartilhando estudo:', title);
                    // Aqui você abriria um modal de compartilhamento
                } else if (action.textContent.includes('Favoritar')) {
                    console.log('Favoritando estudo:', title);
                    action.innerHTML = '<i class="bi bi-bookmark-fill"></i> Favoritado';
                    action.style.background = 'var(--warning-color)';
                }
            }
        });

        // Efeitos de hover nos avatares
        document.querySelectorAll('.avatar').forEach(avatar => {
            avatar.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.2)';
                this.style.zIndex = '20';
            });

            avatar.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.zIndex = '1';
            });
        });
    });

</script>

@endsection
