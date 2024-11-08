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
    border-color: var(--background) !important;
}

.form-control {
    border-color: var(--background) !important;
}

#fecha {
    border-color: #dee2e6 !important;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"
    integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
$(document).ready(function() {
    $('#Cedula').inputmask('999-9999999-9');
    $('#phone').inputmask('999-999-9999');
});
</script>

<div class="col-md-10 ml-5" id='contenedor'>
<form action="{{ route('patient.store') }}" method="post" class="form-group">
        @csrf
        <!-- CSRF protection -->
        <div class="card text-white bg-pink">

            <div class="card-header justify-content-center mt-2">
                <center>
                    <h3 class=" p-2">Smile Clinic</h3>
                </center>
            </div>
            <div class="card-body  pb-4">
                <div class="form-group">
                <label class="mt-2" class="" for="pacient_id">No. de Paciente</label>
                    <input type="text" class="form-control mt-2" id="pacient_id" name="pacient_id"
                        value="{{ $nextClientId +1  }}" readonly>
                    <label class="mt-2" for="fecha" class="mt-2">Fecha</label>
                    <?php
// Set your timezone
date_default_timezone_set('America/Santo_Domingo'); 

// Get the current date
$currentDate = date('Y-m-d');
?>

                    <input type="date" class="form-control " id="fecha" name="fecha" value="{{ $currentDate }}"
                        readonly>
                    <label class="mt-2" for="nombre">Nombre del Paciente </label>
                    <input type="text" class="form-control " id="nombre" name="name" required>
                    <label class="mt-2">Fecha de Nacimiento .</label>
                    <input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth') }}"
                        required>
                    <label class="mt-2">Direccion</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}" required>
                    <label class="mt-2">ARS</label>
                    <input type="text" id="ars" name="ars" class="form-control" value="{{ old('ars') }}" required>
                    <label class="mt-2">Cedula</label>
                    <input type="text" id="Cedula" name="Cedula" class="form-control" value="{{ old('Cedula') }}" required>
                    <label class="mt-2">Telefono</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
                  
                </div>

                <div class="form-group mt-2">
                    <label class="mt-2" class="d-block">¿Ha presentado complicaciones?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="complicaciones_si" name="complicaciones"
                            value="si">
                        <label  class="form-check-label" for="complicaciones_si">Sí</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="complicaciones_no" name="complicaciones"
                            value="no">
                        <label  class="form-check-label" for="complicaciones_no">No</label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="mt-2" for="complicaciones_detalle">Detalles de Complicaciones</label>
                    <input type="text" class="form-control" id="complicaciones_detalle" name="complicaciones_detalle"
                        disabled>
                </div>

                <!-- Sección 3 -->
                <div class="form-group">
                    <label class="mt-2" class="d-block">¿Es usted alérgico/a a un medicamento?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="alergias_si" name="alergias" value="si">
                        <label  class="form-check-label" for="alergias_si" required>Sí</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="alergias_no" name="alergias" value="no">
                        <label  class="form-check-label" for="alergias_no" required>No</label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="mt-2" for="alergias_detalle">Detalles de Alergias</label>
                    <input type="text" class="form-control" id="alergias_detalle" name="alergias_detalle" disabled>
                </div>


                <!-- Sección 4 -->
                <div class="form-group">
                    <label class="mt-2" class="d-block">¿Está tomando algún tipo de medicamento?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="medicamento_si" name="medicamento"
                            value="si">
                        <label  class="form-check-label" for="medicamento_si" required>Sí</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="medicamento_no" name="medicamento"
                            value="no">
                        <label  class="form-check-label" for="medicamento_no" required>No</label>
                    </div>
                </div>


                <div class="form-group">
                    <label class="mt-2" for="medicamentos_detalle">¿Cuáles y con qué dosis?</label>
                    <input type="text" class="form-control" id="medicamentos_detalle" name="medicamentos_detalle"
                        disabled>
                </div>
                <!-- Sección 5 -->
                <div class="form-group mb-3">
                    <label class="mt-2" for="motivo_consulta">Motivo Principal de la Consulta</label>
                    <textarea class="form-control" id="motivo_consulta" name="motivo_consulta" required></textarea>
                </div>
                <div class="form-group mt-2">
                    <input type="submit" class="form-control btn " name="submit" value="Crear Paciente">
                </div>
    </form>
</div>



@endsection