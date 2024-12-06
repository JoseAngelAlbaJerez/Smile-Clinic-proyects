@extends('layouts.app')

@extends('layouts.sidebar')


@section('content')

<link type="text/css" href="{{ URL::asset('css/custom-theme/jquery-ui-1.8.13.custom.css') }}" rel="stylesheet" />

<script type="text/javascript" src="{{ URL::asset('js/jquery-1.7.2.min.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('js/jquery-ui-1.8.13.custom.min.js') }}"></script>

<!-- jQuery (es una dependencia de DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Botones de DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

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

.btn {
    margin-left: 10px !important;
}
</style>




<div class="container  col-md-11">

    <form action="{{ route('CXC.store') }}" method="post" class="form-group">
        @csrf
        <div class="card text-white bg-pink">

            <div class="card-header justify-content-center mt-2">
                <h3 class=" p-2">Smile Clinic</h3>

            </div>
            <div class="card-body ">
    
                <div class="form-group form-inline ">
                    <label for="nombre" style="margin-left: 1%"> Paciente</label>
                   
                </div>

                <div class="form-group form-inline">
                <select name="paciente_id" id="paciente" class="form-control mb-2" style="width: 100%;" onchange="filterbudgets()">
                    <option value="0">Selecciona un paciente</option>
                    @foreach ($patientsWithBalance as $patient)
                        <option value="{{ $patient->pacient_id }}">{{ $patient->pacient_id }} - {{ $patient->name }}</option>
                    @endforeach
                  
                </select>
            </div>


    </form>

    <table class="" id="budgetsTable" style="width: 100%;">
        <caption class="mt-2">Lista de Presupuestos</caption>
        <thead>
            <tr>
                <th># </th>
                <th>Fecha</th>
                <th>Procedimiento</th>
                <th>Tratamiento</th>
                <th>Cantidad</th>
                <th>Monto</th>
                <th>Descuento</th>
                <th>Cobertura</th>
                <th>Total</th>
                <th>Abonar</th>
                <th style="display:none;">Abonar todo</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($budgets as $budget)
    @foreach ($CXCS as $CXC)
        @if ($CXC->budget_id == $budget->id)
            <tr data-cxc-id="{{ $CXC->id }}" data-budget-id="{{ $budget->id }}">
                <td><b>{{ $CXC->id }}</b></td>
                <td><b>{{ $budget->id }}</b></td>
                <td><b>{{ $budget->procedure }}</b></td>
                <td><b>{{ $budget->treatment ?? '' }}</b></td>
                <td><b>{{ $budget->quantity }}</b></td>
                <td><b>{{ $budget->amount }}</b></td>
                <td><b>{{ $budget->discount }}</b></td>
                <td><b>{{ $budget->coberture }}</b></td>
                <td><b>{{ $budget->Total }}</b></td>
                <td><input type="checkbox" name="recipe_checkbox" class="recipe_checkbox"></td>
                <td>  <input type="text" name="custom_payment" id="custom_payment" class="form-control " ></td>
            </tr>
        @endif
    @endforeach
@endforeach

        </tbody>
        <tfoot>
            <b>
                <td style="text-align: left; color: #767675 !important; font-weight: bold;" colspan="9">
                    Balance</td>
                <td id='tdTotal'style="color: var(--background);" ><b></td></b>

            </tr>

        </tfoot>
    </table>

    <!-- style="display: none;" -->


   
</div>

</div>
<div class="card" id="card-abonos">
        <h5 id="abonos">Abonos</h5>
        <div class="card-body">
            <table class="mt-3" id="abonosTable" style="width: 100%;">
                <caption class="mt-2">Abonos</caption>
                <thead>
                    <tr>
                    
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Procedimiento</th>
                        <th>Abono</th>
                        <th>Concepto</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($abonos as $abono)
                    <tr>
                     
                        <td><b>{{ $abono->id }}</b></td>
                        <td><b>{{ $abono->created_at->toDateString() }}</b></td>
                        <td><b>{{ $abono->abonar }}</b></td>
                        <td><b>{{ $abono->concepto }}</b></td>
                        <td><b>{{ $abono->Total }}</b></td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>














<script>
let total = 0;
let value = 0;
let recentAbonosIds = []; 

//Data Tables Info
function calcTotal() {
    const table = document.getElementById("budgetsTable");
    
  
    total = 0;

    // Iterar sobre cada fila de la tabla, excepto la primera (encabezado)
    for (let i = 1; i < table.rows.length; i++) {
        let montoCell = table.rows[i].cells[8]; // Columna de monto (Total)
        let checkbox = table.rows[i].querySelector('input[type="checkbox"]'); // Checkbox
        let customPaymentInput = table.rows[i].querySelector('input[type="number"]'); // Input de pago personalizado

        if (montoCell && checkbox && customPaymentInput) {
            let originalMontoValue = parseFloat(montoCell.textContent.replace(/[^0-9.-]+/g, "")); // Valor original

            // Añadir listener de input para el campo de pago personalizado
            customPaymentInput.addEventListener('input', function () {
                updateTotal(); // Actualizar el total general cuando cambie el valor de pago personalizado
            });

            // Añadir listener para el checkbox
            checkbox.addEventListener('change', function () {
                updateTotal(); // Actualizar el total general cuando cambie el estado del checkbox
            });
        }
    }

    // Actualizar el total en la celda tdTotal
    updateTotal(); 
}

function updateTotal() {
    const table = document.getElementById("budgetsTable");
    let total = 0; // Reiniciar el total
    let originalMontoValue;

    // Iterar sobre cada fila para recalcular el total
    for (let i = 1; i < table.rows.length; i++) {
        let montoCell = table.rows[i].cells[8]; // Columna de monto (Total)
        let checkbox = table.rows[i].querySelector('input[type="checkbox"]'); // Checkbox
        let customPaymentInput = table.rows[i].querySelector('input[type="number"]'); // Input de pago personalizado

        if (montoCell && checkbox && customPaymentInput) {
            originalMontoValue = parseFloat(montoCell.textContent.replace(/[^0-9.-]+/g, "")); // Obtener el valor original

            let customPayment = parseFloat(customPaymentInput.value) || 0; // Obtener el valor del campo de pago personalizado

            if (customPayment > originalMontoValue) {
                checkbox.checked = true; 
                checkbox.disabled = true; 
                Swal.fire({
            icon: "error",
            title: "Oops...",
            text: `El pago no puede ser mayor a ${originalMontoValue.toFixed(2)}.`,
        });
                customPaymentInput.value = originalMontoValue; 
                customPayment = originalMontoValue; // Actualizar el valor de customPayment
              
            }

            if (customPayment > 0) {
                // Si se introduce un pago personalizado, restarlo del total general
                total += (originalMontoValue - customPayment);
               
                checkbox.disabled = true; // Deshabilitar el checkbox si hay un pago personalizado
            } else if (checkbox.checked) {
                // Si el checkbox está marcado, restar el monto completo del total general
                total += 0; // El monto es 0 porque el checkbox está marcado
            } else {
                // Si no hay pago personalizado ni checkbox marcado, sumar el monto original
                total += originalMontoValue;
                checkbox.disabled = false; // Rehabilitar el checkbox si no hay pago personalizado
            }
        }
    }

    // Actualizar el valor en la celda tdTotal
    const tdTotal = document.getElementById('tdTotal');
    if (tdTotal) {
        tdTotal.textContent = total.toFixed(2); // Mostrar el total con 2 decimales
    }
}

function filterbudgets() {
    var pacienteId = document.getElementById('paciente').value;

    if (pacienteId) {
        fetch(`/filtrar-budgets/${pacienteId}`)
            .then(response => response.json())
            .then(data => {

                if ($.fn.DataTable.isDataTable('#budgetsTable')) {
                    $('#budgetsTable').DataTable().destroy();
                }

                var tableBody = document.querySelector('#budgetsTable tbody');
                if (tableBody) {
                    tableBody.innerHTML = '';

                    data.budgets.forEach(budget => {
                        
                        var updatedAt = new Date(budget.updated_at);
                        var formattedDate = updatedAt.toLocaleDateString('es-ES');
                        var row = `<tr data-cxc-id="${budget.c_x_c_id}" data-budget-id="${budget.id}"> 
                                <td><b>${budget.id}</b></td>
                                <td><b>${formattedDate}</b></td>
                                <td><b>${budget.procedure}</b></td>
                                <td><b>${budget.treatment ?? ''}</b></td>
                                <td><b>${budget.quantity}</b></td>
                                <td><b>${budget.amount}</b></td>
                                <td><b>${budget.discount}</b></td>
                                <td><b>${budget.coberture}</b></td>
                                <td><b>${budget.Total}</b></td>
                                <td>  <input type="number" name="custom_payment" id="custom_payment" class="form-control " ></td>
                               <td style="display:none;"><input type="checkbox" name="recipe_checkbox" class="recipe_checkbox"></td>
                            </tr>`;
                        tableBody.innerHTML += row;
                    });

                    addCheckboxListeners();
                    document.getElementById('card-abonos').style.display = 'block';
                    calcTotal();

                    $('#budgetsTable').DataTable({
                        dom: 'Bfrtip',
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
                            {
                                text: 'Pagar Todo',
                                className: 'btn',
                                init: function(api, node, config) {
                                    $(node).removeClass('dt-button');
                                },
                                action: function(e, dt, node, config) {
                                    markAllAsPaid();
                                    calcTotal();
                                }
                            },
                            {
                                text: 'Guardar',
                                className: 'btn',
                                init: function(api, node, config) {
                                    $(node).removeClass('dt-button');
                                },
                                action: function(e, dt, node, config) {
                                    submitAbonos();
                                }
                            }
                        ]
                        
                    });
                }


                if ($.fn.DataTable.isDataTable('#abonosTable')) {
                    $('#abonosTable').DataTable().destroy();
                }

                var abonosTableBody = document.querySelector('#abonosTable tbody');
                if (abonosTableBody) {
                    abonosTableBody.innerHTML = '';




                    data.abonos.forEach(abono => {
                        var created_at = new Date(abono.created_at);
                        var formattedDate = created_at.toLocaleDateString('es-ES');
                        var row = `<tr>
                                <td><b>${abono.id}</b></td>
                                <td><b>${formattedDate}</b></td>
                                <td><b>${abono.procedure}</b></td>
                                <td><b>${abono.abonar}</b></td>
                                <td><b>${abono.coberture}</b></td>
                                <td><b>${abono.Total}</b></td>
                               
                               
                            </tr>`;

                        abonosTableBody.innerHTML += row;
                    });

                    $('#abonosTable').DataTable({
                        order: [[0, 'desc']],
                        dom: 'Bfrtip',
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
                            }
                        ]
                    });
                }
            })
            .catch(error => console.log('Error:', error));
    } else if (pacienteId === "0") {
        if ($.fn.DataTable.isDataTable('#budgetsTable')) {
            $('#budgetsTable').DataTable().destroy();
        }
        if ($.fn.DataTable.isDataTable('#abonosTable')) {
            $('#abonosTable').DataTable().destroy();
        }

        var tableBody = document.querySelector('#budgetsTable tbody');
        if (tableBody) {
            tableBody.innerHTML = '';
        }

        var abonosTableBody = document.querySelector('#abonosTable tbody');
        if (abonosTableBody) {
            abonosTableBody.innerHTML = '';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {

    $('#budgetsTable').DataTable({
        order: [[0, 'asc']],
        dom: 'Bfrtip',
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
            {
                text: 'Pagar Todo',
                className: 'btn',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button');
                },
                action: function(e, dt, node, config) {
                    markAllAsPaid();
                    calcTotal();
                }
            },
            {
                text: 'Guardar',
                className: 'btn',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button');
                },
                action: function(e, dt, node, config) {
                    submitAbonos();
                }
            }
        ]
    });
});



