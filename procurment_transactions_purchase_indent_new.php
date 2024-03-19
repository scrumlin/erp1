<?php
include('includes/connection.php');
session_start();
if(!isset($_SESSION['id']))
{
    header('location:index.php');
}
$page = "pt_purchase_indent";
if($page=="pt_purchase_indent"){
	$pt_purchase_indent="active";
}
if(isset($_GET['id'])){
	$id=$_GET['id'];
}
if(isset($_GET['indent_id'])){
	$indent_id=$_GET['indent_id'];
}

if(isset($_POST['submit'])){
	if(isset($_GET['indent_id'])){
		$indent_no=$connect->real_escape_string($_POST['indent_no']); 
		$branch=$connect->real_escape_string($_POST['branch']); 
		$indent_status=$connect->real_escape_string($_POST['indent_status']); 
		$refer_to=$connect->real_escape_string($_POST['refer_to']);
		$indent_dt=$connect->real_escape_string($_POST['indent_dt']);
		$type_of_purchase=$connect->real_escape_string($_POST['type_of_purchase']);
		$narration=$connect->real_escape_string($_POST['narration']); 
		$uid=$_SESSION['id'];
		$creation_date=date("Y-m-d");

		//update results from the form input
		$query = "UPDATE `purchase_indent` SET `indent_no`='$indent_no', `indent_dt`='$indent_dt', `branch`='$branch', `type_of_purchase`='$type_of_purchase', `indent_status`='$indent_status',, `refer_to`='$refer_to', `narration`='$narration' where indent_id ='$indent_id' ";
		$result = db_query($query);
		//echo $query;
		//$_POST['row_count']  Post no of rows in table 
		$cnt=$connect->real_escape_string($_POST['row_cnt']); 
		$cnt=$cnt-1;
		for($i=0;$i<=$cnt;$i++)
		{
			if($connect->real_escape_string($_POST['item'][$i]))
			{
				$item=$connect->real_escape_string($_POST['item'][$i]);
				$availableQty=$connect->real_escape_string($_POST['availableQty'][$i]); 
				$pRequisitionQty=$connect->real_escape_string($_POST['pRequisitionQty'][$i]); 
				$indentQty=$connect->real_escape_string($_POST['indentQty'][$i]); 
				$remarks=$connect->real_escape_string($_POST['remarks'][$i]); 
				$indent_item_id=$connect->real_escape_string($_POST['indent_item_id'][$i]); 
				$update_query = "UPDATE `purchase_indent_item` set `indent_id`='$indent_id', `item`='$item', `available_qty`='$availableQty', `purchase_req_qty`='$pRequisitionQty', `indent_qty`='$indentQty',`remark`='$remarks' where indent_item_id='$indent_item_id'";
				$result = db_query($update_query);
			}
			//echo $update_query;
		}
		//die();
	}
	else{
		//echo "aaa";
		$indent_no=$connect->real_escape_string($_POST['indent_no']); 
		$branch=$connect->real_escape_string($_POST['branch']); 
		$indent_status=$connect->real_escape_string($_POST['indent_status']); 
		$refer_to=$connect->real_escape_string($_POST['refer_to']);
		$indent_dt=$connect->real_escape_string($_POST['indent_dt']);
		$type_of_purchase=$connect->real_escape_string($_POST['type_of_purchase']);
		$narration=$connect->real_escape_string($_POST['narration']); 
		$uid=$_SESSION['id'];
		$creation_date=date("Y-m-d");

		//insert results from the form input
		$query = "INSERT INTO `purchase_indent` (`indent_no`, `requisition_id`, `indent_dt`, `branch`, `type_of_purchase`, `indent_status`, `refer_to`, `narration`, `created_by`, `created_dt`) 
		VALUES('$indent_no','$id','$indent_dt','$branch','$type_of_purchase','$indent_status','$refer_to','$narration','$uid','$creation_date')";
		//echo $query;
		//die();
		$result = db_query($query);


		$sql="SELECT indent_id  FROM purchase_indent ORDER BY indent_id  DESC LIMIT 1 ";
		$result = db_query($sql);
		while($row=mysqli_fetch_array($result))
		{
			$last_indent_id =$row['indent_id'];
		}

		//$_POST['row_count']  Post no of rows in table 
		$cnt=$connect->real_escape_string($_POST['row_cnt']); 
		$cnt=$cnt-1;
		for($i=0;$i<=$cnt;$i++)
		{
			if($connect->real_escape_string($_POST['item'][$i]))
			{
				$item=$connect->real_escape_string($_POST['item'][$i]);
				$availableQty=$connect->real_escape_string($_POST['availableQty'][$i]); 
				$pRequisitionQty=$connect->real_escape_string($_POST['pRequisitionQty'][$i]); 
				$indentQty=$connect->real_escape_string($_POST['indentQty'][$i]); 
				$remarks=$connect->real_escape_string($_POST['remarks'][$i]); 
				$query = "INSERT INTO `purchase_indent_item` (`indent_id`, `item`, `available_qty`, `purchase_req_qty`, `indent_qty`,`purchase_req_id`,`remark`) 
				VALUES ('$last_indent_id','$item','$availableQty','$pRequisitionQty','$indentQty','$id','$remarks')";
				$result = db_query($query);
			}
			//echo $query;
		}
	}
	
	//die();
	header("location:procurment_transactions_purchase_indent.php");
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
$seql = "SELECT * FROM purchase_indent";
$fetch_data = db_query($seql); 
if ($fetch_data ->num_rows > 0) 
{ 
	$fetch_maxn="SELECT MAX(indent_id) AS serial_no FROM purchase_indent";
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
$indent_no="PI/".$year."/".str_pad($serial_no,4,"0",STR_PAD_LEFT);
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
                        document.getElementById('indent_no').value=xmlhttp.responseText;
                    }
                }
                //alert("get_branch_code.php?branch_id="+val);
                xmlhttp.open("GET","get_purchase_indent_no.php?branch_id="+val,true);
                xmlhttp.send();
            }
			function valid_qty(val){
				//alert("aaa");
				var rows = document.getElementById('prchsIndentTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (num = 1; num < rows.length; num++) {
                    rows[num].onclick = function() {
                        var row_num=this.rowIndex - 1;
						//alert(row_num);
						var req_qty=document.getElementById('pRequisitionQty' + row_num + '').value;
						var item=document.getElementById('item' + row_num + '').value;
						var id=<?php echo $id;?>
						
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
								if(xmlhttp.responseText==""){
									qty=parseInt(val);
								}
								else{
									qty=parseInt(val)+parseInt(xmlhttp.responseText);
								}
								if(parseInt(qty) > parseInt(req_qty)){
									alert("Indent Qty can not greater than Purchase Req Qty");
									document.getElementById('indentQty' + row_num + '').value="";
									return false;
								}
								else{
									return true;
								}
                            }
                        }
                        //alert("get_indent_qty.php?item_id="+item+"&requisition_id="+id);
                        xmlhttp.open("GET","get_indent_qty.php?item_id="+item+"&requisition_id="+id,true);
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
            <?php include('includes/sidebar.php');?>
			<!-- /Sidebar -->
		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content container-fluid">
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-7 col-auto">
							<h3 class="page-title">New Purchase Indent</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="#">Procurement</a></li>
								<li class="breadcrumb-item"><a href="#">Transactions</a></li>
								<li class="breadcrumb-item active"><a href="procurment_transactions_purchase_indent.php">Purchase Indent</a></li>
							</ul>
						</div>
						<div class="col-sm-5 col">
						
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<?php 
				if(isset($_GET['indent_id'])){
					$retrive_query="SELECT * FROM `purchase_indent` where indent_id ='$indent_id'";
					$retrive_result=db_query($retrive_query);
					$retrive_row=mysqli_fetch_assoc($retrive_result);
				}
				?>
				<!--Inner Page Wrapper-->
				<div class="container-fluid pl-0 pr-0 mt-0 mb-2">
					<form method="POST" action="procurment_transactions_purchase_indent_new.php?id=<?php echo $id?><?php if(isset($_GET['indent_id'])){ echo "&indent_id=".$indent_id; }?> ">
						<div class="accordion mb-1" id="purchaseIndent">
							<div class="card">
							<div class="card-header" id="headingOne">
								<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#purchase_indent" aria-expanded="true" aria-controls="purchase_indent">
									<i class="fa fa-minus-circle fa-1x float-right"></i>
								</button>
								</h2>
							</div>
						
							<div id="purchase_indent" class="collapse show" aria-labelledby="headingOne" data-parent="#purchaseIndent">
								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Purchase Indent No</label>
												<div class="col-md-7">
													<?php 
													if(isset($_GET['indent_id'])){
														$query="SELECT indent_no from purchase_indent WHERE indent_id='$indent_id'";
														$query_result = db_query($query);
														while($row=mysqli_fetch_assoc($query_result))
														{
														?>
															<input type="text" readonly id="indent_no" name="indent_no" value="<?php echo $row['indent_no'];?>"  class="form-control" placeholder="" />
														<?php
														}
													}
													else{
													?>
														<input type="text" readonly id="indent_no" name="indent_no" value="<?php echo $indent_no;?>"  class="form-control" placeholder="" />
													<?php
													}	
													?>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Branch</label>
												<div class="col-md-7">
													<select name="branch" class="form-control" onchange="display_branch(this.value)">
														<option Selcted >Please Select Branch</option>
														<?php
														$check="select location_id ,location_name from `payroll_locations`";
														$result = db_query($check);
														while($pdb=mysqli_fetch_assoc($result))
														{
														?>
															<option value="<?php echo $pdb['location_id'];?>" <?php if(isset($_GET['indent_id'])){ if($retrive_row['branch']== $pdb['location_id']){ echo "selected"; } } ?>><?php echo $pdb['location_name'];?></option>
														<?php
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Indent Status</label>
												<div class="col-md-7">
													<select class="form-control" name="indent_status">
														<option Selcted >Please Select Indent Status</option>
														<option value="W" <?php if(isset($_GET['indent_id'])){ if($retrive_row['indent_status']=="W"){ echo "selected"; } } ?>>Waiting</option>
														<option value="A" <?php if(isset($_GET['indent_id'])){ if($retrive_row['indent_status']=="A"){ echo "selected"; } } ?>>Approved </option>
														<option value="N" <?php if(isset($_GET['indent_id'])){ if($retrive_row['indent_status']=="N"){ echo "selected"; } } ?>>Not Approved</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Refer To</label>
												<div class="col-md-7">
													<select class="form-control" name="refer_to">
														<option Selcted >Please Select Refer To</option>
														<option value="1" <?php if(isset($_GET['indent_id'])){ if($retrive_row['refer_to']==1){ echo "selected"; } } ?>>Admin</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-5 col-form-label custom-text-14">Purchase Indent Date</label>
												<div class="col-md-7">
													<input type="date" name="indent_dt" value="<?php if(isset($_GET['indent_id'])){ echo date("Y-m-d", strtotime($retrive_row['indent_dt'])); } else{ echo date('Y-m-d');} ?>" readonly class="form-control" placeholder="">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Type of Purchase</label>
												<div class="col-md-7">
													<select class="form-control" name="type_of_purchase">
														<option Selcted >Please Select Type of Purchase</option>
														<option value="H" <?php if(isset($_GET['indent_id'])){ if($retrive_row['type_of_purchase']=="H"){ echo "selected"; } } ?>>HO Purchase</option>
														<option value="L" <?php if(isset($_GET['indent_id'])){ if($retrive_row['type_of_purchase']=="L"){ echo "selected"; } } ?>>Local Purchase</option>
													</select>
												</div>
											</div>	
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Narration</label>
												<div class="col-md-7">
													<textarea class="form-control" name="narration" placeholder="" rows="2"><?php if(isset($_GET['indent_id'])){ echo $retrive_row['narration']; } ?></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>

						<div class="accordion mb-3" id="purchaseIndentTable">
							<div class="card">
							<div class="card-header" id="headingTwo">
								<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#purchaseIndent_table" aria-expanded="true" aria-controls="purchaseIndent_table">
									
									<i class="fa fa-minus-circle fa-1x float-right"></i>
								</button>
								</h2>
							</div>
						
							<div id="purchaseIndent_table" class="collapse show" aria-labelledby="headingTwo" data-parent="#purchaseIndentTable">
								<div class="card-body horizontal-scroll" style="overflow-y: auto;">
									<table class="table table-bordered table-sm" id="prchsIndentTable">
										<thead class="custom-thead">
											<tr>
												<th scope="col">SL. NO.</th>
												<th scope="col">Item Name</th>
												<th scope="col">Item Specification</th>
												<th scope="col">Unit</th>
												<th scope="col">Available Qty</th>
												<th scope="col">Purchase Req Qty</th>
												<th scope="col">Indent Qty</th>
												<th scope="col">Purchase Req No.</th>
												<th scope="col">Purchase Req Date</th>
												<th scope="col">Required Date</th>
												<th scope="col">Remarks</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if(isset($_GET['indent_id'])){
												$query="SELECT pii.indent_item_id , im.id, im.item_name,im.description, im.purchase_unit, pii.available_qty, pii.purchase_req_qty, pii.indent_qty, pr.requisition_no, pr.requisition_dt,pri.required_dt, pii.remark from purchase_indent_item AS pii LEFT JOIN item_master AS im ON im.id=pii.item LEFT JOIN purchase_indent AS pi ON pi.indent_id=pii.indent_id LEFT JOIN purchase_requisition AS pr ON pr.requisition_id=pi.requisition_id LEFT JOIN purchase_requisition_item AS pri ON pri.requisition_id=pr.requisition_id WHERE pi.requisition_id='$id' GROUP BY pii.indent_item_id ";
											}
											else{
												$query="SELECT im.id, im.item_name, im.description, im.purchase_unit, pri.quantity, pr.requisition_no, pr.requisition_dt, pri.required_dt FROM `purchase_requisition` AS pr LEFT JOIN purchase_requisition_item AS pri ON pri.requisition_id=pr.requisition_id LEFT JOIN item_master AS im ON im.id=pri.item where pri.requisition_id='$id' ";
											}
											//echo $query;
											$result=db_query($query);
											$sl=1;
											$n=0;
											while($pdb=mysqli_fetch_assoc($result)){
											?>
												<tr>
													<td class="text-center" id="slNo"><?php echo $sl;?></td>
													<td>
														<input type="text" style="width: 120px;" readonly value="<?php echo $pdb['item_name'];?>" class="form-control form-control-sm" id="item" name="item_name[]" />
														<input type="text" hidden  class="form-control form-control-sm" value="<?php echo $pdb['id'];?>" id="item<?php echo $sl;?>" name="item[]" />
														<input type="text" hidden  class="form-control form-control-sm" value="<?php echo $pdb['indent_item_id'];?>" name="indent_item_id[]" />
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly value="<?php echo $pdb['description'];?>" class="form-control form-control-sm" id="itemSpecification0" name="itemSpecification[]" />
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly value="<?php echo $pdb['purchase_unit'];?>" class="form-control form-control-sm" id="unit" name="unit[]" style="width: 80px;"/>
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly value="<?php echo $pdb['available_qty'];?>" class="form-control form-control" id="availableQty" name="availableQty[]">
													</td>
													<td>
														<input type="text" style="width: 120px;" readonly value="<?php if(isset($_GET['indent_id'])){ echo $pdb['purchase_req_qty']; } else{ echo $pdb['quantity']; } ?>" class="form-control form-control" id="pRequisitionQty<?php echo $sl;?>" name="pRequisitionQty[]">
													</td>
													<td>
														<input type="text" style="width: 120px;" value="<?php if(isset($_GET['indent_id'])){ echo $pdb['indent_qty']; } ?>" class="form-control form-control" id="indentQty<?php echo $sl;?>" name="indentQty[]" onkeyup="return valid_qty(this.value)">
													</td>
													<td>
														<input type="text" style="width: 150px;" readonly value="<?php echo $pdb['requisition_no'];?>" class="form-control form-control" id="pRequisitionNo" name="pRequisitionNo[]">
													</td>
													<td>
														<input type="text" style="width: 140px;" readonly value="<?php echo date("d/m/Y", strtotime($pdb['requisition_dt']));?>" class="form-control form-control" id="pRequisitionDate" name="pRequisitionDate[]">
													</td>
													<td>
														<input type="text" style="width: 140px;" readonly value="<?php if(isset($pdb['required_dt'])) { echo date("d/m/Y", strtotime($pdb['required_dt']));}?>" class="form-control form-control" id="requiredDate" name="requiredDate[]">
													</td>
													<td>
														<input type="text" style="width: 150px;" class="form-control form-control" id="remarks" name="remarks[]" value="<?php if(isset($_GET['indent_id'])){ echo $pdb['remark']; } ?>">
													</td>
													<td>
														
													</td>
												</tr>
											<?php
											$n++;	
											$sl++;
											}
											?>
											
										</tbody>
									</table>	
									<input type="text" hidden class="form-control form-control" value="<?php echo $sl;?>" name="row_cnt">
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

	<script>
		var i=$('table tr').length;

		$(".add").on('click',function(){
			html = '<tr>'; 
			html += '<td class="text-center" id="slNo">'+i+'</td>';
			html += '<td><select class="form-control form-control-sm w-100" id="item" name="item[]"><option>...</option><option>...</option></select></td>';
			html += '<td><select class="form-control form-control-sm w-100" id="itemSpecification" name="itemSpecification[]"><option>...</option><option>ABT-5(New)</option></select></td>';
			html += '<td><select class="form-control form-control-sm w-100" id="unit" name="unit[]"><option>...</option><option>Dairy</option></select></td>';
			html += '<td><input type="text" class="form-control form-control" id="availableQty" name="availableQty[]"></td>';
			html += '<td><input type="text" class="form-control form-control" id="pRequisitionQty" name="pRequisitionQty[]"></td>';
			html += '<td><input type="text" class="form-control form-control" id="indentQty" name="indentQty[]"></td>';
			html += '<td><input type="text" class="form-control form-control" id="pRequisitionNo" name="pRequisitionNo[]"></td>';
			html += '<td><input type="date" class="form-control form-control" id="pRequisitionDate" name="pRequisitionDate[]"></td>';
			html += '<td><input type="date" class="form-control form-control" id="requiredDate" name="requiredDate[]"></td>';
			html += '<td><input type="text" class="form-control form-control-sm" id="remarks" name="remarks[]"></td>';
			html += '<td class="text-center"><a href="javascript:void(0);" class="remove"><i class="fa fa-trash fa-1x"></i></a></td>';	 
			html += '</tr>';
			$('table').append(html);
			i++;

			$(".remove").on('click', function () {
					$(this).closest('tr').remove();
			});
		});
	</script>


	<!--Custom Checkbox Inside a dropdown -->
	<script>
		(function($) {
			var CheckboxDropdown = function(el) {
				var _this = this;
				this.isOpen = false;
				this.areAllChecked = false;
				this.$el = $(el);
				this.$label = this.$el.find('.dropdown-label');
				this.$checkAll = this.$el.find('[data-toggle="check-all"]').first();
				this.$inputs = this.$el.find('[type="checkbox"]');
				
				this.onCheckBox();
				
				this.$label.on('click', function(e) {
				e.preventDefault();
				_this.toggleOpen();
				});
				
				this.$checkAll.on('click', function(e) {
				e.preventDefault();
				_this.onCheckAll();
				});
				
				this.$inputs.on('change', function(e) {
				_this.onCheckBox();
				});
			};
			
			CheckboxDropdown.prototype.onCheckBox = function() {
				this.updateStatus();
			};
			
			CheckboxDropdown.prototype.updateStatus = function() {
				var checked = this.$el.find(':checked');
				
				this.areAllChecked = false;
				this.$checkAll.html('Check All');
				
				if(checked.length <= 0) {
				this.$label.html('Select Options');
				}
				else if(checked.length === 1) {
				this.$label.html(checked.parent('label').text());
				}
				else if(checked.length === this.$inputs.length) {
				this.$label.html('All Selected');
				this.areAllChecked = true;
				this.$checkAll.html('Uncheck All');
				}
				else {
				this.$label.html(checked.length + ' Selected');
				}
			};
			
			CheckboxDropdown.prototype.onCheckAll = function(checkAll) {
				if(!this.areAllChecked || checkAll) {
				this.areAllChecked = true;
				this.$checkAll.html('Uncheck All');
				this.$inputs.prop('checked', true);
				}
				else {
				this.areAllChecked = false;
				this.$checkAll.html('Check All');
				this.$inputs.prop('checked', false);
				}
				
				this.updateStatus();
			};
			
			CheckboxDropdown.prototype.toggleOpen = function(forceOpen) {
				var _this = this;
				
				if(!this.isOpen || forceOpen) {
				this.isOpen = true;
				this.$el.addClass('on');
				$(document).on('click', function(e) {
					if(!$(e.target).closest('[data-control]').length) {
					_this.toggleOpen();
					}
				});
				}
				else {
				this.isOpen = false;
				this.$el.removeClass('on');
				$(document).off('click');
				}
			};
			
			var checkboxesDropdowns = document.querySelectorAll('[data-control="checkbox-dropdown"]');
			for(var i = 0, length = checkboxesDropdowns.length; i < length; i++) {
				new CheckboxDropdown(checkboxesDropdowns[i]);
			}
		})(jQuery);
	</script>

</body>

</html>
