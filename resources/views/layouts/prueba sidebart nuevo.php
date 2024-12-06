@php
    use App\Http\Controllers\MenuController;
@endphp

<style>
    .main-sidebar {
        background-color: var(--background);
        color: var(--txt);
    }

    .nav-treeview {
        display: none; /* Ocultar submenús por defecto */
    }

    .menu-open > .nav-treeview {
        display: block; /* Mostrar submenús cuando están abiertos */
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .menu-open > .nav-treeview {
    display: block;
    transition: all 0.3s ease-in-out;
}
.nav-treeview {
    display: none;
}

</style>
<aside class="main-sidebar elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <i class="brand-image img-circle fas fa-teeth" style="opacity: .8"></i>
        <span class="h4">Smile-Clinic</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
                <img src="https://dentalclinicapp.com/uploads/female.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                
                <h6 class="h4">{{ Auth::user()->name }}</h6>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            @foreach (MenuController::GetMenuUser(Auth::id()) as $menu)
    @if (empty($menu->father_id)) <!-- Procesar solo menús principales -->
        <li class="nav-item {{ !empty($menu->children) ? 'has-treeview' : '' }}">
            <a class="nav-link {{ $menu->view_start ? 'active' : '' }}" 
               style="cursor: pointer;" 
               @if ($menu->view != '.')
                    onclick="CargarContenido('{{ url($menu->view) }}', 'content-wrapper')"
               @endif>
                <i class="nav-icon {{ $menu->icon_menu }}"></i>
                <p>{{ $menu->module }}</p>
            </a>
            @if (!empty($menu->children))
                <ul class="nav nav-treeview">
                    @foreach ($menu->children as $subMenu)
                        <li class="nav-item">
                            <a class="nav-link" style="cursor: pointer;" 
                               onclick="CargarContenido('{{ url($subMenu->view) }}', 'content-wrapper')">
                                <i class="{{ $subMenu->icon_menu }} nav-icon"></i>
                                <p>{{ $subMenu->module }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endif
@endforeach


                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" style="cursor: pointer;">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Cerrar Sesión</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $(".nav-link").on('click', function(event) {
        event.preventDefault(); // Prevenir comportamiento por defecto

        // Actualizar enlaces activos
        $(".nav-link").removeClass('active');
        $(this).addClass('active');

        // Contraer otros menús y expandir el seleccionado
        $(".has-treeview").not($(this).closest(".has-treeview")).removeClass("menu-open");
        $(this).closest(".has-treeview").toggleClass("menu-open");

        // Cargar contenido dinámico si tiene vista asignada
        let url = $(this).attr('onclick')?.match(/'([^']+)'/);
        if (url && url[1]) {
            CargarContenido(url[1], 'content-wrapper');
        }
    });
});

function CargarContenido(url, contenedor) {
    console.log(contenedor, url);
    if (!url) {
        alert("Error: URL no válida");
        return;
    }

    // Cargar el contenido en el contenedor especificado
    $('#' + contenedor).load(url, function(response, status, xhr) {
        if (status === "error") {
            alert("Error al cargar el contenido: " + xhr.statusText);
        }
    });
}

</script>