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
    margin-left: 80%;

}

.btn {
    padding-left: 15px;
    padding-right: 15px;


}

. {
    background-color: var(--txt) !important;
}

input {
    border: 1px solid var(--background) !important;
}



.table-striped>tbody>tr:nth-child(odd)>td .btn {
    border: 1px solid white !important;
    background-color:var(--background) !important;
    color: var(--txt) !important;

}

.table-striped>tbody>tr:nth-child(even)>td .btn {
    border: 1px solid white !important;
    background-color:var(--background) !important;
    color: var(--txt) !important;
}

.table-striped>tbody>tr:nth-child(odd):hover>td {
    color: #212529;
    background-color: rgba(0, 0, 0, .075);
}
</style>

<div class="container col-lg-12 ">
    <div class="card bg-pink ">
        <div class="card-header  ">
            <h4 class="card-title mt-2 "><i class="fas fa-user fa-2x"></i> Lista de Pacientes</h4>
            <a class="btn  d-flex  mt-3  justify-content-center " href="{{ route('patient.create') }}"
                id="crearpaciente">
                Crear Paciente</a>
        </div>

        <div class="card-body rounded-bottom">
            <div class="row mt-2 ">
                <div class="col-4">
                    <h5>Total de Pacientes: {{ $patients->count() }}</h5>
                </div>


                <table class=" mt-3" id="pacient_table" style="width: 100%;">
                    <caption class="mt-2">Lista de Pacientes</caption>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col" width="20">Fecha de Nacimiento</th>
                            <th scope="col">ARS</th>
                            <th scope="col">Motivo de Consulta</th>
                            <th width="200px" scope="col">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                        <tr onclick="window.location='{{ route('patient.show', ['id' => $patient->pacient_id]) }}';"
                            style="cursor: pointer;">
                            <th scope="row">{{ $patient->pacient_id }}</th>
                            <td><b>{{ $patient->name }}</b></td>
                            <td>{{ $patient->date_of_birth }}</td>
                            <td>{{ $patient->ars }}</td>
                            <td>{{ $patient->motive }}</td>
                            <td>
                                <div class="form-inline justify-content-center">

                                    <a onclick="event.stopPropagation();" href="{{ route('patient.edit', ['id' => $patient->pacient_id]) }}"
                                        class="btn  "><i  class="fas fa-pencil"
                                            aria-hidden="true"></i> Editar</a>


                                    <form onclick="event.stopPropagation();" action="{{ route('patient.destroy', ['id' => $patient->pacient_id]) }}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn mt-3 ml-1 "
                                        id="delete_button">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>
</div>

<script>
    
$('#delete_button').on('click', function(event) {
    event.preventDefault();

    Swal.fire({
        title: "Deseas Eliminar el Paciente?",
        text: "No podras revertir el cambio!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--background)",
        cancelButtonColor:  "var(--background)",
        
        confirmButtonText: "Si, eliminalo!"
    }).then((result) => {
        if (result.isConfirmed) {

            $(this).closest('form').submit();

            Swal.fire({
                title: "Eliminada!",
                text: "El Paciente ha sido eliminado correctamente.",
                icon: "success"
            });
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {

    $('#pacient_table').DataTable({
        dom: 'Bfrtip',
        "language": {
            "emptyTable": "No hay pacientes Registrados",
            "sSearch": "Buscar"
        }, order: [[0, 'desc']],

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
});
</script>
@endsection