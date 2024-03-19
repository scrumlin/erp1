<?php
	include('includes/connection.php');
	$id=$connect->real_escape_string($_GET["id"]);
    $id1=$connect->real_escape_string($_GET["id1"]);
	$sql="DELETE FROM `material_consumption_item` WHERE consumption_id='$id'  and consumption_item_id ='$id1'";
	$result = db_query($sql);
	if ($result === true)
	{
		header("location:procurment_transactions_material_consumption.php");
	}
	else
	{
		echo "<script type='text/javascript'> alert('Error adding user in database')</script>";

	}
?>