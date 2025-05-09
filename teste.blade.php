<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSearch - Conteúdo Pesquisado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- CSS do Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl9V0lpqQWw7ECbmDaA7GcNl2l6UMrOqAJEkvPauVTYJGCzgs" crossorigin="anonymous">

<!-- JavaScript do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w77A7NuiAFJuUT24GfNkwwbZl4LAnM2z35MLQNE" crossorigin="anonymous"></script>

    <style>
        :root {
            --primary-color:rgb(29, 114, 226);
            --secondary-color:rgb(3, 140, 158);
            --accent-color:rgb(125, 255, 216);
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #38b000;
            --warning-color: #ffaa00;
            --danger-color: #e63946;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background-color: #f5f7fa;
            position: relative;
        }
        
        /* Main content styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
            width: calc(100% - 250px);
        }
        
        .content-header {
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            border-radius: 15px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(199, 125, 255, 0.2);
            position: relative;
        }
        
        .content-header .actions {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        
        .content-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
            margin-bottom: 20px;
        }
        
        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .content-card .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: bold;
            padding: 15px;
            border: none;
        }
        
        .content-card .card-body {
            padding: 20px;
        }
        
        .content-card .card-footer {
            background-color: white;
            border-top: 1px solid #f0f0f0;
            padding: 15px;
        }
        
        .badge-level {
            padding: 5px 10px;
            border-radius: 50px;
            font-weight: normal;
            margin-right: 10px;
        }
        
        .badge-iniciante {
            background-color: #38b000;
            color: white;
        }
        
        .badge-intermediario {
            background-color: #ffaa00;
            color: white;
        }
        
        .badge-avancado {
            background-color: #e63946;
            color: white;
        }
        
        .topic-card {
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
            border-radius: 0 5px 5px 0;
            transition: all 0.3s;
        }
        
        .topic-card:hover {
            background-color: #f0f0f0;
            transform: translateX(5px);
        }
        
        .exercise-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
            transition: all 0.3s;
        }
        
        .exercise-item:last-child {
            border-bottom: none;
        }
        
        .exercise-item:hover {
            background-color: #f8f9fa;
        }
        
        .video-card {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }
        
        .video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .video-thumbnail {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }
        
        .video-duration {
            position: absolute;
            bottom: 75px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        
        .video-info {
            padding: 15px;
            background-color: white;
            border-radius: 0 0 10px 10px;
        }
        
        .video-title {
            font-weight: bold;
            margin-bottom: 5px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 48px;
        }
        
        .video-channel {
            color: #6c757d;
            font-size: 14px;
        }
        
        .partner-card {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }
        
        .partner-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .partner-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }
        
        .partner-info {
            flex-grow: 1;
        }
        
        .partner-name {
            font-weight: bold;
            margin-bottom: 0;
        }
        
        .partner-status {
            font-size: 14px;
            color: #6c757d;
        }
        
        .partner-actions {
            display: flex;
            gap: 10px;
        }
        
        .nav-tabs .nav-link {
            color: var(--dark-color);
            border: none;
            padding: 10px 20px;
            border-radius: 5px 5px 0 0;
            font-weight: 500;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: white;
            border-bottom: 3px solid var(--primary-color);
        }
        
        .tab-content {
            background-color: white;
            border-radius: 0 0 10px 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        /* Responsive styles */
        @media (max-width: 991.98px) {
            .sidebar {
                margin-left: -250px;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .main-content {
                width: 100%;
                margin-left: 0;
            }
            
            .main-content.active {
                margin-left: 250px;
                width: calc(100% - 250px);
            }
            
            .overlay {
                display: none;
                position: fixed;
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.7);
                z-index: 998;
                opacity: 0;
                transition: all 0.5s ease-in-out;
                top: 0;
                left: 0;
            }
            
            .overlay.active {
                display: block;
                opacity: 1;
            }
        }
        .article-container {
    background: white;
    border-radius: 20px;
    padding: 50px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    max-width: 1400px; /* Largura aumentada */
    margin: 0 auto 80px;
}

.article-container h1 {
    font-size: 3rem;
    margin-bottom: 2rem;
    color: var(--dark-color);
    font-weight: 700;
    border-bottom: 3px solid var(--primary-color);
    padding-bottom: 0.5rem;
}

.article-container h2 {
    font-size: 2rem;
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    color: var(--primary-color);
    font-weight: 600;
    border-bottom: 2px solid #e0e0e0;
    padding-bottom: 0.5rem;
}

