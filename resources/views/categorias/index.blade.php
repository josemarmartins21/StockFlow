@extends('layouts.app')

@section('title', 'Categorias - StockFlow')
    
@section('content')
<section id="categorias-container">

    <x-alert />

    <h2>Categorias</h2>
    <div id="categorias-menu">
        <form action="{{ route('categorias.index') }}" method="get">
            <div class="form-search">
                <input type="search" name="pesquisa" id="pesquisa" placeholder="Busque por uma categoria" class="pesquisa">
            </div>
        </form>

        <div id="categoria-aco">
            <a href="{{ route('categorias.create') }}">Nova categoria <i class="fa-solid fa-square-plus"></i></a>
        </div>
    </div>

    <div id="categorias-index">
        @forelse ($categorias as $categoria)
            <div href="{{-- {{ route('categorias.show', ['categoria' => $categoria->id]) }} --}}" class="categoria" rel="next">
                <div class="categoria-info">
                    <div id="acoes-title">
                        <h3>{{ ucwords($categoria->name) }}</h3>

                        <span>
                            <a href="{{ route('categorias.edit', ['categoria' => $categoria->id]) }}" class="edit"> <i class="fa-solid fa-pen-to-square"></i></a> 

                            <form action="{{ route('categorias.destroy', ['categoria' => $categoria->id]) }}" method="POST" id="form-delete">
                                        @csrf
                                        @method("Delete")
                                        
                                        <button type="submit" class="btn-delete btn-delete-ver-mais" onclick="return confirm('Tem a certeza que pretende eliminar?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                            </form>


                        </span>
                    </div>
                    <p>
                        {{ substr($categoria->desc, 0, 75) }}</p>
                    </p>
                </div>
                <a href="{{ route('categorias.show', ['categoria' => $categoria->id]) }}" class="ver-mais">ver</a>
            </div>         
        @empty
            <img src="{{ asset('assets/imagens/ilustrations/void.png') }}" alt="Nada encontrado">
        @endforelse
        
    </div>
    @if (! $houvePesquisa)
        {{-- Link de páginas de categorias --}}
        {{ $categorias->links() }}
    @endif
</section>
@endsection