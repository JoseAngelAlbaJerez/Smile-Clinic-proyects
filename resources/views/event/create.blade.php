@extends('layouts.app')
<!-- Assuming you have a layout file -->

@extends('layouts.sidebar')
@section('content')
<style>
#contenedor {
    margin-left: 25% !important;
    margin-top: 3% !important;
}

</style>


<div class="col-md-8 ml-5" id='contenedor'>
<form method="post" action="{{ route('events.store') }}" class="form">
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
                <label>Titulo del Evento</label>
                <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="form-group">
                <label>DR/A.</label>
                <input type="text" class="form-control" name="dr" value="{{ old('dr') }}" required>
            </div>

            <div class="form-group">
                <label>Fecha</label>
                <input type="date" name="date" class="form-control"
                    value="<?php echo !empty($postData['date'])?$postData['date']:''; ?>" required="">
            </div>
            <div class="form-group time">
                <label>Hora Desde:</label>
                <input type="time" name="time_from" class="form-control"
                    value="<?php echo !empty($postData['time_from'])?$postData['time_from']:''; ?>">
                <label>Hasta:</label>
                <input type="time" name="time_to" class="form-control"
                    value="<?php echo !empty($postData['time_to'])?$postData['time_to']:''; ?>">
            </div>

            <div class="form-group mt-2">
                <input type="submit" class="form-control btn " name="submit" value="Crear Cita">
            </div>
</form>
</div>
</div>

@endsection