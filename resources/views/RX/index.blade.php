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
    margin-left: 79%;


}
.custom-select-time{
    width: 150px !important;
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
    background-color:var(--background);
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

<div class="container col-lg-12   ">
    <div class="card text-white  ">
        <div class="card-header ">
            <h4 class="card-title mt-2 "><i class="	fas fa-prescription fa-2x "></i> Lista de Medicamentos</h4>
            <a class="btn  d-flex   justify-content-center mt-3" href="{{ route('RX.create') }}" id="crearpaciente">
                Crear Medicamento</a>
        </div>

        <div class="card-body ">
            <div class="row mt-2 ">
                <div class="col-4">
                    <h5>Total de Medicamentos: {{ $meds->count() }}</h5>
                </div>


            </div>

            <table id="report_table" class=" mt-3" style="width: 100%;">
                <caption class="mt-2">Lista de Medicamentos</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Dosis</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Fecha de Registro</th>

                        <th scope="col" style="width: 150px;">Acciones</th>
                        <th scope="col">Seleccionar</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach($meds as $med)
                    <tr>
                        <th scope="row">{{ $med->id }}</th>
                        <td><b>{{ $med->name }}</b></td>
                        <td>{{ $med->dosis }}</td>
                        <td>{{ $med->quantity }}</td>
                        <td>{{ $med->updated_at->toDateString()}}</td>
                        <td>
                            <div class="form-inline justify-content-center">
                                <!-- Botón de Editar -->
                                <a href="{{ route('RX.edit', ['id' => $med->id]) }}" class="btn  "><i
                                        style="color: var(--background);" class="fas fa-pencil" aria-hidden="true"></i> Editar</a>

                                <!-- Formulario para Eliminar -->
                                <form action="{{ route('RX.destroy', ['id' => $med->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn mt-3 ml-1 "
                                    id="delete_button_">Eliminar</button>
                                </form>
                            </div>
                        </td>
                        <td>
                            <!-- Check para seleccionar medicamentos que quieres recetar-->
                            <input type="checkbox" name="recipe_checkbox" id="recipe_checkbox" class="recipe_checkbox"
                                data-med-id="{{ $med->id }}" data-med-name="{{$med->name}}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
        <button id="generate_report" class="btn mt-1 mb-1 ">Generar Receta</button>

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
    
$(document).on('click', '[id^="delete_button_"]', function(event) {
    event.preventDefault(); // Evitar la acción predeterminada del formulario

    const form = $(this).closest('form'); // Obtener el formulario asociado

    Swal.fire({
        title: "¿Deseas eliminar el Medicamento?",
        text: "¡No podrás revertir el cambio!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--background)",
        cancelButtonColor:  "var(--background)",
        
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
                        text: "El Medicamento ha sido eliminado correctamente.",
                        icon: "success"
                    });

                    // Opcional: Eliminar la fila o el elemento de la tabla
                    form.closest('tr').remove(); // Esto eliminará la fila de la tabla asociada
                },
                error: function(xhr) {
                    // Manejo de error
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo eliminar el Medicamento. Intenta de nuevo.",
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
            "emptyTable": "No hay medicamentos Registrados",
            "sSearch": "Buscar"
        }, order: [[0, 'asc']],
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
let selectedMeds = [];

document.querySelectorAll('.recipe_checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            let medId = this.getAttribute('data-med-id');
            let medname = this.getAttribute('data-med-name')
            if (this.checked) {
                selectedMeds.push(medId);
                
            } else {
                selectedMeds = selectedMeds.filter(id => id !== medId);
            }
        });
    });
