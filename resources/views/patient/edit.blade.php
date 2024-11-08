@extends('layouts.app')

@extends('layouts.sidebar')






@section('content')

<link type="text/css" href="{{ URL::asset('css/custom-theme/jquery-ui-1.8.13.custom.css') }}" rel="stylesheet" />

<script type="text/javascript" src="{{ URL::asset('js/jquery-1.7.2.min.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('js/jquery-ui-1.8.13.custom.min.js') }}"></script>


<style>
#contenedor {
    margin-left: 20% !important;
    margin-top: 3% !important;
}



.disabled {
    pointer-events: none;
    opacity: 0.5;
}




.form-check-input {
    border-color:var(--background) !important;
}

.form-control {
    border-color:var(--background) !important;
}


</style>


<script>
$(function() {
    // Logic for checkboxes - Complicaciones
    $('#complicaciones_si').change(function() {
        if ($(this).is(':checked')) {
            $('#complicaciones_no').prop('checked', false);
            $('#complicaciones_detalle').prop('disabled', false).removeClass('disabled');
            $('#complicaciones_no').prop('required', false);
        } else {
            $('#complicaciones_detalle').prop('disabled', true).addClass('disabled');
            $('#complicaciones_no').prop('required', true);
        }
    });

    $('#complicaciones_no').change(function() {
        if ($(this).is(':checked')) {
            $('#complicaciones_si').prop('checked', false);
            $('#complicaciones_detalle').prop('disabled', true).addClass('disabled');
            $('#complicaciones_si').prop('required', false);
        } else {
            $('#complicaciones_si').prop('required', true);
        }
    });

    // Logic for checkboxes - Alergias
    $('#alergias_si').change(function() {
        if ($(this).is(':checked')) {
            $('#alergias_no').prop('checked', false);
            $('#alergias_detalle').prop('disabled', false).removeClass('disabled');
            $('#alergias_no').prop('required', false);
        } else {
            $('#alergias_detalle').prop('disabled', true).addClass('disabled');
            $('#alergias_no').prop('required', true);
        }
    });

    $('#alergias_no').change(function() {
        if ($(this).is(':checked')) {
            $('#alergias_si').prop('checked', false);
            $('#alergias_detalle').prop('disabled', true).addClass('disabled');
            $('#alergias_si').prop('required', false);
        } else {
            $('#alergias_si').prop('required', true);
        }
    });

    // Logic for checkboxes - Medicamentos
    $('#medicamento_si').change(function() {
        if ($(this).is(':checked')) {
            $('#medicamento_no').prop('checked', false);
            $('#medicamentos_detalle').prop('disabled', false).removeClass('disabled');
            $('#medicamento_no').prop('required', false);
        } else {
            $('#medicamentos_detalle').prop('disabled', true).addClass('disabled');
            $('#medicamento_no').prop('required', true);
        }
    });

    $('#medicamento_no').change(function() {
        if ($(this).is(':checked')) {
            $('#medicamento_si').prop('checked', false);
            $('#medicamentos_detalle').prop('disabled', true).addClass('disabled');
            $('#medicamento_si').prop('required', false);
        } else {
            $('#medicamento_si').prop('required', true);
        }
    });
});
</script>
<script>
$(document).ready(function(){
    $('#Cedula').inputmask('999-9999999-9');
    $('#phone').inputmask('999-999-9999');
});
</script>


<div class="col-md-10 ml-5" id='contenedor'>
<form action="{{ route('patient.update', ['id' => $patient->pacient_id]) }}" method="post" class="form-group">
    @csrf
    @method('PUT')
    <div class="card text-white bg-pink">

        <div class="card-header justify-content-center mt-2">
            <h3 class=" p-2">Smile Clinic</h3>

        </div>
        <div class="card-body  pb-4">
        <div class="form-group">
                <label class="mt-2" for="pacient_id">No. de Paciente:</label>
                <input type="text" class="form-control " id="pacient_id" value="{{ $patient->pacient_id  }}"
                    name="pacient_id" value="{{ $patient->pacient_id  }}" readonly>

                <label for="fecha" class="mt-2">Fecha:</label>
                <?php
