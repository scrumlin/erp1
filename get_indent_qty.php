<?php 
include('includes/connection.php');

if(isset($_GET['item_id']) && isset($_GET['requisition_id'])){
    $item_id=$_GET['item_id'];
    $requisition_id=$_GET['requisition_id'];
    //$query1="SELECT sum(pri.quantity) as qty from purchase_requisition_item AS pri LEFT JOIN purchase_requisition AS pr ON pr.requisition_id=pri.requisition_id WHERE pri.item='$item_id' AND pri.requisition_id='$requisition_id'";
	$query1="SELECT sum(pii.indent_qty) as qty from purchase_indent_item AS pii LEFT JOIN purchase_indent AS pi ON pi.indent_id =pii.indent_id WHERE pii.item='$item_id' AND pi.requisition_id='$requisition_id' ";
    //echo $query1;
    $result1 = db_query($query1);
	if(mysqli_num_rows($result1) > 0){
		while($row1=mysqli_fetch_assoc($result1))
		{
            echo $row1['qty'];
			
		}
	}
}
?>