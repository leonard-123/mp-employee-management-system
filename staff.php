<?php
//staff.php

include('database_connection.php');

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

if($_SESSION["type"] != 'admin')
{
	header("location:index.php");
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
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                            	<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#staffModal" class="btn btn-success btn-xs">Add Staff</button>
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
										<th>Edit</th>
										<th>Delete</th>
									</tr>
								</thead>
                   			</table>
                   		</div>
                   	</div>
               	</div>
           	</div>
        </div>
        <div id="staffModal" class="modal fade">
        	<div class="modal-dialog">
        		<form method="post" id="staff_form">
        			<div class="modal-content">
        			<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add staff</h4>
        			</div>
        			<div class="modal-body">
        				<div class="form-group">
							<label>Enter Fullname</label>
							<input type="text" name="staff_name" id="staff_name" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Enter Badgeid</label>
							<input type="text" name="staff_badge_id" id="staff_badge_id" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Enter Department</label>
							<input type="text" name="staff_department" id="staff_department" class="form-control" required />
						</div>
                        <div class="form-group">
							<label>Enter Phone No</label>
							<input type="tel" name="staff_phoneno" id="staff_phoneno" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Enter Email</label>
							<input type="email" name="user_email" id="user_email" class="form-control" required />
						</div>
                        <div class="form-group">
							<label>Enter Designation</label>
							<input type="text" name="staff_designation" id="staff_designation" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Enter Staff Password</label>
							<input type="password" name="user_password" id="user_password" class="form-control" required />
						</div>
        			</div>
        			<div class="modal-footer">
        				<input type="hidden" name="staff_id" id="staff_id" />
        				<input type="hidden" name="btn_action" id="btn_action" />
        				<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
        				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        			</div>
        		</div>
        		</form>

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

	$('#add_button').click(function(){
        $('#staffModal').modal('show');
		$('#staff_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Staff");
		$('#action').val("Add");
		$('#btn_action').val("Add");
		setTimeout(function(){
            $('#alert_action').html('');
        }, 5000);
	});

	var staffdataTable = $('#staff_data').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax":{
			url:"staff_fetch.php",
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
			url:"staff_action.php",
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
            url:"staff_action.php",
            method:"POST",
            data:{staff_id:staff_id, btn_action:btn_action},
            success:function(data){
                $('#staffdetailsModal').modal('show');
                $('#staff_details').html(data);
            }
        })
    });


	$(document).on('click', '.update', function(){
		var staff_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:"staff_action.php",
			method:"POST",
			data:{staff_id:staff_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#staffModal').modal('show');
				$('#staff_name').val(data.staff_name);
                $('#staff_badge_id').val(data.staff_badge_id);
                $('#staff_department').val(data.staff_department);
                $('#staff_phoneno').val(data.staff_phoneno);
				$('#user_email').val(data.user_email);   
                $('#staff_designation').val(data.staff_designation);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Staff");
				$('#staff_id').val(staff_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
				$('#user_password').attr('required', false);
			}
		})
					setTimeout(function(){
                        $('#alert_action').html('');
                    }, 5000);
	});

	$(document).on('click', '.delete', function(){
		var staff_id = $(this).attr("id");
		var btn_action = "delete";
		if(confirm("Are you sure you want to delete this staff?"))
		{
			$.ajax({
				url:"staff_action.php",
				method:"POST",
				data:{staff_id:staff_id, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').html('<div class="alert alert-info">'+data+'</div>');
                    staffdataTable.ajax.reload();
                    $('#staff_data').DataTable().destroy();
                }
            });    
                    setTimeout(function(){
                        $('#alert_action').html('');
                    }, 5000);
		}

	});

});
</script>


