@extends('layouts.app')
@extends('layouts.sidebar')
@section('content')
<style type="text/css">
	
	#brand-table_filter{
		text-align: left !important;

   
	}
</style>
        <style type="text/css">
                    .swal-wide{
            width:755px !important;
        }
        .nav-stacked>li.active>a, .nav-stacked>li.active>a:hover {
    background: transparent;
    color: #444;
    border-top: 0;
    border-left-color:var(--background) !important;
}
.box.box-primary{
 border-top-color:var(--background) !important;   
}

.bg-pink{
    background:var(--background) !important;
}
table.clinic-table-primary tr th {
    color: #fff !important;
    background:var(--background) !important;
    font-weight: normal !important;

}
.clinic-box-title{
    color: #212529 !important;
}
        </style>
   
  <link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/bootstrap/css/bootstrap.min.css">
         <link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/plugins/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/dist/css/skins/_all-skins.min.css">
        <!-- <link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/plugins/bootstrap-tour-0.12.0/build/css/bootstrap-tour.min.css"> -->
        <link rel="stylesheet" type="text/css" href="https://dentalclinicapp.com/template/AdminLTE/clinic/css/clinic-all.css">
        <link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/plugins/select2/select2.min.css">
<link rel="stylesheet" href="https://dentalclinicapp.com/template/AdminLTE/plugins/select2/select2.bootstrap.css">


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
	<div class="col-md-12">
		<section class="content-header">
		</section>
		<section class="content">
			<div class="row">
				<div class="col-md-2" >
					<ul class="nav nav-pills nav-stacked" style="background-color: #fff;">
					<li role="presentation" class=""><a href="{{route('clinic.drugs')}}">Genericos</a></li>
						<li role="presentation" class="active"><a href="{{route('clinic.brand')}}">Marcas</a></li>
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
			<a href="#drug-generic-modal" data-toggle="modal" data-backdrop="static" data-method="POST" class="btn btn-primary bg-pink btn-sm" data-action="https://dentalclinicapp.com/clinic/settings/drug-generic"><span class="fa fa-plus"></span>&nbsp;Crear Generico</a>
		</div>
			</div>

	<div class="box-body">
		<div class="table-responsive">
			<table class="table table-hover table-bordered clinic-table-primary" id="generic-table" style="width: 100%">
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
</div>																				<div class="box box-danger">
    <div class="box-header with-border">
        <h1 class="box-title"><i class="fa fa-history"></i> Logs</h1>
    </div>
    <div class="box-body">
                        <span class="text-warning">No logs found.</span>
                </div>
</div>				</div>
			</div>
			
		</section>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="drug-generic-modal" tabindex="-1" role="dialog" aria-labelledby="myDrugGenericModalLabel" >
<form method="POST" action="https://dentalclinicapp.com" accept-charset="UTF-8" role="form" id="drug-generic-modal-form" class="form-horizontal clinic-text-gray"><input name="_token" type="hidden" value="8pwtLnLxEyIbV8s1pFCa1UH8CSL0nT797JqTHQuS">
    <input name="_method" type="hidden" value="POST">
    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header clinic-modal-header clinic-text-gray" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myDrugGenericModalLabel"> Add Generic</h4>
            </div>

            <div class="modal-body">
             
                <div class="row">
                
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="name"><i class="asterisk" style="color:red;">*</i> Generic Name :</label>
                            <div class="col-sm-9">
                                <input class="form-control" id="generic_name" placeholder="" autocomplete="off" name="name" type="text" value="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn clinic-btn-magenta btn-loading" id="btn_save_drug-generic" data-loading-text="<i class='fa fa-refresh fa-spin'> </i> Saving...">&nbsp;&nbsp;<i class="fa fa-save"></i> &nbsp;Save&nbsp;&nbsp;&nbsp;</button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</form>
