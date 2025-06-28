@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">
            <i class="bi bi-journal-richtext me-2"></i>Anotações
        </h1>
        <!-- Botão modificado para abrir o modal via atributos data-* -->
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#note-modal">
            <i class="bi bi-plus-lg me-1"></i> Criar Nova Anotação
        </button>
    </div>

    <div id="notes-container" class="row">
        <!-- Anotação Estática 1 -->
        <div class="col-lg-4 col-md-6 mb-4 note-column">
            <div class="card note-card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Reunião de Kickoff</h5>
                    <p class="card-text text-muted">Discutir o escopo do novo módulo de IA, definir as metas para o primeiro sprint e alinhar as expectativas com a equipe.</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-end pb-3">
                    <a href="#" class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></a>
                </div>
            </div>
        </div>
        <!-- Anotação Estática 2 -->
        <div class="col-lg-4 col-md-6 mb-4 note-column">
            <div class="card note-card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Ideias para UI/UX</h5>
                    <p class="card-text text-muted">Brainstorm sobre a nova paleta de cores. Explorar designs com tema escuro. Melhorar a acessibilidade dos formulários.</p>
                </div>
                 <div class="card-footer bg-transparent border-0 text-end pb-3">
                    <a href="#" class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></a>
                </div>
            </div>
        </div>
        <!-- Anotação Estática 3 -->
        <div class="col-lg-4 col-md-6 mb-4 note-column">
            <div class="card note-card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Lembretes Pessoais</h5>
                    <p class="card-text text-muted">1. Agendar consulta no dentista. 2. Comprar livro de arquitetura de software. 3. Finalizar o relatório semanal.</p>
                </div>
                 <div class="card-footer bg-transparent border-0 text-end pb-3">
                    <a href="#" class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nova Anotação -->
<div class="modal fade" id="note-modal" tabindex="-1" aria-labelledby="note-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="note-modal-label">Nova Anotação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="note-form">
                    <div class="mb-3">
                        <label for="note-title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="note-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="note-content" class="form-label">Conteúdo</label>
                        <textarea class="form-control" id="note-content" rows="5" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="save-note-btn" class="btn btn-primary">Salvar Anotação</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .note-card {
        border: none;
        border-radius: 0.75rem;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .note-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15)!important;
    }
    .card-title {
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const saveNoteBtn = document.getElementById('save-note-btn');
    const noteModalEl = document.getElementById('note-modal');
    const noteModal = bootstrap.Modal.getInstance(noteModalEl) || new bootstrap.Modal(noteModalEl);
    const notesContainer = document.getElementById('notes-container');
    const noteForm = document.getElementById('note-form');

    // Limpa o formulário sempre que o modal for aberto
    noteModalEl.addEventListener('show.bs.modal', function(event) {
        noteForm.reset();
    });

    // Salvar anotação
    saveNoteBtn.addEventListener('click', function () {
        const title = document.getElementById('note-title').value.trim();
        const content = document.getElementById('note-content').value.trim();

        if (title === '' || content === '') {
            alert('Por favor, preencha o título e o conteúdo.');
            return;
        }

        addNoteToDOM(title, content);
        noteModal.hide();
    });

    function addNoteToDOM(title, content) {
        const noteColumn = document.createElement('div');
        noteColumn.className = 'col-lg-4 col-md-6 mb-4 note-column';

        noteColumn.innerHTML = `
            <div class="card note-card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">${escapeHTML(title)}</h5>
                    <p class="card-text text-muted">${escapeHTML(content)}</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-end pb-3">
                    <a href="#" class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></a>
                </div>
            </div>
        `;
        notesContainer.prepend(noteColumn);
    }

    function escapeHTML(str) {
        return str.replace(/[&<>"']/g, function (match) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            }[match];
        });
    }
});
</script>
@endpush
