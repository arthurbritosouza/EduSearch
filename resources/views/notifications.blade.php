@extends('layouts.app')

@section('title')
EduSearch - Notificações
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<style>
    /* Estilos específicos para a página de notificações */
    body {
        background: #f9fafb;
        /* Um cinza muito claro para diferenciar do branco puro */
    }

    .notification-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: box-shadow 0.2s, border-color 0.2s;
    }

    .notification-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .notification-icon {
        font-size: 2rem;
        color: var(--primary-color);
        margin-right: 1.25rem;
    }

    .notification-content h6 {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .notification-content p {
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .notification-content small {
        color: #9ca3af;
    }

    .notification-actions .btn {
        min-width: 100px;
    }

    .empty-state {
        background: #fff;
        border-radius: 12px;
        padding: 3rem;
        text-align: center;
        color: #6b7280;
    }

</style>
@endsection

@section('content')
@section('header_content')
<div class="col-md-8">
    <h1 class="dashboard-title">
        <i class="bi bi-bell me-3"></i>Notificações
    </h1>
    <p class="dashboard-subtitle mb-0">Gerencie seus convites para salas de estudo e tópicos compartilhados</p>
</div>
@endsection

@if($notifications->where('partner_id',auth()->user()->id)->isEmpty())
<div class="empty-state mt-5">
    <i class="bi bi-bell-slash" style="font-size: 3rem;"></i>
    <h4 class="mt-3">Nenhuma notificação nova</h4>
    <p>Você não tem convites pendentes no momento.</p>
</div>
@endif

<div class="row">
    <div class="col-lg-10 mx-auto">
        @foreach($notifications as $notification)
        @if($notification->type == 2)
        <div class="notification-card d-flex align-items-center">
            <div class="notification-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="notification-content flex-grow-1">
                <h6>Convite para Sala de Estudos</h6>
                <p><b>{{$notification->name_user}}</b> convidou você para participar da sala <b>"{{$notification->name_relation}}"</b>.</p>
                <small>Enviado {{ $notification->created_at->diffForHumans() }}</small>
            </div>
            <div class="notification-actions ms-4">
                <a href="{{route('relation_notification', $notification->id)}}" class="btn btn-primary btn-sm me-2">
                    <i class="bi bi-check-lg me-1"></i>Aceitar
                </a>
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg me-1"></i>Recusar
                </button>
            </div>
        </div>
        @elseif($notification->type == 1)
        <div class="notification-card d-flex align-items-center">
            <div class="notification-icon">
                <i class="bi bi-folder-symlink-fill"></i>
            </div>
            <div class="notification-content flex-grow-1">
                <h6>Convite para Tópico</h6>
                <p><b>{{$notification->name_user}}</b> compartilhou o tópico <b>"{{$notification->name_relation}}"</b> com você.</p>
                <small>Enviado {{ $notification->created_at->diffForHumans() }}</small>
            </div>
            <div class="notification-actions ms-4">
                <button class="btn btn-primary btn-sm me-2">
                    <i class="bi bi-check-lg me-1"></i>Aceitar
                </button>
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg me-1"></i>Recusar
                </button>
            </div>
        @endif
        @endforeach
        {{-- <!-- Exemplo de notificação mais antiga -->
        <div class="notification-card d-flex align-items-center opacity-75">
            <div class="notification-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="notification-content flex-grow-1">
                <h6>Convite para Sala de Estudos</h6>
                <p><b>Fernanda Lima</b> convidou você para participar da sala <b>"Clube de Leitura: Clássicos"</b>.</p>
                <small>Enviado ontem</small>
            </div>
            <div class="notification-actions ms-4">
                <button class="btn btn-primary btn-sm me-2">
                    <i class="bi bi-check-lg me-1"></i>Aceitar
                </button>
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg me-1"></i>Recusar
                </button>
            </div>
        </div>
 --}}



    </div>
</div>
@endsection

@section('scripts')
<script>
    // Atualizar horário em tempo real
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('pt-BR');
        const dateString = now.toLocaleDateString('pt-BR');
        document.getElementById('currentTime').innerHTML = `${dateString} - ${timeString}`;
    }
    setInterval(updateTime, 1000);
    updateTime();

</script>
@endsection
