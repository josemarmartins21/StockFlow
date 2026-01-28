@extends('layouts.app')

@section('title', $categoria->name)
    
@section('content')
<section id="categorias-create">
    <x-alert />
    <h2>Atualizar {{ $categoria->name }} </h2>

    <form action="{{ route('categorias.update', ['categoria' => $categoria->id]) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-categoria">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" placeholder="Nome *" value="{{ old('name', $categoria->name) }}">
        </div>
        
        <div class="form-categoria">
            <label for="image">Imagem</label>
            <input type="file" name="image" id="image" class="input-file" value="{{ old('image', $categoria->image) }}">
        </div>

        <div class="form-categoria-desc">
            <label for="desc">Descrição</label>
            <textarea name="desc" id="desc" cols="30" rows="10">
                {{ old('desc', $categoria->desc) }}
            </textarea>
        </div>

        <button type="submit">
            Registrar
        </button>
    </form>
</section>
@endsection