</div>
<!-- Modal -->
<div class="modal fade" id="drug-brand-modal" tabindex="-1" role="dialog" aria-labelledby="myDrugBrandModalLabel" >
<form method="POST" action="https://dentalclinicapp.com" accept-charset="UTF-8" role="form" id="drug-brand-modal-form" class="form-horizontal clinic-text-gray"><input name="_token" type="hidden" value="8pwtLnLxEyIbV8s1pFCa1UH8CSL0nT797JqTHQuS">
    <input name="_method" type="hidden" value="POST">
    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header clinic-modal-header clinic-text-gray" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myDrugBrandModalLabel"> Add Brand Name</h4>
            </div>

            <div class="modal-body">
             
                <div class="row">
                    
                    <div class="col-md-12">
                       <!--   <div class="form-group">
                              <label for="generic_id" class="col-sm-3 control-label">Generic Name:</label>
                              <div class="col-sm-9">
                                    <select class="form-control select2" id="generic_id" style="width:100%;" name="generic_id"></select>
                              </div> -->
                                                            <!-- <div class="col-sm-9">
                                    <input class="form-control" id="b_generic_name" placeholder="" readonly="readonly" name="generic_name" type="text" value="">
                                    <input class="form-control" id="b_generic_id" placeholder="" name="generic_id" type="hidden" value="">
                              </div> -->
                                                        <!-- </div> -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="name"><i class="asterisk" style="color:red;">*</i> Brand Name :</label>
                            <div class="col-sm-9">
                                <input class="form-control" id="brand_name" placeholder="" autocomplete="off" name="name" type="text" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn clinic-btn-magenta btn-loading" id="btn_save_drug-brand" data-loading-text="<i class='fa fa-refresh fa-spin'> </i> Saving...">&nbsp;&nbsp;<i class="fa fa-save"></i> &nbsp;Save&nbsp;&nbsp;&nbsp;</button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</form>
