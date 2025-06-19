<!-- Modal Edição de Tópico -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Tópico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('topic.update', $data_topic->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="topicName" class="form-label">Nome do Tópico</label>
                        <input type="text" class="form-control" id="topicName" name="name" value="{{ $data_topic->name }}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Exclusão de Tópico -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Excluir Tópico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o tópico <strong>{{ $data_topic->name }}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('topic.destroy', $data_topic->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Adicionar Material -->
<div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMaterialModalLabel">Adicionar Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('material.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_topic" value="{{ $data_topic->id }}">
                    <input type="hidden" name="name_topic" value="{{ $data_topic->name }}">
                    <div class="mb-3">
                        <label for="materialTitulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="materialTitulo" name="title" placeholder="Digite o título">
                    </div>
                    <div class="mb-3">
                        <label for="materialDescricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="materialDescricao" rows="3" name="descricao" placeholder="Digite a descrição"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="materialNivel" class="form-label">Nível</label>
                        <select class="form-select" name="level" id="materialNivel">
                            <option value="iniciante">Iniciante</option>
                            <option value="intermediario">Intermediário</option>
                            <option value="avancado">Avançado</option>
                        </select>
                    </div>
                    <!-- Aqui você pode adicionar outros campos conforme necessário -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal Gerar Exercícios -->
<div class="modal fade" id="exercicioModal" tabindex="-1" aria-labelledby="exercicioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exercicioModalLabel">
                    <i class="bi bi-puzzle me-2"></i>Gerar Exercícios
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form action="/exercise_generator" method="POST" id="exercicioForm">
                @csrf
                <input type="hidden" name="topic" value="{{ $data_topic->name }}">
                <input type="hidden" name="id_topic" value="{{ $data_topic->id }}">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quantidade" class="form-label">
                            <i class="bi bi-hash me-1"></i>Quantidade de Exercícios
                        </label>
                        <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" max="15" value="0" required>
                        <div class="form-text">Insira um número entre 1 e 15 exercícios.</div>
                    </div>

                    <div class="mb-3">
                        <label for="dificuldade" class="form-label">
                            <i class="bi bi-speedometer2 me-1"></i>Nível de Dificuldade
                        </label>
                        <select class="form-select" id="dificuldade" name="level" required>
                            <option value="">Selecione o nível</option>
                            <option value="iniciante">
                                <span class="badge bg-success">Iniciante</span> - Conceitos básicos
                            </option>
                            <option value="intermediario">
                                <span class="badge bg-warning">Intermediário</span> - Aplicação prática
                            </option>
                            <option value="avancado">
                                <span class="badge bg-danger">Avançado</span> - Desafios complexos
                            </option>
                        </select>
                        <div class="form-text">Escolha o nível adequado ao seu conhecimento.</div>
                    </div>

                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle me-2"></i>
                        <div>
                            Os exercícios serão gerados automaticamente com base no conteúdo de
                            <strong>{{ $data_topic->name }}</strong>.
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="generateBtn">
                        <i class="bi bi-gear me-2"></i>Gerar Exercícios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(!empty($arrayEx))

<!-- Modal do Exercício -->
<div class="modal fade exercise-modal" id="modal-{{ $exercise['id'] }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exercício - {{ ucfirst($exercise['level']) }}</h5>
                <button type="button" class="btn-close close-modal" data-exercise-id="{{ $exercise['id'] }}"></button>
            </div>
            <div class="modal-body">
                <div class="exercise-question">
                    <h6>{{ $exercise['title'] }}</h6>
                </div>
                <form id="answerForm-{{ $exercise['id'] }}">
                    @csrf
                    <input type="hidden" name="id_exercise" value="{{ $exercise['id'] }}">
                    <div class="answer-options">
                        @foreach ($exercise['alternatives'] as $index => $alternativa)
                        <div class="form-check answer-option">
                            <input class="form-check-input" type="radio" name="resposta" id="option-{{ $exercise['id'] }}-{{ $index }}" value="{{ $alternativa }}" required>
                            <label class="form-check-label" for="option-{{ $exercise['id'] }}-{{ $index }}">
                                {{ $alternativa }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal" data-exercise-id="{{ $exercise['id'] }}">Cancelar</button>
                <button type="button" class="btn btn-primary submit-answer" data-exercise-id="{{ $exercise['id'] }}">
                    <i class="bi bi-check-circle me-2"></i>Responder
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal Adicionar Anotação -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNoteModalLabel">Nova Anotação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form action="{{route('topic.addAnnotation')}}" method="POST">
                @csrf
                <input type="hidden" name="topic_id" value="{{ $data_topic->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="noteTitle" class="form-label">Título</label>
                        <input type="text" class="form-control" id="noteTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="noteContent" class="form-label">Conteúdo</label>
                        <textarea class="form-control" id="noteContent" rows="5" style="height: 200px;" name="annotation" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Anotação</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Adicionar Parceiro -->
<div class="modal fade" id="addParceiroModall" tabindex="-1" aria-labelledby="addParceiroModallLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addParceiroModallLabel">Adicionar Parceiro de Estudo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/relations" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id_topic" value="{{ $data_topic->id }}">
                        <label for="partnerEmail" class="form-label">Email do Parceiro</label>
                        <input type="email" class="form-control" name="email" placeholder="email@exemplo.com">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Convite</button>
                </div>
            </form>
        </div>
    </div>
</div>
