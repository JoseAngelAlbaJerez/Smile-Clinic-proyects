@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')

<style>
.container {
    width: 90%;
    margin-left: 10%;
}

#crearpaciente {
    color:var(--background) !important;
    background-color:var(--secondary) !important;
    margin-left: 80%;

}

.btn {
    padding-left: 15px;
    padding-right: 15px;


}



input {
    border: 1px solid var(--background) !important;
   
}

#img-odonto{
 padding-bottom: 1px; padding-top: 2px; 

    width: 600;
  
    border-width: 3px 3px 3px 3px;  
    border-style: solid solid solid solid;
    border-color:var(--background);
   

}

.table-striped>tbody>tr:nth-child(odd)>td .btn {
    border: 1px solid white !important;
    background-color:var(--background) !important;
    color: var(--txt) !important;

}

.table-striped>tbody>tr:nth-child(even)>td .btn {
    border: 1px solid white !important;
    background-color:var(--background) !important;
    color: var(--txt) !important;
}

.table-striped>tbody>tr:nth-child(odd):hover>td {
    color: #212529;
    background-color: rgba(0, 0, 0, .075);
}
</style>

<div class="container col-lg-12 ">
    <div class="card bg-pink">
        <div class="card-header ">
            <h4 class="card-title mt-2 "><i class="fas fa-teeth fa-2x"></i> Lista de Odontodiagramas</h4>
            <a class="btn  d-flex   justify-content-center " 
                id="crearpaciente">
                Crear Odontodiagrama</a>
        </div>

        <div class="card-body rounded-bottom">
            <div class="row mt-2 ">
                <div class="col-4">
                    <h5>Total de Odontodiagramas: {{ $odontos->count() }}</h5>
                </div>
                <table class=" mt-3" id="pacient_table" style="width: 100%;">
                    <caption class="mt-2">Lista de Odontodiagramas</caption>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col" width="50%">Odontodiagrama</th>
                        
                            <th scope="col"width="200">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($odontos as $odonto)
                        <tr>
                            <th scope="row">{{ $odonto->pacient_id }}</th>
                            <td><b>{{ $odonto->name }}</b></td>

                            @foreach ($odonto->odontodiagramas as $odontograph)
                            @if (!$odontograph->image_path)
                                No hay imagen
                            @else
                            <td ><img src="{{ asset($odontograph->image_path) }}" id="img-odonto" alt="Odontodiagrama"></td>
                            @endif
                          
                            @endforeach
                           
                         
                            <td>
                                <div class="form-inline justify-content-center">
                                  
                                        @if (\Carbon\Carbon::parse($odonto->date_of_birth)->age>= 18 )
                                        <a href="{{ route('odontograph.edit', ['id' => $odonto->pacient_id]) }}"
                                        class="btn  "onclick="event.stopPropagation();"><i  class="fas fa-pencil"
                                            aria-hidden="true"></i> Editar</a>
                                        @else
                                        <a href="{{ route('odontographchild.edit', ['id' => $odonto->pacient_id]) }}"
                                        class="btn  "onclick="event.stopPropagation();"><i  class="fas fa-pencil"
                                            aria-hidden="true"></i> Editar</a>
                                        @endif
                                  


                                    <form action="{{ route('odontograph.destroy', ['id' => $odonto->pacient_id]) }}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn mt-3 ml-1" id="delete_button_">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>
</div> 

<div id="patientModal" style="display:none;">
    <select id="pacient_select" class="custom-select">
        <option value="0" data-edad="0">Seleccione un paciente</option>
        @foreach ($patients as $patient)
        <option data-edad="{{ \Carbon\Carbon::parse($patient->date_of_birth)->age  }}" value="{{ $patient->pacient_id }}">
            {{ $patient->pacient_id }} - {{ $patient->name }}
        </option>
        @endforeach
    </select>

    <div id="medicationsContainer" class="mt-3 "></div>
</div>

<script>
    
$(document).on('click', '[id^="delete_button_"]', function(event) {
    event.stopPropagation(); 
    event.preventDefault();
   

    const form = $(this).closest('form'); 

    Swal.fire({
        title: "¿Deseas eliminar el Odontodiagrama?",
        text: "¡No podrás revertir el cambio!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--background)",
        cancelButtonColor:  "#var(--background)",
        
        confirmButtonText: "Sí, elimínalo!"
    }).then((result) => {
        if (result.isConfirmed) {
            
            $.ajax({
                type: form.attr('method'), 
                url: form.attr('action'), 
                data: form.serialize(), 
                success: function(response) {
               
                    Swal.fire({
                        title: "¡Eliminado!",
                        text: "El Odontodiagrama ha sido eliminado correctamente.",
                        icon: "success"
                    });

           
                    form.closest('tr').remove();
                },
                error: function(xhr) {
                 
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo eliminar el Odontodiagrama. Intenta de nuevo.",
                        icon: "error"
                    });
                }
            });
        }
    });
});

document.getElementById('crearpaciente').addEventListener('click', function() {
    Swal.fire({
        title: 'Seleccione un paciente',
        html: document.getElementById('patientModal').innerHTML, 
        showCancelButton: true,
        confirmButtonText: 'Crear Odontodiagrama',
        preConfirm: () => {
            const selectElement = Swal.getPopup().querySelector('#pacient_select');
            const pacient_id = selectElement.value;
            const age = selectElement.options[selectElement.selectedIndex].getAttribute('data-edad');

            if (!pacient_id || pacient_id == 0) {
                Swal.showValidationMessage('Por favor selecciona un Paciente');
            }
            console.log(age);
            console.log(pacient_id);
            return { pacient_id, age };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { pacient_id, age } = result.value;

            // Definir la URL en función de la edad
            const url = age >= 18 ? `/odontograph/${pacient_id}` : `/odontographchild/${pacient_id}`;

            // Redirigir directamente a la página adecuada
            window.location.href = url;
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {

    $('#pacient_table').DataTable({
        dom: 'Bfrtip',
        "language": {
            "emptyTable": "No hay pacientes con Odontodiagramas Registrados",
            "sSearch": "Buscar"
        }, order: [[0, 'asc']],
        buttons: [{
                extend: 'copy',
                className: 'btn',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button');
                }
            },
            {
                extend: 'csv',
                className: 'btn',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button');
                }
            },
            {
                extend: 'excel',
                className: 'btn',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button');
                }
            },
            {
                extend: 'pdf',
                className: 'btn',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button');
                }
            },
            {
                extend: 'print',
                className: 'btn',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button');
                }
            },

        ]
    });
});
</script>
@endsection