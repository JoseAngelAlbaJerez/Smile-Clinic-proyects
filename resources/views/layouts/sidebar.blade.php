<div id="sidebar-wrapper">
    <ul class="sidebar-nav " id="menu">
        <!-- Sección de Inicio -->
        <li>
            <a class="mt-4 {{ Request::routeIs('home') ? 'active' : '' }}" href="{{route('home')}}">
                <span class="fa-stack fa-lg"><i class="fa fa-home fa-stack-1x"></i></span> Inicio
            </a>
        </li>

        <!-- Sección de Clínica -->
        <li class="{{ Request::is('RX*', 'budget*', 'insurance*') ? 'open' : '' }}">
            <a href="#"><span class="fa-stack fa-lg"><i class="fa fa-hospital fa-stack-1x"></i></span> Clínica</a>
            <ul class="{{ Request::is('RX*') || Request::is('budget*') || Request::is('insurance*') ? '' : 'd-none' }}"
                style="list-style-type:none;">
                <li>
                    <a href="{{ route('RX.index') }}" class="{{ Request::routeIs('RX.index') ? 'active' : '' }}">
                        <span class="fa-stack fa-lg"><i class="fas fa-briefcase-medical fa-stack-1x"></i></span>
                        Medicamentos
                    </a>
                </li>
                <li>
                    <a href="{{ route('budget.index') }}"
                        class="{{ Request::routeIs('budget.index') ? 'active' : '' }}">
                        <span class="fa-stack fa-lg"><i class="fa fa-file-invoice fa-stack-1x"></i></span>
                        Presupuestos
                    </a>
                </li>
                <li>
                    <a href="{{ route('insurance.create') }}"
                        class="{{ Request::routeIs('insurance.create') ? 'active' : '' }}">
                        <span class="fa-stack fa-lg"><i class="fa fa-shield-alt fa-stack-1x"></i></span> Seguro Médico
                    </a>
                </li>
            </ul>
        </li>
        <!-- Sección de Pacientes -->
        <li class="{{ Request::is(['patient*', 'odontograph*', 'RX.create*']) ? 'open' : '' }}">
            <a href="#"><span class="fa-stack fa-lg"><i class="fa fa-user fa-stack-1x"></i></span> Pacientes</a>
            <ul class="{{ Request::is(['patient*', 'odontograph*', 'RX.create*']) ? '' : 'd-none' }}"
                style="list-style-type:none;">
                <li>
                    <a href="{{ route('patient.index') }}"
                        class="{{ Request::routeIs('patient.index') ? 'active' : '' }}">
                        <span class="fa-stack fa-lg"><i class="fas fa-briefcase-medical fa-stack-1x"></i></span> Mis
                        Pacientes
                    </a>
                </li>
                <li>
                    <a href="{{ route('odontograph.index') }}"
                        class="{{ Request::routeIs('odontograph.index') ? 'active' : '' }}">
                        <span class="fa-stack fa-lg"><i class="fa fa-teeth fa-stack-1x"></i></span> Odontograma
                    </a>
                </li>
                <li>
                    <a href="{{ route('RX.create') }}" class="{{ Request::routeIs('RX.create') ? 'active' : '' }}">
                        <span class="fa-stack fa-lg"><i class="fa fa-prescription fa-stack-1x"></i></span> Recetar
                    </a>
                </li>
            </ul>
        </li>


        <!-- Sección de Citas -->
        <li class="{{ Request::is('events*') ? 'open' : '' }}">
            <a href="#"><span class="fa-stack fa-lg"><i class="far fa-calendar-check fa-stack-1x"></i></span> Citas</a>
            <ul class="{{ Request::is('events*') ? '' : 'd-none' }}" style="list-style-type:none;">
                <li><a href="{{route('events.list')}}" class="{{ Request::routeIs('events.list') ? 'active' : '' }}">
                        <span class="fa-stack fa-lg"><i class="fas fa-calendar fa-stack-1x"></i></span> Calendario
                    </a></li>
                <li><a href="{{route('events.index')}}" class="{{ Request::routeIs('events.index') ? 'active' : '' }}">
                        <span class="fa-stack fa-lg"><i class="fas fa-calendar-alt fa-stack-1x"></i></span> Mis Citas
                    </a></li>
                <li><a href="{{route('events.create')}}"
                        class="{{ Request::routeIs('events.create') ? 'active' : '' }}">
                        <span class="fa-stack fa-lg"><i class="fa fa-calendar-plus fa-stack-1x"></i></span> Crear Cita
                    </a></li>
            </ul>
        </li>

        <!-- Sección de Finanzas -->
        <li class="{{ Request::is('CXC*', 'income*', 'expenses*') ? 'open' : '' }}">
            <a href="#"><span class="fa-stack fa-lg"><i class="fa fa-money-bill fa-stack-1x"></i></span> Finanzas</a>
            <ul class="{{ Request::is('CXC*', 'income*', 'expenses*') ? '' : 'd-none' }}" style="list-style-type:none;">
                <li><a href="{{route('CXC.index')}}" class="{{ Request::routeIs('CXC.index') ? 'active' : '' }}">
                        <span class="fa-stack fa-lg"><i class="fas fa-money-bill fa-stack-1x"></i></span> Cobros
                    </a></li>
                <li><a href="{{route('income.index')}}" class="{{ Request::routeIs('income.index') ? 'active' : '' }}">
                        <span class="fa-stack fa-lg"><i class="fa fa-cash-register fa-stack-1x"></i></span> Ingresos
                    </a></li>
                <li><a href="{{route('expenses.index')}}"
                        class="{{ Request::routeIs('expenses.index') ? 'active' : '' }}">
                        <span class="fa-stack fa-lg"><i class="fa fa-comments-dollar fa-stack-1x"></i></span> Egresos
                    </a></li>
            </ul>
        </li>

        <!-- Seccion de Reportes -->
        <li>
            <a href="{{route('report.index')}}" class="{{ Request::routeIs('report.index') ? 'active' : '' }}">
                <span class="fa-stack fa-lg"><i class="	fa fa-file-pdf fa-stack-1x"></i></span> Reportes
            </a>
        </li>
        <!-- Sección de Ajustes -->
        <li>
            <a href="{{route('setting.index')}}" class="{{ Request::routeIs('setting.index') ? 'active' : '' }}">
                <span class="fa-stack fa-lg"><i class="fa fa-palette fa-stack-1x"></i></span> Temas
            </a>
        </li>
         <!-- Sección de Roles -->
         <li>
            <a href="{{route('user.index')}}" class="{{ Request::routeIs('user.index') ? 'active' : '' }}">
                <span class="fa-stack fa-lg"><i class="fa fa-user fa-stack-1x"></i></span> Roles y Usuarios
            </a>
        </li>
    </ul>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
