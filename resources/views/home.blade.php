@extends('layouts.app')

@section('title')
EduSearch - Dashboard Principal
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<style>
    .stats-card-large {
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border-radius: 12px;
        padding: 28px 0;
        text-align: center;
        transition: box-shadow .2s;
    }

    .stats-card-large:hover {
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.10);
    }

    .stats-icon {
        font-size: 2.8rem;
        margin-bottom: 10px;
    }

    .quick-action-card {
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        transition: box-shadow .2s, background .2s;
        background: #fff;
        border: none;
        width: 100%;
        padding: 28px 0;
        text-align: center;
    }

    .quick-action-card:hover {
        background: #f8f9fa;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.10);
    }

    .action-icon {
        font-size: 2.2rem;
        margin-bottom: 10px;
    }

    .navigation-card {
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        background: #fff;
        padding: 24px;
        margin-bottom: 24px;
    }

    .nav-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .nav-link-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        color: #495057;
        text-decoration: none;
        border-bottom: 1px solid #f1f1f1;
        transition: background .2s;
    }

    .nav-link-item:last-child {
        border-bottom: none;
    }

    .nav-link-item:hover {
        background: #f8f9fa;
        color: #0f4c81;
    }

    .recent-activity-card {
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        background: #fff;
        padding: 24px;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        border-bottom: 1px solid #f1f1f1;
        padding: 16px 0;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        font-size: 2rem;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
    }

    .activity-content h6 {
        font-weight: 600;
        margin-bottom: 2px;
    }

    .activity-content p {
        font-size: 0.95rem;
        color: #666;
        margin-bottom: 2px;
    }

    .activity-content small {
        color: #999;
    }

</style>
@endsection

@section('content')
@section('header_content')
<div class="col-md-8">
    <h1 class="dashboard-title">
        <i class="bi bi-speedometer2 me-3"></i>Dashboard Principal
    </h1>
    <p class="dashboard-subtitle">Central de controle do seu ambiente de estudos</p>
</div>
@endsection

<!-- Cards de Estatísticas Rápidas -->
<div class="row mb-5">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="stats-card-large primary">
            <div class="stats-icon">
                <i class="bi bi-folder2-open"></i>
            </div>
            <div class="stats-content">
                <h3>{{$topics->count()}}</h3>
                <p>Tópicos Criados</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="stats-card-large success">
            <div class="stats-icon">
                <i class="bi bi-file-earmark-pdf"></i>
            </div>
            <div class="stats-content">
                <h3>{{$pdfs->count()}}</h3>
                <p>PDFs Processados</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="stats-card-large warning">
            <div class="stats-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="stats-content">
                <h3>{{$rooms->count()}}</h3>
                <p>Salas Ativas</p>
            </div>
        </div>
    </div>
</div>

<!-- Ações Rápidas -->
<div class="quick-actions-section mb-5">
    <h4 class="section-title mb-4">
        <i class="bi bi-lightning-charge me-2"></i>Ações Rápidas
    </h4>
    <div class="row g-4">
        <div class="col-lg-3 col-md-6">
            <button class="quick-action-card" data-bs-toggle="modal" data-bs-target="#topicModal">
                <div class="action-icon">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <h5>Criar Tópico</h5>
                <p>Pesquise um novo assunto para estudar</p>
            </button>
        </div>
        <div class="col-lg-3 col-md-6">
            <button class="quick-action-card" data-bs-toggle="modal" data-bs-target="#pdfModal">
                <div class="action-icon">
                    <i class="bi bi-file-earmark-pdf"></i>
                </div>
                <h5>Upload PDF</h5>
                <p>Processe um novo PDF com IA</p>
            </button>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="quick-action-card" data-bs-toggle="modal" data-bs-target="#salaModal">
                <div class="action-icon">
                    <i class="bi bi-door-open"></i>
                </div>
                <h5>Entrar em Sala</h5>
                <p>Junte-se a uma sala de estudos</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="quick-action-card" onclick="window.location.href='/chat-ia'">
                <div class="action-icon">
                    <i class="bi bi-robot"></i>
                </div>
                <h5>Chat com IA</h5>
                <p>Tire suas dúvidas instantaneamente</p>
            </div>
        </div>
    </div>
</div>

<!-- Navegação por Seções -->
<div class="navigation-sections mb-5">
    <h4 class="section-title mb-4">
        <i class="bi bi-compass me-2"></i>Explorar Sistema
    </h4>
    <div class="row g-4">
        <!-- Seção Estudos -->
        <div class="col-lg-6">
            <div class="navigation-card estudos">
                <div class="nav-card-header">
                    <i class="bi bi-mortarboard"></i>
                    <h5>Estudos</h5>
                </div>
                <div class="nav-card-body">
                    <a href="{{route('topic.index')}}" class="nav-link-item">
                        <i class="bi bi-folder2-open"></i>
                        <span>Meus Tópicos</span>
                        <span class="badge bg-primary">{{$topics->count()}}</span>
                    </a>
                    <a href="{{route('pdf.index')}}" class="nav-link-item">
                        <i class="bi bi-file-earmark-pdf"></i>
                        <span>Biblioteca de PDFs</span>
                        <span class="badge bg-success">{{$pdfs->count()}}</span>
                    </a>
                    <a href="{{route('room.index')}}" class="nav-link-item">
                        <i class="bi bi-door-open"></i>
                        <span>Salas</span>
                        <span class="badge bg-success">{{$rooms->count()}}</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Seção Ferramentas -->
        <div class="col-lg-6">
            <div class="navigation-card ferramentas">
                <div class="nav-card-header">
                    <i class="bi bi-tools"></i>
                    <h5>Ferramentas</h5>
                </div>
                <div class="nav-card-body">
                    <a href="/chat-ia" class="nav-link-item">
                        <i class="bi bi-robot"></i>
                        <span>Chat com IA</span>
                        <span class="badge bg-success">Online</span>
                    </a>
                    <a href="/resumos" class="nav-link-item">
                        <i class="bi bi-journal-text"></i>
                        <span>Gerador de Resumos</span>
                    </a>
                    <a href="/flashcards" class="nav-link-item">
                        <i class="bi bi-card-text"></i>
                        <span>Flashcards</span>
                        <span class="badge bg-warning">12 sets</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <!-- Atividades Recentes -->
    <div class="row">
        <div class="col-lg-8">
            <div class="recent-activity-card">
                <div class="card-header">
                    <h5><i class="bi bi-clock-history me-2"></i>Atividades Recentes</h5>
                </div>
                <div class="card-body">
                    @foreach($activities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon {{ $activity['type'] ?? 'primary' }}">
<i class="{{ $activity['icon'] ?? 'bi bi-info-circle' }}"></i>
</div>
<div class="activity-content">
    <h6>{{ $activity['title'] }}</h6>
    <p>{{ $activity['description'] }}</p>
    <small class="text-muted">{{ $activity['time'] }}</small>
</div>
</div>
@endforeach
</div>
</div>
</div>
</div> --}}
@endsection

@section('modals')
@include('modals.modal-home')
@endsection
