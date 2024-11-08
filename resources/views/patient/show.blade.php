@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')

<style>
.container {
    width: 1000px;
    margin-left: 20%;
}

.clinic-patient-info div {
    padding: 10px;
    border-top: 1px solid #ededed;
}

#patient-card {
    background: white !important;
    border-top-color:var(--background) !important;
    border-top: 3px solid !important;
    color:var(--background) !important;
}

h1 {
    color: #737373 !important;
}

.card-title {
    color: var(--txt) !important;
    margin-left: auto !important;
}
#img-odonto{
 padding-bottom: 1px; padding-top: 2px; 
    width: 750px;
    margin-right: 50px;
    border-width: 2px 2px 2px 2px;  
    border-style: solid solid solid solid;
    border-color:var(--background);
}

</style>
<div class="container ml-4">
    <div class="card ">
        <div class="card-header">
            <h4 class="card-title mt-2 ">Historial del paciente</h4>
        </div>
        <div class="card-body rounded-bottom">
            <div class="row mt-2 pb-4">
                <div class=" col-2 image clinic-image " style="padding:20px">
                    <img src="https://dentalclinicapp.com/uploads/female.png" class="img-circle"
                        style="width:100px;height:100px">
                </div>
                <div class="col-8 ml-4  mt-4 ">
                    <h1>{{ $patient->name }}</h1>
                    <p><i class="fa fa-phone" aria-hidden="true"></i>: {{$patient->phone}}</p>
                    <div class="row" id="buttons">

                        <div class="ml-2 mr-2 btn  col-2"><a style=" text-decoration: none; color: var(--txt) !important;"
                                href="{{ route('patient.edit', ['id' => $patient->pacient_id]) }}"><i
                                    class="fa fa-pen  " aria-hidden="true"></i> Editar</a></div>
                        <div class="col-2 btn "><a style=" text-decoration: none; color: var(--txt) !important;" href=""><i
                                    class="fa fa-trash" aria-hidden="true"></i> Eliminar</a></div>


                    </div>

                </div>
            </div>
            <div class="row clinic-patient-info">


                <div class="col-md-6">
                    <span><b>Dirección: </b>Dirección del Paciente</span>
                </div>
                <div class="col-md-3">
                    <span><b>Fecha de Nacimiento:
                        </b>{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d/m/Y') }}</span>
                </div>

                <div class="col-md-6">
                    <span><b>Motivo de Consulta: </b>{{$patient->motive}}</span>
                </div>
                <div class="col-md-3">
                    <span><b>Edad: </b>
                        @php
                        $birthdate = \Carbon\Carbon::parse($patient->date_of_birth);
                        $now = \Carbon\Carbon::now();
                        $years = $birthdate->diffInYears($now);
                        $months = $birthdate->diffInMonths($now) % 12;
                        @endphp

                        @if ($years > 0)
                        {{ $years }} años
                        @else
                        {{ $months }} meses
                        @endif
                    </span>
                </div>

                <div class="col-md-6">
                    <span><b>Fecha de Registro: </b>{{$patient->created_at->format('d/m/Y')}}</span>
                </div>
                <div class="col-md-6">
                    <span><b>Fecha de Próxima Cita: </b>{{$patient->updated_at->format('d/m/Y')}}</span>
                </div>
                <div class="col-md-6">
                    <span><b>Número de Identificación: </b>{{$patient->Cedula}}</span>
                </div>
                <div class="col-md-6">
                    <span><b>Número de Contacto : </b>{{$patient->phone}}</span>
                </div>
            </div>
        </div>

    </div>
    <div class="card " id="patient-card">
        <div class="card-body rounded">
            <div class="row mt-4">
                <div class="col-2 ml-2">
                    <i class="fas fas fas fa-teeth fa-5x"></i>
                </div>
                <div class="col-8 ">
                    <h1>Odontodiagrama</h1>

                    @if($odontographid && $odontographid->image_path)
                    <img src="{{ asset($odontographid->image_path) }}" id="img-odonto" alt="Odontodiagrama">
                
                    @else
                    <p>No hay odontodiagrama disponible para este paciente.</p>
                    @endif

                </div>
            </div>
            <a href="{{ route('showBudget', $patient->pacient_id) }}"
                class="btn text-white btn-md  mt-4 p-3 ml-2 float-right">Eliminar <i class="fa fa-trash"
                    aria-hidden="true"></i></a>
            <a href="{{ route('showBudget', $patient->pacient_id) }}"
                class="btn text-white btn-md  mt-4 p-3 ml-2 float-right">Editar <i class="fa fa-pen"
                    aria-hidden="true"></i></a>
        </div>
        </div>
   

    <div class="card " id="patient-card">
        <div class="card-body rounded">
            <div class="row mt-4">
                <div class="col-2 ml-2">
                    <i class="fas fas fas fa-capsules fa-5x"></i>
                </div>
                <div class="col-8">
                    <h1>Planes de Tratamiento</h1>
                    <p>Tratamientos del paciente</p>
                </div>
            </div>

            @if($budget->isNotEmpty())
            <table id="budgetTable" class=" mt-4">
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
                @foreach($budget as $budgets)
        <tr>
            <th scope="row">{{ $budgets->id }}</th>
            <td style="color: {{ $budgets->type == 'Credito' ? '#bdbd2d' : '#2dbd40' }} !important;"><b>{{ $budgets->type }}</b></td>
            <td><b>{{ $budgets->patient->name }}</b></td>
            <td><b>{{ number_format($budgets->Total, 2);}} $</b></td>
            <td>
                <div class="form-inline justify-content-center">
                    <a href="{{ route('budgets.edit', ['id' => $budgets->id, 'pacientid' => $budgets->patient->pacient_id]) }}" class="btn">
                        <i class="fas fa-pencil" aria-hidden="true"></i> Editar
                    </a>
                    <form action="{{ route('delete.budget', ['id' => $budgets->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn mt-3 ml-1 " id="delete_button_">Eliminar</button>
                    </form>
                    <a href="{{ route('budgets.print', $budgets->id) }}" target="_blank" class="btn ml-1" id="print-button">Imprimir</a>

                </div>
            </td>
        </tr>
        @endforeach
                </tbody>
            </table>
            @else
            <p>No hay planes de tratamiento disponibles.</p>
            @endif
            <a href="{{ route('showBudget', $patient->pacient_id) }}"
                class="btn text-white btn-md  mt-2 p-2 ml-2 float-right">Crear Plan de Tratamiento <i class="fa fa-plus"
                    aria-hidden="true"></i></a>
        </div>
    </div>


    <div class="card " id="patient-card">
        <div class="card-body rounded">
            <div class="row mt-4">
                <div class="col-2 ml-2">
                    <i class="fas fa-money-bill     fa-5x"></i>
                </div>
                <div class="col-8 ">
                    <h1>Cuentas Por Cobrar</h1>
                    <p>Hacer un pago del paciente.</p>
                </div>
            </div>@if($CXCS->isNotEmpty())
            <table id="CXCTable" class=" mt-4">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Balance</th>
                        <th scope="col">Status</th>
                        <th scope="col">Fecha de Emision</th>
                     
                        <th scope="col">Total</th>
                        <th scope="col">Abonos pagos</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($CXCS as $CXC)
                    <tr style="cursor: pointer;" >
                        <th scope="row">{{ $CXC->id }}</th>
                        <td><b>{{ $patient->name }}</b></td>
                        <td><b>{{ $CXC->balance }}</b></td>
                        @if ($CXC->status == "pendiente")
                        <td style="color: #bdbd2d !important;"><b>{{ $CXC->status }}</b></td>
                        @elseif($CXC->status == "pagado")
                        <td style="color: #2dbd40 !important;"><b>{{ $CXC->status }}</b></td>
                        @elseif($CXC->status == "vencido")
                        <td style="color: #bd2d40 !important;"><b>{{ $CXC->status }}</b></td>
                        @endif
                        <td><b>{{ $CXC->updated_at->toDateString() }}</b></td>
                        <td><b>{{ number_format($CXC->total, 2);}}</b></td>
                        <td><b>{{ $CXC->abonos_count }}</b></td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No hay planes de tratamiento disponibles.</p>
            @endif
            <a href="{{route('CXC.create')}}" class="btn text-white btn-md mt-2 p-2 ml-2 float-right">Crear Pago <i
                    class="fa fa-plus" aria-hidden="true"></i></a>
        </div>
    </div>

    <div class="card " id="patient-card">
        <div class="card-body rounded">
            <div class="row mt-4">
                <div class="col-2 ml-2">
                    <i class="fas fa-money-bill     fa-5x"></i>
                </div>
                <div class="col-8 ">
                    <h1>Abonos</h1>
                    <p>Hacer un pago del paciente.</p>
                </div>
            </div>@if($abonos->isNotEmpty())
            <table id="abonosTable" class=" mt-4">
                <thead>
                    <tr>
                        <th># de Cuenta</th>
                        <th># de Abono</th>
                        <th>Fecha</th>
                        <th>Procedimiento</th>
                        <th>Abono</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($abonos as $abono)

                    <tr>
                        <td><b>{{$abono->c_x_c_id}}</b></td>
                        <td><b>{{ $abono->id }}</b></td>
                        <td><b>{{ $abono->created_at->toDateString() }}</b></td>
                        <td><b>{{ $abono->procedure }}</b></td>
                        <td><b>{{ $abono->abonar }}</b></td>
                        <td><b>{{ $abono->Total }}</b></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No hay abonos disponibles.</p>
            @endif
            <a href="{{route('CXC.create')}}" class="btn text-white btn-md mt-2 p-2 ml-2 float-right">Crear Pago <i
                    class="fa fa-plus" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="card " id="patient-card">
        <div class="card-body rounded">
            <div class="row mt-4">
                <div class="col-2 ml-2">
                    <i class="fas fa-briefcase-medical fa-5x"></i>
                </div>
                <div class="col-8 ">
                    <h1>Recetar</h1>
                    <p>Hacer una receta para el paciente.</p>
                </div>
            </div>
            <a href="{{route('RX.index')}}" class="btn text-white btn-md p-2 ml-2 float-right">Crear Receta <i
                    class="fa fa-plus" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="card " id="patient-card">
        <div class="card-body rounded">
            <div class="row mt-4">
                <div class="col-2 ml-2">
                    <i class="fas fa-calendar fa-5x"></i>
                </div>
                <div class="col-8 ">
                    <h1>Citas</h1>
                    <p>Hacer una cita para el paciente.</p>
                </div>
            </div>
            <a href="{{route('events.create')}}" class="btn text-white btn-md p-2 ml-2 float-right">Crear Cita <i
                    class="fa fa-plus" aria-hidden="true"></i></a>
        </div>
    </div>
    </div>


</div>

<script>
    $('#delete_button').on('click', function(event) {
    event.preventDefault();

    Swal.fire({
        title: "Deseas Eliminar el Presupuesto?",
        text: "No podras revertir el cambio!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--background)",
        cancelButtonColor:  "var(--background)",
        
        confirmButtonText: "Si, eliminalo!"
    }).then((result) => {
        if (result.isConfirmed) {

            $(this).closest('form').submit();

            Swal.fire({
                title: "Eliminado!",
                text: "El Presupuesto ha sido eliminado correctamente.",
                icon: "success"
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
    },
});

$('#CXCTable').DataTable({
    dom: 'Bfrtip',
    "language": {
        "emptyTable": "No hay Cuentas por Cobrar Registradas",
        "sSearch": "Buscar"
    },
});
$('#abonosTable').DataTable({
    dom: 'Bfrtip',
    "language": {
        "emptyTable": "No hay Abonos Registrados",
        "sSearch": "Buscar"
    },
});
});
</script>
@endsection