$(document).ready(function() {
    // Inicialmente oculta todos los submenús
    $('#menu ul').hide();

    // Muestra los submenús de los elementos que tienen la clase 'open'
    $('#menu li.open > ul').css({
        display: 'block',
        maxHeight: '500px', // Ajusta según el contenido
        opacity: '1'
    });

    // Verifica si estamos en la ruta 'RX.create'
    if (window.location.pathname.includes('/RX/create')) {
        // Cierra todos los submenús visibles
        $('#menu li.open').removeClass('open').find('ul').css({
            maxHeight: '0',
            opacity: '0'
        });

        // Muestra solo el submenú de Pacientes
        $('#menu li:has(a[href*="RX.create"])').closest('ul').show().css({
            maxHeight: '500px',
            opacity: '1'
        }).parent('li').addClass('open');
    }

    $('#menu li a').click(function(e) {
        var $this = $(this);
        var checkElement = $this.next('ul');

        if (checkElement.length) {
            e.preventDefault(); // Previene la acción del enlace si tiene submenú

            var $parentLi = $this.parent('li');

            if (checkElement.is(':visible')) {
                // Cierra el submenú con transición
                checkElement.css({
                    maxHeight: '0',
                    opacity: '0'
                });

                setTimeout(function() {
                    checkElement.hide(); // Esconde completamente después de la transición
                }, 500); // Tiempo de la transición

                $parentLi.removeClass('open');
            } else {
                // Cierra otros submenús visibles
                $('#menu ul:visible').css({
                    maxHeight: '0',
                    opacity: '0'
                });

                setTimeout(function() {
                    $('#menu ul:visible').hide();
                }, 500);

                $('#menu li').removeClass('open');

                // Abre el submenú con transición
                checkElement.show().css({
                    maxHeight: '500px', // Ajusta según el contenido
                    opacity: '1'
                });

                $parentLi.addClass('open');
            }
        }
    });
});
</script>




<style>
.active {
    font-weight: bold;
    backdrop-filter: brightness(90%);
}

.open>ul {
    display: block !important;
}

