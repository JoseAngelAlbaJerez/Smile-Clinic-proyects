@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')


<style>
.container {
    width: 90%;

    margin-left: 10%;
}

#crearpaciente {
    color:var(--background) !important;
    background-color:var(--secondary) !important;
    margin-left: 85%;

    align-content: center !important;
    padding-right: 20px;

}

input {
    border: 1px solid var(--background) !important;
}

. .table-striped>tbody>tr:nth-child(odd)>td .btn {
    border: 1px solid white !important;
    background-color:var(--background) !important;
    color: var(--txt) !important;

}

.table-striped>tbody>tr:nth-child(even)>td .btn {
    border: 1px solid white !important;
    background-color:var(--background) !important;
    color: var(--txt) !important;
}


.card-header {
    background-color:var(--background) !important;
}
</style>

<div class="container col-lg-12 ">
<div class="card bg-pink">
            <div class="card-header ">
            <h1 class="card-title mt-2 "><i class="	fas fa-calendar-check  fa-2x mr-2"></i> Lista de Citas</h1>
            <a class="btn  d-flex mt-3  justify-content-center " href="{{ route('events.create') }}"
                id="crearpaciente">
                Crear Cita</a>
        </div>

        <div class="card-body rounded-bottom">
            <div class="row mt-2 ">
                <div class="col-4">
                    <h5>Total de Citas: {{ $events->count() }}</h5>
                </div>


            </div>

            <table id="eventTable" class="mt-3" style="width: 100%;">
                <caption class="mt-2">Lista de Citas</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">DR</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora de Inicio</th>
                        <th scope="col">Hora de Finalizacion</th>
                        <th scope="col">Acciones</th>



                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr >
                        <th scope="row">{{ $event->id }}</th>
                        <td><b>{{ $event->title }}</b></td>
                        <td><b>{{$event->dr}}</b></td>
                        <td>{{ $event->date }}</td>
                        <td>{{ \Carbon\Carbon::parse($event->startDateTime)->format('g:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($event->endDateTime)->format('g:i A') }}</td>

                        <td>
                            <!-- Botón de Editar -->
                            <a href="{{ route('events.edit', ['id' => $event->id]) }}" class="btn  "><i
                                   class="fas fa-pencil" aria-hidden="true"></i> Editar</a>

                            <!-- Formulario para Eliminar -->
                            <form action="{{ route('events.destroy', ['id' => $event->id]) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn  ml-1" id="delete_button_">Eliminar</button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>


    </div>

</div>

<!-- <a href="{{route('events.create')}}" class="btn  text-white ">Crear</a> -->

<script>
document.addEventListener('DOMContentLoaded', function() {

    $('#eventTable').DataTable({
        dom: 'Bfrtip',
        "language": {
            "emptyTable": "No hay citas Registradas",
            "sSearch": "Buscar"
        },
        order: [[0, 'desc']],
        buttons: [{
                extend: 'copy',
                className: 'btn',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button');
                }
            },
            {
                extend: 'csv',
                className: 'btn',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button');
                }
            },
            {
                extend: 'excel',
                className: 'btn',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button');
                }
            },
            {
                extend: 'pdf',
                className: 'btn',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button');
                }
            },
            {
                extend: 'print',
                className: 'btn',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button');
                }
            },

        ]
    });
});$(document).on('click', '[id^="delete_button_"]', function(event) {
    event.stopPropagation(); 
    event.preventDefault();
   

    const form = $(this).closest('form'); 

    Swal.fire({
        title: "¿Deseas eliminar la Cita?",
        text: "¡No podrás revertir el cambio!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--background)",
        cancelButtonColor:  "#var(--background)",
        
        confirmButtonText: "Sí, elimínalo!"
    }).then((result) => {
        if (result.isConfirmed) {
            
            $.ajax({
                type: form.attr('method'), 
                url: form.attr('action'), 
                data: form.serialize(), 
                success: function(response) {
               
                    Swal.fire({
                        title: "¡Eliminado!",
                        text: "La Cita ha sido eliminada correctamente.",
                        icon: "success"
                    });

           
                    form.closest('tr').remove();
                },
                error: function(xhr) {
                 
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo eliminar la Cita. Intenta de nuevo.",
                        icon: "error"
                    });
                }
            });
        }
    });
});
</script>
@endsection