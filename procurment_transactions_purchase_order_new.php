<?php
include('includes/connection.php');
session_start();
if(!isset($_SESSION['id']))
{
    header('location:index.php');
}
$page = "pt_purchase_order";
if($page=="pt_purchase_order"){
	$pt_purchase_order="active";
}
if(isset($_GET['id'])){
	$indent_id= $_GET['id'];
}
if(isset($_GET['po_id'])){
	$po_id= $_GET['po_id'];
}
if(isset($_POST['submit'])){
	if(isset($_GET['po_id'])){
		$order_no=$connect->real_escape_string($_POST['order_no']); 
		$vendorAC=$connect->real_escape_string($_POST['vendorAC']); 
		$po_unit=$connect->real_escape_string($_POST['po_unit']); 
		$tax_typ=$connect->real_escape_string($_POST['tax_typ']);

		$narration=$connect->real_escape_string($_POST['narration']);

		$po_dt=$connect->real_escape_string($_POST['po_dt']);
		$type_of_purchase=$connect->real_escape_string($_POST['type_of_purchase']); 
		$indent_status=$connect->real_escape_string($_POST['indent_status']); 
		$is_IGST=$connect->real_escape_string($_POST['is_IGST']); 
		$term_con=$connect->real_escape_string($_POST['term_con']); 
		$uid=$_SESSION['id'];
		$creation_date=date("Y-m-d");

		//insert results from the form input
		$query = "UPDATE `purchase_order` SET `indent_id`='$indent_id', `order_no`='$order_no', `order_dt`='$po_dt', `vendor`='$vendorAC', `type_of_purchase`='$type_of_purchase', `purchase_unit`='$po_unit', `indent_status`='$indent_status', `tax_type`='$tax_typ', `is_IGST`='$is_IGST', `narration`='$narration', `term_conditions`='$term_con' WHERE order_id='$po_id'"; 
		//echo $query;
		//die();
		$result = db_query($query);
		
		//$_POST['row_count']  Post no of rows in table 
		$cnt=$connect->real_escape_string($_POST['row_count']); 
		$cnt=$cnt-1;
		//echo $cnt;
		for($i=0;$i<=$cnt;$i++)
		{
			if($connect->real_escape_string($_POST['item'][$i]))
			{
				$branch=$connect->real_escape_string($_POST['branch'][$i]);
				$item=$connect->real_escape_string($_POST['item'][$i]);
				$rate=$connect->real_escape_string($_POST['rate'][$i]); 
				$poQty=$connect->real_escape_string($_POST['poQty'][$i]); 
				$discount=$connect->real_escape_string($_POST['discount'][$i]); 
				$gross=$connect->real_escape_string($_POST['gross'][$i]); 
				$taxableVal=$connect->real_escape_string($_POST['taxableVal'][$i]); 
				$sGST=$connect->real_escape_string($_POST['sGST'][$i]); 
				$cGST=$connect->real_escape_string($_POST['cGST'][$i]); 
				$iGST=$connect->real_escape_string($_POST['iGST'][$i]); 
				$taxAmt=$connect->real_escape_string($_POST['taxAmt'][$i]); 
				$deliveryDate=$connect->real_escape_string($_POST['deliveryDate'][$i]); 
				$indent_Qty=$connect->real_escape_string($_POST['indent_Qty'][$i]);
				$query = "UPDATE `purchase_order_item` SET `branch`='$branch', `item`='$item', `indent_id`='$indent_id', `gst`='$rate',`po_qty`='$poQty', `indent_qty`='$indent_Qty' ,`discount`='$discount',`gross`='$gross', `taxablevalue`='$taxableVal', `sgst`='$sGST', `cgst`='$cGST', `igst`='$iGST', `tax_amnt`='$taxAmt', `delivery_dt`='$deliveryDate' WHERE order_id='$po_id'";
				$result = db_query($query);
			}
			//echo $query;
		}
	}
	else{
		$order_no=$connect->real_escape_string($_POST['order_no']); 
		$vendorAC=$connect->real_escape_string($_POST['vendorAC']); 
		$po_unit=$connect->real_escape_string($_POST['po_unit']); 
		$tax_typ=$connect->real_escape_string($_POST['tax_typ']);

		$narration=$connect->real_escape_string($_POST['narration']);

		$po_dt=$connect->real_escape_string($_POST['po_dt']);
		$type_of_purchase=$connect->real_escape_string($_POST['type_of_purchase']); 
		$indent_status=$connect->real_escape_string($_POST['indent_status']); 
		$is_IGST=$connect->real_escape_string($_POST['is_IGST']); 
		$term_con=$connect->real_escape_string($_POST['term_con']); 
		$uid=$_SESSION['id'];
		$creation_date=date("Y-m-d");

		//insert results from the form input
		$query = "INSERT INTO `purchase_order` (`indent_id`, `order_no`, `order_dt`, `vendor`, `type_of_purchase`, `purchase_unit`, `indent_status`, `tax_type`, `is_IGST`, `narration`, `term_conditions`, `created_by`, `created_dt`) 
		VALUES('$indent_id','$order_no','$po_dt','$vendorAC','$type_of_purchase','$po_unit','$indent_status','$tax_typ','$is_IGST','$narration','$term_con','$uid','$creation_date')";
		//echo $query;
		//die();
		$result = db_query($query);


		$sql="SELECT order_id  FROM purchase_order ORDER BY order_id   DESC LIMIT 1 ";
		$result = db_query($sql);
		while($row=mysqli_fetch_array($result))
		{
			$last_order_id =$row['order_id'];
		}
		//echo $last_order_id;
		//$_POST['row_count']  Post no of rows in table 
		$cnt=$connect->real_escape_string($_POST['row_count']); 
		$cnt=$cnt-1;
		//echo $cnt;
		for($i=0;$i<=$cnt;$i++)
		{
			if($connect->real_escape_string($_POST['item'][$i]))
			{
				$branch=$connect->real_escape_string($_POST['branch'][$i]);
				$item=$connect->real_escape_string($_POST['item'][$i]);
				$rate=$connect->real_escape_string($_POST['rate'][$i]); 
				$poQty=$connect->real_escape_string($_POST['poQty'][$i]); 
				$discount=$connect->real_escape_string($_POST['discount'][$i]); 
				$gross=$connect->real_escape_string($_POST['gross'][$i]); 
				$taxableVal=$connect->real_escape_string($_POST['taxableVal'][$i]); 
				$sGST=$connect->real_escape_string($_POST['sGST'][$i]); 
				$cGST=$connect->real_escape_string($_POST['cGST'][$i]); 
				$iGST=$connect->real_escape_string($_POST['iGST'][$i]); 
				$taxAmt=$connect->real_escape_string($_POST['taxAmt'][$i]); 
				$deliveryDate=$connect->real_escape_string($_POST['deliveryDate'][$i]); 
				$indent_Qty=$connect->real_escape_string($_POST['indent_Qty'][$i]);
				$query = "INSERT INTO `purchase_order_item` (`order_id`, `branch`, `item`, `indent_id`, `gst`,`po_qty`, `indent_qty`, `discount`,`gross`, `taxablevalue`, `sgst`, `cgst`, `igst`, `tax_amnt`, `delivery_dt`) 
												VALUES ('$last_order_id','$branch','$item','$indent_id','$rate','$poQty','$indent_Qty', '$discount','$gross','$taxableVal','$sGST','$cGST','$iGST','$taxAmt','$deliveryDate')";
				$result = db_query($query);
			}
			//echo $query;
		}
	}
	header("location:procurment_transactions_purchase_order.php");
}

