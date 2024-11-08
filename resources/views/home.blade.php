@extends('layouts.app')
@extends('layouts.sidebar')
@section('content')

<style>
.bg-pink {
    background-color: var(--background) !important;
    color: var(--txt) !important;
}

.nav-tabs>li>a {
    margin-right: 2px;
    line-height: 1.42857143;
    border: 1px solid transparent;
    border-radius: 4px 4px 0 0;
}

.btn-view-all {
    color: var(--txt);
    text-decoration: none !important;
}

.box.box-primary {
    border-top-color: var(--background);
}

.pull-left {
    float: left !important;
}

p {
    margin-top: 20px !important;
}

#styled-calendar-container {
    background-color: var(--background);
}


.box-header {
    color: var(--txt);
    display: block;
    padding: 10px;
    position: relative;
}

.box-header.with-border {
    border-bottom: 1px solid #f4f4f4;
}

table.clinic-table-primary tr th {
    color: var(--txt) !important;
    background: var(--background);
    font-weight: normal !important;
}

.nav>li>a {
    position: relative;
    display: block;
    padding: 10px 15px;
    text-decoration: none;
}

.nav-tabs>li.active>a,
.nav-tabs>li.active>a:focus,
.nav-tabs>li.active>a:hover {
    background-color: var(--background) !important;
    color: var(--txt);

}

#all_appointment_tab_a {
    color: var(--txt) !important;
}

.small-box,
.info-box {
    color: var(--txt) !important;
}

#fila {
    color: var(--txt) !important;
}
</style>

<div class="container  ml-5" style="margin-left: 5.5% !important;">
    <div class="row justify-content-center ml-5 ">
        <div class="ml-5 col-lg-12  pr-5">
            <h1 style="display: inline-block; color: var(--title) !important;"><b>Bienvenido/a,
                    {{ Auth::user()->name }}</b></h1>


            <div class="row">

                <div class="col-lg-12">
                    <div class="row mt-4">
                        <div class="col-md-3 col-xs-12">
                            <div class="small-box bg-pink p-3">
                                <div class="inner">
                                    <h3>{{ $totalPatients }}</h3>
                                    <h5>Total de Pacientes</h5>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                </div>
                                <a href="{{route('patient.index')}}" class="small-box-footer">Mas informacion <i
                                        class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <div class="small-box bg-pink p-3">
                                <div class="inner">
                                    <h3>{{ $totalAppointmentsNextTwoDayscount }}</h3>
                                    <h5>Próximas citas</h5>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </div>
                                <a href="{{route('events.index')}}" class="small-box-footer">Mas informacion <i
                                        class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <div class="small-box bg-pink p-3">
                                <div class="inner">
                                    <h3>{{number_format($income, 0);}} $</h3>
                                    <h5>Ingresos</h5>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-cash-register" aria-hidden="true"></i>
                                </div>
                                <a href="{{route('income.index')}}" class="small-box-footer">Mas informacion <i
                                        class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <div class="small-box bg-pink p-3">
                                <div class="inner">
                                    <h3>{{number_format($expenses,0);}} $</h3>
                                    <h5>Egresos </h5>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-money-bill" aria-hidden="true"></i>
                                </div>
                                <a href="{{route('expenses.index')}}" class="small-box-footer">Mas informacion <i
                                        class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="fila">
                <div class="col-md-3">
                    <div class="row ">
                        <div class="col-md-12">
                            <a style="text-decoration: none;" id="fila" href="{{route('patient.create')}}">
                                <div class="info-box clinic-box-info  bg-pink">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-user-plus"
                                            aria-hidden="true"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text  h5">Crear Paciente</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 ">
                            <a style="text-decoration: none;" href="{{route(name: 'events.index')}}">
                                <div class="info-box clinic-box-info bg-pink ">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-calendar-check"
                                            aria-hidden="true"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text h5">Crear Cita</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12">
                            <a style="text-decoration: none;" href="{{route(name: 'CXC.create')}}">
                                <div class="info-box clinic-box-info  bg-pink">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-money-bill"
                                            aria-hidden="true"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text  h5">Crear Pago</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12">
                            <a style="text-decoration: none;" href="{{route(name: 'CXC.create')}}">
                                <div class="info-box clinic-box-info  bg-pink">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-prescription "
                                            aria-hidden="true"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text  h5">Crear Receta</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12">
                            <a style="text-decoration: none;" href="{{route(name: 'odontograph.index')}}">
                                <div class="info-box clinic-box-info  bg-pink">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-teeth "
                                            aria-hidden="true"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text  h5"> Odontogramas</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12">
                            <a style="text-decoration: none;" href="{{route(name: 'budget.index')}}">
                                <div class="info-box clinic-box-info  bg-pink">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-file-invoice "
                                            aria-hidden="true"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text  h5"> Presupuestos</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">



                    <style>
                    .embedded-calendar {
                        border: 0;
                        width: 700px;


                    }

                    .alert {
                        background-color: var(--txt);
                        border: var(--background) solid 2px;

                    }

                    .embedded-calendar-container {
                        width: auto;
                        height: auto;
                        border-radius: 10;
                        max-width: 100%;
                        overflow-x: auto;
                    }

                    .fc-credit-button {
                        display: hidden !important;
                    }

                    .btn {
                        margin-bottom: 40px !important;

                    }

                    fc-credit-button fc-button fc-button-primary {
                        display: hidden !important;
                    }

                 
                    </style>

                    <div class="embedded-calendar-container">
                        <iframe id="open-web-calendar"
                            style="background-color: var(--background); background: url('https://raw.githubusercontent.com/niccokunzmann/open-web-calendar/master/static/img/loaders/circular-loader.gif') center center no-repeat;"
                            src="https://calendar.google.com/calendar/embed?height=600&wkst=2&ctz=America%2FSanto_Domingo&showPrint=0&mode=AGENDA&title=Citas%20Smile%20Clinic&src=am9zZWFuZ2VsYWxiYTI0QGdtYWlsLmNvbQ&src=NGVlY2JhYzU3ZWNlOGNkODEyZDZiYmNiNzY4ODEyZjYxMWM5M2NlN2VmYTdlYTU4ZjMyYmNkYWIzZmQyMWI4OUBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=ZXMtNDE5LmRvI2hvbGlkYXlAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&color=%23039BE5&color=%237986CB&color=%230B8043"
                            style="border:solid 1px #777" width="100%" height="560" frameborder="0" scrolling="no"
                            sandbox="allow-scripts allow-same-origin allow-top-navigation" allowtransparency="true">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- <div class="alert  p-1 px-5" style="position: fixed; top: 65px; right: 40px;">
    <button type="button" class="close" onclick="closeAlert()" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
   //Que se pueda abrir y ver detalles quiere el nombre de los pacientes que tienen cita. 
   
 <h4 class="mt-1">Citas en los próximos 2 días:</h4>
    <ul>
        @foreach ($totalAppointmentsNextTwoDays as $appointment)
        <li>{{ \Carbon\Carbon::parse($appointment->date)->format('M/d') }}
            {{ \Carbon\Carbon::parse($appointment->startDateTime)->format('h:i')}} - {{ $appointment->name }}</li>
        @endforeach
    </ul>
</div> -->


<script>
function closeAlert() {
    document.querySelector('.alert').style.display = 'none';
}
</script>

<script>



</script>
@endsection