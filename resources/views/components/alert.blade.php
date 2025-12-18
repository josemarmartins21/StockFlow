<div>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
           <p class="erro"> {{ $error }} </p>
        @endforeach
    @endif
</div>

@if (session('erro'))
    <p class="erro"> {{ session('erro') }} </p>
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