// Saving Data
function submitAbonos() {
    let { abonosData, totalAbono, cxcIds } = getAbonosData();
let patientId = $('#paciente').val();
let customPayment = parseFloat($('#custom_payment').val()) || 0; // Valor global de customPayment, si existe
let abonoFinal = customPayment > 0 ? customPayment : totalAbono;
let balance = parseFloat($('#tdTotal').text()) || 0;

if (patientId === "0") {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Por favor selecciona un paciente.",
    });
    return;
}

if (abonosData.length === 0 ) {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Seleccione el monto a Abonar ",
    });
    return;
}

let $selectedCheckboxes = $('.recipe_checkbox:checked');
let budgetIdsToDelete = [];
let abonosConCXC = [];
let budgetsToUpdate = [];

// Recolectar información de abonos y presupuestos seleccionados
$selectedCheckboxes.each(function () {
    let $row = $(this).closest('tr');
    let budgetId = $row.data('budget-id');
    let cxcId = $row.data('cxc-id');
    let originalAmount = parseFloat($row.find('td').eq(8).text().replace(/[^0-9.-]+/g, ""));
    
    // Obtener el valor del input "custom_payment" para esta fila
    let inputPayment = parseFloat($row.find('input[name="custom_payment"]').val()) || 0;
    
    // Si hay un pago personalizado en esta fila, lo usamos. Si no, usamos el valor global o el monto original.
    let abono = inputPayment;

  

    // Si el abono es igual o mayor al monto original, eliminar el presupuesto
    if (abono >= originalAmount) {
        budgetIdsToDelete.push(budgetId);
    } else {
        // Si queda saldo pendiente, actualizar el presupuesto
        let remainingAmount = originalAmount - abono;
        budgetsToUpdate.push({
            budget_id: budgetId,
            remaining_amount: remainingAmount
        });
    }

    // Agregar abono con CXC
    abonosConCXC.push({
        cxc_id: cxcId,
        abonar: abono,
        budget_id: budgetId,
    });
});

    // Ya se guarda todo correctament solo verifica si no solo es un valor que se guarda y que el recentabonosid se itere de cada vez que se guarde
   
    // Guardar Abonos
    $.ajax({
    url: '{{ route('Abono.store') }}',
    method: 'POST',
    data: {
        _token: '{{ csrf_token() }}',
        abonos: abonosData,
        patient_id: patientId,
        abonoscxc: abonosConCXC,
    },
    success: function (response) {
    let abonoIds = response.abonos.map(abono => abono.id);
    recentAbonosIds = abonoIds; // Almacena los IDs de los abonos guardados
      

    
    // Ejecuta las siguientes acciones solo si hay abonos o presupuestos que procesar
    if (budgetsToUpdate.length > 0) {
     
        updatebudget(balance, recentAbonosIds, budgetsToUpdate,cxcIds).done(function() {
       
            // Después de actualizar presupuestos, elimina los presupuestos si es necesario
            if (budgetIdsToDelete.length > 0) {
                deletebudget(balance,recentAbonosIds, budgetIdsToDelete,cxcIds).done(function() {
                    finalizeProcess(patientId); // Finaliza el proceso solo después de ambas acciones
                });
            } else {
                finalizeProcess(patientId); // Si no hay presupuestos a eliminar, finaliza aquí
            }
        });
    } else if (budgetIdsToDelete.length > 0) {
   
        deletebudget(balance,recentAbonosIds, budgetIdsToDelete,cxcIds).done(function() {
            finalizeProcess(patientId); // Finaliza el proceso si solo se eliminaron presupuestos
        });
    } else {
        finalizeProcess(patientId); // Si no hay ni actualizaciones ni eliminaciones, finaliza directamente
    }
},
error: function (xhr) {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: 'Hubo un error al guardar los datos: ' + xhr.responseJSON.error,
    });

}
})
}

