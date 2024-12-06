@extends('layouts.app')
@extends('layouts.sidebar')
@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.17/jstree.min.js"></script>
<style>
    .content{
        margin-left: 10%;
        
    }
    table.dataTable tbody tr.selected>* {
    box-shadow: inset 0 0 0 9999px var(--background);
    color: var(--txt);
}
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #495057;
 background-color: var(--background); 
    border-color: #dee2e6 #dee2e6 #fff;
    opacity: 100%;
}
.nav-link, .dropdown-item {
    color: var(--txt) !important;
    background-color: var(--background); 
    opacity: 70%;
}
.tree-text{
    text-decoration: none !important;
    color: var(--background);
}
.jstree-checkbox {
    display: inline-block !important;
}

</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>

 

<div class="content ">


    <div class="container-fluid">

        <ul class="nav nav-tabs" id="tabs-asignar-modulos-perfil" role="tablist">

            <li class="nav-item">
                <a class="nav-link active" id="content-perfiles-tab" data-bs-toggle="pill" href="#content-perfiles" role="tab" aria-controls="content-perfiles" aria-selected="false">Perfiles</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="content-modulos-tab" data-bs-toggle="pill" href="#content-modulos" role="tab" aria-controls="content-modulos" aria-selected="false">Modulos</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="content-modulo-perfil-tab" data-bs-toggle="pill" href="#content-modulo-perfil" role="tab" aria-controls="content-modulo-perfil" aria-selected="false">Asignar Modulo a Perfil</a>
            </li>

        </ul>

        <div class="tab-content" id="tabsContent-asignar-modulos-perfil">


            <div class="tab-pane fade  show mt-1 " id="content-modulo-perfil" role="tabpanel" aria-labelledby="content-modulo-perfil-tab">

                <div class="row">

                    <div class="col-md-8">

                        <div class="card  shadow ">

                            <div class="card-header text-white">

                                <h3 class="card-title"><i class="fas fa-list"></i> Listado de Perfiles</h3>

                            </div>

                            <div class="card-body rounded-bottom">

                                <table id="tbl_perfiles_asignar" >

                                    <thead class=" text-left">
                                        <th>id</th>
                                        <th>Perfil</th>
                                        <th>Estado</th>
                                        <th>F. Creación</th>
                                        <th>F. Actualización</th>
                                        <th class="text-center">Opciones</th>
                                    </thead>

                                    <tbody class="small text left">

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card  shadow" style="display:none" id="card-modulos">

                            <div class="card-header">

                                <h3 class="card-title text-white"><i class="fas fa-laptop"></i> Módulos del Sistema</h3>

                            </div>

                            <div class="card-body" id="card-body-modulos">

                                <div class="row m-2">

                                    <div class="col-md-6">

                                        <button class="btn  btn-small  m-0 p-0 w-100" id="marcar_modulos">Marcar todo</button>

                                    </div>

                                    <div class="col-md-6">

                                        <button class="btn  btn-small m-0 p-0 w-100" id="desmarcar_modulos">Desmarcar todo</button>

                                    </div>

                                </div>

                                <!-- AQUI SE CARGAN TODOS LOS MODULOS DEL SISTEMA -->
                                <div id="modulos" class="demo"></div>

                                <div class="row m-2">

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Seleccione el modulo de inicio</label>
                                            <select class="custom-select" id="select_modulos">
                                            </select>

                                        </div>

                                    </div>

                                </div>

                                <div class="row m-2">

                                    <div class="col-md-12">

                                        <button class="btn  btn-small w-50 text-center" id="asignar_modulos">Asignar</button>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
            <div class="tab-pane  active show fade mt-1 " id="content-perfiles" role="tabpanel" aria-labelledby="content-perfiles-tab">
             
                <div class="row">

