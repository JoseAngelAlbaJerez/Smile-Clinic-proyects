@extends('layouts.app')
@extends('layouts.sidebar')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<style>
.signature-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 50px;
}

.signature-pad {
    border-bottom: 1px solid #000;

}

.card {
    margin-left: 20%;
}

#nombre {
    width: 300% !important;
}

#container {
    margin-left: 5% !important;
    margin-top: 1% !important;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var canvas = document.getElementById('signature-pad');
    var signaturePad = new SignaturePad(canvas);

    document.getElementById('clear-button').addEventListener('click', function() {
        signaturePad.clear();
    });
});
</script>


<div class="col-md-10 ml-5" id='container'>
    <form method="post" action="{{ route('events.store') }}" class="form">
        @csrf
        <!-- CSRF protection -->
        <div class="card text-white bg-pink">

            <div class="card-header justify-content-center mt-2">
                <center>
                    <h3 class=" p-2">Smile Clinic</h3>
                </center>
            </div>
            <div class="card-body  pb-4">
                <div class="form-group" style="display: flex; align-items: center;">
                    <img src="https://cartaafiliacion.arssenasa.gob.do/Scripts/Components/logo-Senasa.jpg" width="200"
                        height="200" alt="" style="margin-right: 20px;">
                    <div>
                        <label style="margin-top: 62px;">Nombre del Afiliado:</label>
                        <input type="text" class="form-control" id="nombre" name="name" required>
                    </div>
                </div>
                <div class="container">
                    <div class="form-group row">
                      
                        <div class="col-md-3">
                            <label>NO. del Afiliado:</label>
                            <input type="number" class="form-control" id="id" name="id"     >
                        </div>
                        <div class="col-md-9">
                            <label>Dirección:</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                    </div>
                    <div class="form-group row">           
                        <div class="col-md-6">
                            <label>Teléfono / Celular:</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label>Cédula:</label>
                            <input type="text" class="form-control" id="Cedula" name="Cedula">
                        </div>
                    </div>
                </div>
                <div class="signature-container">
                    <canvas id="signature-pad" class="signature-pad" width="700" height="200" required></canvas>
                    <p class="mt-2">FIRMA AUTORIZADA Y SELLO RECLAMANTE</p>

                    <div class="form-inline mt-2">
                        <button id="clear-button" class="btn text-white mr-2 form-control">Limpiar Firma</button>
                        <input type="submit" class="form-control btn " name="submit" value="Crear Seguro">
                    </div>
                </div>
    </form>
</div>
</div>

@endsection