// Set your timezone
date_default_timezone_set('America/Santo_Domingo'); 

// Get the current date
$currentDate = date('Y-m-d');
?>

                <input type="date" class="form-control " id="fecha" name="fecha" value="{{ $currentDate }}"
                    readonly>


                   
                    <label class="mt-2" for="nombre">Nombre del Paciente </label>
                    <input type="text" class="form-control " id="nombre" name="name" required value="{{$patient->name}}">
                    <label class="mt-2">Fecha de Nacimiento .</label>
                    <input type="date" class="form-control" name="date_of_birth" value="{{$patient->date_of_birth}}"
                        required>
                    <label class="mt-2">Direccion</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{$patient->address}}" required>
                    <label class="mt-2">ARS</label>
                    <input type="text" id="ars" name="ars" class="form-control" value="{{$patient->ars}}" required>
                    <label class="mt-2">Cedula</label>
                    <input type="text" id="Cedula" name="Cedula" class="form-control" value="{{$patient->Cedula}}" required>
                    <label class="mt-2">Telefono</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{$patient->phone}}" required>
                  
                </div>

            <div class="form-group">
                <label class="d-block">¿Ha presentado complicaciones?</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="complicaciones_si" name="complicaciones"
                        value="si" {{ $patient->complications == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="complicaciones_sirequired">Sí</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="complicaciones_no" name="complicaciones"
                        value="no" {{ $patient->complications == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="complicaciones_no" required>No</label>
                </div>
            </div>

            <div class="form-group">
                <label for="complicaciones_detalle">Detalles de Complicaciones:</label>
                <input type="text" class="form-control" id="complicaciones_detalle"
                    value="{{ $patient->compliaction_detail  }}" name="complicaciones_detalle" disabled>
            </div>

            <!-- Sección 3 -->
            <div class="form-group">
                <label class="d-block">¿Es usted alérgico/a a un medicamento?</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="alergias_si" name="alergias" value="si"
                        {{ $patient->alergies == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="alergias_si" required>Sí</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="alergias_no" name="alergias" value="no"
                        {{ $patient->alergies == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="alergias_no" required>No</label>
                </div>
            </div>

            <div class="form-group">
                <label for="alergias_detalle">Detalles de Alergias:</label>
                <input type="text" class="form-control" id="alergias_detalle" value="{{ $patient->alergies_detail  }}"
                    name="alergias_detalle" disabled>
            </div>


            <!-- Sección 4 -->
            <div class="form-group">
                <label class="d-block">¿Está tomando algún tipo de medicamento?</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="medicamento_si" name="medicamento" value="si">
                    <label class="form-check-label" for="medicamento_si" required
                        {{ $patient->drugs == 1 ? 'checked' : '' }}>Sí</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="medicamento_no" name="medicamento" value="no"
                        {{ $patient->drugs == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="medicamento_no" required>No</label>
                </div>
            </div>


            <div class="form-group">
                <label for="medicamentos_detalle">¿Cuáles y con qué dosis?</label>
                <input type="text" class="form-control" id="medicamentos_detalle" value="{{ $patient->drugs_detail  }}"
                    name="medicamentos_detalle" disabled>
            </div>
            <!-- Sección 5 -->
            <div class="form-group mb-2">
                <label for="motivo_consulta">Motivo Principal de la Consulta:</label>
                <textarea class="form-control" id="motivo_consulta" name="motivo_consulta"
                    required>{{ $patient->motive }}</textarea>
            </div>
            <div class="form-group mt-4">
                    <input type="submit" class="form-control btn " name="submit" value="Actualizar Paciente">
                </div></form>

</div>



@endsection

