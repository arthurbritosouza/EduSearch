<div class="modal fade" id="topicModal" tabindex="-1" aria-labelledby="topicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Criar Tópico Rápido
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('topic.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quickTopic" class="form-label">Assunto para estudar</label>
                        <input type="text" class="form-control" id="quickTopic" name="topic" placeholder="Ex: Equações de 2º grau, Revolução Francesa..." required>
                        <div class="form-text">A IA irá gerar conteúdo automaticamente</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-magic me-1"></i>Criar com IA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Upload PDF Rápido
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pdf.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quickPdfTitle" class="form-label">Título do PDF</label>
                        <input type="text" class="form-control" id="quickPdfTitle" name="pdf_title" placeholder="Ex: Matemática Básica" required>
                    </div>
                    <div class="mb-3">
                        <label for="quickPdfFile" class="form-label">Arquivo PDF</label>
                        <input type="file" class="form-control" id="quickPdfFile" name="pdf_file" accept=".pdf" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cloud-upload me-1"></i>Processar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="salaModal" tabindex="-1">
    <div class="modal-dialog">
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
                        <select class="form-select">
                            <option selected>Criar nova sala</option>
                            <option>Entrar em sala existente</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Confirmar</button>
                </form>
            </div>
        </div>
    </div>
</div>
