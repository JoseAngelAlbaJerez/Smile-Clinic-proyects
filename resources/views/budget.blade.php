@extends('layouts.app')
@extends('layouts.sidebar')



@section('content')

<style>
.container {

    width: 90%;
    margin-left: 10%;
}
.dt-button, #tabla_filter{
    display: none !important;
}


.btn {
    color: var(--txt) !important;

    margin-left: 40%;
    padding: 10px. 20px;
}

#procedimientoModelo {
    display: none;
}

#tabla, th{
    color: var(--background);
}
th{
    background-color: var(--background) !important;
}

#presupuesto {
    margin-left: 720px;

}




#img-odonto{
 padding-bottom: 1px; padding-top: 2px; 
  
    border-width: 2px 2px 2px 2px;  
    border-style: solid solid solid solid;
    border-color:var(--background);
    margin-left: 50px;
}
</style>
<div class="container ">
    <div class="card  "style="color: var(--txt) !important;">

        <div class="card-header  mt-2">
            <h3 class="ml-auto mr-auto p-2">Smile Clinic</h3>

        </div>

        <div class="card-body rounded-bottom">


            <div class=" form-inline">
            <h5 class="mt-2 ">Tipo de Pago: </h5>
                <select class="form-control ml-2" style="width:  160px;" type="number" name="type" id="type">
                    <option value="Contado">Contado</option>
                    <option value="Credito">Credito</option>
                </select>

            <h5 class="mt-2 ml-2">Buscar Procedimiento: </h5> <select class=" form-control ml-2 " style="width: 600px;" type="text"
                name="nombre_procedimiento">
                <option id="prod">Procedimientos...</option>
                <option value="Protesis" data-cantidad="1" data-monto="500">Protesis</option>
                <option value="Extracciones" data-cantidad="1" data-monto="500">Extracciones</option>
                <option value="Caries" data-cantidad="1" data-monto="800">Caries</option>
                <option value="Restauraciones" data-cantidad="1" data-monto="500">Restauraciones</option>
                <option value="Ausencias" data-cantidad="1" data-monto="500">Ausencias</option>
                <option value="Corona" data-cantidad="1" data-monto="500">Corona</option>
                <option value="Implantes" data-cantidad="1" data-monto="500">Implantes</option>
                <option value="Pulpar" data-cantidad="1" data-monto="500">Pulpar</option>
                <option value="Periodontal" data-cantidad="1" data-monto="500">Periodontal</option>
                <option value="Resinas" data-cantidad="1" data-monto="500">Resinas</option>
                <option value="Cirugia" data-cantidad="1" data-monto="500">Cirugia</option>
                <option value="Ortodoncia" data-cantidad="1" data-monto="500">Ortodoncia</option>


            </select>
               



           
          

            </div>
            <h5 class="mt-2">Paciente : {{ $paciente->name}}</h5>
            @php
            $totalAmount = 0;
            @endphp




            <table class="mt-3" id="tabla">
                <thead class='bg-pink'>
                    <tr>
                        <th>Diagnóstico</th>
                        <th style="width: 10%;">Tratamiento</th>
                        <th style="width: 20;">Cantidad</th>
                        <th style="width: 20;">Monto</th>
                        <th style="width: 20;">Cobertura</th>
                        <th style="width: 20;">Descuento</th>
                        <th style="width: 20;">Total Unitario</th>
                        <th >Acciones </th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr id="procedimientoModelo"style="background-color: var(--txt) !important;" >
                       
                        <th scope="row" style="background-color: var(--txt) !important;"></th>
                        <td contenteditable></td>
                        <td contenteditable></td>
                        <td contenteditable></td>
                        <td contenteditable></td>
                        <td contenteditable></td>
                        <td contenteditable></td>
                        <td ></td>
                    
                       
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td style="text-align: left; color: #767675 !important; font-weight: bold;" colspan="7"
                            id="td_total">Total</td><b>
                        <td id='tdTotal'style="color: var(--background);"></td></b>
                    </tr>
                </tfoot>
            </table>



            <button class=" btn mt-3 pl-4 pr-4 " type="submit">Guardar</button>

        </div>
        <div hidden="true" id="patient-info" data-id="{{ $paciente->pacient_id }}"></div>


    </div> 
    
    @if (!$odontodiagrama)
    
    @else
    <div class="card "style="color: var(--txt) !important;">


