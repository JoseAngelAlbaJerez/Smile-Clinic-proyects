@extends('layouts.app')
@extends('layouts.sidebar')
@section('content')
<style type="text/css">
#brand-table_filter {
    text-align: left !important;


}
</style>
<style type="text/css">
.swal-wide {
    width: 755px !important;
}

.nav-stacked>li.active>a,
.nav-stacked>li.active>a:hover {
    background: transparent;
    color: #444;
    border-top: 0;
    border-left-color:var(--background) !important;
}

.box.box-primary {
    border-top-color:var(--background) !important;
}

.bg-pink {
    background:var(--background) !important;
}

table.clinic-table-primary tr th {
    color: #fff !important;
    background:var(--background) !important;
    font-weight: normal !important;

}

.clinic-box-title {
    color: #212529 !important;
}
</style>

<link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/dist/css/AdminLTE.min.css">
<link rel="stylesheet"
    href="https://dentalclinicapp.com/template/AdminLTE/plugins/sweetalert2/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/dist/css/skins/_all-skins.min.css">
<!-- <link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/plugins/bootstrap-tour-0.12.0/build/css/bootstrap-tour.min.css"> -->
<link rel="stylesheet" type="text/css" href="https://dentalclinicapp.com/template/AdminLTE/clinic/css/clinic-all.css">
<link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/plugins/select2/select2.min.css">
<link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/plugins/select2/select2.bootstrap.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
               
              
                    <div class="row">
                        <div class="col-md-2">
                            <ul class="nav nav-pills nav-stacked" style="background-color: #fff;">
                                <li role="presentation" class="active"><a href="{{route('clinic.drugs')}}">Genericos</a>
                                </li>
                                <li role="presentation" class=""><a href="{{route('clinic.brand')}}">Marcas</a></li>
                                <li role="presentation" class=""><a href="{{route('clinic.dosage')}}">Dosis</a></li>
                            </ul>
                        </div>
                        <div class="col-md-10">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <div class="pull-left">
                                        <span class="clinic-box-title">
                                            <i class="fa fa-medkit" aria-hidden="true"></i>&nbsp; Medicamentos Genericos
                                        </span>
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" data-toggle="modal" data-target="#drugGenericModal"
                                            data-backdrop="static" data-method="POST"
                                            class="btn btn-primary bg-pink btn-sm"
                                            data-action="https://dentalclinicapp.com/clinic/settings/drug-generic">
                                            <span class="fa fa-plus"></span>&nbsp;Crear Genérico
                                        </a>
                                    </div>
                                </div>


                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered clinic-table-primary"
                                            id="generic-table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h1 class="box-title"><i class="fa fa-history"></i> Logs</h1>
                                </div>
                                <div class="box-body">
                                    <span class="text-warning">No logs found.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                
            </div>
        </div>

    </div>
</div>
<footer class="main-footer">
    <div class="container-fluid">
        <div class="pull-right hidden-xs">
            <b>Version:</b>
        </div>
        <strong>Copyright &copy; 2024 <a href="http://www.quantumx.com">Quantum X, Inc</a>.</strong>
    </div>
</footer>
</div>
<!-- Modal  -->
<div class="modal fade" id="drugGenericModal" tabindex="-1" role="dialog" aria-labelledby="drugGenericModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="drugGenericModalLabel">Crear Genérico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your modal content here -->
                <!-- You may load content dynamically using AJAX or other methods -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="https://dentalclinicapp.com/vendor/jsvalidation/js/jsvalidation.js"></script>

@endsection