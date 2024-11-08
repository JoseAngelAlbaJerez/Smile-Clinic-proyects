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
            <h4 class="card-title mt-2 "><i class="fas fa-money-bill "></i> Presupuestos</h4>
            <a class="btn  d-flex   justify-content-center " id="crearpaciente"><i class=" mt-1"></i>
                Crear Presupuesto</a>
        </div>

        <div class="card-body rounded-bottom">
            <div class="row mt-2 ">


            </div>

            <table class="mt-3 rounded" id="budgetTable" style="width: 100%;">
    <caption class="mt-2">Lista de Presupuestos</caption>
    <thead>
        <tr>
            <th scope="col"># </th>
            <th scope="col">Tipo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Total</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($budgets as $budget)
        <tr>
            <th scope="row">{{ $budget->id }}</th>
            <td style="color: {{ $budget->type == 'Credito' ? '#bdbd2d' : '#2dbd40' }} !important;"><b>{{ $budget->type }}</b></td>
            <td><b>{{ $budget->patient->name }}</b></td>
            <td><b>{{ number_format($budget->Total, 2);}} $</b></td>
            <td>
                <div class="form-inline justify-content-center">
                    <a href="{{ route('budgets.edit', ['id' => $budget->id, 'pacientid' => $budget->patient->pacient_id]) }}" class="btn">
                        <i class="fas fa-pencil" aria-hidden="true"></i> Editar
                    </a>
                    <form action="{{ route('delete.budget', ['id' => $budget->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn mt-3 ml-1 " id="delete_button_">Eliminar</button>
                    </form>
                    <a href="{{ route('budgets.print', $budget->id) }}" target="_blank" class="btn ml-1" id="print-button">Imprimir</a>

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

<div id="printable_report" style="diplay:none;">
    <div id="patientModal" style="display:none;">
        <select id="patientSelect" class="custom-select">
            <option value="0">Seleccione un paciente</option>
            @foreach ($patients as $patient)
            <option value="{{ $patient->pacient_id }}">{{ $patient->pacient_id }} - {{ $patient->name }}</option>
            @endforeach
        </select>

        <div id="medicationsContainer" class="mt-3 "></div>
    </div>
</div>

<script>
    $(document).on('click', '#print-button', function(event) {
    event.preventDefault(); 

    const url = $(this).attr('href'); 

    const SwalLoading = Swal.fire({
        title: "Generando Receta!",
        timerProgressBar: true,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading(); 
        }
    });

    $.ajax({
        url: url, 
        method: 'GET', 
        success: function(response) {
            window.open(url, '_blank'); 
            SwalLoading.close(); 
        },
        error: function(xhr) {
            SwalLoading.close(); 
            Swal.fire({
                title: "Error",
                text: "No se pudo generar la receta. Intenta de nuevo.",
                icon: "error"
            });
        }
    });
});

$(document).on('click', '[id^="delete_button_"]', function(event) {
    event.preventDefault(); 

    const form = $(this).closest('form'); 

    Swal.fire({
        title: "¿Deseas eliminar el presupuesto?",
        text: "¡No podrás revertir el cambio!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--background)",
        cancelButtonColor:  "#var(--background)",
        
        confirmButtonText: "Sí, elimínalo!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: form.attr('method'), // Obtener el método (DELETE)
                url: form.attr('action'), // Obtener la acción del formulario
                data: form.serialize(), // Serializar los datos del formulario
                success: function(response) {
                    Swal.fire({
                        title: "¡Eliminado!",
                        text: "El presupuesto ha sido eliminado correctamente.",
                        icon: "success"
                    });

                    form.closest('tr').remove(); // Esto eliminará la fila de la tabla asociada
                },
                error: function(xhr) {
                    // Manejo de errorp
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo eliminar el presupuesto. Intenta de nuevo.",
                        icon: "error"
                    });
                }
            });
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {

    $('#budgetTable').DataTable({
        dom: 'Bfrtip',
        "language": {
            "emptyTable": "No hay Presupuestos Registrados",
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

document.getElementById('crearpaciente').addEventListener('click', function() {

    Swal.fire({
        title: 'Selecciona un paciente',
        html: document.getElementById('patientModal').innerHTML, 
        showCancelButton: true,
        confirmButtonText: 'Asignar paciente',
        preConfirm: () => {
            const patientId = Swal.getPopup().querySelector('#patientSelect').value;
            if (!patientId) {
                Swal.showValidationMessage('Por favor selecciona un paciente');
            }
            return patientId;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const selectedPatientId = result.value;

            window.location.href = '/budget/' + selectedPatientId;

        }
    });
});
</script>
@endsection