</div>
<!-- Modal -->
<div class="modal fade" id="drug-dosage-modal" tabindex="-1" role="dialog" aria-labelledby="myDrugDosageModalLabel" >
<form method="POST" action="https://dentalclinicapp.com" accept-charset="UTF-8" role="form" id="drug-dosage-modal-form" class="form-horizontal clinic-text-gray"><input name="_token" type="hidden" value="8pwtLnLxEyIbV8s1pFCa1UH8CSL0nT797JqTHQuS">
    <input name="_method" type="hidden" value="POST">
    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header clinic-modal-header clinic-text-gray" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myDrugDosageModalLabel"> Add Dosage Name</h4>
            </div>

            <div class="modal-body">
             
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="name"><i class="asterisk" style="color:red;">*</i> Dosage Name :</label>
                            <div class="col-sm-9">
                                <input class="form-control" id="dosage_name" placeholder="" autocomplete="off" name="name" type="text" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn clinic-btn-magenta btn-loading" id="btn_save_drug-dosage" data-loading-text="<i class='fa fa-refresh fa-spin'> </i> Saving...">&nbsp;&nbsp;<i class="fa fa-save"></i> &nbsp;Save&nbsp;&nbsp;&nbsp;</button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</form>
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
        <script type="text/javascript">
            $(function(){

                var firstDay = "0";
                $.datepicker.setDefaults({
                  firstDay: parseInt(firstDay)
                });

                // var current_system_time = '2024-01-11';
                // var storageNameSystemDown = 'system_down_notice_60171';
                // var storageStSystemDown = window.localStorage.getItem(storageNameSystemDown) || "";
                // if(storageStSystemDown && JSON.parse(storageStSystemDown).date != current_system_time || !storageStSystemDown){
                //         localStorage.removeItem(storageNameSystemDown);
                //     swal({
                //         title: 'My Dental Clinic System Upgrade Maintenance',
                //         html: "<p align='left'>Dear Valued Users and Partners,<br><br>"+
                //               `<p align='justify'>We hope this message finds you well. We would like to inform you that My Dental Clinic will be undergoing a scheduled system upgrade maintenance on <b>December 28, 2023</b>, starting at <b>6:00 PM (Philippine Time)</b>. This upgrade is essential for enhancing the performance and reliability of our systems.</p> 

                //               <p align="left"><b>Maintenance Details:</b></p> 
                //               <ul>
                //                 <li align="left"><b>Date and Time:</b> December 28, 2023, starting at 6:00 PM (Philippine Time) </li>
                //                 <li align="left"><b>Expected Duration:</b> Up to 8 hours </li>
                //               </ul>
                //             <p align="justify">During this period, My Dental Clinic will experience downtime. We understand the inconvenience this may cause and apologize for any disruption to your service.</p>

                //             <p align="justify"><b>Purpose of the Upgrade:</b> The primary focus of this maintenance is to perform a Database Version Upgrade. This crucial update will ensure the security, efficiency, and overall functionality of our systems, allowing us to continue providing you with the best possible dental care experience.</p>

                //             <p align="justify">We appreciate your understanding and patience during this upgrade process. Our team will be working diligently to minimize the downtime and restore normal operations as swiftly as possible.</p>

                //             <p align="justify">If you have any immediate concerns or need assistance during the maintenance period, please don't hesitate to contact us at email@dentalclinicapp.com.</p>

                //             <p align="justify">Thank you for your continued trust and cooperation.</p>

                //             <p align="justify">Best regards,</p> 
                //             <p align="justify">Mr. Jonell M. Babat<br/>Vice President for Sales<br/>My Dental Clinic</p>`,

                //         type: 'info',
                //         showCancelButton: true,
                //         showConfirmButton: false,
                //         cancelButtonColor: '#00c0ef',
                //          customClass: 'swal-wide',
                //         cancelButtonText: 'OK',
                //         allowOutsideClick: false
                //     }).then(function (result) {
                //         if(result.dismiss == 'cancel'){
                //             var res = {date: current_system_time, clicked: 1};
                //             window.localStorage.setItem(storageNameSystemDown, JSON.stringify(res));
                //         }
                //     });
                // }
            })
        </script>

                        <script type="text/javascript">
            $(function () {
                $('body').on('hidden.bs.modal', function () {
                    if($('.modal.in').length > 0)
                    {
                        $('body').addClass('modal-open');
                    }
                });
                
                $.ajaxSetup({
                   headers: { 'X-CSRF-TOKEN': '8pwtLnLxEyIbV8s1pFCa1UH8CSL0nT797JqTHQuS' }
                });
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="popover"]').popover();
                $.datepicker.setDefaults({
                    yearRange: "1970:+1"
                });
                $('.btn-loading').click(function(){
                    $(this).button('loading');
                });
                $.fn.dataTable.ext.errMode = 'none'; 
                $('table').on('error.dt', function(e, settings, techNote, message) {
                  console.log( 'An error occurred: ', message); 
                });

                $('a[href="#upgrade"]').click(function(){
                    UpgradeAlert();

                    var data_installment = $(this).data('installment');
                    if(data_installment == false){
                        setTimeout(function(){
                            $('#installment_tab').removeClass('active');
                            $('#full_payment_tab').addClass('active');
                        }, 10);
                    }

                    var data_add_installment = $(this).data('add_installment');
                    if(data_add_installment == false){
                        setTimeout(function(){
                            $('#li-cash').addClass('active');
                            $('#li-installment').removeClass('active');
                        }, 10);
                    }
                });
            });
            function UpgradeAlert(){
                swal({
                    title: 'Unlock Feature',
                    text: "This feature is not available for free users.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#18a2eb',
                    cancelButtonColor: '#b566d3',
                    confirmButtonText: 'Upgrade',
                    showLoaderOnConfirm: true,
                    preConfirm : function(){
                        return new Promise(function(){
                            window.location = "https://dentalclinicapp.com/clinic/dmvbF4cchxdmLEi27rG8CBkF6LdBwa7bcuwva9OJG1fFyq63FLmucO3mQzFr/subscription";
                        });
                    },
                    allowOutsideClick: false
                });
            }
        </script>
        <script type="text/javascript" src="https://dentalclinicapp.com/vendor/jsvalidation/js/jsvalidation.js"></script>