.d-none {
    display: none;
}

.sidebar-nav li a span {
    font-size: 2em;
    /* Puedes ajustar el valor según tus preferencias */
}

.nav-pills>li>a {
    border-radius: 0;
}


#wrapper {
    padding-left: 0;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
    overflow: hidden;
}

#wrapper.toggled {
    padding-left: 230px;
    overflow: hidden;
}


#sidebar-wrapper {
    top: 9% !important;
    bottom: 0;
    z-index: 1000;
    position: absolute;
    left: 230px;
    width: 0;

    margin-left: -230px;

    background: var(--background);

    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}


#wrapper.toggled #sidebar-wrapper {
    width: 230px;
}

#page-content-wrapper {
    position: absolute;
    padding: 15px;
    width: 100%;
    overflow-x: hidden;
}

.xyz {
    min-width: 360px;
}

#wrapper.toggled #page-content-wrapper {
    position: relative;
    margin-right: 0px;
}

.fixed-brand {
    width: auto;
}

/* Sidebar Styles */

.sidebar-nav {
    position: absolute;
    top: 0;
    width: 230px;
    margin: 0;
    padding: 0;
    list-style: none;
    margin-top: 2px;
}

.sidebar-nav li {
    text-indent: 15px;
    line-height: 40px;
}

.sidebar-nav li a {
    display: block;
    text-decoration: none;
    color: var(--txt) !important;
}

.sidebar-nav li a:hover {
    text-decoration: none;
    color: var(--txt) !important;
    background: rgba(255, 255, 255, 0.2);
    border-left: gray 2px solid;
}

.sidebar-nav li a:active,
.sidebar-nav li a:focus {
    text-decoration: none;
}

.sidebar-nav>.sidebar-brand {
    height: 65px;
    font-size: 18px;
    line-height: 60px;
}

.sidebar-nav>.sidebar-brand a {
    color: #999999;
}

.sidebar-nav>.sidebar-brand a:hover {
    color: var(--txt) !important;
    background: none;
}

.no-margin {
    margin: 0;
}

@media (min-width: 768px) {
    #wrapper {
        padding-left: 230px;
    }

    #wrapper {
        display: flex;

        overflow: hidden;
    }

    #sidebar-wrapper {
        height: 100%;
        overflow-y: auto;
        height: 100vh !important;
        padding-bottom: 200%;
    }

    #page-content-wrapper {
        flex-grow: 1;
        height: 100%;
        overflow-y: auto;
        padding: 15px;
    }

    .fixed-brand {
        width: 230px;
    }

    #wrapper.toggled {
        padding-left: 0;
    }

    #sidebar-wrapper {
        width: 230px;
    }

    #wrapper.toggled #sidebar-wrapper {
        width: 230px;
    }

    #wrapper.toggled-2 #sidebar-wrapper {
        width: 50px;
    }

    #wrapper.toggled-2 #sidebar-wrapper:hover {
        width: 230px;
    }

    #page-content-wrapper {
        padding: 20px;
        position: relative;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    #wrapper.toggled #page-content-wrapper {
        position: relative;
        margin-right: 0;
        padding-left: 230px;
    }

    #wrapper.toggled-2 #page-content-wrapper {
        position: relative;
        margin-right: 0;
        margin-left: -200px;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
        width: auto;
    }

    /* Transiciones para la apertura y cierre del submenú */
    .sidebar-nav li ul {
        max-height: 0;
        /* Altura inicial cero cuando está cerrado */
        opacity: 0;
        /* Comienza siendo invisible */
        overflow: hidden;
        /* Oculta el contenido que no cabe cuando está cerrado */
        transition: max-height 0.5s ease, opacity 0.5s ease;
        /* Transiciones para max-height y opacity */
    }

    /* Cuando el submenú está abierto */
    .sidebar-nav li.open ul {
        max-height: 500px;
        /* Altura suficiente para que todo el contenido del submenú sea visible */
        opacity: 1;
        /* Hace visible el submenú */
        overflow: visible;
        /* Permite ver todo el contenido cuando está abierto */
        transition: max-height 0.5s ease, opacity 0.5s ease;
        /* Transición para la apertura */
    }

    /* Transición para los enlaces al hacer hover */
    .sidebar-nav li a:hover {
        background: rgba(255, 255, 255, 0.3);
        border-left: gray 3px solid;
        transition: background 0.3s ease, border-left 0.3s ease;
    }

}
</style>