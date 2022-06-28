<?php
//staff.php

include('database_connection.php');

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

include('header.php');


?>
		<span id="alert_action"></span>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">Staff List</h3>
                            </div>
                        </div>
                       
                        <div class="clear:both"></div>
                   	</div>
                   	<div class="panel-body">
                   		<div class="row"><div class="col-sm-12 table-responsive">
                   			<table id="staff_data" class="table table-bordered table-striped">
                   				<thead>
									<tr>
										<th>No.</th>
										<th>Name</th>
										<th>Email</th>
										<th>View</th>
									</tr>
								</thead>
                   			</table>
                   		</div>
                   	</div>
               	</div>
           	</div>
        </div>

        <div id="staffdetailsModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="staff_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Staff Details</h4>
                        </div>
                        <div class="modal-body">
                            <Div id="staff_details"></Div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

<script>
$(document).ready(function(){

	var staffdataTable = $('#staff_data').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax":{
			url:"employee_staff_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"target":[4,5,6],
				"orderable":false
			}
		],
		"pageLength": 25
	});

	$(document).on('submit', '#staff_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"employee_staff_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#staff_form')[0].reset();
				$('#staffModal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#action').attr('disabled', false);
				staffdataTable.ajax.reload();
			}
		})
	});

    $(document).on('click', '.view', function(){
        var staff_id = $(this).attr("id");
        var btn_action = 'staff_details';
        $.ajax({
            url:"employee_staff_action.php",
            method:"POST",
            data:{staff_id:staff_id, btn_action:btn_action},
            success:function(data){
                $('#staffdetailsModal').modal('show');
                $('#staff_details').html(data);
            }
        })
    });

});
</script>


