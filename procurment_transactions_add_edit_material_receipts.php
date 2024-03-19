<?php 
session_start();
if(!isset($_SESSION['id']))
{
    header('location:index.php');
}
$page = "pt_material_receipts";
if($page=="pt_material_receipts"){
	$pt_material_receipts="active";
}
include('includes/connection.php');
if(isset($_GET['id'])){
	$issue_id=$_GET['id'];
}
if(isset($_GET['recp_id'])){
	$recp_id=$_GET['recp_id'];
}
//echo $issue_id.",".$recp_id;
if(isset($_POST['submit']))
{
	if(isset($_GET['recp_id'])){
		$receipts_no=$connect->real_escape_string($_POST['receipts_no']); 
		$branch=$connect->real_escape_string($_POST['branch']); 
		$request_by=$connect->real_escape_string($_POST['request_by']); 
		$issue_dt=$connect->real_escape_string($_POST['issue_dt']);
		$receipt_dt=$connect->real_escape_string($_POST['receipt_dt']);
		$department=$connect->real_escape_string($_POST['department']);
		$issue_no=$connect->real_escape_string($_POST['issue_no']); 
		$narration=$connect->real_escape_string($_POST['narration']); 
		//insert results from the form input
		$query = "UPDATE `material_receipts` SET `receipts_no`='$receipts_no', `receipts_dt`='$receipt_dt', `branch`='$branch', `department`='$department', `request_by`='$request_by', `material_issue_no`='$issue_no', `material_issue_dt`='$issue_dt', `narration`='$narration' WHERE receipts_id='$recp_id' "; 
		//echo $query;
		$result = db_query($query);

		//$_POST['row_count']  Post no of rows in table 
		$cnt=$connect->real_escape_string($_POST['row_count']); 
		//echo $cnt;
		for($i=0;$i<=$cnt;$i++)
		{
			if($connect->real_escape_string($_POST['wareHouse'][$i]))
			{
				$wareHouse=$connect->real_escape_string($_POST['wareHouse'][$i]);
				$item=$connect->real_escape_string($_POST['item'][$i]);
				$receivedQty=$connect->real_escape_string($_POST['receivedQty'][$i]); 
				$remarks=$connect->real_escape_string($_POST['remarks'][$i]);
				$receipts_items_id=$connect->real_escape_string($_POST['receipts_items_id'][$i]); 
				$query = "UPDATE `material_receipts_items` set `warehouse` ='$wareHouse', `item`='$item',`received_qty`= '$receivedQty', `remarks`='$remarks'  where `receipts_items_id`='$receipts_items_id'";
				$result = db_query($query);
				//echo $query;
			}
		}
	}
	else{
		$receipts_no=$connect->real_escape_string($_POST['receipts_no']); 
		$branch=$connect->real_escape_string($_POST['branch']); 
		$request_by=$connect->real_escape_string($_POST['request_by']); 
		$issue_dt=$connect->real_escape_string($_POST['issue_dt']);
		$receipt_dt=$connect->real_escape_string($_POST['receipt_dt']);
		$department=$connect->real_escape_string($_POST['department']);
		$issue_no=$connect->real_escape_string($_POST['issue_no']); 
		$narration=$connect->real_escape_string($_POST['narration']); 
		$uid=$_SESSION['id'];
		$creation_date=date("Y-m-d");
		//insert results from the form input
		$query = "INSERT INTO `material_receipts` (`receipts_no`, `receipts_dt`, `branch`, `department`, `request_by`, `material_issue_no`, `material_issue_dt`, `narration`, `created_by`, `created_dt`) VALUES('$receipts_no','$receipt_dt','$branch','$department','$request_by','$issue_no','$issue_dt', '$narration','$uid','$creation_date')";
		//echo $query;
		$result = db_query($query);


		$sql="SELECT receipts_id  FROM material_receipts ORDER BY receipts_id  DESC LIMIT 1 ";
		$result = db_query($sql);
		while($row=mysqli_fetch_array($result))
		{
			$receipts_id =$row['receipts_id'];
		}

		//$_POST['row_count']  Post no of rows in table 
		$cnt=$connect->real_escape_string($_POST['row_count']); 
		//echo $cnt;
		for($i=0;$i<=$cnt;$i++)
		{
			if($connect->real_escape_string($_POST['wareHouse'][$i]))
			{
				$wareHouse=$connect->real_escape_string($_POST['wareHouse'][$i]);
				$item=$connect->real_escape_string($_POST['item'][$i]);
				$receivedQty=$connect->real_escape_string($_POST['receivedQty'][$i]); 
				$remarks=$connect->real_escape_string($_POST['remarks'][$i]); 
				$query = "INSERT INTO `material_receipts_items` (`warehouse`, `item`, `received_qty`, `remarks`, `receipts_id`) 
				VALUES ('$wareHouse','$item','$receivedQty','$remarks','$receipts_id')";
				$result = db_query($query);
				//echo $query;
			}
		}
	}
	
	//die();
    header("location:procurment_transactions_material_receipts.php");
}

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
$receipts_no="MI/".$year."/".str_pad($serial_no,4,"0",STR_PAD_LEFT);


