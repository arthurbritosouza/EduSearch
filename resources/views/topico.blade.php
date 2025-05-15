<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="32x32" href="{{ asset('logo_edusearch.png') }}" type="image/png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSearch - Conteúdo Pesquisado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl9V0lpqQWw7ECbmDaA7GcNl2l6UMrOqAJEkvPauVTYJGCzgs" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w77A7NuiAFJuUT24GfNkwwbZl4LAnM2z35MLQNE" crossorigin="anonymous"></script>
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

            <!-- Cabeçalho do conteúdo -->
            <div class="content-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2>{{$data_topic->materia}}: {{$data_topic->name}}</h2>
                        <p class="mb-0">Pesquisado em 15/05/2023 • 48 recursos encontrados</p>
                    </div>
                    <div class="actions">
                        <button class="btn btn-light"><i class="bi bi-share"></i> Compartilhar</button>
                    </div>
                </div>
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
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <!-- Navegação por abas -->
            <ul class="nav nav-tabs mb-0" id="contentTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">
                        <i class="bi bi-grid"></i> Visão Geral
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="topics-tab" data-bs-toggle="tab" data-bs-target="#topics" type="button" role="tab" aria-controls="topics" aria-selected="false">
                        <i class="bi bi-list-check"></i> Tópicos
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="exercises-tab" data-bs-toggle="tab" data-bs-target="#exercises" type="button" role="tab" aria-controls="exercises" aria-selected="false">
                        <i class="bi bi-pencil-square"></i> Exercícios
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="partners-tab" data-bs-toggle="tab" data-bs-target="#partners" type="button" role="tab" aria-controls="partners" aria-selected="false">
                        <i class="bi bi-people"></i> Parceiros
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="anotacao-tab" data-bs-toggle="tab" data-bs-target="#anotacao" type="button" role="tab" aria-controls="anotacao" aria-selected="false">
                        <i class="bi bi-pencil"></i> Anotações
                    </button>
                </li>

                <!-- Botão de Delete -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-danger" id="delete-tab" data-bs-toggle="modal" data-bs-target="#deleteModal" type="button" role="tab" aria-controls="delete" aria-selected="false">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </li>
                <!-- Botão de Editar -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-primary" id="edit-tab" data-bs-toggle="modal" data-bs-target="#editModal" type="button" role="tab" aria-controls="edit" aria-selected="false">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                </li>
            </ul>

            <!-- Modal de Deleção -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza que deseja deletar este item?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <a href="/delete/{{$data_topic->id}}" type="button" class="btn btn-danger">Deletar</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Edição -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Tópico</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/edit_topic" method="POST">
                                @csrf
                                <input type="hidden" name="id_topic" value="{{ $data_topic->id }}">
                                <div class="mb-3">
                                    <label for="topicName" class="form-label">Nome do Tópico</label>
                                    <input type="text" class="form-control" id="topicName" name="name_topic" value="{{ $data_topic->name }}" required>
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


            <!-- Conteúdo das abas -->
            <div class="tab-content" id="contentTabsContent">
                <!-- Aba Visão Geral -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="content-card">
                                <div class="card-header">
                                    <i class="bi bi-info-circle"></i> Um breve resumo sobre {{$data_topic->name}}
                                </div>
                                <div class="card-body">
                                    {!! $texto !!}

                                </div>
                            </div>


                        </div>

                        <div class="col-md-4">
                            <div class="content-card">
                                <div class="card-header">
                                    <i class="bi bi-lightbulb"></i> Materiais por Nível
                                </div>
                                <div class="card-body">
                                    <div class="d-flex mb-4">
                                        <span class="badge badge-level badge-iniciante">Iniciante</span>
                                        <span class="badge badge-level badge-intermediario">Intermediário</span>
                                        <span class="badge badge-level badge-avancado">Avançado</span>
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>


                                    <!-- Modal de Formulário -->

                                    <div class="accordion" id="levelAccordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <span class="badge badge-level badge-iniciante me-2">Iniciante</span> Fundamentos de {{$data_topic->name}}
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#levelAccordion">
                                                <div class="accordion-body">
                                                    <ul>
                                                        @foreach ($materials as $material)
                                                        @if ($material->level == 1)
                                                        <li><i class="bi bi-file-earmark-text"></i> <a href="/conteudo/{{$data_topic->id}}/{{$material->id}}/1">{{$material->name_material}}</a></li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    <span class="badge badge-level badge-intermediario me-2">Intermediário</span> Aprofundamento em {{$data_topic->name}}
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#levelAccordion">
                                                <div class="accordion-body">
                                                    <ul>
                                                        @foreach ($materials as $material)
                                                        @if ($material->level == 2)
                                                        <li><i class="bi bi-file-earmark-text"></i> <a href="/conteudo/{{$data_topic->id}}/{{$material->id}}/2">{{$material->name_material}}</a></li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    <span class="badge badge-level badge-avancado me-2">Avançado</span> Tópicos Avançados em {{$data_topic->name}}
                                                </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#levelAccordion">
                                                <div class="accordion-body">
                                                    <ul>
                                                        @foreach ($materials as $material)
                                                        @if ($material->level == 3)
                                                        <li><i class="bi bi-file-earmark-text"></i> <a href="/conteudo/{{$data_topic->id}}/{{$material->id}}/3">{{$material->name_material}}</a></li>
                                                        @endif
                                                        @endforeach </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>



                </div>

                <div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addMaterialModalLabel">Adicionar Material</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/add_material" method="post">
                                    @csrf
                                    <input type="hidden" name="id_topic" value="{{$data_topic->id}}">
                                    <input type="hidden" name="name_topic" value="{{$data_topic->name}}">
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

                <!-- Aba Tópicos -->
                <div class="tab-pane fade" id="topics" role="tabpanel" aria-labelledby="topics-tab">
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Artigo principal -->
                            <div class="article-container">
                                <h1>{{$data_topic->name}}</h1>

                                <div>
                                    {!! $topicFormatado !!}
                                </div>

                                <div class="article-actions">
                                    <button class="btn btn-outline-primary"><i class="bi bi-printer"></i> Imprimir</button>
                                    <button class="btn btn-outline-primary"><i class="bi bi-download"></i> Baixar PDF</button>
                                    <button class="btn btn-primary"><i class="bi bi-bookmark-plus"></i> Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aba Exercícios -->
                <div class="tab-pane fade" id="exercises" role="tabpanel" aria-labelledby="exercises-tab">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4>Exercícios de {{$data_topic->name}}</h4>

                        <div>
                            <select class="form-select">
                                <option selected>Todos os níveis</option>
                                <option>Iniciante</option>
                                <option>Intermediário</option>
                                <option>Avançado</option>
                            </select>
                        </div>
                    </div>
                    @foreach ($arrayEx as $exercise)
                    <div class="exercise-item mb-3 p-3 border">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>{{ $exercise['titulo'] }}</h5>
                            @if ($exercise['level'] == 'iniciante')
                            <span class="badge badge-level badge-iniciante">Iniciante</span>
                            @elseif ($exercise['level'] == 'intermediario')
                            <span class="badge badge-level badge-intermediario">Intermediário</span>
                            @elseif ($exercise['level'] == 'avancado')
                            <span class="badge badge-level badge-avancado">Avançado</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-primary open-exercise-modal" data-exercise-id="{{ $exercise['id'] }}">
                                Resolver Exercício
                            </button>
                        </div>
                    </div>

                    <!-- Modal para responder o exercício -->
                    <div class="modal fade exercise-modal" id="modal-{{ $exercise['id'] }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-{{ $exercise['id'] }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel-{{ $exercise['id'] }}">Resolver Exercício</h5>
                                    <button type="button" class="close close-modal" data-exercise-id="{{ $exercise['id'] }}" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>{{ $exercise['titulo'] }}</p>
                                    <form id="answerForm-{{ $exercise['id'] }}">
                                        @csrf
                                        <input type="hidden" name="id_exercise" value="{{ $exercise['id'] }}">
                                        @foreach ($exercise['alternativas'] as $index => $alternativa)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="resposta" id="option-{{ $exercise['id'] }}-{{ $index }}" value="{{ $alternativa }}" required>
                                            <label class="form-check-label" for="option-{{ $exercise['id'] }}-{{ $index }}">
                                                {{ $alternativa }}
                                            </label>
                                        </div>
                                        @endforeach
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary close-modal" data-exercise-id="{{ $exercise['id'] }}">Fechar</button>
                                            <button type="button" class="btn btn-primary submit-answer" data-exercise-id="{{ $exercise['id'] }}">Responder</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de Feedback -->
                    <div class="modal fade feedback-modal" id="feedback-modal-{{ $exercise['id'] }}" tabindex="-1" role="dialog" aria-labelledby="feedbackLabel-{{ $exercise['id'] }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="feedbackLabel-{{ $exercise['id'] }}">Resultado</h5>
                                    <button type="button" class="close close-feedback-modal" data-exercise-id="{{ $exercise['id'] }}" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="feedback-message-{{ $exercise['id'] }}" class="alert"></div>
                                    <p class="mt-3"><strong>Resolução:</strong> <span id="resolucao-{{ $exercise['id'] }}"></span></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary close-feedback-modal" data-exercise-id="{{ $exercise['id'] }}">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="container text-center mt-4">
                        <!-- Botão para abrir o modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exercicioModal">
                            Carregar mais exercícios
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exercicioModal" tabindex="-1" aria-labelledby="exercicioModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exercicioModalLabel">Gerar Exercícios</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/exercise_generator" method="POST" id="exercicioForm">
                                            @csrf
                                            <input type="hidden" name="topic" value="{{$data_topic->name}}">
                                            <input type="hidden" name="id_topic" value="{{$data_topic['id']}}">
                                            <div class="form-group">
                                                <label for="quantidade">Quantidade de Exercícios</label>
                                                <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" max="15" required>
                                                <small class="form-text text-muted">Insira um número entre 1 e 15.</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="dificuldade">Nível de Dificuldade</label>
                                                <select class="form-control" id="dificuldade" name="level" required>
                                                    <option value="iniciante">Iniciante</option>
                                                    <option value="intermediario">Intermediário</option>
                                                    <option value="avancado">Avançado</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary" form="exercicioForm">Gerar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Aba Anotações -->
                <div class="tab-pane fade" id="anotacao" role="tabpanel" aria-labelledby="anotacao-tab">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4>Anotações</h4>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                                    <i class="bi bi-plus-lg"></i> Nova Anotação
                                </button>
                            </div>

                            @foreach ($anotacoes as $anotacao)
                            <div class="notes-container">
                                <div class="card mb-3" data-note-id="1">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 note-title">{{$anotacao->titulo}}</h5>
                                        <div class="note-actions">
                                            <!-- Botão Ver em Popup -->
                                            <button class="btn btn-sm btn-outline-secondary btn-view" title="Ver em Popup" data-bs-toggle="modal" data-bs-target="#viewNoteModal">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <!-- Botão Tela Cheia -->
                                            <button class="btn btn-sm btn-outline-info ms-2 btn-fullscreen" title="Ver em Tela Cheia">
                                                <i class="bi bi-arrows-fullscreen"></i>
                                            </button>
                                            <!-- Botão Excluir -->
                                            <a href="/excluir_anotacao/{{$anotacao->id}}" class="btn btn-sm btn-outline-danger ms-2 btn-delete" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="note-content">
                                            <p class="card-text">{{$anotacao->anotacao}}.</p>
                                            <small class="text-muted">{{$anotacao->created_at }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Modal Adicionar Anotação -->
                <div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addNoteModalLabel">Nova Anotação</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <form action="/add_anotacao" method="POST">
                                @csrf
                                <input type="hidden" name="id_topic" value="{{ $data_topic->id }}">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="noteTitle" class="form-label">Título</label>
                                        <input type="text" class="form-control" id="noteTitle" name="title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="noteContent" class="form-label">Conteúdo</label>
                                        <textarea class="form-control" id="noteContent" rows="5" style="height: 200px;" name="anotacao" required></textarea>
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

                <!-- Modal Visualizar Anotação -->
                <div class="modal fade" id="viewNoteModal" tabindex="-1" aria-labelledby="viewNoteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewNoteModalLabel">Visualizar Anotação</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <div id="viewNoteContent">
                                    <!-- Conteúdo da anotação será carregado aqui -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    /* Estilo para o elemento em tela cheia */
                    .fullscreen-note {
                        background-color: white;
                        padding: 20px;
                        overflow-y: auto;
                        width: 100%;
                        height: 100%;
                    }

                    /* Animação para os cards de anotação */
                    .notes-container .card {
                        transition: transform 0.2s ease;
                    }

                    .notes-container .card:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                    }

                </style>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Elementos do DOM
                        const notesContainer = document.querySelector('.notes-container');
                        const editNoteModal = document.getElementById('editNoteModal');
                        const viewNoteModal = document.getElementById('viewNoteModal');

                        // Variável para armazenar o ID da nota atual
                        let currentNoteId = null;

                        // Listener para os botões nas anotações
                        notesContainer.addEventListener('click', function(e) {
                            const target = e.target;
                            const noteCard = target.closest('.card');

                            if (!noteCard) return;

                            currentNoteId = noteCard.dataset.noteId;

                            // Botão de editar
                            if (target.closest('.btn-edit')) {
                                const noteTitle = noteCard.querySelector('.note-title').textContent;
                                const noteContent = noteCard.querySelector('.card-text').textContent;

                                // Preencher o formulário de edição
                                document.getElementById('editNoteTitle').value = noteTitle;
                                document.getElementById('editNoteContent').value = noteContent;
                            }

                            // Botão de visualizar em popup
                            if (target.closest('.btn-view')) {
                                const noteTitle = noteCard.querySelector('.note-title').textContent;
                                const noteContent = noteCard.querySelector('.note-content').innerHTML;

                                // Preencher o modal de visualização
                                document.getElementById('viewNoteModalLabel').textContent = noteTitle;
                                document.getElementById('viewNoteContent').innerHTML = noteContent;
                            }

                            // Botão de tela cheia
                            if (target.closest('.btn-fullscreen')) {
                                const noteContent = noteCard.querySelector('.note-content').cloneNode(true);

                                // Criar elemento para tela cheia
                                const fullscreenElement = document.createElement('div');
                                fullscreenElement.className = 'fullscreen-note';
                                fullscreenElement.appendChild(noteContent);
                                document.body.appendChild(fullscreenElement);

                                // Abrir em tela cheia
                                if (fullscreenElement.requestFullscreen) {
                                    fullscreenElement.requestFullscreen();
                                } else if (fullscreenElement.webkitRequestFullscreen) {
                                    fullscreenElement.webkitRequestFullscreen();
                                } else if (fullscreenElement.msRequestFullscreen) {
                                    fullscreenElement.msRequestFullscreen();
                                }

                                // Remover o elemento quando sair da tela cheia
                                document.addEventListener('fullscreenchange', function() {
                                    if (!document.fullscreenElement) {
                                        if (fullscreenElement.parentNode) {
                                            fullscreenElement.parentNode.removeChild(fullscreenElement);
                                        }
                                    }
                                });
                            }
                        });

                        // Salvar alterações da edição
                        document.getElementById('editNoteForm').addEventListener('submit', function(e) {
                            e.preventDefault();

                            const noteTitle = document.getElementById('editNoteTitle').value;
                            const noteContent = document.getElementById('editNoteContent').value;

                            // Atualizar a anotação no DOM
                            const noteCard = document.querySelector(`.card[data-note-id="${currentNoteId}"]`);
                            if (noteCard) {
                                noteCard.querySelector('.note-title').textContent = noteTitle;
                                noteCard.querySelector('.card-text').textContent = noteContent;

                                // Fechar o modal
                                const modal = bootstrap.Modal.getInstance(editNoteModal);
                                modal.hide();
                            }
                        });
                    });

                </script>


                <!-- Aba Parceiros -->
                <div class="tab-pane fade" id="partners" role="tabpanel" aria-labelledby="partners-tab">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h4>Parceiros de {{$data_topic->name}}</h4>
                            <p>Conecte-se com outros estudantes que estão aprendendo Álgebra Linear para estudar em grupo, trocar materiais e tirar dúvidas.</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPartnerModal">
                                <i class="bi bi-person-plus"></i> Adicionar Parceiro
                            </button>
                        </div>
                    </div>

                    <div class="content-card">
                        <div class="card-header">
                            <i class="bi bi-people"></i> Seus Parceiros de Estudo
                        </div>
                        @foreach($parceiros as $parceiro)
                        <div class="card-body">
                            <div class="partner-card">
                                <div class="partner-info">
                                    <h5 class="partner-name">{{$parceiro->name}}</h5>
                                    <p class="partner-status">{{$parceiro->email}}</p>
                                </div>
                                <div class="partner-actions">
                                    <a href="/excluir_parceiro/{{$data_topic->id}}/{{$parceiro->id}}" class="btn btn-sm btn-outline-primary"><i class="bi bi-trash"></i> Expulsar</a>
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

    <!-- Modal Adicionar Parceiro -->
    <div class="modal fade" id="addPartnerModal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPartnerModalLabel">Adicionar Parceiro de Estudo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/relacione" method="post">
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



    {{--<div class="tab-pane fade" id="anotacao" role="tabpanel" aria-labelledby="anotacao-tab">--}}
    {{-- <div class="row mb-4">--}}
    {{-- <div class="col-md-8">--}}
    {{-- <h4>Anotações</h4>--}}
    {{-- <p>Compartilhe suas anotações e materiais de estudo com outros estudantes.</p>--}}
    {{-- </div>--}}
    {{-- <div class="col-md-4 text-end">--}}
    {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAnotacaoModal">--}}
    {{-- <i class="bi bi-plus"></i> Adicionar Anotação--}}
    {{-- </button>--}}
    {{-- </div>--}}
    {{-- </div>--}}

    {{-- <div class="content-card">--}}
    {{-- <div class="card-header">--}}
    {{-- <i class="bi bi-pencil"></i> Suas Anotações--}}
    {{-- </div>--}}
    {{-- @foreach($parceiros as $parceiro)--}}
    {{-- <div class="card-body">--}}
    {{-- <div class="anotacao-card">--}}
    {{-- <div class="anotacao-info">--}}
    {{-- <h5 class="anotacao-title">{{ $parceiro->titulo }}</h5>--}}
    {{-- <p class="anotacao-content">{{ $parceiro->conteudo }}</p>--}}
    {{-- </div>--}}
    {{-- <div class="anotacao-actions">--}}
    {{-- <a href="" class="btn btn-sm btn-outline-primary">--}}
    {{-- <i class="bi bi-pencil"></i> Editar--}}
    {{-- </a>--}}
    {{-- <a href="" class="btn btn-sm btn-outline-danger">--}}
    {{-- <i class="bi bi-trash"></i> Excluir--}}
    {{-- </a>--}}
    {{-- </div>--}}
    {{-- </div>--}}
    {{-- </div>--}}
    {{-- @endforeach--}}
    {{-- </div>--}}
    {{--</div>--}}

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Abrir modal de exercício
        $('.open-exercise-modal').on('click', function() {
            var exerciseId = $(this).data('exercise-id');
            openExerciseModal(exerciseId);
        });

        // Fechar modal de exercício
        $('.close-modal').on('click', function() {
            var exerciseId = $(this).data('exercise-id');
            closeExerciseModal(exerciseId);
        });

        // Fechar modal de feedback
        $('.close-feedback-modal').on('click', function() {
            var exerciseId = $(this).data('exercise-id');
            closeFeedbackModal(exerciseId);
        });

        // Enviar resposta
        $('.submit-answer').on('click', function() {
            var exerciseId = $(this).data('exercise-id');
            submitAnswer(exerciseId);
        });

        // Garantir limpeza adequada ao fechar qualquer modal
        $(document).on('hidden.bs.modal', '.modal', function() {
            if ($('.modal:visible').length === 0) {
                setTimeout(function() {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('body').css('padding-right', '');
                }, 300);
            }
        });
    });

    function openExerciseModal(exerciseId) {
        // Fechar qualquer modal aberto primeiro
        $('.modal').modal('hide');

        // Limpar qualquer resíduo de modal
        cleanupModals();

        // Abrir o modal de exercício
        $('#modal-' + exerciseId).modal('show');
    }

    function closeExerciseModal(exerciseId) {
        $('#modal-' + exerciseId).modal('hide');
        cleanupModals();
    }

    function closeFeedbackModal(exerciseId) {
        $('#feedback-modal-' + exerciseId).modal('hide');
        cleanupModals();
    }

    function cleanupModals() {
        setTimeout(function() {
            if ($('.modal:visible').length === 0) {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                $('body').css('padding-right', '');
            }
        }, 300);
    }

    function submitAnswer(exerciseId) {
        let form = document.getElementById('answerForm-' + exerciseId);
        let formData = new FormData(form);

        // Verificar se uma resposta foi selecionada
        let respostaSelecionada = form.querySelector('input[name="resposta"]:checked');
        if (!respostaSelecionada) {
            alert('Por favor, selecione uma resposta.');
            return;
        }

        fetch('/verificar-resposta', {
                method: 'POST'
                , body: formData
                , headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                let feedbackMessage = document.getElementById('feedback-message-' + exerciseId);
                let resolucaoText = document.getElementById('resolucao-' + exerciseId);

                // Define a classe do alerta conforme o resultado
                if (data.resultado === 'correto') {
                    feedbackMessage.className = 'alert alert-success';
                } else {
                    feedbackMessage.className = 'alert alert-danger';
                }
                feedbackMessage.innerText = data.mensagem;
                resolucaoText.innerText = data.resolucao;

                // Fechar o modal de exercício
                $('#modal-' + exerciseId).modal('hide');

                // Limpar qualquer resíduo de modal
                cleanupModals();

                // Esperar antes de abrir o modal de feedback
                setTimeout(function() {
                    $('#feedback-modal-' + exerciseId).modal('show');
                }, 500);
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Ocorreu um erro ao enviar a resposta.');
            });
    }


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
    });

</script>
</body>
</html>
