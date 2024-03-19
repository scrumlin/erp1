<?php
	include('includes/connection.php');
	$id=$connect->real_escape_string($_GET["id"]);
	$sql="DELETE FROM `unit_master` WHERE id='$id' ";
	$result = db_query($sql);
	if ($result === true)
	{
		header("location:procurment_master_unit_master.php");
	}
	else
	{
		echo "<script type='text/javascript'> alert('Error adding user in database')</script>";

	}
?>