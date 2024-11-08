@extends('layouts.app')
@extends('layouts.sidebar')



@section('content')

<style>
.container {

    width: 1200px;
    margin-left: 10%;
}

.dt-button,
#tabla_filter {
    display: none !important;
}


.btn[type=submit] {
    color: var(--txt) !important;

    margin-left: 40%;
    padding: 10px. 20px;
}

#procedimientoModelo {
    display: none;
}



#presupuesto {
    margin-left: 720px;

}

#initial_payment {
    width: 14%;

}

#emission_date {
    width: 14%;

}

#expiration_date {
    width: 14%;

}
</style>
<div class="container ">
    <div class="card text-white ">

        <div class="card-header  mt-2">
            <h3 class="ml-auto mr-auto p-2 ">Smile Clinic</h3>

        </div>

        <div class="card-body rounded-bottom">

            <div class=" form-inline">


                <h5 class="mt-2 ml-2">Buscar Procedimiento: </h5> <select class="form-control ml-2 "
                    style="width: 425px;" type="text" name="nombre_procedimiento">
                    <option id="prod">Procedimientos...</option>
                    <option value="Protesis" data-cantidad="1" data-monto="500.00">Protesis</option>
                    <option value="Extracciones" data-cantidad="1" data-monto="500.00">Extracciones</option>
                    <option value="Caries" data-cantidad="1" data-monto="800.00">Caries</option>
                    <option value="Restauraciones" data-cantidad="1" data-monto="500.00">Restauraciones</option>
                    <option value="Ausencias" data-cantidad="1" data-monto="500.00">Ausencias</option>
                    <option value="Corona" data-cantidad="1" data-monto="500.00">Corona</option>
                    <option value="Implantes" data-cantidad="1" data-monto="500.00">Implantes</option>
                    <option value="Pulpar" data-cantidad="1" data-monto="500.00">Pulpar</option>
                    <option value="Periodontal" data-cantidad="1" data-monto="500.00">Periodontal</option>
                    <option value="Resinas" data-cantidad="1" data-monto="500.00">Resinas</option>
                    <option value="Cirugia" data-cantidad="1" data-monto="500.00">Cirugia</option>
                    <option value="Ortodoncia" data-cantidad="1" data-monto="500.00">Ortodoncia</option>

                </select>
                <h5 class="mt-2 ml-2 ">Tipo : </h5>
                <select class="form-control ml-2" style="width:  160px;" type="number" name="type" id="type" disabled>
                    <option value="{{$budget->type}}">{{$budget->type}}</option>


                </select>
                <h5 class="ml-2" id="initial_payment_label">Inicial: </h5>

                <input disabled type="number" class="form-control ml-2" name="initial_payment" id="initial_payment"
                    value="{{round($budget->initial_payment)}}">


                <h5 class="mt-2 ml-2"><b>Paciente : {{ $paciente->name}}</b></h5>







            </div>

            <table id="tabla" class="mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Procedimiento</th>
                        <th style="width: 20%;">Tratamiento</th>
                        <th>Cantidad</th>
                        <th>Monto</th>
                        <th>Cobertura</th>
                        <th>Descuento</th>
                        <th>Total Unitario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($budget_detalle as $budget_detalles)
                    <tr class="db">
                        <th scope="row" class="budget-id">{{$budget_detalles->id}}</th>
                        <td contenteditable>{{$budget_detalles->procedure}}</td>
                        <td contenteditable>{{$budget_detalles->treatment}}</td>
                        <td contenteditable>{{$budget_detalles->quantity}}</td>
                        <td contenteditable>{{$budget_detalles->amount}}</td>
                        <td contenteditable>{{$budget_detalles->coberture}}%</td>
                        <td contenteditable>{{$budget_detalles->discount}}%</td>
                        <td contenteditable>{{$budget_detalles->Total}}</td>
                        <td><a href="#" class="btn eliminar">Eliminar</a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="text-align: left; color: #767675 !important; font-weight: bold;" colspan="8">Total
                        </td>
                        <td id='tdTotal' style="text-align: right;color: var(--background);"><b></b></td>
                    </tr>
                </tfoot>
            </table>




            <button class=" btn  mt-3 pl-4 pr-4 " type="submit">Editar</button>

        </div>
        <div hidden="true" id="patient-info" data-id="{{ $paciente->pacient_id }}"></div>


    </div>