<div class="col-md-8">

    <div class="card  shadow ">

        <div class="card-header text-white">

            <h3 class="card-title"><i class="fas fa-list"></i> Listado de Perfiles</h3>

        </div>

        <div class="card-body rounded-bottom">

            <table id="tbl_perfiles" >

                <thead class=" text-left">
                    <th>ID</th>
                    <th>Perfil</th>
                    <th>Estado</th>
                    <th>F. Creación</th>
                    <th>F. Actualización</th>
                    <th class="text-center">Opciones</th>
                </thead>

                <tbody class="small text left">

                </tbody>

            </table>

        </div>

    </div>

</div>
 <!--FORMULARIO PARA REGISTRO Y EDICION -->
 <div class="col-md-3">

<div class="card  shadow">

    <div class="card-header">

        <h3 class="card-title text-white "><i class="fas text-white  fa-edit"></i> Registro de Perfiles</h3>

    </div>

    <div class="card-body">

    <form method="post" action="{{ route('profile.store') }}" class="form">
    @csrf

        <div class="row">
                                   
                                   <div class="col-12">

                                       <div class="form-inline mb-2">
                                       <label for="description">Descripción</label>
                                           <input type="text" style="width: 100%;" id="description" class="form-control " name="description" required>
                                           
                                           <div class="invalid-feedback">Ingrese la descripción</div>
                                       </div>

                                   </div>

                                   <!-- ESTADO -->
                                   <div class="col-12">
                                       <div class="form-inline mb-2">
                                       <label for="status">Estado</label>
                                           <select class="form-select select2" style="width: 100%;" id="status" name="status" aria-label=" label select example" required>
                                               <option value="" disabled>--Seleccione un estado--</option>
                                               <option value="1" selected>ACTIVO</option>
                                               <option value="0">INACTIVO</option>
                                           </select>
                                        
                                       </div>
                                   </div>


                                 
                               </div>

                <div class="col-md-12">

                    <div class="form-group m-0 mt-2">

                        <button type="submit" class="btn  w-100" >Guardar Perfil</button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

</div>
<!--/. col-md-3 -->


