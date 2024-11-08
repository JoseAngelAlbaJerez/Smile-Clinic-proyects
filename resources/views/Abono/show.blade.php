@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')
<style>
    .container {
    text-align: center;
margin-left: 10%;

}


.disabled {
    pointer-events: none;
    opacity: 0.5;
}

#abonos {
    color: var(--txt) !important;
    margin-top: 10px;
}


.form-check-input {
    border-color:var(--background) !important;
}

.form-control {
    border-color:var(--background) !important;
}

#fecha {
    border-color: #dee2e6 !important;
}

#label-custom_payment {
    margin-left: 70% !important;

}
#card-abonos{
    margin-top: 3% !important;
}
.btn {
    margin-left: 10px !important;
}
</style>
<div class="container  col-md-11 ">
<div class="card p-3" id="card-abonos">
    <h1 id="abonos">Abonos</h1>
    <div class="card-body rounded-bottom">
        <table class=" mt-3" id="abonosTable" style="width: 100%;">
            <caption class="mt-2">Abono</caption>
            <thead>
                <tr>
                    
                    <th># de Abono</th>
                    <th>Fecha</th>
                    <th>Procedimiento</th>
                    <th>Tratamiento</th>
                    <th>Abonado</th>
                    <th width="300"> Acciones</th>
             
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($Abonos as $abono )
                    
                    
             
                    <td><b>{{ $abono->id }}</b></td>
                    <td><b>{{ $abono->created_at->toDateString() }}</b></td>
                    <td><b>{{ $abono->procedure }}</b></td>
                    <td><b>{{ $abono->treatment }}</b></td>
                    <td><b>{{ number_format($abono->abonar) }} $</b></td>
                    <td><div class="form-inline justify-content-center">
                                <!-- Botón de Editar -->
                                <a href="{{ route('RX.edit', ['id' => $abono->id]) }}" class="btn  "><i
                                         class="fas fa-pencil" aria-hidden="true"></i> Editar</a>

                                <!-- Formulario para Eliminar -->
                                <form action="{{ route('Abono.destroy', ['id' => $abono->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn mt-3 ml-1 " id="delete_button_">Eliminar</button>
                                </form>
                                <a href="{{ route('abono.print', $abono->id) }}" target="_blank" class="btn ml-1" id="print-button">Imprimir</a>

                            </div></td>
                </tr>
                @endforeach
                
            </tbody>
            <tfoot>
       
                <td style="text-align: left; color: #767675 !important; font-weight: bold;" colspan="5">Total</td>
                <td id="tdTotal" style="text-align: center; color: var(--background);"><b>{{ number_format($total_abonos) }} $</b></td>
         
                
            </tfoot>
        </table>
        @php
    $patientId = $Abonos->first()->patient_id;
@endphp

    </div>
    <button id="generate_report" class="btn mt-2 ">Generar Reporte</button>
</div>
</div>


<script>

$(document).on('click', '[id^="delete_button_"]', function(event) {
    event.preventDefault(); // Evitar la acción predeterminada del formulario

    const form = $(this).closest('form'); // Obtener el formulario asociado

    Swal.fire({
        title: "¿Deseas eliminar el Abono?",
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
                        text: "El Abono ha sido eliminado correctamente.",
                        icon: "success"
                    });

                    // Opcional: Eliminar la fila o el elemento de la tabla
                    form.closest('tr').remove(); // Esto eliminará la fila de la tabla asociada
                    location.reload();
                },
                error: function(xhr) {
                    // Manejo de error
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo eliminar el Abono. Intenta de nuevo.",
                        icon: "error"
                    });
                }
            });
        }
    });
});
        document.addEventListener('DOMContentLoaded', function() {
        $('#abonosTable').DataTable({
        dom: 'Bfrtip',
        "language": {
            "emptyTable": "No hay Cuentas Registradas",
            "sSearch": "Buscar"
        },
        order: [[2, 'desc']],
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
        title: "Generando Reporte...",
        timerProgressBar: true,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const patientId = {{ $Abonos->first()->patient_id }}; 

fetch(`/abonos/pdf/${patientId}`, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
   
})
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.blob();
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
});
</script>
@endsection