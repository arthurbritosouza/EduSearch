@extends('layouts.app')

@section('title')
EduSearch - Salas de Estudo
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/room.css') }}">
@endsection

@section('content')
@section('header_content')
<div class="col-md-8">
    <h1 class="dashboard-title">
        <i class="bi bi-door-open me-3"></i>Salas de Estudo
    </h1>
    <p class="dashboard-subtitle">Encontre, entre ou crie uma sala para estudar em grupo</p>
</div>
@endsection

<!-- Botão para abrir modal -->
<div class="mb-4 text-end">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#salaModal">
        <i class="bi bi-plus-circle me-2"></i>Criar/Entrar em Sala
    </button>
</div>

<!-- Lista de Salas -->
<div class="row g-4">
    @if($rooms->count() > 0)
    @foreach($rooms as $room)
    <div class="col-lg-4 col-md-6">
        <div class="room-card">
            <div class="room-card-header">
                <i class="bi bi-mortarboard icon"></i>
            </div>
            <div class="room-card-body">
                <h5 class="room-card-title">{{$room->name}}</h5>
                <p class="room-card-description">{{$room->description}}</p>
                <div class="room-card-footer">
                    <span class="room-participants">
                        <i class="bi bi-people-fill me-1"></i>
                        {{ $participantsByRoom->get($room->id, collect())->count() }} participantes
                    </span>
                    <a href="{{route('room.show',$room->id)}}" class="btn btn-outline-primary btn-sm">Entrar</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="col-12">
        <div class="empty-state">
            <i class="bi bi-door-open"></i>
            <h4>Nenhuma sala encontrada</h4>
            <p>Você ainda não participa de nenhuma sala de estudo.</p>
            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#salaModal">
                <i class="bi bi-plus-circle me-2"></i>Criar sua primeira sala
            </button>
        </div>
    </div>
    @endif
</div>

<!-- Modal Criar/Entrar em Sala -->
<div class="modal fade" id="salaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-door-open me-2"></i>Criar ou Entrar em Sala
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('room.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nome da Sala</label>
                        <input type="text" class="form-control" name="name" placeholder="Ex: Biologia Vestibular" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição da sala</label>
                        <input type="text" class="form-control" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha (opcional)</label>
                        <input type="password" class="form-control" name="password" placeholder="Se a sala for privada">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ação</label>
                        <select class="form-select" name="action">
                            <option value="create" selected>Criar nova sala</option>
                            <option value="join">Entrar em sala existente</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Confirmar</button>
                </form>
            </div>
        </div>
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
