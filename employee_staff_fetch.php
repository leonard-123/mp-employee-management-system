<?php

//staff_fetch.php

include('database_connection.php');

$query = '';

$output = array();

$query .= "
SELECT * FROM staff_details 
WHERE staff_type = 'staff' AND 
";

if(isset($_POST["search"]["value"]))
{
	$query .= '(user_email LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR staff_name LIKE "%'.$_POST["search"]["value"].'%" )';
	 
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY staff_id DESC ';
}

if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	$status = '';
	if($row["staff_status"] == 'Active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Inactive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['staff_id'];
	$sub_array[] = $row['staff_name'];
	$sub_array[] = $row['user_email'];
    $sub_array[] = '<button type="button" name="view" id="'.$row["staff_id"].'" class="btn btn-info btn-xs view">View</button>';
	$data[] = $sub_array;
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"    			=> 	$data
);
echo json_encode($output);

function get_total_all_records($connect)
{
	$statement = $connect->prepare("SELECT * FROM staff_details WHERE staff_type='staff'");
	$statement->execute();
	return $statement->rowCount();
}

?>