</div>


          




            <!--============================================================================================================================================
            CONTENIDO PARA MODULOS 
            =============================================================================================================================================-->
            <div class="tab-pane fade  mt-1" style="width: 105%;" id="content-modulos" role="tabpanel" aria-labelledby="content-modulos-tab">

                <div class="row">

                    <!--LISTADO DE MODULOS -->
                    <div class="col-md-6">

                        <div class="card  shadow">

                            <div class="card-header">

                                <h3 class="card-title text-white "><i class="fas text-white  fa-list"></i> Listado de Módulos</h3>

                            </div>

                            <div class="card-body">

                            <table id="tblModulos">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>ID</th>
                                        <th>Orden</th>
                                        <th>Módulo</th>
                                        <th>Módulo Padre</th>
                                        <th>Vista</th>
                                        <th>Ícono</th>
                                        <th>Creado</th>
                                        <th>Actualizado</th>
                                    </tr>
                                </thead>
                            </table>

                            </div>

                        </div>

                    </div>
                    <!--/. col-md-6 -->

                    <!--FORMULARIO PARA REGISTRO Y EDICION -->
                    <div class="col-md-3">

                        <div class="card  shadow">

                            <div class="card-header">

                                <h3 class="card-title text-white "><i class="fas text-white  fa-edit"></i> Registro de Módulos</h3>

                            </div>

                            <div class="card-body">

                            <form method="post" action="{{ route('module.store') }}" class="form">
                            @csrf
                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group mb-2">

                                                <label for="module" class="m-0 p-0 col-sm-12 col-form-label-sm"><span class="small">Módulo</span><span class="text-danger">*</span></label>

                                                <div class="input-group  m-0">
                                                    <input type="text" class="form-control form-control-sm" name="module" id="module" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text "><i style=" color: var(--background) !important;" class="fas fa-laptop  fs-6"></i></span>
                                                    </div>
                                                    <div class="invalid-feedback">Debe ingresar el módulo</div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-12">

                                            <div class="form-group mb-2">

                                                <label for="view" class="m-0 p-0 col-sm-12 col-form-label-sm"><span class="small">Ruta PHP</span></label>
                                                <div class="input-group  m-0">
                                                    <input type="text" class="form-control form-control-sm" name="view" id="view">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text "><i style=" color: var(--background) !important;" class="fas fa-code  fs-6"></i></span>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-12">

                                            <div class="form-group mb-2">

                                                <label for="icon_menu" class="m-0 p-0 col-sm-12 col-form-label-sm"><span class="small">Icono</span><span class="text-danger">*</span></label>
                                                <div class="input-group  m-0">
                                                    <input type="text" placeholder="<i class='far fa-circle'></i>" name="icon_menu" class="form-control form-control-sm" id="icon_menu" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text " id="spn_icono_modulo"><i style=" color: var(--background) !important;" class="far fa-circle fs-6 "></i></span>
                                                    </div>
                                                    <div class="invalid-feedback">Debe ingresar el ícono del módulo</div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-md-12">

                                        <div class="form-group mb-2">

                                            <label for="father_id" class="m-0 p-0 col-sm-12 col-form-label-sm"><span class="small">Modulo Padre</span><span class="text-danger">*</span></label>
                                            <div class="input-group  m-0">
                                                <input type="text" placeholder="0, 1, 2, 3" name="father_id" class="form-control form-control-sm" id="father_id" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text " id="spn_icono_modulo"><i style=" color: var(--background) !important;" class="far fa-circle fs-6 "></i></span>
                                                </div>
                                                <div class="invalid-feedback">Debe ingresar el ícono del módulo</div>
                                            </div>

                                        </div>

                                        </div>

                                        <div class="col-md-12">

                                            <div class="form-group mb-2">

                                                <label for="order" class="m-0 p-0 col-sm-12 col-form-label-sm"><span class="small">Orden</span><span class="text-danger">*</span></label>
                                                <div class="input-group  m-0">
                                                    <input type="text" placeholder="0, 1, 2, 3" name="order" class="form-control form-control-sm" id="order" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text " id="spn_icono_modulo"><i style=" color: var(--background) !important;" class="far fa-circle fs-6 "></i></span>
                                                    </div>
                                                    <div class="invalid-feedback">Debe ingresar el ícono del módulo</div>
                                                </div>

                                            </div>

                                            </div>

                                        <div class="col-md-12">

                                            <div class="form-group m-0 mt-2">

                                                <button type="submit" class="btn  w-100" >Guardar Módulo</button>

                                            </div>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>
                    <!--/. col-md-3 -->

                    <!--ARBOL DE MODULOS PARA REORGANIZAR -->
                    <div class="col-md-3">

                        <div class="card  shadow">

                            <div class="card-header">

                                <h3 class="card-title text-white"><i class="fas text-white fa-edit"></i> Organizar Módulos</h3>

                            </div>

                            <div class="card-body">

                                <div class="">

                                    <div>Modulos del Sistema</div>

                                    <div class="" id="arbolModulos"></div>

                                </div>

                                <hr>

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="text-center">

                                            <button id="btnReordenarModulos" class="btn  btn-sm" style="width: 100%;">Organizar Módulos</button>

                                            <button id="btnReiniciar" class="btn btn-sm  mt-3 " style="width: 100%;">Estado Inicial</button>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <!--/. col-md-3 -->

                </div>
                <!--/.row -->

            </div><!-- /#content-modulos -->
            </div>
        </div>

    </div>

</div>