// Al hacer clic en un checkbox, agregamos o removemos el medicamento del array
document.getElementById('generate_report').addEventListener('click', function() {
        Swal.fire({
            title: "¿Desea asignar un paciente ya registrado a la receta?",
            showDenyButton: true,
            showCancelButton: true,
            
            cancelButtonColor: 'var(--background)',
            confirmButtonText: "Sí",
            confirmButtonColor: "var(--background)",
            denyButtonText: "No",
            denyButtonColor: "var(--background)",
            customClass: {
                cancelButton: 'cancel',
                confirmButton: 'confirm',
                denyButton: 'deny'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Limpiamos el contenedor de medicamentos para evitar duplicados
                document.getElementById('medicationsContainer').innerHTML = '';

                if (selectedMeds.length === 0) {
                    Swal.fire('Por favor selecciona al menos un medicamento');
                    return;
                }

                // Agregar selects para cada medicamento seleccionado
                selectedMeds.forEach((medId) => {
                const medName = document.querySelector(`.recipe_checkbox[data-med-id="${medId}"]`).getAttribute('data-med-name'); 

                const medSelectHTML = `
                <div class="form-inline justify-content-center mt-4 mb-2"><b> <span class="ml-2 h4">${medName}</b></span>
                </div>
                    <div class="form-inline" id="med_${medId}">
                       
                        <label for="hourselect_${medId}" class="">Cada:</label>
                        <select id="hourselect_${medId}" class="custom-select-time custom-select ml-2  mt-2">
                            <option value="0">Seleccione un tiempo</option>
                            <option value="8">8 horas</option>
                            <option value="12">12 horas</option>
                            <option value="24">24 horas</option>
                        </select>
                        <label for="dayselect_${medId}" class="ml-2">Por:</label>
                        <select id="dayselect_${medId}" class="custom-select-time custom-select mt-2 ml-2">
                            <option value="0">Seleccione un día</option>
                            <option value="1">1 días</option>
                            <option value="2">2 días</option>
                            <option value="3">3 días</option>
                            <option value="4">4 días</option>
                            <option value="5">5 días</option>
                            <option value="6">6 días</option>
                            <option value="7">7 días</option>
                            <option value="8">1 mes</option>
                            <option value="9">2 meses</option>
                            <option value="10">3 meses</option>
                            <option value="11">6 meses</option>
                            <option value="12">1 año</option>
                        </select>
                    </div>
                `;

                    document.getElementById('medicationsContainer').insertAdjacentHTML('beforeend', medSelectHTML);
                });

                // Mostrar el modal y cargar los selects
                Swal.fire({
                    title: 'Selecciona un paciente y asigna tiempo a los medicamentos',
                    html: document.getElementById('patientModal').innerHTML, // Usamos el contenido del modal
                    showCancelButton: true,
                    
                    cancelButtonColor: 'var(--background)',
                    confirmButtonText: 'Asignar paciente y medicamentos',
                    confirmButtonColor: 'var(--background)',
                    willOpen: () => {
                        // Aquí puedes agregar lógica adicional si es necesario
                    },
                    preConfirm: () => {
                        const patientId = Swal.getPopup().querySelector('#patientSelect').value;
                        if (patientId == 0) {
                            Swal.showValidationMessage('Por favor selecciona un paciente');
                            return false; // Asegúrate de devolver false para cancelar
                        }

                        // Recoger los valores de tiempo y días para cada medicamento seleccionado
                        let medicationsData = [];
                        selectedMeds.forEach(medId => {
                            let hourSelect = Swal.getPopup().querySelector(`#hourselect_${medId}`);
                            let daySelect = Swal.getPopup().querySelector(`#dayselect_${medId}`);

                            if (hourSelect && daySelect) {
                                let hour = hourSelect.value;
                                let day = daySelect.value;
                               

                                if (hour == 0 || day == 0) {
                                    Swal.showValidationMessage('Por favor selecciona el tiempo y los días para todos los medicamentos');
                                    return false; // Asegúrate de devolver false para cancelar
                                }

                                medicationsData.push({
                                    medicationId: medId,
                                    hour: hour,
                                    day: day
                                });
                            }
                        });

                        return {
                            patientId,
                            medicationsData
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const { patientId, medicationsData } = result.value;
                        generarReporteConPacienteYMedicamentos(patientId, medicationsData);
                    }
                });

            } else if (result.isDenied) {
                generarReporteSinPaciente();
            }
        });
    });



function generarReporteConPacienteYMedicamentos(patientId, selectedMeds) {
    Swal.fire({
        title: "Generando Receta!",
        timerProgressBar: true,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    if (selectedMeds.length > 0) {
    // Crear un array para almacenar la información de los medicamentos
    let medicationsData = selectedMeds.map(med => {
        const hourSelect = med.hour; // Ahora usando med directamente
        const daySelect = med.day;

        console.log(hourSelect);

        if (hourSelect && daySelect) {
            const hour = hourSelect; 
            const day = daySelect; 

            if (hour === '0' || day === '0') {
                Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: `Seleccione un tiempo y un día para el medicamento ID: ${med.medicationId}.`,
                });
                throw new Error(`Valores no válidos para el medicamento ID: ${med.medicationId}`); 
            }

            return {
                id: med.medicationId, 
                hour: hour,
                day: day
            };
        } else {
            console.error(`Selectores para medicamento ID: ${med.medicationId} no encontrados.`);
            return null;
        }
    }).filter(data => data !== null); 

    if (medicationsData.length > 0) {
        fetch('/get-selected-meds-with-patient', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                meds: medicationsData,
                patient_id: patientId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.blob();
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            window.open(url, '_blank');
            Swal.close();
        })
        .catch(error => {
            console.error('Error al generar el reporte:', error);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Hubo un problema al generar el reporte.",
            });
            });
        } 
    } else {
        Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "Selecciona al menos un medicamento para generar el reporte.",
        });
    }
}








function generarReporteSinPaciente() {
    Swal.fire({
        title: "Generando Reporte sin Paciente!",
        timerProgressBar: true,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Lógica para generar el reporte sin paciente
    if (selectedMeds.length > 0) {
        fetch('/get-selected-meds', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    meds: selectedMeds
                })
            })
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                window.open(url, '_blank');
                Swal.close(); // Cerrar el Swal cuando el reporte esté listo
            })
            .catch(error => {
                console.error('Error al generar el reporte:', error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al generar el reporte.",
                });
            });
    } else {
        Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "Selecciona al menos un medicamento para generar el reporte.",
        });
    }
}






document.querySelectorAll('.recipe_checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('click', function(event) {
        event.stopPropagation();
    });
});
</script>
@endsection