function updatebudget(balance,recentAbonosIds, budgetsToUpdate,cxcIds) {
   
   
    return $.ajax({
    url: '{{ route('update.budgets') }}',
    method: 'PUT',
    data: {
        _token: '{{ csrf_token() }}',
        budgets: budgetsToUpdate 
    },
    success: function(updateResponse) {
        console.log('Respuesta del servidor update:', updateResponse);
        recentAbonosIds = recentAbonosIds.concat(updateResponse.abonoIds || []);
        updateCXC(balance,cxcIds);
    },
    error: function(xhr) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: 'Error al actualizar los presupuestos: ' + xhr.responseJSON.error,
        });
    }
});
}


function deletebudget(balance,recentAbonosIds, budgetIdsToDelete,cxcIds) {
   
    return $.ajax({
        url: '{{ route('delete.budgets') }}',
        method: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}',
            ids: budgetIdsToDelete,
        },
        success: function(deleteResponse) {
            console.log('Respuesta del servidor delete:', deleteResponse);
            recentAbonosIds = recentAbonosIds.concat(deleteResponse.abonoIds || []);
            updateCXC(balance,cxcIds);
        },
        error: function (xhr) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: 'Hubo un error al eliminar el presupuesto: ' + xhr.responseJSON.error,
            });
        }
    });
}

