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

input {
    border: 1px solid var(--background) !important;
}


.table-striped>tbody>tr:nth-child(odd)>td .btn {

    background-color:var(--background) !important;
    color: var(--txt) !important;
}

.table-striped>tbody>tr:nth-child(even)>td .btn {

    background-color:var(--background) !important;
    color: var(--txt) !important;
}
</style>

<div class="container col-lg-12 ">
    <div class="card bg-pink">
        <div class="card-header ">
            <h4 class="card-title mt-2 "><i class="fas fa-money-bill fa-2x"></i> Cuentas Por Cobrar</h4>
            <a class="btn  d-flex   justify-content-center mt-2 " href="{{ route('CXC.create') }}"
                id="crearpaciente"><i class=" mt-1"></i>
                Cobros</a>
        </div>

        <div class="card-body rounded-bottom">
            <div class="row mt-2 ">
            <div class="col-4">
                    <h5>Total de Cuentas: {{ $CXCS->count() }}</h5>
                </div>

            </div>

            <table class=" mt-3" id="CXCtable" style="width: 100%;">
                <caption class="mt-2">Lista de Cuentas</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Balance</th>
                        <th scope="col">Status</th>
                        <th scope="col">Fecha de Emision</th>
                      
                        <th scope="col">Total</th>
                        <th scope="col">Abonos pagos</th>
                        <th scope="col" width="200">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($CXCS as $CXC)
                    <tr data-abonos="{{ $CXC->abonos_count }}"
                        data-url="{{ route('Abono.show', ['id' => $CXC->patient_id]) }}" onclick="handleRowClick(this);"
                        style="cursor: pointer;">

                        <th scope="row">{{ $CXC->id }}</th>
                        <td><b>{{$CXC->patient->name}}</b></td>
                        <td><b>{{ number_format($CXC->balance, 2);}} $</b></td>

                        @if ($CXC->status == "pendiente")
                        <td style="color: #bdbd2d !important;"><b>{{ $CXC->status }}</b></td>
                        @elseif($CXC->status == "pagado")
                        <td style="color: #2dbd40 !important;"><b>{{ $CXC->status }}</b></td>
                        @elseif($CXC->status == "vencido")
                        <td style="color: #bd2d40 !important;"><b>{{ $CXC->status }}</b></td>
                        @endif

                        <td><b>{{ $CXC->updated_at->toDateString() }}</b></td>
                       
                        <td><b>{{ number_format($CXC->total, 2);}} $</b></td>
                        <td><b>{{ $CXC->abonos_count }}</b></td>

                        <td>
                            <div class="form-inline justify-content-center">
                                <!-- Botón Editar -->
                                <a href="" class="btn d-inline" onclick="event.stopPropagation();">
                                    <i  class="fas fa-pencil" aria-hidden="true"></i> Editar
                                </a>

                                <!-- Formulario Eliminar -->
                                <form action="{{ route('delete.cxc', ['id' => $CXC->id]) }}" method="POST"
                                    style="display: inline;" onclick="event.stopPropagation();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="delete_button" class="btn mt-3 ml-1">Eliminar</button>
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
        title: "Deseas Eliminar la Cuenta?",
        text: "No podras revertir el cambio!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--background)",
        cancelButtonColor: "var(--background)",

        confirmButtonText: "Si, eliminalo!"
    }).then((result) => {
        if (result.isConfirmed) {

            $(this).closest('form').submit();

            Swal.fire({
                title: "Eliminada!",
                text: "La cuenta ha sido eliminada correctamente.",
                icon: "success"
            });
        }
    });
});
function handleRowClick(row) {
  
    const abonosCount = row.getAttribute('data-abonos');
    const url = row.getAttribute('data-url');
    
    if (parseInt(abonosCount) === 0) {
   
        Swal.fire({
            title: 'Error',
            text: 'Este paciente no tiene abonos registrados. Debe haber al menos un abono para continuar.',
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
    } else {
     
        window.location.href = url;
    }
}


document.addEventListener('DOMContentLoaded', function() {

    $('#CXCtable').DataTable({
        order: [[0, 'desc']],
        dom: 'Bfrtip',
        "language": {
            "emptyTable": "No hay Cuentas Registradas",
            "sSearch": "Buscar"
        },
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