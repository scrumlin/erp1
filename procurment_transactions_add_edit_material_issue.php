<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('location:index.php');
}
include('includes/connection.php');
if(isset($_GET['id'])){
	$reg_id=$_GET['id'];
}
if(isset($_GET['issue_id'])){
	$issue_id=$_GET['issue_id'];
}
//echo $reg_id;
if(isset($_POST['submit']))
{
	//$_POST['row_count']  Post no of rows in table 
    $cnt=$connect->real_escape_string($_POST['row_count']); 
    //echo $cnt;
    for($i=0;$i<=$cnt;$i++)
    {
		if($connect->real_escape_string($_POST['wareHouse'][$i]))
		{
			$wareHouse=$connect->real_escape_string($_POST['wareHouse'][$i]);
        	$wareHouse=$connect->real_escape_string($_POST['wareHouse'][$i]);
            $item=$connect->real_escape_string($_POST['item'][$i]);
            $noOfPacks=$connect->real_escape_string($_POST['noOfPacks'][$i]); 
            $availableQty=$connect->real_escape_string($_POST['availableQty'][$i]); 
			$requestedQty=$connect->real_escape_string($_POST['requestedQty'][$i]); 
			$issuedQty=$connect->real_escape_string($_POST['issuedQty'][$i]); 
			$remarks=$connect->real_escape_string($_POST['remarks'][$i]); 
			$material_issue_item_id=$connect->real_escape_string($_POST['material_issue_item_id'][$i]); 
            $query = "UPDATE `material_issue_item` set `warehouse`='$wareHouse' , `item`='$item' , `no_of_packs`='$noOfPacks', `available_qty`='$availableQty', `requested_qty`='$requestedQty',`issued_qty`='$issuedQty',`remarks`='$remarks' where `material_issue_item_id`='$material_issue_item_id'";
            $result = db_query($query);
        	//echo $query;
			
		}
		
    }
	//die();
    header("location:procurment_transactions_material_issue.php");
}
$page = "pt_material_issue";
if($page=="pt_material_issue"){
	$pt_material_issue="active";
}

if (date('m') > 6) {
    $year = date('y')."-".(date('y') +1);
}
else {
    $year = (date('y')-1)."-".date('y');
}

