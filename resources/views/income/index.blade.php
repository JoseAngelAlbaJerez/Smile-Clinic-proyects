@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')

<style>
.container {
    width: 90%;
    align-self: center;
    margin-left: 10%;
}

#crearpaciente {
    color:var(--background) !important;
    background-color:var(--secondary) !important;
    margin-left: 79%;


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



.card-header {
    background-color:var(--background) !important;
}




.custom-select {
    position: relative;
    font-family: Arial;

}

.custom-select select {
    display: none;
 
}

.select-selected {
    background-color:var(--background);
}

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
            <h4 class="card-title mt-2 "><i class="	fas fa-cash-register fa-3x  mr-2 "></i> Ingresos</h4>
            <a class="btn  d-flex  mt-4  justify-content-center " id="crearpaciente">
                Generar Reporte</a>
        </div>

        <div class="card-body rounded-bottom">
            <div class="row mt-2 ">
                <div class="col-4">
                    <h5>Total de Ingresos: {{ $abonos->count() + $budgets->count()}}</h5>
                </div>


            </div>

            <table id="report_table" class=" mt-3" style="width: 100%;">
                <caption class="mt-2">Lista de Ingresos</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Nombre</th>
                      

                        <th scope="col">Total</th>

                        <th scope="col">Fecha de Registro</th>
                        <th scope="col" style="width: 250px;">Acciones</th>



                    </tr>
                </thead>
                <tbody>
                    @foreach($budgets as $budget)
                    <tr>
                        <th scope="row">{{ $budget->id }}</th>
                        
                        @if ($budget->type == "Abono")
                        <td style="color: #bdbd2d !important;"><b>{{ $budget->type }}</b></td>
                        @elseif($budget->type == "Contado")
                        <td style="color: #2dbd40 !important;"><b>{{ $budget->type }}</b></td>
                      
                        @endif
                        <td> {{ $budget->patient->name }}</td>
                      
                        <td>{{number_format( $budget->Total)}} $</td>
                        <td>{{ $budget->updated_at->toDateString()}}</td>
                        <td>
                            <div class="form-inline justify-content-center">
                                    
                                     <a href="{{ route('budgets.edit', ['id' => $budget->id, 'pacientid' => $budget->patient->pacient_id]) }}" class="btn  "><i
                                         class="fas fa-pencil" aria-hidden="true"></i> Editar</a>

                                <!-- Formulario para Eliminar -->
                                <form action="{{ route('delete.budget', ['id' => $budget->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn mt-3 ml-1 " id="delete_button_">Eliminar</button>
                    </form>
                    <a href="{{ route('budgets.print', $budget->id) }}" target="_blank" class="btn ml-1" id="print-button">Imprimir</a>

                            </div>
                        </td>


                        </td>
                    </tr>

                    @endforeach
                    @foreach($abonos as $abono)
                    <tr>
                        <th scope="row">{{ $abono->id }}</th>
                        <td><b>Abono</b></td>
                        <td>{{$abono->patient_name}}</td>
                        
                        <td>{{ number_format($abono->Total) }} $</td>
                        <td>{{ $abono->updated_at->toDateString()}}</td>
                        <td>
                            <div class="form-inline justify-content-center">
                                <!-- Botón de Editar -->
                                <a href="{{ route('RX.edit', ['id' => $abono->id]) }}" class="btn  "><i
                                         class="fas fa-pencil" aria-hidden="true"></i> Editar</a>

                                <!-- Formulario para Eliminar -->
                                <form action="{{ route('RX.destroy', ['id' => $abono->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn mt-3 ml-1 " id="delete_button_">Eliminar</button>
                                </form>
                                <a href="{{ route('abono.print', $abono->id) }}" target="_blank" class="btn ml-1" id="print-button">Imprimir</a>

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

    <div id="patientModal" style="display:none;">
        <div class="form-inline">
        <label for="startDate" class=" ml-auto">Desde </label>
        <label for="endDate" class=" mx-auto">Hasta </label>
        </div>
        <div class="form-inline mt-3 justify-content-center">
         
            
            <input type="date" id="startDate" class="form-control ml-2 mr-2 px-4">

           
            <input type="date" id="endDate" class="form-control ml-2 px-4">
        </div>
        <div class="form-inline  mt-3">
            <button id="daily" class="btn mx-auto">Diario</button>
            <button id="weekly" class="btn mx-auto">Semanal</button>
            <button id="biweekly" class="btn mx-auto">Quincenal</button>
            <button id="monthly" class="btn mx-auto">Mensual</button>
            <button id="yearly" class="btn mx-auto">Anual</button>
        </div>
    </div>


