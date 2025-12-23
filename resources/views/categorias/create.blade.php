@extends('layouts.app')

@section('title', 'Registrar Categoria - StockFlow')
    
@section('content')
<section id="categorias-create">
    <x-alert />
    <h2>Nova categoria</h2>

    <form action="{{ route('categorias.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-categoria">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" placeholder="Nome *" value="{{ old('name') }}">
        </div>
        
        <div class="form-categoria">
            <label for="image">Imagem</label>
            <input type="file" name="image" id="image" class="input-file" value="{{ old('image') }}">
        </div>

        <div class="form-categoria-desc">
            <label for="desc">Descricao</label>
            <textarea name="desc" id="desc" cols="30" rows="10">
                {{ old('desc') }}
            </textarea>
        </div>

        <button type="submit">
            Registrar
        </button>
    </form>
</section>
@endsection