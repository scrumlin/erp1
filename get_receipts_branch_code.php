<?php 
include('includes/connection.php');


if(isset($_GET['branch_id'])){
    $branch_id=$_GET['branch_id'];
    $sql="select location_code from `payroll_locations` where location_id='$branch_id'";
    //echo "select location_code from `payroll_locations` where location_id='$branch_id'";
    $result = db_query($sql);
    while($row=mysqli_fetch_array($result))
    {
        $location_code=$row['location_code'];

        if (date('m') > 6) {
            $year = date('y')."-".(date('y') +1);
        }
        else {
            $year = (date('y')-1)."-".date('y');
        }

        $last_no=0;
        $serial_no=0; 
        $seql = "SELECT * FROM material_receipts";
        $fetch_data = db_query($seql); 
        if ($fetch_data ->num_rows > 0) 
        { 
            $fetch_maxn="SELECT MAX(receipts_id) AS serial_no FROM material_receipts";
            $results = db_query($fetch_maxn);
            while($row = $results->fetch_assoc())
            {	
                $last_no=$row['serial_no'];
                $serial_no=$last_no+1;
            }
        }   
        else
        {
            $serial_no=1;
        }
        $receipts_no="MI/".$location_code."/".$year."/".str_pad($serial_no,4,"0",STR_PAD_LEFT);
        echo $receipts_no;
    }
    
}
?>