<script>
    jQuery(document).ready(function(){

        $("form#drug-generic-modal-form").each(function() {
            $(this).validate({
                errorElement: 'span',
                errorClass: 'help-block error-help-block error_message',

                // errorPlacement: function (error, element) {
                //     if (element.parent('.input-group').length ||
                //         element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                //         error.insertAfter(element.parent());
                //         // else just place the validation message immediately after the input
                //     } else {
                //         error.insertAfter(element);
                //     }
                // },
                errorPlacement: function(error, element) {
                    
                    if (element.parent('.input-group').length ||
                        element.prop('type') === 'checkbox' || element.prop('type') === 'radio' || element.hasClass('intlphone')) {

                        if(element.hasClass('radio-inline')) {
                            $(element).closest('.form-group').find('div.inline-message').html(error);
                        } else if(element.hasClass('entry_for')) {
                            $(element).closest('.form-group').find('div.inline-message').html(error);
                        } else {

                            error.insertAfter(element.parent());
                        }
                        // else just place the validation message immediatly after the input
                    } else if (element.hasClass('select2')) {
                        error.insertAfter(element.next('span'));
                    } else if (element.hasClass('editor')) {
                        $(element).closest('.form-group').find('div.long-message').html(error);
                    } else if (element.hasClass('select2-hide-search')) {
                        $(element).closest('.form-group').find('div.long-message').html(error);
                    } else if (element.hasClass('group')) {
                        $(element).closest('.form-group').find('div.group-message').html(error);
                    } else if (element.hasClass('textbox-short')) {
                        $(element).closest('.form-group').find('div.long-message').html(error);
                    } else if (element.prop('type') === 'hidden') {
                        $(element).closest('.form-group').find('div.combobox-message').html(error);
                    } else if (element.hasClass('min_age')) {
                        $(element).closest('.group').find('div.inline-message').html(error);
                    } else if( element.hasClass('text-label')){
                       $(element).closest('.form-group').find('div.inline-message').html(error);
                    } else {
                        
                        error.insertAfter(element);
                    }

                },
                highlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
                },

                
                /*
                 // Uncomment this to mark as validated non required fields
                 unhighlight: function(element) {
                 $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                 },
                 */
                success: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
                },

                focusInvalid: false, // do not focus the last invalid input
                
                rules: {"name":{"laravelValidation":[["Required",[],"Generic name field is required.",true]]}}            });
        });
    });
</script>

<script>
    jQuery(document).ready(function(){

        $("form#drug-brand-modal-form").each(function() {
            $(this).validate({
                errorElement: 'span',
                errorClass: 'help-block error-help-block error_message',

                // errorPlacement: function (error, element) {
                //     if (element.parent('.input-group').length ||
                //         element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                //         error.insertAfter(element.parent());
                //         // else just place the validation message immediately after the input
                //     } else {
                //         error.insertAfter(element);
                //     }
                // },
                errorPlacement: function(error, element) {
                    
                    if (element.parent('.input-group').length ||
                        element.prop('type') === 'checkbox' || element.prop('type') === 'radio' || element.hasClass('intlphone')) {

                        if(element.hasClass('radio-inline')) {
                            $(element).closest('.form-group').find('div.inline-message').html(error);
                        } else if(element.hasClass('entry_for')) {
                            $(element).closest('.form-group').find('div.inline-message').html(error);
                        } else {

                            error.insertAfter(element.parent());
                        }
                        // else just place the validation message immediatly after the input
                    } else if (element.hasClass('select2')) {
                        error.insertAfter(element.next('span'));
                    } else if (element.hasClass('editor')) {
                        $(element).closest('.form-group').find('div.long-message').html(error);
                    } else if (element.hasClass('select2-hide-search')) {
                        $(element).closest('.form-group').find('div.long-message').html(error);
                    } else if (element.hasClass('group')) {
                        $(element).closest('.form-group').find('div.group-message').html(error);
                    } else if (element.hasClass('textbox-short')) {
                        $(element).closest('.form-group').find('div.long-message').html(error);
                    } else if (element.prop('type') === 'hidden') {
                        $(element).closest('.form-group').find('div.combobox-message').html(error);
                    } else if (element.hasClass('min_age')) {
                        $(element).closest('.group').find('div.inline-message').html(error);
                    } else if( element.hasClass('text-label')){
                       $(element).closest('.form-group').find('div.inline-message').html(error);
                    } else {
                        
                        error.insertAfter(element);
                    }

                },
                highlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
                },

                
                /*
                 // Uncomment this to mark as validated non required fields
                 unhighlight: function(element) {
                 $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                 },
                 */
                success: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
                },

                focusInvalid: false, // do not focus the last invalid input
                
                rules: {"name":{"laravelValidation":[["Required",[],"Brand name field is required.",true]]}}            });
        });
    });
</script>

