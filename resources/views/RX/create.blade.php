@extends('layouts.app')
@extends('layouts.sidebar')



@section('content')

<link type="text/css" href="{{ URL::asset('css/custom-theme/jquery-ui-1.8.13.custom.css') }}" rel="stylesheet" />

<script type="text/javascript" src="{{ URL::asset('js/jquery-1.7.2.min.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('js/jquery-ui-1.8.13.custom.min.js') }}"></script>


<style>
#contenedor {
    margin-left: 25% !important;
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
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"
    integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>




<div class="col-md-8 ml-5" id='contenedor'>
    <form method="post" action="{{ route('RX.store') }}" class="form">
        @csrf
        <!-- CSRF protection -->
        <div class="card text-white ">

            <div class="card-header justify-content-center mt-2">
                <center>
                    <h3 class=" p-2">Smile Clinic</h3>
                </center>
            </div>
            <div class="card-body  pb-4">
                <div class="form-group">
                    <label class="mt-2" for="id">No. de Medicamento</label>
                    <input type="text" class="form-control " id="id" name="id" value="{{ $nextMedId +1  }}" readonly>
                </div>
                <div class="form-group">
                    <label class="mt-2" for="fecha" class="">Fecha</label>
                    <?php
                        date_default_timezone_set('America/Santo_Domingo'); 
                        $currentDate = date('Y-m-d');
                            ?>
                    <input type="date" class="form-control " id="fecha" name="fecha" value="{{ $currentDate }}"
                        readonly>
                </div>
                <div class="form-group ">
                    <label class="mt-2" for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="name" required>
                </div>
                <div class="form-group ">
                    <label class="mt-2" for="quantity" class="">Cantidad</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <div class="form-group ">
                <label class="mt-2" for="dosis" class="">Dosis</label>
                <input type="text" class="form-control" id="dosis" name="dosis" required>
                </div>
            

                <div class="form-group mt-2 ">
                    <center>
                    <input type="submit" style="width: 250px;" class="form-control btn " name="submit" value="Crear Medicamento">
                    </center>
                </div>
    </form>
</div>
</div>








    @endsection