?>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Maxim ERP</title>	
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
        <?php include("includes/css.php"); ?>
		<style>
            .custom-blue-btn {
                background-color: #334f9a;
                color: #fff;
            }
            .custom-blue-btn:hover{
                color: #fff;
            }
        </style>
		<script>
			function display_branch(val){
                //alert(val);
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
                        document.getElementById('receipts_no').value=xmlhttp.responseText;
                    }
                }
                //alert("get_branch_code.php?branch_id="+val);
                xmlhttp.open("GET","get_receipts_branch_code.php?branch_id="+val,true);
                xmlhttp.send();
            }
			function valid_qty(val){
				var rows = document.getElementById('materialReceiptsTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (num = 0; num < rows.length; num++) {
                    rows[num].onclick = function() {
                        //alert(this.rowIndex - 1);
                        var row_num=this.rowIndex - 1;
						//var req_qty=document.getElementById('receivedQty' + row_num + '').value;
						var item=document.getElementById('item' + row_num + '').value;
						var issue_id=<?php echo $issue_id;?>
						
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
								qty=xmlhttp.responseText;
								if(parseInt(val) > parseInt(xmlhttp.responseText)){
									alert("Received Qty can not greater than "+qty+"");
									document.getElementById('receivedQty' + row_num + '').value="";
									return false;
								}
								else{
									return true;
								}
                            }
                        }
                        //alert("get_material_issue_item_dlts.php?item_id="+val+"&request_no="+req_no);
                        xmlhttp.open("GET","get_received_qty.php?item_id="+item+"&issue_id="+issue_id,true);
                        xmlhttp.send();
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
            <?php include("includes/sidebar.php"); ?>
			<!-- /Sidebar -->
		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content container-fluid">
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-7 col-auto">
							<h3 class="page-title">View Material Receipts</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="#">Procurement</a></li>
								<li class="breadcrumb-item"><a href="#">Transactions</a></li>
								<li class="breadcrumb-item active"><a href="procurment_transactions_material_receipts.php">Material Receipts</a></li>
							</ul>
						</div>
						<div class="col-sm-5 col">

						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<?php 
				if(isset($_GET['recp_id'])){
					$retrive_query="SELECT * FROM `material_receipts` where receipts_id ='$recp_id'";
					$retrive_result=db_query($retrive_query);
					$retrive_row=mysqli_fetch_assoc($retrive_result);
				}
				?>
				<!--Inner Page Wrapper-->
				<div class="container-fluid pl-0 pr-0 mt-0 mb-2">
					<form method="POST" action="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $issue_id; ?>&recp_id=<?php echo $recp_id; ?>">
						<div class="accordion mb-1" id="materialReceipt">
							<div class="card">
							<div class="card-header" id="headingOne">
								<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#material_receipt" aria-expanded="true" aria-controls="material_receipt">
									<i class="fa fa-minus-circle fa-1x float-right"></i>
								</button>
								</h2>
							</div>
						
							<div id="material_receipt" class="collapse show" aria-labelledby="headingOne" data-parent="#materialReceipt">
								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Material Receipt No</label>
												<div class="col-md-7">
													<?php 
													if(isset($_GET['recp_id'])){
														$query="select receipts_no from `material_receipts` where receipts_id ='$recp_id' ";
														$query_result = db_query($query);
														while($row=mysqli_fetch_assoc($query_result))
														{
														?>
															<input type="text" readonly id="receipts_no" name="receipts_no" value="<?php echo $row['receipts_no'];?>"  class="form-control" placeholder="" />
														<?php
														}
													}
													else{
													?>
														<input type="text" readonly id="receipts_no" name="receipts_no" value="<?php echo $receipts_no;?>"  class="form-control" placeholder="" />
													<?php
													}
													?>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Branch</label>
												<div class="col-md-7">
													<select name="branch" <?php if(!isset($_GET['recp_id'])){ echo "required";}?> class="form-control" onchange="display_branch(this.value)">
														<option Selcted value="" >Please Select Branch</option>
														<?php
															$check="select location_id ,location_name from `payroll_locations`";
															$result = db_query($check);
															while($pdb=mysqli_fetch_assoc($result))
															{
															?>
																<option value="<?php echo $pdb['location_id'];?>" <?php if(isset($_GET['recp_id'])){ if($retrive_row['branch']== $pdb['location_id']){ echo "selected"; } } ?>><?php echo $pdb['location_name'];?></option>
															<?php
															}
														?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Request By</label>
												<div class="col-md-7">
													<input type="text" class="form-control" placeholder="" name="request_by" value="<?php if(isset($_GET['recp_id'])){ echo $retrive_row['request_by']; } ?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Material Issue Date</label>
												<div class="col-md-7">
													<?php 
														$check="select material_issue_dt from `material_issue` where material_issue_id='$issue_id' ";
														$result = db_query($check);
														while($pdb=mysqli_fetch_assoc($result))
														{
														?>
															<input type="text" name="issue_dt" value="<?php if(isset($_GET['recp_id'])){ echo date("Y-m-d", strtotime($retrive_row['material_issue_dt'])); } else{ echo date("Y-m-d", strtotime($pdb['material_issue_dt']));} ?>" readonly class="form-control" placeholder="">
														<?php
														}
													?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-5 col-form-label custom-text-14">Material Receipt Date</label>
												<div class="col-md-7">
												<input type="date" name="receipt_dt" value="<?php if(isset($_GET['recp_id'])){ echo date("Y-m-d", strtotime($retrive_row['receipts_dt'])); } else{ echo date("Y-m-d");} ?>" readonly class="form-control" placeholder="">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Department</label>
												<div class="col-md-7">
													<select class="form-control" name="department"> 
														<option Selcted >Please Select Department</option>
														<?php
															$check="select dept_id ,  dept_name from `payroll_department`";
															$result = db_query($check);
															while($pdb=mysqli_fetch_assoc($result))
															{
															?>
																<option value="<?php echo $pdb['dept_id'];?>" <?php if(isset($_GET['recp_id'])){ if($retrive_row['department']== $pdb['dept_id']){ echo "selected"; } } ?>><?php echo $pdb['dept_name'];?></option>
															<?php
															}
															?>
													</select>
												</div>
											</div>	
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Material Issue No</label>
												<div class="col-md-7">
													<?php 
															$check="SELECT material_issue_id, material_issue_no FROM material_issue WHERE material_issue_id ='$issue_id' ";
															$result = db_query($check);
															while($pdb=mysqli_fetch_assoc($result))
															{
															?>
																<input type="text" hidden name="issue_no" value="<?php echo $pdb['material_issue_id'];?>" readonly class="form-control" placeholder="">
																<input type="text"  name="material_issue_no" value="<?php echo $pdb['material_issue_no'];?>" readonly class="form-control" placeholder="">
															<?php
															}
														?>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Narration</label>
												<div class="col-md-7">
													<textarea class="form-control" placeholder="" name="narration" rows="1"><?php if(isset($_GET['recp_id'])){ echo $retrive_row['narration']; } ?></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>

						<div class="accordion mb-3" id="materialReceiptTable">
							<div class="card">
							<div class="card-header" id="headingTwo">
								<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#material_receipt_table" aria-expanded="true" aria-controls="material_receipt_table">
									
									<i class="fa fa-minus-circle fa-1x float-right"></i>
								</button>
								</h2>
							</div>
						
							<div id="material_receipt_table" class="collapse show" aria-labelledby="headingTwo" data-parent="#materialReceiptTable">
								<div class="card-body">
									<table class="table table-bordered table-sm" id="materialReceiptsTable">
										<thead class="thead-green">
											<tr>
												<th scope="col" width="1%">SL. NO.</th>
												<th scope="col" width="20%">Warehouse</th>
												<th scope="col" width="20%">Item Name</th>
												<th scope="col" width="20%">Item Specification</th>
												<th scope="col" width="15%">Unit</th>
												<th scope="col" width="9%">Received Qty</th>
												<th scope="col" width="15%">Remarks</th>
											</tr>
										</thead>
										<tbody>
											<?php
											//query for fetching item name , id, description, unit ,quantity
											if(isset($_GET['recp_id'])){
												$query="SELECT mri.warehouse,mri.receipts_items_id ,mri.item, mri.received_qty,mri.remarks, im.description,im.id, im.item_name,im.purchase_unit from material_receipts_items AS mri LEFT JOIN item_master AS im ON im.id=mri.item WHERE mri.receipts_id='$recp_id' ";
											}
											else{
												$query="SELECT i.id ,i.item_name,i.description,i.purchase_unit,mii.issued_qty FROM item_master AS i LEFT JOIN material_issue_item AS mii ON i.id=mii.item WHERE mii.material_issue_id='$issue_id'  group by i.item_name ORDER BY i.item_name ";
											}
											$result = db_query($query);
											//echo $query;
											$sl=0;
											$a=1;
											while($row=mysqli_fetch_assoc($result))
											{
												if(isset($_GET['recp_id'])){
												?>
													<tr>
														<td class="text-center" id="slNo"><?php echo $a?></td>
														<td>
															<select class="form-control" id="wareHouse" name="wareHouse[]" style="width: 200px;">
																<option Selcted >Please Select WareHouse</option>
																<?php
																$query1="select id ,name from `warehouse_master`";
																$result1 = db_query($query1);
																while($row1=mysqli_fetch_assoc($result1))
																{
																?>
																	<option value="<?php echo $row1['id'];?>"><?php echo $row1['name'];?></option>
																<?php	
																}
																?>
															</select>
														</td>
														<td>
															<input type="text" readonly class="form-control form-control-sm" value="<?php echo $row['item_name'];?>" id="itemname<?php echo $sl;?>" name="itemname[]" />
															<input type="text" readonly hidden class="form-control form-control-sm" value="<?php echo $row['id'];?>" id="item<?php echo $sl;?>" name="item[]" />
															<input type="text" hidden readonly class="form-control form-control-sm" value="<?php echo $row['receipts_items_id'];?>" name="receipts_items_id[]" />
														</td>
														<td>
															<input type="text" readonly class="form-control form-control-sm" value="<?php echo $row['description'];?>" id="itemSpecification<?php echo $sl;?>" name="itemSpecification[]" />
														</td>
														<td>
															<input type="text" readonly class="form-control form-control-sm" value="<?php echo $row['purchase_unit'];?>" id="unit<?php echo $sl;?>" name="unit[]" />
														</td>
														<td>
															<input type="text" class="form-control form-control" id="receivedQty<?php echo $sl;?>" value="<?php echo $row['received_qty'];?>" name="receivedQty[]" onkeyup="return valid_qty(this.value)">
														</td>
														<td>
															<input type="text" class="form-control form-control" id="remarks" value="<?php echo $row['remarks'];?>" name="remarks[]">
														</td>
													</tr>
												<?php
												}
												else{
													//$query1="SELECT sum(issued_qty) issued_qty from material_issue_item AS mii LEFT JOIN material_issue AS mi ON mi.material_issue_id=mii.material_issue_id LEFT JOIN material_request AS mr ON mr.material_request_id=mi.material_request_no WHERE mi.material_request_no=$issue_id and item='".$row['id']."'  ";
													$query1="SELECT sum(received_qty) qty FROM `material_receipts_items` AS mri LEFT JOIN `material_receipts` AS mr ON mr.receipts_id =mri.receipts_id  where mr.material_issue_no ='".$issue_id."' AND mri.item='".$row['id']."'";
													$result1= db_query($query1);
													//echo $query1;
													while($row1=mysqli_fetch_assoc($result1))
													{
														if($row['issued_qty']>$row1['qty']){	
														?>
															<tr>
																<td class="text-center" id="slNo"><?php echo $a?></td>
																<td>
																	<select class="form-control" id="wareHouse" name="wareHouse[]" style="width: 200px;">
																		<option Selcted >Please Select WareHouse</option>
																		<?php
																		$query1="select id ,name from `warehouse_master`";
																		$result1 = db_query($query1);
																		while($row1=mysqli_fetch_assoc($result1))
																		{
																		?>
																			<option value="<?php echo $row1['id'];?>"><?php echo $row1['name'];?></option>
																		<?php	
																		}
																		?>
																	</select>
																</td>
																<td>
																	<input type="text" readonly class="form-control form-control-sm" value="<?php echo $row['item_name'];?>" id="itemname<?php echo $sl;?>" name="itemname[]" />
																	<input type="text" readonly hidden class="form-control form-control-sm" value="<?php echo $row['id'];?>" id="item<?php echo $sl;?>" name="item[]" />
																</td>
																<td>
																	<input type="text" readonly class="form-control form-control-sm" value="<?php echo $row['description'];?>" id="itemSpecification<?php echo $sl;?>" name="itemSpecification[]" />
																</td>
																<td>
																	<input type="text" readonly class="form-control form-control-sm" value="<?php echo $row['purchase_unit'];?>" id="unit<?php echo $sl;?>" name="unit[]" />
																</td>
																<td>
																	<input type="text" class="form-control form-control" id="receivedQty<?php echo $sl;?>" name="receivedQty[]" onkeyup="return valid_qty(this.value)">
																</td>
																<td>
																	<input type="text" class="form-control form-control" id="remarks" name="remarks[]">
																</td>
															</tr>
														<?php
														}
													}
												}
												
											$sl++;
											$a++;
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
							<button type="submit" name="submit"  class="btn custom-blue-btn mb-5">Submit</button>
							<input type="hidden" id="row_count" name="row_count" value="1">
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

	
</body>

</html>
