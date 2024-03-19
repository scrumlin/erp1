<?php 
include('includes/connection.php');


if(isset($_GET['item_id']) && isset($_GET['request_no'])){
    $item_id=$_GET['item_id'];
    $request_no=$_GET['request_no'];
    $sql="select description, purchase_unit from `item_master` where id='$item_id'";
    $result = db_query($sql);
    while($row=mysqli_fetch_array($result))
    {
        $itemSpecification=$row['description'];
        $unit=$row['purchase_unit'];
        
    }
    $sql="select quantity from `material_request_item` where item='$item_id' and material_request_id='$request_no'";
    $result = db_query($sql);
    while($row=mysqli_fetch_array($result))
    {
        $quantity=$row['quantity'];
    }
    echo $itemSpecification."/".$unit."/".$quantity;
}
?>