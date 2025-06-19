@extends('layouts.app') {{-- 1. Estende o layout pai --}}

@section('title')
EduSearch - {{ $data_topic->name }}
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endsection

@section('content')
@section('header_content')
<div class="col-md-8">
    <h1 class="dashboard-title">
        {{$data_topic->name}}
    </h1>
    <p class="dashboard-subtitle"></p>
</div>
@endsection
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
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
