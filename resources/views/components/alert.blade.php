@if ($errors->any())
    @foreach ($errors->all() as $error)
       <p> {{ $error }} </p>     
    @endforeach
@endif

@if (session('erro'))
    <p> {{ session('erro') }} </p>
@endif

@if (session('sucesso'))
   {{--  <script>
    document.addEventListener('DOMContentLoaded', () => { 
            Swal.fire({
            title: "Pronto",
            text: "{{ session('sucesso') }}",
            icon: "success"
       });
    });
    </script> --}}
    <p> {{ session('sucesso') }} </p>

@endif