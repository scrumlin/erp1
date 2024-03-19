<?php 
include('includes/connection.php');


if(isset($_GET['item_id'])){
    $item_id=$_GET['item_id'];
    $sql="select description, purchase_unit from `item_master` where id='$item_id'";
    $result = db_query($sql);
    while($row=mysqli_fetch_array($result))
    {
        $itemSpecification=$row['description'];
        $unit=$row['purchase_unit'];
        echo $itemSpecification."/".$unit;
    }
    
}
?>