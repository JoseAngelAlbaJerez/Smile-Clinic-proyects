@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')

<style>
.container {
    width: 90%;
    margin-left: 10%;
    align-self: center;
}

#crearpaciente {
    color:var(--background) !important;
    background-color:var(--secondary) !important;
    margin-left: 80%;


}

.confirm {
    padding: 10 40 10 40;
    border: none;
}

.deny {
    padding: 10 40 10 40;
}

.cancel {
    padding: 10 15 10 15;
}

input {
    border: 1px solid var(--background) !important;
}

. .table-striped>tbody>tr:nth-child(odd)>td .btn {

    background-color:var(--background) !important;
    color: var(--txt) !important;

}

.table-striped>tbody>tr:nth-child(even)>td .btn {

    background-color:var(--background) !important;
    color: var(--txt) !important;
}


.card-header {
    background-color:var(--background) !important;
}

td {
    margin-top: 25px !important;
}
</style>
<style>
/* The container must be positioned relative: */
.custom-select {
    position: relative;
    font-family: Arial;

}

.custom-select select {
    display: none;
    /*hide original SELECT element: */
}

.select-selected {
    background-color: var(--background);
}

/* Style the arrow inside the select element: */
.select-selected:after {
    position: absolute;
    content: "";
    top: 14px;
    right: 10px;
    width: 0;
    height: 0;
    border: 6px solid transparent;
    border-color: #fff transparent transparent transparent;
}

/* Point the arrow upwards when the select box is open (active): */
.select-selected.select-arrow-active:after {
    border-color: transparent transparent #fff transparent;
    top: 7px;
}

/* style the items (options), including the selected item: */
.select-items div,
.select-selected {
    color: #ffffff;
    padding: 8px 16px;
    border: 1px solid transparent;
    border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
    cursor: pointer;
}

/* Style items (options): */
.select-items {
    position: absolute;
    background-color: DodgerBlue;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 99;
}

/* Hide the items when the select box is closed: */
.select-hide {
    display: none;
}

.select-items div:hover,
.same-as-selected {
    background-color: rgba(0, 0, 0, 0.1);
}
</style>

<div class="container col-lg-12 ">
    <div class="card text-white  ">
        <div class="card-header ">
            <h1 class="card-title mt-2 "><i class="	fas fa-comments-dollar fa-3x mr-2"></i> Egresos</h1>
            <a class="btn  d-flex   justify-content-center mt-4" href="{{ route('expenses.create') }}"
                id="crearpaciente">
                Crear Egreso</a>
        </div>

        <div class="card-body ">
            <div class="row mt-2 ">
                <div class="col-4">
                    <h5>Total de Egresos: {{ $expenses->count() }}</h5>
                </div>


            </div>

            <table id="report_table" class=" mt-3" style="width: 100%;">
                <caption class="mt-2">Lista de Egresos</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Monto</th>
                        <th scope="col">Fecha de Registro</th>

                        <th scope="col" style="width: 150px;">Acciones</th>



                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $expense)
                    <tr>
                        <th scope="row">{{ $expense->id }}</th>
                        <td><b>{{ $expense->name }}</b></td>
                        <td>{{ $expense->amount }} $</td>
                        <td>{{ $expense->date }}</td>

                        <td>
                            <div class="form-inline justify-content-center">
                                <!-- Botón de Editar -->
                                <a href="{{ route('expenses.edit', ['id' => $expense->id]) }}" class="btn  "><i
                                        class="fas fa-pencil" aria-hidden="true"></i> Editar</a>

                                <!-- Formulario para Eliminar -->
                                <form action="{{ route('expenses.destroy', ['id' => $expense->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn mt-3 ml-1 " id="delete_button_">Eliminar</button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
        <button id="generate_report" class="btn mt-2 ">Generar Reporte</button>

    </div>

</div>
</div>
</div>
<div id="patientModal" style="display:none;">
        <div class="form-inline">
        <label for="startDate" class=" ml-auto">Desde </label>
        <label for="endDate" class=" mx-auto">Hasta </label>
        </div>
        <div class="form-inline mt-3 justify-content-center">
         
            
            <input type="date" id="startDate" class="form-control ml-2 mr-2 px-4">

           
            <input type="date" id="endDate" class="form-control ml-2 px-4">
        </div>
    </div>


</div>

<script>
$(document).on('click', '[id^="delete_button_"]', function(event) {
    event.preventDefault();

    const form = $(this).closest('form');

    Swal.fire({
        title: "¿Deseas eliminar el Egreso?",
        text: "¡No podrás revertir el cambio!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--background)",
        cancelButtonColor: "var(--background)",

        confirmButtonText: "Sí, elimínalo!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    // Mensaje de éxito
                    Swal.fire({
                        title: "¡Eliminado!",
                        text: "El Egreso ha sido eliminado correctamente.",
                        icon: "success"
                    });

                    // Opcional: Eliminar la fila o el elemento de la tabla
                    form.closest('tr')
                .remove(); // Esto eliminará la fila de la tabla asociada
                },
                error: function(xhr) {
                    // Manejo de error
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo eliminar el Egreso. Intenta de nuevo.",
                        icon: "error"
                    });
                }
            });
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {

    $('#report_table').DataTable({
        dom: 'Bfrtip',
        "language": {
            "emptyTable": "No hay Egresos Registrados",
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


document.getElementById('generate_report').addEventListener('click', function() {
    Swal.fire({
        title: 'Fechas del Reporte',
        html: document.getElementById('patientModal').innerHTML, // Modal para seleccionar paciente
        showCancelButton: true,
        confirmButtonText: 'Generar Reporte',
        preConfirm: () => {

            const startDate = Swal.getPopup().querySelector('#startDate').value;
            const endDate = Swal.getPopup().querySelector('#endDate').value;

            if (!startDate) {
                Swal.showValidationMessage('Por favor selecciona una Fecha de Inicio');
            }
            if (!endDate) {
                Swal.showValidationMessage('Por favor selecciona una Fecha Final');
            }
            if (new Date(startDate) > new Date(endDate)) {
                Swal.showValidationMessage(
                    'La Fecha Final no puede ser anterior a la Fecha de Inicio');
            }
            return {
                startDate,
                endDate,

            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const {
                startDate,
                endDate,
            } = result.value;

            generarReporte(startDate, endDate);

        }
    });

});

function generarReporte(startDate, endDate) {
    Swal.fire({
        title: "Generando Reporte...",
        timerProgressBar: true,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('/expenses/pdf', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                startDate,
                endDate
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.blob(); // Get the PDF blob
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            window.open(url);
            window.URL.revokeObjectURL(url);
            Swal.fire({
                title: "Reporte Generado",
                text: "El reporte ha sido generado correctamente.",
                icon: "success"
            });
        })
        .catch(error => {
            Swal.fire({
                title: "Error",
                text: "Ocurrió un error al generar el reporte.",
                icon: "error"
            });
            console.error('Error:', error);
        });
}
</script>
@endsection