</div>

<script>
 $(document).on('click', '[id^="daily"], [id^="weekly"], [id^="biweekly"], [id^="monthly"], [id^="yearly"]', function(event) {
    let reportType = $(this).attr('id'); 
    Swal.fire({
        title: "Generando Reporte...",
        timerProgressBar: true,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });


    $.ajax({
        url: '/income/' + reportType + '/pdf',  
        method: 'POST',
        data: {
            report_type: reportType, 
            _token: '{{ csrf_token() }}'
        },
        xhrFields: {
            responseType: 'blob'  
        },
        success: function(response) {
            Swal.close(); 

            let blob = new Blob([response], { type: 'application/pdf' });
            let link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.target = '_blank';  
            link.click(); 

            Swal.fire({
                title: "Reporte Generado",
                text: "El reporte ha sido generado exitosamente.",
                icon: "success"
            });
        },
        error: function() {
            Swal.close();
            Swal.fire({
                title: "Error",
                text: "Hubo un problema al generar el reporte.",
                icon: "error"
            });
        }
    });
});


</script>



<script>
    $(document).on('click', '[id^="delete_button_"]', function(event) {
    event.preventDefault(); // Evitar la acción predeterminada del formulario

    const form = $(this).closest('form'); // Obtener el formulario asociado

    Swal.fire({
        title: "¿Deseas eliminar el presupuesto/abono?",
        text: "¡No podrás revertir el cambio!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--background)",
        cancelButtonColor:  "#var(--background)",
        
        confirmButtonText: "Sí, elimínalo!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar el formulario usando AJAX
            $.ajax({
                type: form.attr('method'), // Obtener el método (DELETE)
                url: form.attr('action'), // Obtener la acción del formulario
                data: form.serialize(), // Serializar los datos del formulario
                success: function(response) {
                    // Mensaje de éxito
                    Swal.fire({
                        title: "¡Eliminado!",
                        text: "El presupuesto/abono ha sido eliminado correctamente.",
                        icon: "success"
                    });

                    // Opcional: Eliminar la fila o el elemento de la tabla
                    form.closest('tr').remove(); // Esto eliminará la fila de la tabla asociada
                },
                error: function(xhr) {
                    // Manejo de error
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo eliminar el presupuesto/abono. Intenta de nuevo.",
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
            "emptyTable": "No hay Ingresos Registrados",
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
        title: 'Fechas del Reporte',
        html: document.getElementById('patientModal').innerHTML, // Modal para seleccionar paciente
        showCancelButton: true,
        confirmButtonText: 'Generar Reporte',
        preConfirm: () => {
           
            const startDate = Swal.getPopup().querySelector('#startDate').value;
            const endDate = Swal.getPopup().querySelector('#endDate').value;
         
            if (!startDate ) {
                Swal.showValidationMessage('Por favor selecciona una Fecha de Inicio');
            }
            if (!endDate ) {
                Swal.showValidationMessage('Por favor selecciona una Fecha Final');
            }
            if (new Date(startDate) > new Date(endDate)) {
                Swal.showValidationMessage('La Fecha Final no puede ser anterior a la Fecha de Inicio');
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

    fetch('/income/pdf', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ startDate, endDate })
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