<script>
    /* =============================================================
    VARIABLES GLOBALES
    ============================================================= */
    var tbl_perfiles_asignar, tbl_modulos, modulos_usuario, modulos_sistema;

    $(document).ready(function() {


        /* =============================================================
        FUNCIONES PARA LAS CARGAS INICIALES DE DATATABLES, ARBOL DE MODULOS Y REAJUSTE DE CABECERAS DE DATATABLES
        ============================================================= */
        cargarDataTables();
        ajustarHeadersDataTables($('#tblModulos'));
        iniciarArbolModulos();


        /* =============================================================
        VARIABLES PARA REGISTRAR EL PERFIL Y LOS MODULOS SELECCIOMADOS
        ============================================================= */
        var idPerfil = 0;
        var selectedElmsIds = [];

        /* =============================================================
        EVENTO PARA SELECCIONAR UN PERFIL DEL DATATABLE Y MOSTRAR LOS MODULOS ASIGNADOS EN EL ARBOL DE MODULOS
        ============================================================= */
        $('#tbl_perfiles_asignar tbody').on('click', '.btnSeleccionarPerfil', function() {

            var data = tbl_perfiles_asignar.row($(this).parents('tr')).data();
           
            console.log(data);
            
            if ($(this).parents('tr').hasClass('selected')) {

                $(this).parents('tr').removeClass('selected');

                $('#modulos').jstree("deselect_all", false);

                $("#select_modulos option").remove();

                idPerfil = 0;

                $("#card-modulos").css("display", "none");

            } else {

                tbl_perfiles_asignar.$('tr.selected').removeClass('selected');

                $(this).parents('tr').addClass('selected');

                idPerfil = data.id;

                $("#card-modulos").css("display", "block"); //MOSTRAMOS EL ALRBOL DE MODULOS DEL SISTEMA

            //  alert(idPerfil);

                $.ajax({
    async: false,
    url: "{{ route('profile.GetModulesByProfile') }}",
    method: 'POST',
    data: {
        _token: '{{ csrf_token() }}',
        id_profile: idPerfil 
    },
    dataType: 'json',
    success: function(respuesta) {
        console.log(respuesta);
        modulos_usuario = respuesta;
        seleccionarModulosPerfil(idPerfil);
    },
    error: function(error) {
        console.error("Error al cargar los módulos:", error);
    }
});


            }
        })

        /* =============================================================
        EVENTO QUE SE DISPARA CADA VEZ QUE HAY UN CAMBIO EN EL ARBOL DE MODULOS
        ============================================================= */
        $("#modulos").on("changed.jstree", function(evt, data) {

            $("#select_modulos option").remove();

            var selectedElms = $('#modulos').jstree("get_selected", true);

            // console.log(selectedElms);

            $.each(selectedElms, function() {

                for (let i = 0; i < modulos_sistema.length; i++) {

                    if (modulos_sistema[i]["id"] == this.id && modulos_sistema[i]["vista"]) {

                        $('#select_modulos').append($('<option>', {
                            value: this.id,
                            text: this.text
                        }));
                    }
                }

            })

            if ($("#select_modulos").has('option').length <= 0) {

                $('#select_modulos').append($('<option>', {
                    value: 0,
                    text: "--No hay modulos seleccionados--"
                }));
            }


        })
        $('#modulos').on("changed.jstree", function(e, data) {
    console.log("Nodos seleccionados:", data.selected);
});
        /* =============================================================
        EVENTO PARA MARCAR TODOS LOS CHECKBOX DEL ARBOL DE MODULOS
        ============================================================= */
        $("#marcar_modulos").on('click', function() {
    // Seleccionar todos los nodos
    $('#modulos').jstree('select_all');

    // Obtener los nodos seleccionados
    let selectedNodes = $('#modulos').jstree('get_selected');

    // Mostrar los nodos seleccionados en un contenedor (por ejemplo, un <div> con id "nodosSeleccionados")
    let htmlContent = `<strong>Nodos seleccionados:</strong> <ul>`;
    selectedNodes.forEach(function(node) {
        htmlContent += `<li>${node}</li>`;
    });
    htmlContent += `</ul>`;

    // Insertar el contenido en el contenedor
    $('#nodosSeleccionados').html(htmlContent);
});


        /* =============================================================
        EVENTO PARA DESMARCAR TODOS LOS CHECKBOX DEL ARBOL DE MODULOS
        ============================================================= */
        $("#desmarcar_modulos").on('click', function() {

            $('#modulos').jstree("deselect_all", false);
            $("#select_modulos option").remove();

            $('#select_modulos').append($('<option>', {
                value: 0,
                text: "--No hay modulos seleccionados--"
            }));
        })

        /* =============================================================
        REGISTRO EN BASE DE DATOS DE LOS MODULOS ASOCIADOS AL PERFIL 
        ============================================================= */
        $("#asignar_modulos").on('click', function() {

          
            selectedElmsIds = []
            var selectedElms = $('#modulos').jstree("get_selected", true);

            $.each(selectedElms, function() {

                selectedElmsIds.push(this.id);

                if (this.parent != "#") {
                    selectedElmsIds.push(this.parent);
                }

            });

            //quitamos valores duplicados
            let modulosSeleccionados = [...new Set(selectedElmsIds)];

            let modulo_inicio = $("#select_modulos").val();

            // console.log(modulosSeleccionados);

            if (idPerfil != 0 && modulosSeleccionados.length > 0) {
                registrarPerfilModulos(modulosSeleccionados, idPerfil, modulo_inicio);
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Debe seleccionar el perfil y módulos a registrar',
                    showConfirmButton: false,
                    timer: 3000
                })
            }

        })

        /* =============================================================
        =============================================================
        =============================================================
        MANTENIMIENTO DE MODULOS
        =============================================================
        =============================================================
        ============================================================= */

        fnCargarArbolModulos();

        /* =============================================================
        REORGANIZAR MODULOS DEL SISTEMA
        ============================================================= */
        $("#btnReordenarModulos").on('click', function() {
            fnOrganizarModulos();
        })


        /* =============================================================
        REINICIALIZAR MODULOS DEL SISTEMA EN EL JSTREE
        ============================================================= */
        $("#btnReiniciar").on('click', function() {
            actualizarArbolModulos();
        })

        /*=============================================================
        VISTA PREVIA DEL ICONO DE LA VISTA
        ==============================================================*/
        $("#iptIconoModulo").change(function(){

            $("#spn_icono_modulo").html($("#iptIconoModulo").val())

            if($("#iptIconoModulo").val().length === 0){                
                $("#spn_icono_modulo").html("<i class='far fa-circle fs-6 text-white'></i>")
            }
        })

        /*===================================================================*/
        //EVENTO QUE GUARDA LOS DATOS DEL MODULO
        /*===================================================================*/
      


    }) // FIN DOCUMENT READY
    $('#delete_button').on('click', function(event) {
    event.preventDefault();

    Swal.fire({
        title: "Deseas Eliminar la Cuenta?",
        text: "No podras revertir el cambio!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--background)",
        cancelButtonColor: "var(--background)",

        confirmButtonText: "Si, eliminalo!"
    }).then((result) => {
        if (result.isConfirmed) {

            $(this).closest('form').submit();

            Swal.fire({
                title: "Eliminada!",
                text: "La cuenta ha sido eliminada correctamente.",
                icon: "success"
            });
        }
    });
});
$('#delete_module_button').on('click', function(event) {
    event.preventDefault();

    Swal.fire({
        title: "Deseas Eliminar la Cuenta?",
        text: "No podras revertir el cambio!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--background)",
        cancelButtonColor: "var(--background)",

        confirmButtonText: "Si, eliminalo!"
    }).then((result) => {
        if (result.isConfirmed) {

            $(this).closest('form').submit();

            Swal.fire({
                title: "Eliminada!",
                text: "La cuenta ha sido eliminada correctamente.",
                icon: "success"
            });
        }
    });
});

    function cargarDataTables() {

        tbl_perfiles_asignar = $('#tbl_perfiles_asignar').DataTable({
    ajax: {
        async: false,
        url: '{{ route('profile.load') }}',
        type: 'GET',
        dataType: 'json',
        dataSrc: 'data', // Esto asegura que DataTables use el array "data"
    },
    columns: [
        { data: 'id' },
        { data: 'description' },
        { data: 'status' },
        { data: 'created_at' },
        { data: 'updated_at' },
        { data: 'opciones', defaultContent: '' } // Para el botón de acciones
    ],
    columnDefs: [
        {
            targets: 2, // Columna "status"
            sortable: false,
            createdCell: function(td, cellData, rowData, row, col) {
                $(td).html(cellData == 1 ? 'Activo' : 'Inactivo');
            }
        },
        {
            targets: 5, // Columna "opciones"
            sortable: false,
            render: function(data, type, full, meta) {
                return `
                    <center>
                        <span class='btnSeleccionarPerfil  px-1' 
                              style='cursor:pointer;' 
                              data-bs-toggle='tooltip' 
                              data-bs-placement='top' 
                              title='Seleccionar perfil'>
                            <i class='fas fa-check fs-5'></i>
                        </span>
                    </center>
                `;
            }
        }
    ]
});

tbl_perfiles = $('#tbl_perfiles').DataTable({
    ajax: {
        async: false,
        url: '{{ route('profile.load') }}',
        type: 'GET',
        dataType: 'json',
        dataSrc: 'data', // Esto asegura que DataTables use el array "data"
    },
    columns: [
        { data: 'id' },
        { data: 'description' },
        { data: 'status' },
        { data: 'created_at' },
        { data: 'updated_at' },
    
    ],
    columnDefs: [
        {
            targets: 2, // Columna "status"
            sortable: false,
            createdCell: function(td, cellData, rowData, row, col) {
                $(td).html(cellData == 1 ? 'Activo' : 'Inactivo');
            }
        },
        {
            targets: 5, 
            sortable: false,
            render: function(data, type, rowData, meta) {
                return `
                    <form action="{{ url('profile/delete') }}/${rowData.id}" method="POST" 
                          style="display: inline;" onclick="event.stopPropagation();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="delete_button" class="btn  mt-3 ml-1">
                            Eliminar
                        </button>
                    </form>`;
            }
        }
     
    ]
});


        tbl_modulos = $('#tblModulos').DataTable({

            ajax: {
            url: "{{ route('module.load') }}",
            type: 'GET',
            dataType: 'json',
            dataSrc: 'data' // Especifica que los datos están en la clave "data"
        },
        columns: [
    { data: 'opciones' },
    { data: 'id' },
    { data: 'order' },
    { data: 'module' },
    { data: 'modulo_padre' },
    { data: 'view' },
    { data: 'icon_menu' },
    { data: 'created_at' },
    { data: 'updated_at' }
],

            columnDefs: [{
                    targets: 7,
                    visible: false
                },
                {
                    targets: 8,
                    visible: false
                },
                {
            targets: 0, 
            sortable: false,
            render: function(data, type, rowData, meta) {
                return `
                    <form action="{{ url('module/delete') }}/${rowData.id}" method="POST" 
                          style="display: inline;" onclick="event.stopPropagation();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="delete_module_button" class="btn  mt-3 ml-1">
                            Eliminar
                        </button>
                    </form>`;
            }
        }
            ],
            scrollX: true,
            order: [
                [2, 'asc']
            ],
            lengthMenu: [0, 5, 10, 15, 20, 50],
            pageLength: 20,
           
        });

    }

    function ajustarHeadersDataTables(element) {

        var observer = window.ResizeObserver ? new ResizeObserver(function(entries) {
            entries.forEach(function(entry) {
                $(entry.target).DataTable().columns.adjust();
            });
        }) : null;

        // Function to add a datatable to the ResizeObserver entries array
        resizeHandler = function($table) {
            if (observer)
                observer.observe($table[0]);
        };

        // Initiate additional resize handling on datatable
        resizeHandler(element);

    }

    function iniciarArbolModulos() {

        $.ajax({
            async: false,
            url: "{{route('GetModules')}}",
            method: 'GET',
            
            dataType: 'json',
            success: function(respuesta) {

                modulos_sistema = respuesta;

                // console.log(respuesta);

                // inline data demo
                $('#arbolModulos').jstree({
                    'core': {
                        "check_callback": true,
                        'data': respuesta
                    },
                    "checkbox": {
                        "keep_selected_style": true
                    },
                    "types": {
                        "default": {
                            "icon": "fas fa-laptop tree-text"
                        }
                    },
                    "plugins": ["wholerow", "checkbox", "types", "changed"]

                }).bind("loaded.jstree", function(event, data) {
                    // you get two params - event & data - check the core docs for a detailed description
                    $(this).jstree("open_all");
                });
                $('#modulos').jstree({
                    'core': {
                        "check_callback": true,
                        'data': respuesta
                    },
                    "checkbox": {
                        "keep_selected_style": false, // Los checkboxes no seguirán el estilo de selección
                        "tie_selection": false // Desvincula selección de checkboxes del nodo
                    },
                    "types": {
                        "default": {
                            "icon": "fas fa-laptop"
                        }
                    },
                    "plugins": ["wholerow", "checkbox", "types", "changed"]
                }).bind("loaded.jstree", function(event, data) {
                    $(this).jstree("open_all");
                });


            }
        })
    }

    function seleccionarModulosPerfil(pin_idPerfil) {

        $('#modulos').jstree('deselect_all');
        // console.log("modulos_sistema",modulos_sistema);
        // console.log("modulos_usuario",modulos_usuario);
        console.log("pin_idPerfil",pin_idPerfil);

        for (let i = 0; i < modulos_sistema.length; i++) {

            // console.log("modulos_sistema[i]['id']",modulos_sistema[i]["id"]);

            if (parseInt(modulos_sistema[i]["id"]) == parseInt(modulos_usuario[i]["id"]) && parseInt(modulos_usuario[i]["sel"]) == 1) {

                 

                $("#modulos").jstree("select_node", modulos_sistema[i]["id"]);

            }

        }

        /*OCULTAMOS LA OPCION DE MODULOS Y PERFILES PARA EL PERFIL DE ADMINISTRADOR*/
        if (pin_idPerfil == 1) { //SOLO PERFIL ADMINISTRADOR
            $("#modulos").jstree(true).hide_node(13);
        } else {
            $('#modulos').jstree(true).show_all();
        }

    }

    function registrarPerfilModulos(modulosSeleccionados, idPerfil, idModulo_inicio) {


        $.ajax({
            async: false,
            url: "{{route('storeprofile_modules')}}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id_modulosSeleccionados: modulosSeleccionados,
                id_Perfil: idPerfil,
                id_modulo_inicio: idModulo_inicio
            },
            dataType: 'json',
            success: function(respuesta) {

                if (respuesta > 0) {

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Se registro correctamente',
                        showConfirmButton: false,
                        timer: 2000
                    })

                    $("#select_modulos option").remove();
                    $('#modulos').jstree("deselect_all", false);
                    tbl_perfiles_asignar.ajax.reload();
                    $("#card-modulos").css("display", "none");

                } else {

                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Error al registrar',
                        showConfirmButton: false,
                        timer: 3000
                    })

                }

            }
        });
    }

    function actualizarArbolModulosPerfiles() {

        $.ajax({
            async: false,
            url: "{{route('GetModules')}}",
            method: 'GET',
            data: {
                accion: 1
            },
            dataType: 'json',
            success: function(respuesta) {
                modulos_sistema = respuesta;

                // console.log(modulos_sistema);

                $('#modulos').jstree(true).settings.core.data = respuesta;
                $('#modulos').jstree(true).refresh();
            }
        });

    }

    /* =============================================================
    =============================================================
    =============================================================
    FUNCIONES PARA EL MANTENIMIENTO DE MODULOS
    =============================================================
    =============================================================
    ============================================================= */

    function fnCargarArbolModulos() {

        var dataSource;

        $.ajax({
            async: false,
            url: "{{route('module.load')}}",
            method: 'get',
            dataType: 'json',
            success: function(respuesta) {

                dataSource = respuesta;
                // console.log("🚀 ~ file: modulos_perfiles.php ~ line 793 ~ fnCargarArbolModulos ~ dataSource", dataSource)
            }
        });
    

      
        $('#arbolModulos').jstree({
            "core": {
                "check_callback": true,
                "data": dataSource
            },
            "types": {
                "default": {
                    "icon": "fas fa-laptop"
                },
                "file": {
                    "icon": "fas fa-laptop"
                }
            },
            "plugins": ["types", "dnd"]
        }).bind('ready.jstree', function(e, data) {
            $('#arbolModulos').jstree('open_all')
        })

    }

    function actualizarArbolModulos() {

        $.ajax({
            async: false,
            url: "{{route('GetModules')}}",
            method: 'GET',
            data: {
                accion: 1
            },
            dataType: 'json',
            success: function(respuesta) {

                $('#arbolModulos').jstree(true).settings.core.data = respuesta;
                $('#arbolModulos').jstree(true).refresh();
            }
        });

    }

    function fnOrganizarModulos() {

        var array_modulos = [];

        var reg_id, reg_padre_id, reg_orden;

        var v = $("#arbolModulos").jstree(true).get_json('#', {
            'flat': true
        });

        console.log("🚀 ~ file: modulos_perfiles.php ~ line 1074 ~ fnOrganizarModulos ~ v", v)

        for (i = 0; i < v.length; i++) {

            var z = v[i];
            console.log("🚀 ~ file: modulos_perfiles.php ~ line 871 ~ fnOrganizarModulos ~ z", z)

            //asignamos el id, el padre Id y el nombre del modulo
            reg_id = z["id"];
            reg_padre_id = z["parent"];
            reg_orden = i;

            array_modulos[i] = reg_id + ';' + reg_padre_id + ';' + reg_orden;

        }



        console.log("🚀 ~ file: modulos_perfiles.php ~ line 713 ~ $ ~ array_modulos", array_modulos)

        /*REGISTRAMOS LOS MODULOS CON EL NUEVO ORDENAMIENTO */
        $.ajax({
            async: false,
            url: "OrganizeModules",
            method: 'POST',
            data: {
                accion: 4,
                modulos: array_modulos
            },
            dataType: 'json',
            success: function(respuesta) {

                if (respuesta > 0) {

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Se registró correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    tbl_modulos.ajax.reload();

                    //recargamos arbol de modulos - MANTENIMIENTO MODULOS ASIGNADOS A PERFILES                                
                    actualizarArbolModulosPerfiles();

                } else {

                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Error al registrar',
                        showConfirmButton: false,
                        timer: 1500
                    })

                }



            }
        });

    }

    function fnRegistrarModulo() {

        var forms = document.getElementsByClassName('needs-validation-registro-modulo');

        var validation = Array.prototype.filter.call(forms, function(form) {

            if (form.checkValidity() === true) {

                console.log("Listo para registrar el producto");

                Swal.fire({
                    title: 'Está seguro de registrar el producto?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, deseo registrarlo!',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {

                    if (result.isConfirmed) {

                        $("#iptIconoModulo").val($('#spn_icono_modulo i').attr('class'));

                        $.ajax({
                            async: false,
                            url: "ajax/modulo.ajax.php",
                            method: 'POST',
                            data: {
                                accion: 5,
                                datos: $('#frm_registro_modulo').serialize()
                            },
                            dataType: 'json',
						    success: function(respuesta) {

							    console.log("🚀 ~ file: modulos_perfiles.php ~ line 1240 ~ validation ~ respuesta", respuesta)

                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: respuesta,
                                    showConfirmButton: false,
                                    timer: 1500
                                })

                                tbl_modulos.ajax.reload();

                                //recargamos arbol de modulos - MANTENIMIENTO MODULOS
							    actualizarArbolModulos();

                                //recargamos arbol de modulos - MANTENIMIENTO MODULOS ASIGNADOS A PERFILES                                
							    actualizarArbolModulosPerfiles();

                                $("#iptModulo").val("");
                                $("#iptVistaModulo").val("");
                                $("#iptIconoModulo").val("");

                                $(".needs-validation-registro-modulo").removeClass("was-validated");
                            }

                        })

                    }
                });

            }

            form.classList.add('was-validated');
        })

    }
</script>
@endsection