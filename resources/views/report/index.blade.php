@extends('layouts.app')
@extends('layouts.sidebar')



@section('content')

<link type="text/css" href="{{ URL::asset('css/custom-theme/jquery-ui-1.8.13.custom.css') }}" rel="stylesheet" />

<script type="text/javascript" src="{{ URL::asset('js/jquery-1.7.2.min.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('js/jquery-ui-1.8.13.custom.min.js') }}"></script>


<style>
#contenedor {
    margin-left: 10% !important;
    margin-top: 3% !important;
}


.disabled {
    pointer-events: none;
    opacity: 0.5;
}


table,

td {
    background-color: var(--txt) !important;
}

table,

th {
    background-color: var(--background) !important;
    color: var(--txt) !important;
    border: none !important;
}

.form-check-input {
    border-color: var(--background) !important;
}

.form-control {
    border-color: var(--background) !important;
}
</style>

@if(session('success'))

<script>
swal.fire({
    icon: "success",
    text: "Paciente Registrado correctamente",
});
</script>
@endif

@if(session('error'))
<script>
swal.fire({
    icon: "error",
    title: "Oops...",
    text: "Error al registrar el paciente",
});
</script>
@endif
<div id="contenedor" class="row justify-content-center">
    <!-- Card 1 -->
    <div class="col-md-6 mr-3">
        <div class="card text-white bg-pink">
            <div class="card-header text-center">
                <h3 class="p-2">Smile Clinic</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('report.generate') }}" method="POST" class="form-group">
                    @csrf
                    <div class="form-group">
                        <label for="startDate">Desde *</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" required>

                        <label class="mt-2" for="endDate">Hasta *</label>
                        <input type="date" class="form-control" id="endDate" name="endDate" required>

                        <label class="mt-2" for="select-1">Tabla 1 *</label>
                        <select class="form-control" name="select-1" id="select-1" required>
                            <option value="0">Seleccione una tabla...</option>
                            <option value="patient">Paciente</option>
                            <option value="odontograph">Odontodiagrama</option>
                            <option value="budgets">Presupuestos</option>
                            <option value="cxc">Cuentas Por Cobrar</option>
                            <option value="abonos">Abonos</option>
                            <option value="expenses">Egresos</option>
                            <option value="RX">Medicamentos</option>
                        </select>

                        <label class="mt-2" for="select-2">Tabla 2</label>
                        <select class="form-control" name="select-2" id="select-2">
                            <option value="0">Seleccione una tabla...</option>
                            <option value="patient">Paciente</option>
                            <option value="odontograph">Odontodiagrama</option>
                            <option value="budgets">Presupuestos</option>
                            <option value="cxc">Cuentas Por Cobrar</option>
                            <option value="abonos">Abonos</option>
                            <option value="expenses">Egresos</option>
                            <option value="RX">Medicamentos</option>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <input type="submit" class="form-control btn btn-light" id="generate_report" name="submit"
                            value="Generar Reporte">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-5 ml-3">
        <div class="card text-white bg-pink">
            <div class="card-header text-center">
                <h3 class="p-2">Reportes Disponibles</h3>
            </div>
            <div class="card-body rounded-bottom">
                <table class="table table-bordered text-white text-center ">
                    <thead>
                        <tr>
                            <th><b>Opcion 1</b></th>
                            <th><b>Opcion 2</b></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td colspan="2"><b>Pacientes</b></td>
                        </tr>


                        <tr>
                            <td>Paciente</td>
                            <td>Odontodiagrama</td>
                        </tr>
                        <tr>
                            <td>Paciente</td>
                            <td>Presupuestos</td>
                        </tr>
                        <tr>
                            <td>Paciente</td>
                            <td>Cuentas Por Cobrar</td>
                        </tr>
                        <tr>
                            <td>Paciente</td>
                            <td>Abonos</td>
                        </tr>

                        <tr>
                            <td colspan="2"><b>Odontodiagramas</b></td>
                        </tr>

                        <tr>
                            <td>Odontodiagrama</td>
                            <td>Paciente</td>
                        </tr>
                        <tr>
                            <td>Odontodiagrama</td>
                            <td>Presupuestos</td>
                        </tr>

                        <tr>
                            <td colspan="2"><b>Presupuestos</b></td>
                        </tr>

                        <tr>
                            <td>Presupuestos</td>
                            <td>Paciente</td>
                        </tr>
                        <tr>
                            <td>Presupuestos</td>
                            <td>Odontodiagrama</td>
                        </tr>
                        <tr>
                            <td>Presupuestos</td>
                            <td>Cuentas Por Cobrar</td>
                        </tr>
                        <tr>
                            <td>Presupuestos</td>
                            <td>Abonos</td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Cuentas Por Cobrar</b></td>
                        </tr>


                        <tr>
                            <td>Cuentas Por Cobrar</td>
                            <td>Paciente</td>
                        </tr>
                        <tr>
                            <td>Cuentas Por Cobrar</td>
                            <td>Presupuestos</td>
                        </tr>
                        <tr>
                            <td>Cuentas Por Cobrar</td>
                            <td>Abonos</td>
                        </tr>

                        <tr>
                            <td colspan="2"><b>Abonos</b></td>
                        </tr>

                        <tr>
                            <td>Abonos</td>
                            <td>Paciente</td>
                        </tr>
                        <tr>
                            <td>Abonos</td>
                            <td>Presupuestos</td>
                        </tr>
                        <tr>
                            <td>Abonos</td>
                            <td>Cuentas Por Cobrar</td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Egresos</b></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Medicamentos</b></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script>
    $(document).on('click', '[id^="generate_report"]', function(event) {
        event.preventDefault(); // Evitar la acción predeterminada del formulario

        const form = $(this).closest('form'); // Obtener el formulario asociado
        let select = document.getElementById('select-1').value;
        let select2 = document.getElementById('select-2').value;
        let startDate = document.getElementById('startDate').value;
        let endDate = document.getElementById('endDate').value;


        if (startDate > endDate) {
            Swal.fire({
                title: "Error",
                text: "La fecha inicial no puede ser mayor a la final. Intenta de nuevo.",
                icon: "error"
            });
            return false;
        }

        if (select == 0 && !startDate || !startDate) {
            Swal.fire({
                title: "Error",
                text: "Debe llenar los campos necesarios. Intenta de nuevo.",
                icon: "error"
            });
            return false;
        }
        if (select2 != 0) {
            let selects = select + '-' + select2;
            console.log(selects);

            switch (select) {
                case selects = 'patient-odontograph':
                    submitReport();
                    break;
                case selects = 'patient-budgets':
                    submitReport();
                    break;
                case selects = 'patient-cxc':
                    submitReport();
                    break;
                case selects = 'patient-abonos':
                    submitReport();
                    break;
                case selects = 'odontograph-patient':
                    submitReport();
                    break;
                case selects = 'odontograph-budgets':
                    submitReport();
                    break;
                case selects = 'budgets-patient':
                    submitReport();
                    break;
                case selects = 'budgets-odontograph':
                    submitReport();
                    break;
                case selects = 'budgets-cxc':
                    submitReport();
                    break;
                case selects = 'budgets-abonos':
                    submitReport();
                    break;
                case selects = 'cxc-patient':
                    submitReport();
                    break;
                case selects = 'cxc-budgets':
                    submitReport();
                    break;
                case selects = 'cxc-abonos':
                    submitReport();
                    break;
                case selects = 'abonos-patient':
                    submitReport();
                    break;
                case selects = 'abonos-budgets':
                    submitReport();
                    break;
                case selects = 'abonos-cxc':
                    submitReport();
                    break;
                default:
                    break;
            }
            return false;


        } else {

            console.log(select);
            submitReport();
        }



    });

    function submitReport() {

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {

                Swal.fire({
                    title: "Generando Reporte!",
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });


            },
            error: function(xhr) {

                Swal.fire({
                    title: "Error",
                    text: "No se pudo eliminar el Medicamento. Intenta de nuevo.",
                    icon: "error"
                });
            }
        });
    }
    </script>


    @endsection