function updateCXC(balance,cxcIds) {
    let cxcId = cxcIds[0];
    let status = balance === 0 ? 'pagado' : 'pendiente';
    
    $.ajax({
        url: '{{ route('CXC.update', ['id' => '__ID__ ']) }}'.replace('__ID__', cxcId),
        method: 'PUT',
        data: {
            _token: '{{ csrf_token() }}',
            balance: balance,
            status: status,
        },
        success: function () {
           
        },
        error: function (xhr) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: 'Hubo un error al actualizar la cuenta. ' + xhr.responseJSON.error,
            });
        }
    });
}

function finalizeProcess(patientId) {
    Swal.fire({
        icon: "success",
        title: "Abonos Guardados Correctamente",
        showConfirmButton: false,
        timer: 3500
    });

 
    calcTotal();

  
    window.open(
        '{{ route('CXCReceipt.pdf', ['patient_id' => '__PATIENT_ID__', 'abonosEncoded' => '__ABONOS__']) }}'
        .replace('__PATIENT_ID__', encodeURIComponent(patientId))
        .replace('__ABONOS__', encodeURIComponent(JSON.stringify(recentAbonosIds))),
        '_blank'
    );
    window.location.href = "{{ route('CXC.index') }}";
   
  
}


function getAbonosData() {
    var abonosData = [];
    let totalAbono = 0;
    let cxcIds = [];
  

    $('#budgetsTable tbody tr').each(function() {
        var checkbox = $(this).find('.recipe_checkbox');
        let montoCell = $(this).find('td').eq(8).text();
        let customPayment = parseFloat($('#custom_payment').val()) || 0;
        if (checkbox.is(':checked')) {
            let abono = parseFloat(montoCell.replace(/[^0-9.-]+/g, ""));
            totalAbono += abono;

            var row = {
                fecha: $(this).find('td').eq(1).text(),
                procedure: $(this).find('td').eq(2).text(),
                treatment: $(this).find('td').eq(3).text(),
                quantity: $(this).find('td').eq(4).text(),
                amount: $(this).find('td').eq(5).text(),
                discount: $(this).find('td').eq(6).text(),
                coberture: $(this).find('td').eq(7).text(),
                total: abono.toFixed(2)
            };
            abonosData.push(row);

            // Agregar el cxc-id al array
            let cxcId = $(this).data('cxc-id');
            if (cxcId) {
                cxcIds.push(cxcId);
            }
        }
        else if (customPayment > 0) {
            totalAbono += customPayment; // Sumar al total de abonos
            checkbox.prop('checked', true);
            
            // Agregar el cxc-id al array
            let cxcId = $(this).data('cxc-id');
            if (cxcId) {
                cxcIds.push(cxcId);
            }

            abonosData.push({
                fecha: $(this).find('td').eq(1).text(),
                procedure: $(this).find('td').eq(2).text(),
                treatment: $(this).find('td').eq(3).text(),
                quantity: $(this).find('td').eq(4).text(),
                amount: $(this).find('td').eq(5).text(),
                discount: $(this).find('td').eq(6).text(),
                coberture: $(this).find('td').eq(7).text(),
                total: totalAbono.toFixed(2)
            });
        }
    });
console.log(totalAbono);
    return {
        abonosData,
        totalAbono,
        cxcIds // Regresar el array de cxcIds
    };
}

function addCheckboxListeners() {
    const checkboxes = document.querySelectorAll('#budgetsTable input[type="checkbox"]');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            calcTotal();

        });
    });
}

window.addEventListener("load", function() {
 
        
                   

    addCheckboxListeners();
    calcTotal();
});

$("#custom_payment").on('input', function() {
    calcTotal();

});

function markAllAsPaid() {
    const table = document.getElementById("budgetsTable");

    for (let i = 1; i < table.rows.length - 1; i++) {
        let checkbox = table.rows[i].querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.checked = true;
        }
    }


}
</script>


@endsection