.article-container h3 {
    font-size: 1.6rem;
    margin-top: 2rem;
    margin-bottom: 0.8rem;
    color: var(--secondary-color);
    font-weight: 600;
}

.article-container p {
    margin-bottom: 1.5rem;
    font-size: 1.2rem;
    line-height: 1.8;
}

.article-container ul,
.article-container ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.article-container li {
    margin-bottom: 0.6rem;
}

.article-container blockquote {
    border-left: 5px solid var(--accent-color);
    background: #f9f9f9;
    padding: 1rem 1.5rem;
    font-style: italic;
    color: #555;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.article-container img {
    max-width: 100%;
    height: 1000px;
    border-radius: 12px;
    margin: 2rem 0;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.article-container figcaption {
    text-align: center;
    font-size: 1rem;
    color: #777;
    margin-top: 0.5rem;
    margin-bottom: 2rem;
}

.article-meta {
    display: flex;
    align-items: center;
    margin-bottom: 2rem;
    color: #666;
    font-size: 1rem;
}

.article-meta .divider {
    margin: 0 12px;
}

.article-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 3rem;
    padding-top: 1.5rem;
    border-top: 1px solid #eee;
}

.article-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 2rem;
}

.article-tag {
    background-color: #f5f5f5;
    color: #555;
    padding: 8px 14px;
    border-radius: 25px;
    font-size: 0.9rem;
    transition: all 0.3s;
}