$last_no=0;
$serial_no=0; 
$seql = "SELECT * FROM material_issue";
$fetch_data = db_query($seql); 
if ($fetch_data ->num_rows > 0) 
{ 
	$fetch_maxn="SELECT MAX(material_issue_id) AS serial_no FROM material_issue";
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
$material_issue_no="MI/".$year."/".str_pad($serial_no,4,"0",STR_PAD_LEFT);

?>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Maxim ERP</title>	
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
        <?php include("includes/css.php"); ?>
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
                        document.getElementById('material_issue_no').value=xmlhttp.responseText;
                    }
                }
                //alert("get_branch_code.php?branch_id="+val);
                xmlhttp.open("GET","get_material_issue_branch_code.php?branch_id="+val,true);
                xmlhttp.send();
            }

            function display_item(val){
                var rows = document.getElementById('materialIssuTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (num = 0; num < rows.length; num++) {
                    rows[num].onclick = function() {
                        //alert(this.rowIndex - 1);
                        var row_num=this.rowIndex - 1;
						//alert(row_num);
						var req_no=<?php echo $reg_id;?>;
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
                                str=xmlhttp.responseText;
                                result=str.split('/');
								document.getElementById('itemSpecification' + row_num + '').value=result[0];
								document.getElementById('unit' + row_num + '').value=result[1];
								document.getElementById('requestedQty' + row_num + '').value=result[2];
								document.getElementById('issuedQty' + row_num + '').value="";
                            }
                        }
                        //alert("get_material_issue_item_dlts.php?item_id="+val+"&request_no="+req_no);
                        xmlhttp.open("GET","get_material_issue_item_dlts.php?item_id="+val+"&request_no="+req_no,true);
                        xmlhttp.send();
                    }
                }
            }

			
			function valid_qty(val){
				var rows = document.getElementById('materialIssuTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (num = 0; num < rows.length; num++) {
                    rows[num].onclick = function() {
                        //alert(this.rowIndex - 1);
                        var row_num=this.rowIndex - 1;
						var req_qty=document.getElementById('requestedQty' + row_num + '').value;
						var item=document.getElementById('item' + row_num + '').value;
						var reg_id=<?php echo $reg_id;?>
						
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
									alert("Issued Qty can not greater than Requested Qty");
									document.getElementById('issuedQty' + row_num + '').value="";
									return false;
								}
								else{
									return true;
								}
                            }
                        }
                        //alert("get_material_issue_item_dlts.php?item_id="+val+"&request_no="+req_no);
                        xmlhttp.open("GET","get_issue_qty.php?item_id="+item+"&reg_id="+reg_id,true);
                        xmlhttp.send();
					}
				}
			}
			function isNumberKey(evt) 
            {      
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                return true;
            }
        </script>
		<style>
            .custom-blue-btn {
                background-color: #334f9a;
                color: #fff;
            }
            .custom-blue-btn:hover{
                color: #fff;
            }
        </style>
    </head>

    <body>	
		<!-- Main Wrapper -->
        <div class="main-wrapper">		
			<!-- Header -->
            <?php include("includes/top_header.php"); ?>
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
							<h3 class="page-title">View Material Issue</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="#">Procurement</a></li>
								<li class="breadcrumb-item"><a href="#">Transactions</a></li>
								<li class="breadcrumb-item active"><a href="procurment_transactions_material_issue.php">Material Issue</a></li>
							</ul>
						</div>
						<div class="col-sm-5 col">
						
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<?php 
				if(isset($_GET['issue_id'])){
					$retrive_query="SELECT * FROM `material_issue` where material_issue_id ='$issue_id'";
					$retrive_result=db_query($retrive_query);
					$retrive_row=mysqli_fetch_assoc($retrive_result);
				}
				?>
				<!--Inner Page Wrapper-->
				<div class="container-fluid pl-0 pr-0 mt-0 mb-2">
					<form method="POST" action="procurment_transactions_add_edit_material_issue.php?id=<?php echo $reg_id?>&issue_id=<?php echo $issue_id;?>">
						<div class="accordion mb-1" id="materialIssue">
							<div class="card">
							<div class="card-header" id="headingOne">
								<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#material_issue" aria-expanded="true" aria-controls="material_issue">
									
									<i class="fa fa-minus-circle fa-1x float-right"></i>
								</button>
								</h2>
							</div>
						
							<div id="material_issue" class="collapse show" aria-labelledby="headingOne" data-parent="#materialIssue">
								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Material Issue No</label>
												<div class="col-md-7">
													<?php 
														$query="select material_issue_no from `material_issue` where material_issue_id ='$issue_id' ";
														$query_result = db_query($query);
														while($row=mysqli_fetch_assoc($query_result))
														{
														?>
															<input type="text" readonly id="material_issue_no" name="material_issue_no" value="<?php echo $row['material_issue_no'];?>"  class="form-control" placeholder="" />
														<?php
														}
													?>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Branch</label>
												<div class="col-md-7">
													<select name="branch" class="form-control" onchange="display_branch(this.value)">
														<option Selcted value="" >Please Select Branch</option>
														<?php
															$check="select location_id ,location_name from `payroll_locations`";
															$result = db_query($check);
															while($pdb=mysqli_fetch_assoc($result))
															{
															?>
																<option value="<?php echo $pdb['location_id'];?>" <?php if(isset($_GET['issue_id'])){ if($retrive_row['branch']== $pdb['location_id']){ echo "selected"; } } ?>><?php echo $pdb['location_name'];?></option>
															<?php
															}
														?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Request By</label>
												<div class="col-md-7">
													<input type="text"  name="request_by" class="form-control" placeholder="" name="<?php if(isset($_GET['issue_id'])){ echo $retrive_row['request_by']; } ?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Material Request Date</label>
												<div class="col-md-7">
													<?php 
														$check="select material_request_dt from `material_request` where material_request_id='$reg_id' ";
														$result = db_query($check);
														while($pdb=mysqli_fetch_assoc($result))
														{
														?>
															<input type="text" name="material_request_dt" value="<?php echo date("d/m/Y", strtotime($pdb['material_request_dt']));?>" readonly class="form-control" placeholder="">
														<?php
														}
													?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-5 col-form-label custom-text-14">Material Issue Date</label>
												<div class="col-md-7">
													<input type="date" name="material_issue_dt" value="<?php echo date('Y-m-d');?>" readonly class="form-control" placeholder="">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Department</label>
												<div class="col-md-7">
													<select name="department" class="form-control">
														<option Selcted >Please Select Department</option>
                                                        <?php
                                                                $check="select dept_id ,  dept_name from `payroll_department`";
                                                                $result = db_query($check);
                                                                while($pdb=mysqli_fetch_assoc($result))
                                                                {
                                                                ?>
                                                                    <option value="<?php echo $pdb['dept_id'];?>" <?php if(isset($_GET['issue_id'])){ if($retrive_row['department']== $pdb['dept_id']){ echo "selected"; } } ?>><?php echo $pdb['dept_name'];?></option>
                                                                <?php
                                                                }
                                                                ?>
													</select>
												</div>
											</div>	
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Material Request No</label>
												<div class="col-md-7">
													<?php 
														$check="select material_request_no,material_request_id from `material_request` where material_request_id='$reg_id' ";
														$result = db_query($check);
														while($pdb=mysqli_fetch_assoc($result))
														{
														?>
															<input type="text" hidden name="material_request_no" value="<?php echo $pdb['material_request_id'];?>" readonly class="form-control" placeholder="">
															<input type="text"  name="material_request" value="<?php echo $pdb['material_request_no'];?>" readonly class="form-control" placeholder="">
														<?php
														}
													?>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Narration</label>
												<div class="col-md-7">
													<textarea class="form-control" name="narration" placeholder="" rows="1"></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>

						<div class="accordion mb-3" id="materialIssueTable">
							<div class="card">
							<div class="card-header" id="headingTwo">
								<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#materialIssue_table" aria-expanded="true" aria-controls="materialIssue_table">
									
									<i class="fa fa-minus-circle fa-1x float-right"></i>
								</button>
								</h2>
							</div>
						
							<div id="materialIssue_table" class="collapse show" aria-labelledby="headingTwo" data-parent="#materialIssueTable">
								<div class="card-body">
									
									<table class="table table-bordered table-sm" id="materialIssuTable">
                                                <thead class="thead-green">
													<tr>
														<th scope="col" width="1%">SL. NO.</th>
														<th scope="col" width="14%">Warehouse</th>
														<th scope="col" width="14%">Item Name</th>
														<th scope="col" width="14%">Item Specification</th>
														<th scope="col" width="8%">Unit</th>
														<th scope="col" width="8.5%">No of Packs</th>
														<th scope="col" width="8.5%">Available Qty</th>
														<th scope="col" width="8%">Requested Qty</th>
														<th scope="col" width="9%">Issued Qty</th>
														<th scope="col" width="15%">Remarks</th>
													</tr>
                                                </thead>

                                                <tbody>
													<?php
													$sql_fetch="SELECT mii.warehouse,mii.material_issue_item_id , mii.item, im.id, im.item_name, im.description, im.purchase_unit, mii.no_of_packs,mii.available_qty, mii.requested_qty, mii.issued_qty, mii.remarks FROM `material_issue_item` AS mii LEFT JOIN `material_issue` AS mi ON mii.material_issue_id=mi.material_issue_id LEFT JOIN item_master AS im ON im.id=mii.item where mi.material_request_no ='$reg_id' and mi.material_issue_id='$issue_id'";
													//echo $sql_fetch;
													$result_fetch=db_query($sql_fetch);
													$sl=0;
													$a=1;
													while($row = $result_fetch->fetch_assoc()){ 
														?>
														<tr>
															<td class="text-center" id="slNo"><?php echo $a;?></td>
															<td>
																<select class="form-control" id="wareHouse" name="wareHouse[]" style="width: 200px;">
																	<option Selcted >Please Select WareHouse</option>
																	<?php
																		$check="select id ,name from `warehouse_master`";
																		$result = db_query($check);
																		while($pdb=mysqli_fetch_assoc($result))
																		{
																			if($row[warehouse]==$pdb['id']){
																			?>
																				<option selected value="<?php echo $pdb['id'];?>"><?php echo $pdb['name'];?></option>
																			<?php
																			}
																			else{
																				?>
																				<option value="<?php echo $pdb['id'];?>"><?php echo $pdb['name'];?></option>
																			<?php	
																			}
																		}
																	?>
																</select>
															</td>
															<td>
																<input type="text" readonly class="form-control form-control-sm" value="<?php echo $row['item_name'];?>" id="itemname<?php echo $sl;?>" name="itemname[]" />
																<input type="text" hidden  readonly class="form-control form-control-sm" value="<?php echo $row['id'];?>" id="item<?php echo $sl;?>" name="item[]" />
																<input type="text" hidden readonly class="form-control form-control-sm" value="<?php echo $row['material_issue_item_id'];?>" name="material_issue_item_id[]" />
															</td>

															<td>
																<input type="text" readonly class="form-control form-control-sm" value="<?php echo $row[description]?>" id="itemSpecification<?php echo $sl;?>" name="itemSpecification[]" />
															</td>

															<td>
																<input type="text" readonly class="form-control form-control-sm" value="<?php echo $row[purchase_unit]?>" id="unit<?php echo $sl;?>" name="unit[]" />
															</td>

															<td>
																<input type="text" class="form-control form-control" value="<?php echo $row[no_of_packs]?>" id="noOfPacks" onkeypress="return isNumberKey(event)" name="noOfPacks[]">
															</td>
															<td>
																<input type="text" readonly class="form-control form-control" value="<?php echo $row[available_qty]?>" id="availableQty" name="availableQty[]">
															</td>
															<td>
																<input type="text" readonly class="form-control form-control" value="<?php echo $row[requested_qty]?>" id="requestedQty<?php echo $sl;?>" name="requestedQty[]">
															</td>
															<td>
																<input type="text" class="form-control form-control" id="issuedQty<?php echo $sl;?>" value="<?php echo $row[issued_qty]?>" name="issuedQty[]" onkeyup="return valid_qty(this.value)">
															</td>
															<td>
																<input type="text" class="form-control form-control" id="remarks" value="<?php echo $row[remarks]?>" name="remarks[]">
															</td>
															
														</tr>
														<?php
														//}
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

	<script>
		var i=$('table tr').length;
		var j= 1;

		$(".add").on("click", function () {
                html = "<tr>";

                html += '<td class="text-center" id="slNo">' + i + "</td>";
				html += '<td><select class="form-control form-control-sm w-100" id="wareHouse" name="wareHouse[]"><option Selcted >Please Select WareHouse</option><?php $check="select id ,name from `warehouse_master`"; $result = db_query($check); while($pdb=mysqli_fetch_assoc($result)) { ?> <option value="<?php echo $pdb['id'];?>"><?php echo $pdb['name'];?></option> <?php }?></select></td>';
                html += '<td><select name="item[]" id="item' + j + '" class="select w-100 form-control form-control-sm" onchange="display_item(this.value)"><option Selcted >Please Select Item</option> <?php $check="SELECT i.id ,i.item_name FROM item_master AS i LEFT JOIN material_request_item AS mri ON i.id=mri.item WHERE mri.material_request_id=$reg_id ORDER BY i.item_name "; $result = db_query($check); while($pdb=mysqli_fetch_assoc($result)) { $query1='SELECT issued_qty FROM `material_issue_item` AS mii LEFT JOIN `material_issue` AS mi ON mii.material_issue_id=mi.material_issue_id where mi.material_request_no ="'.$reg_id.'" AND mii.item="'.$pdb['id'].'" '; $result1 = db_query($query1); if(mysqli_num_rows($result1) > 0){ while($row1=mysqli_fetch_assoc($result1)){ $query2='SELECT quantity FROM `material_request_item` where material_request_id ="'.$reg_id.'" AND item="'.$pdb['id'].'" '; $result2 = db_query($query2); while($row2=mysqli_fetch_assoc($result2)) { if($row1['issued_qty'] < $row2['quantity']){ ?> <option value="<?php echo $pdb['id'];?>"><?php echo $pdb['item_name'];?></option><?php } } } } else{ ?> <option value="<?php echo $pdb['id'];?>"><?php echo $pdb['item_name'];?></option><?php } } ?></select></td>';
                html += '<td><input type="text" readonly class="form-control form-control-sm" id="itemSpecification' + j + '" name="itemSpecification[]"></td>';
                html += '<td><input type="text" readonly class="form-control form-control-sm" id="unit' + j + '" name="unit[]"></td>';
                html += '<td><input type="text" class="form-control form-control-sm" id="noOfPacks" name="noOfPacks[]" onkeypress="return isNumberKey(event)"></td>';
                html += '<td><input type="text" readonly class="form-control form-control-sm" id="availableQty" name="availableQty[]"></td>';
				html += '<td><input type="text" readonly class="form-control form-control-sm" id="requestedQty' + j + '" name="requestedQty[]"></td>';
                html += '<td><input type="text" class="form-control form-control-sm" id="issuedQty' + j + '" name="issuedQty[]" onkeyup="return valid_qty(this.value)"></td>';
				html += '<td><input type="text" class="form-control form-control-sm" id="remarks" name="remarks[]"></td>';
                html += '<td class="text-center"><a href="javascript:void(0);" class="remove"><i class="fa fa-trash fa-1x"></i></a></td>';
                html += "</tr>";

                $("table").append(html);
                var rowCount = $('#materialIssuTable tr').length;
                //alert();
                $('#row_count').val(rowCount-1);
                i++;
                j++;
                $(".remove").on("click", function () {
                    $(this).closest("tr").remove();
                });
            });
	</script>

</body>

</html>
