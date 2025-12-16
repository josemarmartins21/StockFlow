<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        <!-- Estilos CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

        <!-- Font Awesome - Icones -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Sweet Alert via Vite -->
        @vite(['resources/js/app.js'])
      {{--   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"> --}}
    </head>
    <body>
        <main> <!-- Secção main que engloba todo os HTML do site -->
            <section id="sidebar">
                <h1>Dashboard</h1>
    
                <nav>
                    <ul>
                        <li><a href="{{ route('home') }}"> Home <i class="fa-solid fa-house"></i></a></li>
                        <li><a href="#">Dashboard <i class="fa-solid fa-grip"></i></a></li>
                        <li><a href="{{ route('produtos.create') }}"> Adicionar produtos <i class="fa-solid fa-wine-bottle"></i></i></a></li>
                        <li><a href="#"> Ver categorias <i class="fa-solid fa-table-cells"></i> </a></li>
                        <li><a href="#">Ver produtos em falta <i class="fa-brands fa-product-hunt"></i></a></li>
                        <li><a href="#">Atualizar o estoque actual <i class="fa-solid fa-arrow-trend-up"></i></i></a></li>
                        <li><a href="#">Definições <i class="fa-solid fa-gear"></i> </a></li>
                    </ul>
                    <div class="logout">
                        <a href="{{ route('auth.logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
                    </div>
                </nav>
            </section><!-- Fim sidebar -->
            <section id="principal">
                        <header>    
                            <h1>Olá, <span>Josimar</span></h1>

                            <div id="form-search">
                                <form action="" method="get">
                                    <input type="search" name="" id="" placeholder="Pesquise qualquer coisa..">
                                    <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                                </form>
                            </div>
                        </header>
                        <section id="conteudo-container">
                            @yield('content')
                        </section>
                        <footer>
                            <p>&copy;Todos os direitos reservados 2025</p>
                        </footer>
            </section> <!-- Fim da secção principal -->
        </main>
        <footer></footer>
    </body>
</html>