//Get get current financial year
if (date('m') > 6) {
    $year = date('y')."-".(date('y') +1);
}
else {
    $year = (date('y')-1)."-".date('y');
}

//last serial_no 
$last_no=0;
$serial_no=0; 
$seql = "SELECT * FROM purchase_order";
$fetch_data = db_query($seql); 
if ($fetch_data ->num_rows > 0) 
{ 
	$fetch_maxn="SELECT MAX(order_id) AS serial_no FROM purchase_order";
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

//get requisition_no
$order_no="PO/".$year."/".str_pad($serial_no,4,"0",STR_PAD_LEFT);
//echo $Material_Request_No;
?>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Maxim ERP</title>	
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
        <?php include('includes/css.php');?>
		<script>
			function display_PO_no(val){
				var xmlhttp;
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function()
                {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    {
                        //alert(xmlhttp.responseText);
                        document.getElementById('order_no').value=xmlhttp.responseText;
                    }
                }
                //alert("get_branch_code.php?branch_id="+val);
                xmlhttp.open("GET","get_po_no.php?unit_id="+val,true);
                xmlhttp.send();
			}
			function display_igst(val){
				var rows = document.getElementById('purchaseOrdrTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (num = 0; num < rows.length; num++) {
                    rows[num].onclick = function() {
                        //alert(this.rowIndex - 1);
                        var row_num=this.rowIndex - 1;
						if(val=="Y"){
							document.getElementById('iGST' + row_num + '').readOnly = true;
						}
						else if(val=="N"){
							document.getElementById('iGST' + row_num + '').readOnly = false;
						}
					}
				}
				
			}
			function show_gst_value(val){
				var rows = document.getElementById('purchaseOrdrTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (num = 0; num < rows.length; num++) {
                    rows[num].onclick = function() {
                        //alert(this.rowIndex - 1);
                        var row_num=this.rowIndex - 1;
						var rate=document.getElementById('rate' + row_num + '').value;
						var gst_value= rate*(val/100);
						var gst_value= gst_value/2;
						document.getElementById('sGST' + row_num + '').value=gst_value;
						document.getElementById('cGST' + row_num + '').value=gst_value;
					}
				}
			}
			function show_gross(){
				var rows = document.getElementById('purchaseOrdrTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (num = 0; num < rows.length; num++) {
                    rows[num].onclick = function() {
                        //alert(this.rowIndex - 1);
                        var row_num=this.rowIndex - 1;
						var tax_typ=document.getElementById('tax_typ').value;
						var rate=document.getElementById('rate' + row_num + '').value;
						var poQty=document.getElementById('poQty' + row_num + '').value;
						var discount=document.getElementById('discount' + row_num + '').value;
						var gst=document.getElementById('gST' + row_num + '').value;
						var gros=(poQty*rate)-discount;
						//alert(gros);
						var taxablevalue= gros*(gst/100);
						//alert(taxablevalue);
						if(tax_typ=="E"){
							var taxAmt= gros+taxablevalue;
						}
						else if(tax_typ=="I"){
							var taxAmt= gros-taxablevalue;
						}
						document.getElementById('gross' + row_num + '').value=gros;
						document.getElementById('taxableVal' + row_num + '').value=taxablevalue;
						document.getElementById('taxAmt' + row_num + '').value=taxAmt;
					}
				}
			}
		</script>
    </head>

    <body>	
		<!-- Main Wrapper -->
        <div class="main-wrapper">		
			<!-- Header -->
            <?php include('includes/top_header.php');?>
			<!-- /Header -->			
			<!-- Sidebar -->
            <?php include('includes/sidebar.php');?>
			<!-- /Sidebar -->
		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content container-fluid">
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-7 col-auto">
							<h3 class="page-title">New Purchase Order</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="#">Procurement</a></li>
								<li class="breadcrumb-item"><a href="#">Transactions</a></li>
								<li class="breadcrumb-item active"><a href="procurment_transactions_purchase_order.php">Purchase Order</a></li>
							</ul>
						</div>
						<div class="col-sm-5 col">
						
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<?php 
				if(isset($_GET['po_id'])){
					$retrive_query="SELECT * FROM `purchase_order` where order_id ='$po_id'";
					$retrive_result=db_query($retrive_query);
					$retrive_row=mysqli_fetch_assoc($retrive_result);
				}
				?>
				<!--Inner Page Wrapper-->
				<div class="container-fluid pl-0 pr-0 mt-0 mb-2">
					<form method="POST" action="procurment_transactions_purchase_order_new.php?id=<?php echo $indent_id;?><?php if(isset($_GET['po_id'])){ echo "&po_id=".$po_id; }?> ">
						<div class="accordion mb-1" id="purchaseOrder">
							<div class="card">
							<div class="card-header" id="headingOne">
								<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#purchase_order" aria-expanded="true" aria-controls="purchase_order">
									<i class="fa fa-minus-circle fa-1x float-right"></i>
								</button>
								</h2>
							</div>
						
							<div id="purchase_order" class="collapse show" aria-labelledby="headingOne" data-parent="#purchaseOrder">
								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-4 col-form-label">PO No</label>
												<div class="col-md-8">
													<?php 
													if(isset($_GET['po_id'])){
														$query="SELECT order_no from purchase_order WHERE indent_id='$indent_id'";
														$query_result = db_query($query);
														while($row=mysqli_fetch_assoc($query_result))
														{
														?>
															<input type="text" readonly id="order_no" name="order_no" value="<?php echo $row['order_no'];?>"  class="form-control" placeholder="" />
														<?php
														}
													}
													else{
													?>
														<input type="text" readonly id="order_no" name="order_no" value="<?php echo $order_no;?>"  class="form-control" placeholder="" />
													<?php
													}	
													?>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">VendorAC</label>
												<div class="col-md-8">
													<select name="vendorAC" class="form-control">
														<option Selcted >Please Select VendorAC</option>
														<?php
														/*$check="select location_id ,location_name from `payroll_locations`";
														$result = db_query($check);
														while($pdb=mysqli_fetch_assoc($result))
														{
														?>
															<option value="<?php echo $pdb['location_id'];?>"><?php echo $pdb['location_name'];?></option>
														<?php
														}*/
														?>
														<option value="1" <?php if(isset($_GET['po_id'])){ if($retrive_row['vendor']==1){ echo "selected"; } } ?>>Admin</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Purchase Unit</label>
												<div class="col-md-8">
													<select name="po_unit" class="form-control" onchange="display_PO_no(this.value)">
														<option Selcted >Please Select Purchase Unit</option>
														<?php
														$check="select id ,name from `unit_master`";
														$result = db_query($check);
														while($pdb=mysqli_fetch_assoc($result))
														{
														?>
															<option value="<?php echo $pdb['id'];?>" <?php if(isset($_GET['po_id'])){ if($retrive_row['purchase_unit']== $pdb['id']){ echo "selected"; } } ?>><?php echo $pdb['name'];?></option>
														<?php
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Tax Type</label>
												<div class="col-md-8">
													<select class="form-control" id="tax_typ" name="tax_typ">
														<option Selcted >Please Select Tax Type</option>
														<option value="E" <?php if(isset($_GET['po_id'])){ if($retrive_row['tax_type']=="E"){ echo "selected"; } } ?>>Exclusive </option>
														<option value="I" <?php if(isset($_GET['po_id'])){ if($retrive_row['tax_type']=="I"){ echo "selected"; } } ?>>Inclusive</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Narration</label>
												<div class="col-md-8">
													<textarea class="form-control" placeholder=""  name="narration" rows="1"><?php if(isset($_GET['po_id'])){ echo $retrive_row['narration']; } ?></textarea>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-4 col-form-label custom-text-14">PO Date</label>
												<div class="col-md-8">
													<input type="date" name="po_dt" value="<?php if(isset($_GET['po_id'])){ echo date("Y-m-d", strtotime($retrive_row['order_dt'])); } else{ echo date('Y-m-d');} ?>" readonly class="form-control" placeholder="">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Type of Purchase</label>
												<div class="col-md-8">
													<select class="form-control" name="type_of_purchase">
														<option Selcted >Please Select Type of Purchase</option>
														<option value="H" <?php if(isset($_GET['po_id'])){ if($retrive_row['type_of_purchase']=="H"){ echo "selected"; } } ?>>HO Purchase</option>
														<option value="L" <?php if(isset($_GET['po_id'])){ if($retrive_row['type_of_purchase']=="L"){ echo "selected"; } } ?>>Local Purchase</option>
													</select>
												</div>
											</div>	
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Indent Status</label>
												<div class="col-md-8">
													<select class="form-control" name="indent_status">
														<option Selcted >Please Select Indent Status</option>
														<option value="W" <?php if(isset($_GET['po_id'])){ if($retrive_row['indent_status']=="W"){ echo "selected"; } } ?>>Waiting</option>
														<option value="A" <?php if(isset($_GET['po_id'])){ if($retrive_row['indent_status']=="A"){ echo "selected"; } } ?>>Approved </option>
														<option value="N" <?php if(isset($_GET['po_id'])){ if($retrive_row['indent_status']=="N"){ echo "selected"; } } ?>>Not Approved</option>
													</select>
												</div>
											</div>	
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Is IGST</label>
												<div class="col-md-8">
													<select class="form-control" name="is_IGST" onchange="display_igst(this.value)">
														<option Selcted >Please Select Is IGST</option>
														<option value="Y" <?php if(isset($_GET['po_id'])){ if($retrive_row['is_IGST']=="Y"){ echo "selected"; } } ?>>Yes</option>
														<option value="N" <?php if(isset($_GET['po_id'])){ if($retrive_row['is_IGST']=="N"){ echo "selected"; } } ?>>No</option>
													</select>
												</div>
											</div>	
											<div class="form-group row">
												<label class="col-md-4 col-form-label custom-text-14">Term & Conditions</label>
												<div class="col-md-8">
													<input type="text" name="term_con" class="form-control" placeholder="" value="<?php if(isset($_GET['po_id'])){ echo $retrive_row['term_conditions']; } ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>

						<div class="accordion mb-3" id="purchaseOrderTable">
							<div class="card">
							<div class="card-header" id="headingTwo">
								<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#purchaseOrder_table" aria-expanded="true" aria-controls="purchaseOrder_table">
									
									<i class="fa fa-minus-circle fa-1x float-right"></i>
								</button>
								</h2>
							</div>				  
							<div id="purchaseOrder_table" class="collapse show" aria-labelledby="headingTwo" data-parent="#purchaseOrderTable">
								<div class="card-body horizontal-scroll" style="overflow-y: auto;">
									<table class="table table-bordered table-sm" id="purchaseOrdrTable">
										<thead class="custom-thead">
											<tr>
												<th scope="col" width="1%">SL. NO.</th>
												<th scope="col">Branch</th>
												<th scope="col">Item Name</th>
												<th scope="col">Item Specification</th>
												<th scope="col">Unit</th>
												<th scope="col">Purchase Indent No.</th>
												<th scope="col">Indent Date</th>
												<th scope="col">Rate</th>
												<th scope="col">GST%</th>
												<th scope="col">PO Quantity</th>
												<th scope="col">Discount</th>
												<th scope="col">Gross</th>
												<th scope="col">Taxablevalue</th>
												<th scope="col">SGST</th>
												<th scope="col">CGST</th>
												<th scope="col">IGST</th>
												<th scope="col">Tax Amt</th>
												<th scope="col">Delivery Date</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if(isset($_GET['po_id'])){
												$query="SELECT poi.order_item_id, pl.location_name, im.item_name, im.description, im.purchase_unit, pi.indent_no, pi.indent_dt, im.gst_rate, poi.* from purchase_order_item AS poi LEFT JOIN payroll_locations AS pl ON pl.location_id=poi.branch LEFT JOIN item_master AS im ON im.id=poi.item LEFT JOIN purchase_indent AS pi ON pi.indent_id=poi.indent_id WHERE poi.order_id='$po_id'";
											}
											else{
												$query="SELECT pl.location_id , pl.location_name, im.id, im.gst_rate, im.item_name, im.description, im.purchase_unit, pi.indent_no, pi.indent_dt, pii.indent_qty FROM purchase_indent AS pi LEFT JOIN payroll_locations AS pl ON pl.location_id=pi.branch LEFT JOIN purchase_indent_item AS pii ON pii.indent_id=pi.indent_id LEFT JOIN item_master AS im ON im.id=pii.item WHERE pi.indent_id='$indent_id' ";
											}
											//echo $query;
											$result=db_query($query);
											$sl=1;
											$n=0;
											while($pdb=mysqli_fetch_assoc($result))
											{
											?>
												<tr>
													<td class="text-center" id="slNo"><?php echo $sl;?></td>
													<td>
														<input type="text" style="width: 120px;" readonly value="<?php echo $pdb['location_name'];?>" class="form-control form-control-sm" id="branch" name="branch_name[]" />
														<input type="text" hidden style="width: 120px;" readonly value="<?php echo $pdb['location_id'];?>" class="form-control form-control-sm" id="branch" name="branch[]" />
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly value="<?php echo $pdb['item_name'];?>" class="form-control form-control-sm" id="item" name="item_name[]" />
														<input type="text"  hidden class="form-control form-control-sm" value="<?php echo $pdb['id'];?>" id="item<?php echo $sl;?>" name="item[]" />
														<input type="text" hidden  class="form-control form-control-sm" value="<?php echo $pdb['order_item_id'];?>" name="order_item_id[]" />
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly value="<?php echo $pdb['description'];?>" class="form-control form-control-sm" id="itemSpecification0" name="itemSpecification[]" />
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly value="<?php echo $pdb['purchase_unit'];?>" class="form-control form-control-sm" id="unit" name="unit[]" style="width: 80px;"/>
													</td>
													<td>
														<input type="text" style="width: 140px;" readonly value="<?php echo $pdb['indent_no'];?>" class="form-control form-control-sm" id="purchaseIndNo" name="purchaseIndNo[]" style="width: 80px;"/>
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly value="<?php echo date("d/m/Y", strtotime($pdb['indent_dt']));?>" class="form-control form-control" id="indentDate" name="indentDate[]">
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly class="form-control form-control" id="rate<?php echo $n;?>" name="rate[]" value="<?php echo $pdb['gst_rate']; ?>">
													</td>
													<td>
														<input type="text" style="width: 120px;" class="form-control form-control" id="gST<?php echo $n;?>" name="gST[]" value="<?php if(isset($_GET['po_id'])){ echo $pdb['gst_rate']; } else{ echo "0"; }?>" onkeyup="show_gst_value(this.value)">
													</td>
													<td>
														<input type="text" hidden style="width: 120px;" class="form-control form-control" id="indent_Qty<?php echo $n;?>" name="indent_Qty[]" value="<?php echo $pdb['indent_qty'];?>">
														<input type="text" style="width: 120px;" class="form-control form-control" id="poQty<?php echo $n;?>" name="poQty[]" value="<?php if(isset($_GET['po_id'])){ echo $pdb['po_qty']; } else{ echo "0"; }?>" onkeyup="show_gross()">
													</td>
													<td>
														<input type="text" style="width: 120px;" class="form-control form-control" id="discount<?php echo $n;?>" name="discount[]" value="<?php if(isset($_GET['po_id'])){ echo $pdb['discount']; } else{ echo "0"; }?>" onkeyup="show_gross()">
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly class="form-control form-control" id="gross<?php echo $n;?>" name="gross[]" value="<?php if(isset($_GET['po_id'])){ echo $pdb['gross']; } else{ echo "0"; }?>">
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly class="form-control form-control" id="taxableVal<?php echo $n;?>" name="taxableVal[]" value="<?php if(isset($_GET['po_id'])){ echo $pdb['taxablevalue']; } else{ echo "0.00"; }?>">
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly class="form-control form-control" id="sGST<?php echo $n;?>" name="sGST[]" value="<?php if(isset($_GET['po_id'])){ echo $pdb['sgst']; } else{ echo "0.00"; }?>">
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly class="form-control form-control" id="cGST<?php echo $n;?>" name="cGST[]" value="<?php if(isset($_GET['po_id'])){ echo $pdb['cgst']; } else{ echo "0.00"; }?>">
													</td>
													<td>
														<input type="text" style="width: 120px;" class="form-control form-control" id="iGST<?php echo $n;?>" name="iGST[]" value="<?php if(isset($_GET['po_id'])){ echo $pdb['igst']; } else{ echo "0.00"; }?>">
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly class="form-control form-control" id="taxAmt<?php echo $n;?>" name="taxAmt[]" value="<?php if(isset($_GET['po_id'])){ echo $pdb['tax_amnt']; } else{ echo "0.00"; }?>">
													</td>
													<td>
														<input type="date" style="width: 160px;" class="form-control form-control" id="deliveryDate" name="deliveryDate[]" value="<?php if(isset($_GET['po_id'])){ echo date("Y-m-d", strtotime($pdb['delivery_dt'])); } ?>">
													</td>
												</tr>
											<?php
											$sl++;
											$n++;
											}
											?>
										</tbody>
									</table>	
								</div>
							</div>
							</div>
						</div>
						<div class="form-group pull-right">
							<button type="reset" class="btn btn-secondary mr-2 mb-5">Cancel</button>
							<input type="hidden" id="row_count" name="row_count" value="<?php echo $sl;?>">
							<button type="submit" name="submit" class="btn custom-blue-btn mb-5">Submit</button>
						</div> 
					</form>
				</div>
			</div>
		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->

	<?php include("js.php"); ?>
	<script>
		$(document).ready(function () {
			// Add minus icon for collapse element which is open by default
			$(".collapse.show").each(function () {
				$(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
			});

			// Toggle plus minus icon on show hide of collapse element
			$(".collapse").on('show.bs.collapse', function () {
				$(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
			}).on('hide.bs.collapse', function () {
				$(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
			});
			$(".collapse.show").each(function () {
				$(this).prev(".card-header").addClass("bb").removeClass("no_bb");
			});

			// Toggle plus minus icon on show hide of collapse element
			$(".collapse").on('show.bs.collapse', function () {
				$(this).prev(".card-header").removeClass("no_bb").addClass("bb");
			}).on('hide.bs.collapse', function () {
				$(this).prev(".card-header").removeClass("bb").addClass("no_bb");
			});
		});

		var input = document.querySelector('input[type=file]'); // see Example 4
		input.onchange = function () {
			var file = input.files[0];
			drawOnCanvas(file);   // see Example 6
			displayAsImage(file); // see Example 7
		};
		function drawOnCanvas(file) {
			var reader = new FileReader();

			reader.onload = function (e) {
				var dataURL = e.target.result,
					c = document.querySelector('canvas'), // see Example 4
					ctx = c.getContext('2d'),
					img = new Image();

				img.onload = function () {
					c.width = img.width;
					c.height = img.height;
					ctx.drawImage(img, 0, 0);
				};

				img.src = dataURL;
			};

			reader.readAsDataURL(file);
		}

		function displayAsImage(file) {
			var imgURL = URL.createObjectURL(file),
				img = document.createElement('img');

			img.onload = function () {
				URL.revokeObjectURL(imgURL);
			};

			img.src = imgURL;
			document.body.appendChild(img);
		}

		$("#upfile1").click(function () {
			$("#file1").trigger('click');
		});
		$("#upfile2").click(function () {
			$("#file2").trigger('click');
		});
		$("#upfile3").click(function () {
			$("#file3").trigger('click');
		});
	</script>

	<script>
		var i=$('table tr').length;
		var j= 1;
		$(".add").on('click',function(){
			html = '<tr>'; 
			html += '<td class="text-center" id="slNo">'+i+'</td>';
			html += '<td><select class="select w-100" id="branch" name="branch[]"><option>...</option><option>Dairy</option></select></td>';
			html += '<td><select class="select w-100" id="item" name="item[]"><option>...</option><option>...</option></select></td>';
			html += '<td><select class="select w-100" id="itemSpecification" name="itemSpecification[]"><option>...</option><option>ABT-5(New)</option></select></td>';
			html += '<td><select class="select w-100" id="unit" name="unit[]"><option>...</option><option>Dairy</option></select></td>';
			html += '<td><select class="select w-100" id="purchaseIndNo" name="purchaseIndNo[]"><option>...</option><option>Dairy</option></select></td>';
			html += '<td><input type="date" class="form-control form-control" id="indentDate" name="indentDate[]"></td>';
			html += '<td><input type="text" class="form-control form-control" id="rate' + j + '" name="rate[]"></td>';
			html += '<td><input type="text" class="form-control form-control" id="gST" name="gST[]"></td>';
			html += '<td><input type="text" class="form-control form-control" id="poQty' + j + '" name="poQty[]"></td>';
			html += '<td><input type="text" class="form-control form-control" id="discount' + j + '" name="discount[]"></td>';
			html += '<td><input type="text" class="form-control form-control" id="gross" name="gross[]"></td>';
			html += '<td><input type="text" class="form-control form-control-sm" id="taxableVal" name="taxableVal[]"></td>';
			html += '<td><input type="text" class="form-control form-control-sm" id="sGST" name="sGST[]"></td>';
			html += '<td><input type="text" class="form-control form-control-sm" id="cGST" name="cGST[]"></td>';
			html += '<td><input type="text" class="form-control form-control-sm" id="iGST" name="iGST[]"></td>';
			html += '<td><input type="text" class="form-control form-control-sm" id="taxAmt" name="taxAmt[]"></td>';
			html += '<td><input type="date" class="form-control form-control-sm" id="deliveryDate" name="deliveryDate[]"></td>';
			html += '<td class="text-center"><a href="javascript:void(0);" class="remove"><i class="fa fa-trash fa-1x"></i></a></td>';	 
			html += '</tr>';
			$('table').append(html);
			i++;
			j++;
			$(".remove").on('click', function () {
					$(this).closest('tr').remove();
			});
		});
	</script>

</body>

</html>
