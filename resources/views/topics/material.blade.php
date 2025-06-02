@extends('layouts.app') {{-- 1. Estende o layout pai --}}

@section('title')
    EduSearch - {{ $data_topic->name }}
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endsection

@section('content')
    <!-- Overlay para mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Conteúdo Principal -->
    <div class="container-fluid">
        <!-- Cabeçalho do conteúdo -->
        <div class="content-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>{{ $data_topic->name }}: {{ $data_topic->matter }}</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Artigo principal -->
                <div class="article-container">
                    <h1>{{ $data_material->name_material }}</h1>

                    <div>
                        {!! $textoMD !!}

                    </div>

                    <div class="article-actions">
                        <form action="{{ route('material.destroy', $data_material->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash"></i> Deletar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="related-content">
                    <h3><i class="bi bi-journal-text"></i> Exercícios</h3>
                    @foreach ($exercises as $exercicio)
                        <div class="related-item">
                            <i class="bi bi-pencil-square"></i>
                            <a href="#">{{ $exercicio->titulo }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