<script>
    jQuery(document).ready(function(){

        $("form#drug-dosage-modal-form").each(function() {
            $(this).validate({
                errorElement: 'span',
                errorClass: 'help-block error-help-block error_message',

                // errorPlacement: function (error, element) {
                //     if (element.parent('.input-group').length ||
                //         element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                //         error.insertAfter(element.parent());
                //         // else just place the validation message immediately after the input
                //     } else {
                //         error.insertAfter(element);
                //     }
                // },
                errorPlacement: function(error, element) {
                    
                    if (element.parent('.input-group').length ||
                        element.prop('type') === 'checkbox' || element.prop('type') === 'radio' || element.hasClass('intlphone')) {

                        if(element.hasClass('radio-inline')) {
                            $(element).closest('.form-group').find('div.inline-message').html(error);
                        } else if(element.hasClass('entry_for')) {
                            $(element).closest('.form-group').find('div.inline-message').html(error);
                        } else {

                            error.insertAfter(element.parent());
                        }
                        // else just place the validation message immediatly after the input
                    } else if (element.hasClass('select2')) {
                        error.insertAfter(element.next('span'));
                    } else if (element.hasClass('editor')) {
                        $(element).closest('.form-group').find('div.long-message').html(error);
                    } else if (element.hasClass('select2-hide-search')) {
                        $(element).closest('.form-group').find('div.long-message').html(error);
                    } else if (element.hasClass('group')) {
                        $(element).closest('.form-group').find('div.group-message').html(error);
                    } else if (element.hasClass('textbox-short')) {
                        $(element).closest('.form-group').find('div.long-message').html(error);
                    } else if (element.prop('type') === 'hidden') {
                        $(element).closest('.form-group').find('div.combobox-message').html(error);
                    } else if (element.hasClass('min_age')) {
                        $(element).closest('.group').find('div.inline-message').html(error);
                    } else if( element.hasClass('text-label')){
                       $(element).closest('.form-group').find('div.inline-message').html(error);
                    } else {
                        
                        error.insertAfter(element);
                    }

                },
                highlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
                },

                
                /*
                 // Uncomment this to mark as validated non required fields
                 unhighlight: function(element) {
                 $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                 },
                 */
                success: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
                },

                focusInvalid: false, // do not focus the last invalid input
                
                rules: {"name":{"laravelValidation":[["Required",[],"Dosage form field is required.",true]]}}            });
        });
    });
</script>

<script type="text/javascript">
var $drugGenericModalForm = $('form#drug-generic-modal-form');
var $drugBrandModalForm = $('form#drug-brand-modal-form');
var $drugDosageModalForm = $('form#drug-dosage-modal-form');

