<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
        <link rel="icon" sizes="32x32" href="{{ asset('logo_edusearch.png') }}" type="image/png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSearch - Segunda Guerra Mundial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

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
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Artigo principal -->
                    <div class="article-container">
                        <h1>{{$data_topic->name}}</h1>

                        <div>
                            {!! $textoMD !!}

                        </div>

                        <div class="article-actions">
                            <a href="/excluir_material/{{$data_topic->id}}/{{$data_material->id}}"class="btn btn-outline-danger"><i class="bi bi-trash"></i> Deletar</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">

                    <div class="related-content">
                        <h3><i class="bi bi-journal-text"></i> Exercícios</h3>
                        @foreach ($exercises as $exercicio)
                        <div class="related-item">
                            <i class="bi bi-pencil-square"></i>
                            <a href="#">{{$exercicio->titulo}}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

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

            // Scroll suave para os links do índice
            document.querySelectorAll('.table-of-contents a').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    window.scrollTo({
                        top: targetElement.offsetTop - 100
                        , behavior: 'smooth'
                    });
                });
            });
        });

    </script>
</body>
</html>
