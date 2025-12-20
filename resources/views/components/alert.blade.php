<div>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
           <p class="erro"> {{ $error }} </p>
        @endforeach
    @endif
</div>

@if (session('erro'))
       <script>
    document.addEventListener('DOMContentLoaded', () => { 
            Swal.fire({
            title: "Erro",
            text: "{{ session('erro') }}",
            icon: "warning"
       });
    });
    </script>
@endif

@if (session('sucesso'))
    <script>
    document.addEventListener('DOMContentLoaded', () => { 
            Swal.fire({
            title: "Pronto",
            text: "{{ session('sucesso') }}",
            icon: "success"
       });
    });
    </script>
@endif