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
    <form method="POST" action="{{ route('events.update', $Event->id) }}" class="form">
        @csrf
        @method('PATCH') 
        <div class="card text-white bg-pink">
            <div class="card-header justify-content-center mt-2">
                <center>
                    <h3 class="p-2">Smile Clinic</h3>
                </center>
            </div>
            <div class="card-body rounded-bottom  pb-4">
                <div class="form-group">
                    <label>Titulo del Evento</label>
                    <input type="text" class="form-control" name="title" value="{{ $Event->title }}" required>
                </div>
                <div class="form-group">
                    <label>DR/A.</label>
                    <input type="text" class="form-control" name="dr" value="{{ $Event->dr }}" required>
                </div>
                <div class="form-group">
                    <label>Fecha</label>
                    <input type="date" name="date" class="form-control" value="{{ $Event->date }}" required>
                </div>
                <div class="form-group time">
                    <label>Hora Desde:</label>
                    <input type="time" name="time_from" class="form-control" value="{{ $Event->startDateTime }}">
                    <label>Hasta:</label>
                    <input type="time" name="time_to" class="form-control" value="{{ $Event->endDateTime }}">
                </div>
                <div class="form-group mt-2">
                    <input type="submit" class="form-control btn btn-primary" name="submit" value="Actualizar Cita">
                </div>
            </div>
        </div>
    </form>
</div>
@endsection