<div class="card-header  mt-2">
    <h3 class="ml-auto mr-auto p-2">Odontograma</h3>

</div>

<div class="card-body rounded-bottom">


    <div class=" form-inline">
    <img src="{{ asset($odontodiagrama->image_path) }}" id="img-odonto" alt="Odontodiagrama">

</div>



</div>






</div>
    @endif
  
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

    $('select[name="nombre_procedimiento"]').change(function() {

        $('#type').prop('disabled', true);
        var procedimientoSeleccionado = $(this).val();
        var cantidad = $(this).find(':selected').data('cantidad');
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
                return false;
            }
        });

        if (!existe) {
            // Clonar la fila modelo
            var nuevaFila = $('#procedimientoModelo').clone();

            // Agregar la nueva fila a la tabla
            nuevaFila.removeAttr('id').show();
            nuevaFila.find('th').text(procedimientoSeleccionado);
            nuevaFila.find('td:eq(0)').text(''); // Tratamiento
            nuevaFila.find('td:eq(1)').text('1'); 
            nuevaFila.find('td:eq(2)').text(monto); // Monto
            nuevaFila.find('td:eq(3)').text(c + '%'); // Cobertura
            nuevaFila.find('td:eq(4)').text(d + '%'); // Descuento
            nuevaFila.find('td:eq(5)').text(total); // Total
            nuevaFila.find('td:eq(6)').append(
                             `<a href="#" class="btn   eliminar ">Eliminar</a>` 
           
            );


         

            nuevaFila.appendTo('table tbody');

            // Deshabilitar la opción seleccionada
            $(this).find(':selected').prop('disabled', true);
        } else {
            swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Este presupuesto ya ha sido seleccionado.",
            });

        }

        calcTotal(); // Llamar a la función que calcula el total
    });

    $(document).on('click', '.eliminar', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        calcTotal();
    });