$(function(){
	// Generic Modal
	$('#drug-generic-modal').on('show.bs.modal', function(e){
		var button = $(e.relatedTarget);
		var action = button.data('action');
		var method = button.data('method');
		var generic_name = button.data("generic-name");
		var modal = $(this);

		$drugGenericModalForm.attr('action', action);
		$drugGenericModalForm.attr('method', method);
		$drugGenericModalForm.find('[name="_method"]').val(method);

		if(method == 'PUT'){
			modal.find('.modal-title').html('<i class="fa fa-pencil-square-o"></i> Edit Generic Name');
			modal.find('#generic_name').val(generic_name);
		}

		if(method == 'POST'){
			modal.find('.modal-title').html('<i class="fa fa-plus-square-o"></i> Add Generic Name');
		}			
		modal.find('.form-group').removeClass('has-error has-success');
		modal.find('[id*="-error"]').remove();
	});

	$('#drug-generic-modal').on('hidden.bs.modal', function(e){
		var modal = $(this);

		$drugGenericModalForm.attr('action', '');
		$drugGenericModalForm.attr('method', '');
		$drugGenericModalForm.find('[name="_method"]').val('');	
		modal.find('#generic_name').val('');
		modal.find('.form-group').removeClass('has-error has-success');
		modal.find('[id*="-error"]').remove();
	});

	$drugGenericModalForm.submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var action = $(this).attr('action');
        var method = $(this).find('input[name="_method"]').val();
        var brand_action = 'https://dentalclinicapp.com/clinic/settings/drug-brand';
	    if(form.valid()) {
	    	$.ajax({
                url: action,
                type: method,
                dataType: 'json',
                data: form.serialize(),
            })
            .done(function(response) {
                if(response.type == 'success')
                {
                    drugsGenericTable.draw();
                    $('#drug-generic-modal').modal('hide');
                    /*if(response.method == 'add'){
                    	swal({ 
							title: response.message,
				            text: "Do you want to add a brand?",
				            type: "success",
				            showCancelButton: true,
					        confirmButtonColor: '#e663b8',
					        cancelButtonColor: '##ddd',
					        confirmButtonText: 'Yes',
					        cancelButtonText: 'No',
				            allowOutsideClick: false
						}).then(okay => {
							if(okay.value){
								$drugBrandModalForm.attr('action', brand_action);
								$drugBrandModalForm.attr('method', method);
								$drugBrandModalForm.find('[name="_method"]').val(method);
								$drugBrandModalForm.find('#b_generic_name').val(response.data.name);
								$drugBrandModalForm.find('#b_generic_id').val(response.data.id);
								$('#drug-brand-modal').modal('show');
							}
						});
                    //}else{*/
                    	swal(response.message, '', 'success')
                   // }
                    $('.btn-loading').button('reset');
                }else if(response.type == 'not_changed'){
                	$('#drug-generic-modal').modal('hide');
                	$('.btn-loading').button('reset');
                }else{
                	swal(response.message, '', 'error');
                	$('.btn-loading').button('reset');
                }
            });
	    } else {
	    	setTimeout(function(){
	    		$('.btn-loading').button('reset');
	    	}, 500)
	    }
	});

	// Brand Modal
	$('#drug-brand-modal').on('show.bs.modal', function(e){
		var button = $(e.relatedTarget);
		var action = button.data('action');
		var method = button.data('method');
		var gen_id = button.attr('data-gen-id');
		var gen_name = button.attr('data-gen-name');
		var brand_name = button.data('brand-name');
		var modal = $(this);

		if(action != '' && action != undefined){
			$drugBrandModalForm.attr('action', action);
		}

		if(method != '' && method != undefined){
			$drugBrandModalForm.attr('method', method);
			$drugBrandModalForm.find('[name="_method"]').val(method);
		}

		if(gen_id != '' && gen_id != undefined){
			$drugBrandModalForm.find('#b_generic_name').val(gen_name);
			$drugBrandModalForm.find('#b_generic_id').val(gen_id);
		}

		if(method == 'POST' || method == undefined){
			modal.find('.modal-title').html('<i class="fa fa-plus-square-o"></i> Add Brand Name');
		}

		if(method == 'PUT'){
			$drugBrandModalForm.find('#brand_name').val(brand_name);
			modal.find('.modal-title').html('<i class="fa fa-pencil-square-o"></i> Edit Brand Name');
		}

		modal.find('.form-group').removeClass('has-error has-success');
		modal.find('[id*="-error"]').remove();
	});

	$('#drug-brand-modal').on('hidden.bs.modal', function(e){
		var modal = $(this);

		$drugBrandModalForm.attr('action', '');
		$drugBrandModalForm.attr('method', '');
		$drugBrandModalForm.find('[name="_method"]').val('');
		modal.find('#b_generic_name').val('');
		modal.find('#b_generic_id').val('');
		modal.find('#brand_name').val('');
		modal.find('.form-group').removeClass('has-error has-success');
		modal.find('[id*="-error"]').remove();

		var view_brand = $('#view-brand-modal').is(':visible');
		if(view_brand == true){
			$("body").addClass("modal-open");
		}
	});

	$drugBrandModalForm.submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var action = $(this).attr('action');
        var method = $(this).find('input[name="_method"]').val();

	    if(form.valid()) {
	    	$.ajax({
                url: action,
                type: method,
                dataType: 'json',
                data: form.serialize(),
            })
            .done(function(response) {
                if(response.type == 'success'){
                	if ($.fn.DataTable.isDataTable('#brand-table')) {
						drugsBrandTable.draw();
					}
                    $('#drug-brand-modal').modal('hide');
                    swal(response.message, '', 'success')
                    $('.btn-loading').button('reset');
                }else if(response.type == 'not_changed'){
                	$('#drug-brand-modal').modal('hide');
                	$('.btn-loading').button('reset');
                }else{
                	swal(response.message, '', 'error');
                	$('.btn-loading').button('reset');
                }
            });
	    } else {
	    	setTimeout(function(){
	    		$('.btn-loading').button('reset');
	    	}, 500)
	    }
	});

	// Dosage Modal
	$('#drug-dosage-modal').on('show.bs.modal', function(e){
		var button = $(e.relatedTarget);
		var action = button.data('action');
		var method = button.data('method');
		var dosage_name = button.data('dosage-name');
		var modal = $(this);

		$drugDosageModalForm.attr('action', action);
		$drugDosageModalForm.attr('method', method);
		$drugDosageModalForm.find('[name="_method"]').val(method);

		if(method == 'PUT'){
			$drugDosageModalForm.find('#dosage_name').val(dosage_name);
			modal.find('.modal-title').html('<i class="fa fa-pencil-square-o"></i> Edit Dosage Name');
		}

		if(method == 'POST'){
			modal.find('.modal-title').html('<i class="fa fa-plus-square-o"></i> Add Dosage Name');
		}			
		modal.find('.form-group').removeClass('has-error has-success');
		modal.find('[id*="-error"]').remove();
	});

	$('#drug-dosage-modal').on('hidden.bs.modal', function(e){
		var modal = $(this);

		$drugDosageModalForm.attr('action', '');
		$drugDosageModalForm.attr('method', '');
		$drugDosageModalForm.find('[name="_method"]').val('');	
		modal.find('#dosage_name').val('');
		modal.find('.form-group').removeClass('has-error has-success');
		modal.find('[id*="-error"]').remove();
	});

	$drugDosageModalForm.submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var action = $(this).attr('action');
        var method = $(this).find('input[name="_method"]').val();

	    if(form.valid()) {
	    	$.ajax({
                url: action,
                type: method,
                dataType: 'json',
                data: form.serialize(),
            })
            .done(function(response) {
                if(response.type == 'success'){
                	drugsDosageTable.draw();
                    $('#drug-dosage-modal').modal('hide');
                    swal(response.message, '', 'success')
                    $('.btn-loading').button('reset');
                }else if(response.type == 'not_changed'){
                	$('#drug-dosage-modal').modal('hide');
                	$('.btn-loading').button('reset');
                }else{
                	swal(response.message, '', 'error');
                	$('.btn-loading').button('reset');
                }
            });
	    } else {
	    	setTimeout(function(){
	    		$('.btn-loading').button('reset');
	    	}, 500)
	    }
	});
});
</script><script type="text/javascript" src="https://dentalclinicapp.com/template/AdminLTE/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
$(function(){
	drugsGenericTable = $('#generic-table').DataTable({
		processing: true,
	    serverSide: true,
	    "pagingType": "input",
	    ajax: {
	        url:'https://dentalclinicapp.com/clinic/settings/drug/get-generic-data',
	        method: 'POST'
	    },
	    columns: [
	    	{data: 'DT_Row_Index', orderable: false, searchable: false,width:'10px', className : 'text-center'},
	    	{ data: 'name', name: 'name', orderable: true, searchable: true},
	    	{ data: 'action', name: 'action', orderable: false, searchable: false,width:'100px', class:'text-center'},
	    ],
	    fnDrawCallback: function ( oSettings ) {
	    	$('a#btn-generic-delete').click(function(){
	    		var action = $(this).data('action');
				swal({
				    title: 'Are you sure?',
				    text: "You will not be able to recover this!",
				    type: 'warning',
				    showCancelButton: true,
				    confirmButtonColor: '#e663b8',
				    cancelButtonColor: '##ddd',
				    confirmButtonText: 'Yes, delete it!',
				    showLoaderOnConfirm: true,
				    preConfirm : function(){
				    	return new Promise(function(){
					        $.ajax({
					            type: "DELETE",
					            url: action,
					            dataType: 'json',
					            success: function(data) {
					                if(data.type == "success") {
					                    swal({
				                    		title: 	'Deleted!',
				                    	  	text: 	data.message,
				                    	 	type: 	'success'
					                    });
					                    drugsGenericTable.draw();
					               }else{
					                    swal({
				                    		title: 	'Error!',
				                    	  	text: 	data.message,
				                    	 	type: 	'error'
					                    });
					               }
					            },
					            error :function( jqXhr ) {
					                swal(
				                      'Error!',
				                      'Something went wrong.',
				                      'error'
				                    );        
					            }
					        });
				    	});
				    },
				    allowOutsideClick: false
				});
	    	});
	    },
	    "order": [[1, "asc"]],
	});

	drugsBrandTable = $('#brand-table').DataTable({
		processing: true,
	    serverSide: true,
	    "pagingType": "input",
	    ajax: {
	        url:'https://dentalclinicapp.com/clinic/settings/drug/get-brand-data',
	        method: 'POST'
	    },
	    columns: [
	    	{data: 'DT_Row_Index', orderable: false, searchable: false,width:'10px', className : 'text-center'},
	    	{ data: 'name', name: 'name', orderable: true, searchable: true},
	    	{ data: 'action', name: 'action', orderable: false, searchable: false,width:'100px', class:'text-center'},
	    ],
	    fnDrawCallback: function ( oSettings ) {
	    	$('a#btn-brand-delete').click(function(){
	    		var action = $(this).data('action');
				swal({
				    title: 'Are you sure?',
				    text: "You will not be able to recover this!",
				    type: 'warning',
				    showCancelButton: true,
				    confirmButtonColor: '#e663b8',
				    cancelButtonColor: '##ddd',
				    confirmButtonText: 'Yes, delete it!',
				    showLoaderOnConfirm: true,
				    preConfirm : function(){
				    	return new Promise(function(){
					        $.ajax({
					            type: "DELETE",
					            url: action,
					            dataType: 'json',
					            success: function(data) {
					                if(data.type == "success") {
					                    swal({
				                    		title: 	'Deleted!',
				                    	  	text: 	data.message,
				                    	 	type: 	'success'
					                    });
					                    drugsBrandTable.draw();
					               }else{
					                    swal({
				                    		title: 	'Error!',
				                    	  	text: 	data.message,
				                    	 	type: 	'error'
					                    });
					               }
					            },
					            error :function( jqXhr ) {
					                swal(
				                      'Error!',
				                      'Something went wrong.',
				                      'error'
				                    );        
					            }
					        });
				    	});
				    },
				    allowOutsideClick: false
				});
	    	});
	    },
	    "order": [[1, "asc"]],
	});

	drugsDosageTable = $('#dosage-table').DataTable({
		processing: true,
	    serverSide: true,
	    "pagingType": "input",
	    ajax: {
	        url:'https://dentalclinicapp.com/clinic/settings/drug/get-dosage-data',
	        method: 'POST'
	    },
	    columns: [
	    	{data: 'DT_Row_Index', orderable: false, searchable: false,width:'10px', className : 'text-center'},
	    	{ data: 'name', name: 'name', orderable: true, searchable: true},
	    	{ data: 'action', name: 'action', orderable: false, searchable: false,width:'100px', class:'text-center'},
	    ],
	    fnDrawCallback: function ( oSettings ) {
	    	$('a#btn-dosage-delete').click(function(){
	    		var action = $(this).data('action');
				swal({
				    title: 'Are you sure?',
				    text: "You will not be able to recover this!",
				    type: 'warning',
				    showCancelButton: true,
				    confirmButtonColor: '#e663b8',
				    cancelButtonColor: '##ddd',
				    confirmButtonText: 'Yes, delete it!',
				    showLoaderOnConfirm: true,
				    preConfirm : function(){
				    	return new Promise(function(){
					        $.ajax({
					            type: "DELETE",
					            url: action,
					            dataType: 'json',
					            success: function(data) {
					                if(data.type == "success") {
					                    swal({
				                    		title: 	'Deleted!',
				                    	  	text: 	data.message,
				                    	 	type: 	'success'
					                    });
					                    drugsDosageTable.draw();
					               }
					            },
					            error :function( jqXhr ) {
					                swal(
				                      'Error!',
				                      'Something went wrong.',
				                      'error'
				                    );        
					            }
					        });
				    	});
				    },
				    allowOutsideClick: false
				});
	    	});
	    },
	    "order": [[1, "asc"]],
	});
});
</script>
  @endsection