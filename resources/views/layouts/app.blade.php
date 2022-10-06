<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@hasSection('title') @yield('title') | @endif {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
        {{-- //! by me --}}
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
     <script src="sweetalert2.all.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @livewireStyles
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     {{-- //! by me --}}
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
     {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

	 
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
					@auth()
                    <ul class="navbar-nav mr-auto">
						<!--Nav Bar Hooks - Do not delete!!-->
						{{-- <li class="nav-item">
                            <a href="{{ url('/quedanfacturas') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Gestiones</a> 
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ url('/quedans') }}" class="nav-link"><i style="color: rgb(178, 191, 199)" class="fab fa-laravel text-info"></i> Quedans</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/facturas') }}" class="nav-link"><i style="color: rgb(178, 191, 199)" class="fas fa-file-invoice-dollar"></i> Facturas</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/proveedores') }}" class="nav-link"><i style="color: rgb(178, 191, 199)" class="fas fa-hands-helping"></i>Proveedores</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/fuentes') }}" class="nav-link" ><i style="color: rgb(178, 191, 199)" class="fas fa-money-bill-wave"></i>Fuentes</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/proyectos') }}" class="nav-link"><i style="color: rgb(178, 191, 199)" class="fas fa-project-diagram"></i></i> Proyectos</a> 
                        </li>
                    </ul>
					@endauth()
					
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                                <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @livewireScripts

        <main class="py-2">
            @yield('content')
        </main>
    </div>

    

<script type="text/javascript">
	window.livewire.on('closeModal', () => {
		$('#createDataModal').modal('hide');
		$('#updateModal').modal('hide');
	});
</script>

<script>
    window.addEventListener('modal', event => { 
        Swal.fire({
        title: event.detail.message,
        text: event.detail.text,
        icon: event.detail.icon,
        timer: event.detail.timer,
        toast: event.detail.toast,
        // position: event.detail.position,
        
        });

        // swal('Any fool can use a computer')
    });

//     window.addEventListener('confirm', event => { 
//     Swal.fire({
//       title: event.detail.message,
//       text: event.detail.text,
//       icon: event.detail.type,
//     //   buttons: event.detail.buttons,
//     //   dangerMode: event.detail.dangerMode,
//       showCancelButton: true,
//     //   buttons: true,
//     //   dangerMode: true,
//     })
//     .then((willDelete) => {
//       if (willDelete) {
//         window.livewire.emit('hidingfact');
//       }
//     });
// });

    window.addEventListener('confirm', event => { 
        Swal.fire({
            title: event.detail.message,
            text: event.detail.text,
            icon: event.detail.type,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, eliminar!'
            // cancelButtonText: 'No, cancel!'
            }).then((result) => {
            if (result.isConfirmed) {
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )

                window.livewire.emit('hidingfact');
            }
            })
    });


</script>

@stack('scripts') 

</body>
</html>
