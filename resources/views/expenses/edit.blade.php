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
    <form method="Post" action="{{ route('expenses.update',['id' => $expense->id]) }}" class="form">
        @csrf
        @method('PUT')
        <div class="card text-white bg-pink">

            <div class="card-header justify-content-center mt-2">
                <center>
                    <h3 class=" p-2">Smile Clinic</h3>
                </center>
            </div>
            <div class="card-body  pb-4">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="name" value="{{$expense->name}}" required>
                </div>
                <div class="form-group">
                    <label>Monto</label>
                    <input type="number" class="form-control" name="amount" value="{{$expense->amount}}"  required>
                </div>

                <div class="form-group">
                    <label>Fecha</label>
                    <input type="date" name="date" class="form-control"
                    value="{{$expense->date}}"  required="">
                </div>
                
                <div class="form-group mt-2">
                    <input type="submit" class="form-control btn " name="submit" value="Crear ">
                </div>
    </form>
</div>
</div>

@endsection