.article-tag:hover {
    background-color: var(--accent-color);
    color: #fff;
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
        
        <!-- Cabeçalho do conteúdo -->
        <div class="content-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>{{$dados_topico->materia}}: {{$dados_topico->name}}</h2>
                    <p class="mb-0">Pesquisado em 15/05/2023 • 48 recursos encontrados</p>
                </div>
                <div class="actions">
                    <button class="btn btn-light"><i class="bi bi-share"></i> Compartilhar</button>
                </div>
            </div>
        </div>
        
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
  <!-- Botão de Delete -->
  <li class="nav-item" role="presentation">
    <button class="nav-link text-danger" id="delete-tab" data-bs-toggle="modal" data-bs-target="#deleteModal" type="button" role="tab" aria-controls="delete" aria-selected="false">
      <i class="bi bi-trash"></i> Delete
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
        <a href="/delete/{{$dados_topico->id}}"type="button" class="btn btn-danger">Deletar</a>
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
                                <i class="bi bi-info-circle"></i> Um breve resumo sobre Álgebra Linear
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
                                                <span class="badge badge-level badge-iniciante me-2">Iniciante</span> Fundamentos de {{$dados_topico->name}}
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#levelAccordion">
                                            <div class="accordion-body">
                                                <ul>
                                                    @foreach ($materials as $material)
                                                        @if ($material->level == 1)
                                                            <li><i class="bi bi-file-earmark-text"></i> <a href="/conteudo/{{$dados_topico->id}}/{{$material->id}}/1">{{$material->name_material}}</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <span class="badge badge-level badge-intermediario me-2">Intermediário</span> Aprofundamento em {{$dados_topico->name}}
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#levelAccordion">
                                            <div class="accordion-body">
                                                <ul>
                                                    @foreach ($materials as $material)
                                                        @if ($material->level == 2)
                                                            <li><i class="bi bi-file-earmark-text"></i> <a href="/conteudo/{{$dados_topico->id}}/{{$material->id}}/2">{{$material->name_material}}</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <span class="badge badge-level badge-avancado me-2">Avançado</span> Tópicos Avançados em {{$dados_topico->name}}
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#levelAccordion">
                                            <div class="accordion-body">
                                                <ul>
                                                @foreach ($materials as $material)
                                                        @if ($material->level == 3)
                                                            <li><i class="bi bi-file-earmark-text"></i> <a href="/conteudo/{{$dados_topico->id}}/{{$material->id}}/3">{{$material->name_material}}</a></li>
                                                        @endif
                                                    @endforeach                                                </ul>
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
            <input type="hidden" name="id_topico" value="{{$dados_topico->id}}">
            <input type="hidden" name="name_topico" value="{{$dados_topico->name}}">
          <div class="mb-3">
            <label for="materialTitulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="materialTitulo" name="titulo" placeholder="Digite o título">
          </div>
          <div class="mb-3">
            <label for="materialDescricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="materialDescricao" rows="3" name="descricao" placeholder="Digite a descrição"></textarea>
          </div>
          <div class="mb-3">
            <label for="materialNivel" class="form-label">Nível</label>
            <select class="form-select" name="nivel" id="materialNivel">
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
                    <h1>{{$dados_topico->name}}</h1>

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
                    <h4>Exercícios de {{$dados_topico->name}}</h4>
                    
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

<!-- Scripts necessários do Bootstrap -->
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
            method: 'POST',
            body: formData,
            headers: {
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
</script>





                <!-- <div class="exercise-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Determinante de Matriz 3x3</h5>
                        <span class="badge badge-level badge-iniciante">Iniciante</span>
                    </div>
                    <p>Calcule o determinante da matriz A = [[2, 1, 3], [4, -2, 5], [1, 0, 2]].</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary me-2">Matrizes</span>
                            <span class="badge bg-secondary">Determinantes</span>
                        </div>
                        <button class="btn btn-sm btn-primary">Resolver Exercício</button>
                    </div>
                </div>
                
                <div class="exercise-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Sistema de Equações Lineares</h5>
                        <span class="badge badge-level badge-intermediario">Intermediário</span>
                    </div>
                    <p>Resolva o sistema de equações lineares usando o método de eliminação de Gauss-Jordan: 2x + y - z = 8, 3x - 5y + 2z = -1, x + y + z = 2.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary me-2">Sistemas Lineares</span>
                            <span class="badge bg-secondary">Método de Gauss</span>
                        </div>
                        <button class="btn btn-sm btn-primary">Resolver Exercício</button>
                    </div>
                </div>
                
                <div class="exercise-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Autovalores e Autovetores</h5>
                        <span class="badge badge-level badge-intermediario">Intermediário</span>
                    </div>
                    <p>Encontre os autovalores e autovetores da matriz B = [[3, 1], [1, 3]].</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary me-2">Autovalores</span>
                            <span class="badge bg-secondary">Autovetores</span>
                        </div>
                        <button class="btn btn-sm btn-primary">Resolver Exercício</button>
                    </div>
                </div>
                
                <div class="exercise-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Diagonalização de Matriz</h5>
                        <span class="badge badge-level badge-avancado">Avançado</span>
                    </div>
                    <p>Verifique se a matriz C = [[2, 1, 0], [0, 3, 0], [0, -1, 1]] é diagonalizável. Em caso afirmativo, encontre a matriz diagonal D e a matriz de mudança de base P.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary me-2">Diagonalização</span>
                            <span class="badge bg-secondary">Mudança de Base</span>
                        </div>
                        <button class="btn btn-sm btn-primary">Resolver Exercício</button>
                    </div>
                </div>
                 -->
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
                    <input type="hidden" name="topico" value="{{$dados_topico->name}}">
                    <input type="hidden" name="id_topico" value="{{$dados_topico['id']}}">
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
       
         
            
            <!-- Aba Parceiros -->
            <div class="tab-pane fade" id="partners" role="tabpanel" aria-labelledby="partners-tab">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h4>Parceiros de Estudo</h4>
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
                    <div class="card-body">
                        <div class="partner-card">
                            <img src="https://via.placeholder.com/50" class="partner-avatar" alt="Avatar">
                            <div class="partner-info">
                                <h5 class="partner-name">Ana Silva</h5>
                                <p class="partner-status">Online • Estudando Álgebra Linear há 3 meses</p>
                            </div>
                            <div class="partner-actions">
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-chat"></i> Mensagem</button>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-calendar-event"></i> Agendar</button>
                            </div>
                        </div>
                    
                    </div>
                </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="content-card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://via.placeholder.com/50" class="partner-avatar" alt="Avatar">
                                    <div class="ms-3">
                                        <h5 class="mb-1">Mariana Santos</h5>
                                        <p class="text-muted mb-0">Estudante de Matemática</p>
                                    </div>
                                </div>
                                <p>Focada em teoria de espaços vetoriais e aplicações em geometria. Posso ajudar com exercícios de diagonalização de matrizes.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-secondary">87% compatível</span>
                                    <button class="btn btn-sm btn-primary"><i class="bi bi-person-plus"></i> Adicionar</button>
                                </div>
                            </div>
                        </div>
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
            <div class="modal-body">
                <div class="mb-3">
                    <label for="partnerEmail" class="form-label">Email do Parceiro</label>
                    <input type="email" class="form-control" id="partnerEmail" placeholder="email@exemplo.com">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Enviar Convite</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

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
    });
</script>
</body>
</html>