$('table').on('input', ' td[contenteditable]', function() {
    var $row = $(this).closest('tr');
        var cantidad = parseInt($row.find('td:eq(1)').text()) || 0;
        var monto = parseInt($row.find('td:eq(2)').text()) || 0;
        var descuento = parseInt($row.find('td:eq(4)').text()) || 0;

  
    saved_cantidad = cantidad;
    saved_monto = monto;

 
    $row.find('td:eq(5)').text(cantidad * monto); 

    calcTotal();
});


    $('.btn[type="submit"]').click(function(event) {
        event.preventDefault();

        if ($('#type').val() === "Credito") {
            let tableData = getTableData();
          
            let patientId = $('#patient-info').data('id');
            let type = $('#type').val();
            
         
            let saved_total = parseFloat($("#tdTotal").text()) || 0;
           
            let balance = parseFloat(saved_total ).toFixed(2);

            
            let status = "pendiente";

         
         

            // Guardar los datos de la CXC primero
            $.ajax({
                    url: '{{ route('CXC.store') }}',
                    method: 'POST', 
                    data: {
                        _token: '{{ csrf_token() }}', 
                        patient_id: patientId,
                        balance: balance,
                        status: status,
                       
                        
                        total: saved_total
    },
                success: function(response) {
                    $.ajax({
                        url: '{{ route('budget_header.store') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            patient_id: patientId,
                            
                            type: type,
                            total: balance
                        },
                        success: function(headerResponse) {
                            let budgetHeaderId = headerResponse.budget_header_id; 
                            
                            $.ajax({
                        url: '{{ route('store.budgets') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            datos: tableData,
                            patient_id: patientId,
                            type: type,
                            budget_header_id: budgetHeaderId,
                           
                        },
                        success: function(response) {
                            let patientId = response.patient_id;
                            let budgetIds = response.budgets.map(budget =>
                                budget.id);
                            let budgetIdsEncoded = encodeURIComponent(JSON
                                .stringify(budgetIds));

                            let url = '{{ route('budgetsCXC.pdf', ['patient_id' => '__PATIENT_ID__', 'budgetIds' => '__BUDGET_IDS__']) }}'.replace('__PATIENT_ID__', patientId).replace('__BUDGET_IDS__', budgetIdsEncoded);

                            // Abrir el PDF en una nueva pestaña
                            window.open(url, '_blank');

                            // Redirigir a la página de índice de CXC
                            window.location.href = "{{ route('CXC.index') }}";
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
                            return false;
                        }
                    });
                        
                                        },error: function(xhr) {
                        swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: 'Hubo un error al guardar el encabezado. ' + (xhr.responseJSON?.error || xhr.statusText),
                        });
                        return false;
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
                    return false;
                }
            });

        } else {
    let tableData = getTableData();
    let patientId = $('#patient-info').data('id');
    let type = $('#type').val();
   
           
    // Primera solicitud AJAX: Guardar el encabezado del presupuesto
    $.ajax({
    url: '{{ route('budget_header.store') }}',
    method: 'POST',
    data: {
        _token: '{{ csrf_token() }}',
        patient_id: patientId,
        type: type,
        total: saved_total
    },
    success: function(headerResponse) {
        let budgetHeaderId = headerResponse.budget_header_id; // Obtiene el ID del encabezado

        // Segunda solicitud AJAX: Guardar los detalles del presupuesto
        $.ajax({
            url: '{{ route('store.budgets') }}',
            method: 'POST',
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

                let budgetsEncoded = encodeURIComponent(JSON.stringify(detailResponse.budgets));
                let url = '{{ route('budgets.pdf', ['patient_id' => '__PATIENT_ID__']) }}'
                    .replace('__PATIENT_ID__', patientId) + '/' + budgetsEncoded;
                
                window.open(url, '_blank');
                window.location.href = "{{ route('budget.index') }}";
            },
            error: function(xhr) {
                swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: 'Hubo un error al guardar los detalles. ' + (xhr.responseJSON?.error || xhr.statusText),
                });
                return false;
            }
        });
    },
    error: function(xhr) {
        swal.fire({
            icon: "error",
            title: "Oops...",
            text: 'Hubo un error al guardar el encabezado. ' + (xhr.responseJSON?.error || xhr.statusText),
        });
        return false;
    }
});
}
    });

    function getTableData() {
    let tableData = [];
    $('table tbody tr').each(function() {
        let procedure = $(this).find('th').text().trim();
        let treatment = $(this).find('td:eq(0)').text().trim();
        let quantity = $(this).find('td:eq(1)').text().trim();;
        let amount = $(this).find('td:eq(2)').text().trim().replace(',', '');
        let coberture = $(this).find('td:eq(3)').text().trim().replace('%', '');
        let discount = $(this).find('td:eq(4)').text().trim().replace('%', '');
        let total = $(this).find('td:eq(5)').text().trim();
        
     
     
        let balance = parseFloat(total).toFixed(2);
        
        
        if (procedure && quantity && amount && coberture && discount && total) {
            let row = {
                procedure: procedure,
                treatment: treatment,
                quantity: parseInt(quantity, 10),
                amount: parseFloat(amount),
                coberture: parseFloat(coberture),
                discount: parseFloat(discount),
                total: parseFloat(total),
              
            };
            tableData.push(row);
          
        }
    });
    console.log("Table Data:", tableData); // Agrega este log para depuración
    return tableData;
}


    window.addEventListener("load", function() {
        calcTotal();

    });

    function calcTotal() {
        let total = 0;
        const table = document.getElementById("tabla");
        for (let i = 1; i < table.rows.length; i++) {
            let cell = table.rows[i].cells[6];
            if (cell !== undefined) {
               
                let rowValue = cell.innerHTML;
                total = total + Number(rowValue);
            }
        }
        const tdTotal = document.getElementById('tdTotal');
        tdTotal.textContent = total;
        saved_total = total;
        
        getTableData();
    }
});
</script>
@endsection