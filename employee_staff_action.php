<?php

//staff_action.php

include('database_connection.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO staff_details (staff_name, staff_badge_id, staff_department, staff_phoneno, user_email, staff_designation, user_password, staff_type, staff_status) 
		VALUES (:staff_name, :staff_badge_id, :staff_department, :staff_phoneno, :user_email, :staff_designation, :user_password, :staff_type, :staff_status)
		";	
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':staff_name'		=>	$_POST["staff_name"],
				':staff_badge_id'		=>	$_POST["staff_badge_id"],
				':staff_department'		=>	$_POST["staff_department"],
				':staff_phoneno'		=>	$_POST["staff_phoneno"],
				':user_email'		=>	$_POST["user_email"],
				':staff_designation'		=>	$_POST["staff_designation"],
				':user_password'	=>	password_hash($_POST["user_password"], PASSWORD_DEFAULT),
				':staff_type'		=>	'staff',
				':staff_status'		=>	'active'
				
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'New staff Added';
		}
	}

	if($_POST['btn_action'] == 'staff_details')
	{
		$query = "
		SELECT staff_status, staff_name, staff_badge_id, staff_department, staff_phoneno, user_email, staff_designation
		FROM  staff_details
		WHERE staff_id = '".$_POST["staff_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$output = '
		<div class="table-responsive">
			<table class="table table-boredered">
		';
		foreach($result as $row)
		{
			$status = '';
			if($row['staff_status'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Inactive</span>';
			}
			$output .= '
			<tr>
				<td>Status</td>
				<td>'.$row["staff_status"].'</td>
			</tr>
			<tr>
				<td>Name</td>
				<td>'.$row["staff_name"].'</td>
			</tr>
			<tr>
				<td>Badge ID</td>
				<td>'.$row["staff_badge_id"].'</td>
			</tr>
			<tr>
				<td>Department</td>
				<td>'.$row["staff_department"].'</td>
			</tr>
			<tr>
				<td>Phone no</td>
				<td>'.$row["staff_phoneno"].'</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>'.$row["user_email"].'</td>
			</tr>
			<tr>
				<td>Designation</td>
				<td>'.$row["staff_designation"].'</td>
			</tr>
			';
		}
		$output .= '
			</table>
		</div>
		';
		echo $output;
	}
}

?>