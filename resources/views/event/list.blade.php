@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')

<style>
.container {
    width: 90%;
    margin-left: 9.5%;
    align-self: center;
}

#crearpaciente {
    color:var(--background) !important;
    background-color:var(--secondary) !important;
    margin-left: 75%;


}



.card-header {
    background-color: var(--background) !important;
}
</style>

<div class="container col-lg-12  ">
    <div class="card text-white pb-5 ">
        <div class="card-header ">
            <h4 class="card-title  "><i class="	fas fa-calendar fa-3x mr-1 "></i> Calendario</h4>
            <a class="btn  d-flex   justify-content-center mt-3" href="{{ route('events.create') }}"
                id="crearpaciente">
                Crear Cita</a>
        </div>


        <div class="row ">


            <div class="col-md-12">

                <style>
                .embedded-calendar {
                    border: 0;



                }

                .alert {
                    background-color: var(--txt);
                    border: var(--background) solid 2px;

                }

                .embedded-calendar-container {
                    width: auto;
                    height: auto;

                    max-width: 100%;
                    overflow-x: auto;
                }

                .fc-credit-button {
                    display: hidden !important;
                }



                fc-credit-button fc-button fc-button-primary {
                    display: hidden !important;
                }
                </style>

<div class="embedded-calendar-container">
<iframe id="open-web-calendar" 
    style="background:url('https://raw.githubusercontent.com/niccokunzmann/open-web-calendar/master/static/img/loaders/circular-loader.gif') center center no-repeat;"
    src="https://calendar.google.com/calendar/embed?src=4eecbac57ece8cd812d6bbcb768812f611c93ce7efa7ea58f32bcdab3fd21b89%40group.calendar.google.com&ctz=America%2FSanto_Domingo"
    sandbox="allow-scripts allow-same-origin allow-top-navigation"
    allowTransparency="true" scrolling="no" 
    frameborder="0" height="520" width="100%"></iframe>
</div>


                </div>
            </div>




        </div>


    </div>

</div>
</div>
</div>
@endsection