<?php 
include('includes/connection.php');

if(isset($_GET['item_id']) && isset($_GET['issue_id'])){
    $item_id=$_GET['item_id'];
    $issue_id=$_GET['issue_id'];
    $query1='SELECT issued_qty FROM `material_issue_item` AS mii LEFT JOIN `material_issue` AS mi ON mii.material_issue_id=mi.material_issue_id where mi.material_issue_id ="'.$issue_id.'" AND mii.item="'.$item_id.'" ';
	$result1 = db_query($query1);
	if(mysqli_num_rows($result1) > 0){
		while($row1=mysqli_fetch_assoc($result1))
		{
            echo $row1['issued_qty'];
			
		}
	}
}
?>