</div>
<script>
document.addEventListener('DOMContentLoaded', function() {

    $('#tabla').DataTable({
        dom: 'Bfrtip',
        "language": {
            "emptyTable": "Seleccione un Procedimiento",

        },
    });
});
</script>
<script>
$(document).ready(function() {
    let saved_total = 0;
    const table = $('#tabla').DataTable();
    var budget_ids = {!! json_encode($budget_id) !!} + 1;

    $('table').on('input', 'td[contenteditable]', function() {
        var $row = $(this).closest('tr');
        var cantidad = parseInt($row.find('td:eq(2)').text()) || 0;
        var monto = parseFloat($row.find('td:eq(3)').text()) || 0;
        var total = cantidad * monto;

        $row.find('td:eq(6)').text(total.toFixed(2));
        calcTotal(); // Actualiza el total después de editar una celda
    });

    // Asegúrate de que esta parte de código esté correctamente definida y se ejecute
    $('select[name="nombre_procedimiento"]').change(function() {
        $('#type').prop('disabled', true);
        var procedimientoSeleccionado = $(this).val();
        var cantidad = $(this).find(':selected').data('cantidad') || 1;
        var monto = $(this).find(':selected').data('monto');
        var c = 35;
        var d = 5;
        var total = cantidad * monto;
        var cobertura = c * total / 100;
        var descuento = d * total / 100;
        var totaldesc = total - cobertura - descuento;

        var existe = false;
        $('table tbody tr').each(function() {
            var procedimientoExistente = $(this).find('th').text();
            if (procedimientoExistente === procedimientoSeleccionado) {
                existe = true;
                return false; // Sale del bucle si el procedimiento ya existe
            }
        });

        if (!existe) {
            // Crea la nueva fila con jQuery y configura cada celda en el orden correcto
            var nuevaFila = $('<tr class="not-db"></tr>').append(
                `<th scope="row" class="budget-id"><b>${budget_ids}</b></th>`,
                `<td contenteditable="true">${procedimientoSeleccionado}</td>`, // Procedimiento
                `<td contenteditable="true"></td>`, // Tratamiento
                `<td contenteditable="true">${cantidad}</td>`, // Cantidad
                `<td contenteditable="true">${parseFloat(monto).toFixed(2)}</td>`, // Monto
                `<td contenteditable="true">${c}%</td>`, // Cobertura
                `<td contenteditable="true">${d}%</td>`, // Descuento
                `<td contenteditable="true" >${parseFloat(total).toFixed(2)}</td>`, // Total
                `<td><a href="#" class="btn eliminar">Eliminar</a></td>` // Botón de eliminación
            );

            // Agrega la nueva fila a la tabla
            nuevaFila.appendTo('table tbody');

            // Llama a calcTotal después de agregar una nueva fila
            calcTotal(); // Actualiza el total después de agregar un nuevo procedimiento

            budget_ids++;
            $(this).find(':selected').prop('disabled', true);
        } else {
            swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Este procedimiento ya ha sido seleccionado.",
            });
        }
    });

    $('#tabla tbody').on('click', '.eliminar', function(e) {
        e.preventDefault();
        table.row($(this).closest('tr')).remove().draw();

        calcTotal();
    });

    $(document).ready(function() {
        // Verificar el valor de #type al cargar la página
        if ($('#type').val() === "Contado") {
            $('#initial_payment').prop('disabled', true);
        } else {
            $('#initial_payment').prop('disabled', false);
        }
    });
    $('table').on('input', 'td[contenteditable]', function() {
        var $row = $(this).closest('tr');
        var cantidad = parseFloat($row.find('td:eq(2)').text()) || 0; // Asegura cantidad como número
        var monto = parseFloat($row.find('td:eq(3)').text()) || 0; // Asegura monto como número
        var total = cantidad * monto;

        $row.find('td:eq(6)').text(total.toFixed(2)); // Actualiza total de la fila
        calcTotal(); // Actualiza el total después de editar una celda
    });







    $('.btn[type="submit"]').click(function(event) {
        event.preventDefault();
        if ($('#type').val() === "Credito") {
            let tableData = getUpdateTableData();
            let SaveTableData = getTableSaveData();
            let patientId = $('#patient-info').data('id');
            let type = $('#type').val();
            let initial_payment = parseFloat($("#initial_payment").val()) || 0;
            let saved_total = parseFloat($("#tdTotal").text()) || 0;
            let balance = parseFloat(saved_total - initial_payment).toFixed(2);
            let status = "pendiente";

            if (initial_payment > saved_total) {
                swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "El pago inicial no puede ser mayor al Balance",
                });
                return;
            }

            // Guardar los datos de la CXC primero
            let cxcid = {{ $budget -> c_x_c_id ?? 0 }};
            $.ajax({
                url: '{{ url("CXC") }}/' + cxcid + '/update',
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',

                    balance: balance,
                    status: status,
                    initial_payment: initial_payment,
                    total: saved_total
                },
                //Luego Actualizar el header del budget
                success: function(response) {
                    $.ajax({
                        url: '{{ route('budget_header.update', $budget->id ) }}',
                        method: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            type: type,
                            initial_payment: initial_payment,
                            total: saved_total
                        },

                        success: function(headerResponse) {
                            let budgetHeaderId = headerResponse
                            .budget_header_id;
                            //Luego almacenamos los budgets que no tienen id (tienen clase: no-db)
                            $.ajax({
                        url: '{{ route('store.budgets') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            datos: SaveTableData,
                            patient_id: patientId,
                            type: type,
                            budget_header_id: budgetHeaderId
                        },
                        
                        success: function(response) {
                            let patientId = response.patient_id;
                            let budgetIds = response.budgets.map(budget =>
                                budget.id);
                            let budgetIdsEncoded = encodeURIComponent(JSON
                                .stringify(budgetIds));

                            let url = '{{ route('budgetsCXC.pdf', ['patient_id' => '__PATIENT_ID__', 'budgetIds' => '__BUDGET_IDS__']) }}'.replace('__PATIENT_ID__', patientId).replace('__BUDGET_IDS__', budgetIdsEncoded);

                         
                            window.open(url, '_blank');

                           
                        },
                        error: function(xhr, status, error) {
                            swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: 'Hubo un error al guardar los presupuestos. ' +
                                    xhr.responseJSON.error,
                                    error,
                                    status,
                            });
                        }
                            
                    });

                            $.ajax({
                                url: '{{ route('budgets.update') }}',
                                method: 'PUT',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    datos: tableData,
                                    patient_id: patientId,
                                    type: type,
                                    initial_payment: initial_payment,
                                    budget_header_id: budgetHeaderId
                                },
                                success: function(response) {
                                    let patientId = response
                                        .patient_id;
                                    let budgetIds = response.budgets
                                        .map(budget =>
                                            budget.id);
                                    let budgetIdsEncoded =
                                        encodeURIComponent(JSON
                                            .stringify(budgetIds));

                                            let url = '{{ route('budgetsCXC.pdf', ['patient_id' => '__PATIENT_ID__', 'budgetIds' => '__BUDGET_IDS__']) }}'.replace('__PATIENT_ID__', patientId).replace('__BUDGET_IDS__', budgetIdsEncoded);

                                    window.open(url, '_blank');

                                    // Redirigir a la página de índice de CXC
                                    window.location.href =
                                        "{{ route('CXC.index') }}";
                                },
                                error: function(xhr, status, error) {
                                    swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: 'Hubo un error al guardar los presupuestos. ' +
                                            xhr.responseJSON
                                            .error,
                                        error,
                                        status,
                                    });
                                }
                            });

                        },
                        error: function(xhr) {
                            swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: 'Hubo un error al guardar el encabezado. ' +
                                    (xhr.responseJSON?.error || xhr
                                        .statusText),
                            });
                        }

                    });


                },
                error: function(xhr) {
                    swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: 'Hubo un error al guardar los datos de la Cuenta . ' +
                            xhr.responseJSON.error,
                    });
                }
            });

        } else {
            let tableData = getUpdateTableData();
            let patientId = $('#patient-info').data('id');
            let type = $('#type').val();
            let SaveTableData =getTableSaveData();

            $.ajax({
                url: '{{ route('budget_header.update', $budget->id ) }}',
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    type: type,

                    total: saved_total
                },
                success: function(headerResponse) {
                    let budgetHeaderId = headerResponse.budget_header_id;

                          $.ajax({
                        url: '{{ route('store.budgets') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            datos: SaveTableData,
                            patient_id: patientId,
                            type: type,
                            budget_header_id: budgetHeaderId
                        },
                        
                        success: function(response) {
                            let patientId = response.patient_id;
                            let budgetIds = response.budgets.map(budget =>
                                budget.id);
                            let budgetIdsEncoded = encodeURIComponent(JSON
                                .stringify(budgetIds));

                            let url = '{{ route('budgetsCXC.pdf', ['patient_id' => '__PATIENT_ID__', 'budgetIds' => '__BUDGET_IDS__']) }}'.replace('__PATIENT_ID__', patientId).replace('__BUDGET_IDS__', budgetIdsEncoded);

                         
                            window.open(url, '_blank');

                           
                        },
                        error: function(xhr, status, error) {
                            swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: 'Hubo un error al guardar los presupuestos. ' +
                                    xhr.responseJSON.error,
                                    error,
                                    status,
                            });
                        }
                            
                    });

                    $.ajax({
                        url: '{{ route('budgets.update') }}',
                        method: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            datos: tableData,
                            patient_id: patientId,
                            type: type,

                            budget_header_id: budgetHeaderId

                        },
                        success: function(detailResponse) {
                            swal.fire({
                                icon: "success",
                                text: "Presupuesto guardado exitosamente.",
                            });


                            let budgetsEncoded = encodeURIComponent(JSON
                                .stringify(detailResponse.budgets));
                            let url = '{{ route('budgets.pdf', ['patient_id' => '__PATIENT_ID__']) }}'.replace('__PATIENT_ID__', patientId) + '/' + budgetsEncoded;

                            window.open(url, '_blank');
                            window.location.href ="{{ route('budget.index') }}";
                        },
                        error: function(xhr) {
                            swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: 'Hubo un error al guardar los detalles. ' +
                                    (xhr.responseJSON?.error || xhr
                                        .statusText),
                            });
                        }
                    });
                },
                error: function(xhr) {
                    swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: 'Hubo un error al guardar el encabezado. ' + (xhr
                            .responseJSON?.error || xhr.statusText),
                    });
                }
            });
        }
    });



    function getUpdateTableData() {
        let tableData = [];
        $('#tabla tbody tr.db').each(function() {
            let budgetId = $(this).find('.budget-id').text().trim();
            let procedure = $(this).find('td:eq(0)').text().trim();
            let treatment = $(this).find('td:eq(1)').text().trim();
            let quantity = parseInt($(this).find('td:eq(2)').text().trim(), 10) || 0;
            let amount = parseFloat($(this).find('td:eq(3)').text().trim()) || 0;
            let coberture = parseFloat($(this).find('td:eq(4)').text().trim().replace('%', '')) || 0;
            let discount = parseFloat($(this).find('td:eq(5)').text().trim().replace('%', '')) || 0;
            let total = parseFloat($(this).find('td:eq(6)').text().trim()) || 0;


            let row = {
                id: budgetId,
                procedure: procedure,
                treatment: treatment,
                quantity: quantity,
                amount: amount,
                coberture: coberture,
                discount: discount,
                total: total,
            };
            tableData.push(row);
        });
        console.log("Table Data:", tableData);
        return tableData;
    }

    function getTableSaveData() {
        let tableData = [];
        $('table tbody tr.not-db').each(function() {
            let budgetId = $(this).find('.budget-id').text().trim();
            let procedure = $(this).find('td:eq(0)').text().trim();
            let treatment = $(this).find('td:eq(1)').text().trim();
            let quantity = parseInt($(this).find('td:eq(2)').text().trim(), 10) || 0;
            let amount = parseFloat($(this).find('td:eq(3)').text().trim()) || 0;
            let coberture = parseFloat($(this).find('td:eq(4)').text().trim().replace('%', '')) || 0;
            let discount = parseFloat($(this).find('td:eq(5)').text().trim().replace('%', '')) || 0;
            let total = parseFloat($(this).find('td:eq(6)').text().trim()) || 0;


            let row = {
                id: budgetId,
                procedure: procedure,
                treatment: treatment,
                quantity: quantity,
                amount: amount,
                coberture: coberture,
                discount: discount,
                total: total,
            };
            tableData.push(row);
        });
        console.log("Save Table Data:", tableData);
        return tableData;
    }

    function calcTotal() {
        let total = 0;


        $('#tabla tbody tr').each(function() {

            let rowValue = parseFloat($(this).find('td:eq(6)').text()) || 0;
            total += rowValue;

        });

        $('#tdTotal').text(total.toFixed(2));
        saved_total = total;
        getUpdateTableData();
        getTableSaveData();
    }







    window.addEventListener("load", function() {
        calcTotal();
    });
});
</script>
@endsection