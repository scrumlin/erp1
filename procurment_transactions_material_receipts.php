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
?>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Maxim ERP</title>	
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
        <?php include("includes/css.php"); ?>
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
							<h3 class="page-title">Material Receipts</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="#">Procurement</a></li>
								<li class="breadcrumb-item"><a href="#">Transactions</a></li>
								<li class="breadcrumb-item active">Material Receipts</li>
							</ul>
						</div>
						<div class="col-sm-5 col">
							
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<!-- Inner Page Header 2 -->
				<nav class="inner-navbar2 bg-success">
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-link active" id="nav-pendingIssue-tab" data-toggle="tab" href="#nav-pendingIssue" role="tab"
							aria-controls="nav-pendingIssue" aria-selected="true">Pending Material Issue</a>
						<a class="nav-link" id="nav-receiptVoucher-tab" data-toggle="tab" href="#nav-receiptVoucher" role="tab"
							aria-controls="nav-receiptVoucher" aria-selected="false">Material Receipt Voucher</a>
					</div>
				</nav><!-- /Inner Page Header 2 -->

				<!--Inner Page Wrapper-->
				<div class="container-fluid pl-0 pr-0">
					<div class="tab-content" id="nav-tabContent">
						<!--Pending Material Request-->
						<div class="tab-pane fade show active" id="nav-pendingIssue" role="tabpanel" aria-labelledby="nav-pendingIssue-tab">
							<table class="table table-bordered table-sm" id="printLayoutTable">
								<thead class="thead-green">
									<tr>
										<th scope="col">#</th>
										<th scope="col">
											<input type="checkbox" id="">
										</th>
										<th scope="col">Material Issue Date</th>
										<th scope="col">Material Issue No</th>
										<th scope="col">Branch</th>
										<th scope="col">Item Name</th>
										<th scope="col">Item Specification</th>
										<th scope="col">Quantity</th>
										<th scope="col">Created Date</th>
										<th scope="col">Balance Qty</th>
									</tr>
								</thead>
								<tbody>
									<?php
										//Display Pending Material Request
										$sql_fetch="SELECT mi.material_issue_dt, mi.material_issue_id , mi.material_issue_no,pl.location_name, im.item_name, im.id , im.description,mii.issued_qty,mi.created_by,mi.created_dt FROM material_issue AS mi LEFT JOIN material_issue_item AS mii ON mi.material_issue_id=mii.material_issue_id LEFT JOIN payroll_locations AS pl ON mi.branch=pl.location_id LEFT JOIN item_master AS im ON im.id=mii.item LEFT JOIN admin_login AS a ON mi.created_by=a.id ORDER BY mi.material_issue_id DESC ";
										$result_fetch=db_query($sql_fetch);
										$c=1;
										//echo $sql_fetch;
										while($row = $result_fetch->fetch_assoc()){ 
											//$issued_qty_query="SELECT sum(issued_qty) issued_qty FROM `material_issue_item` AS mii LEFT JOIN `material_issue` AS mi ON mii.material_issue_id=mi.material_issue_id where mi.material_request_no ='".$row["material_request_id"]."' AND mii.item='".$row['id']."' ";
											$issued_qty_query="SELECT sum(received_qty) qty FROM `material_receipts_items` AS mri LEFT JOIN `material_receipts` AS mr ON mr.receipts_id =mri.receipts_id  where mr.material_issue_no ='".$row["material_issue_id"]."' AND mri.item='".$row['id']."'";
											$result_issued_qty=db_query($issued_qty_query);
											//echo $issued_qty_query;
											//Display if item is issued
											if(mysqli_num_rows($result_issued_qty) > 0){
												while($result_row = $result_issued_qty->fetch_assoc())
												{
													//Display if material quantity is greater than issued quantity
													if($row['issued_qty'] > $result_row['qty']){
														//$bal_qty=(int)$row['quantity']-(int)$result_row['issued_qty'];
														?>
														<tr>
															<td class="text-right"><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $c;?></a></td>
															<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><input type="checkbox" id="" /></a></td>
															<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo date("d/m/Y", strtotime($row['material_issue_dt'])); ?></a></td>
															<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $row['material_issue_no']?></a></td>
															<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $row['location_name'];?></a></td>
															<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $row['item_name'];?></a></td>
															<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $row['description'];?></a></td>
															<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $row['issued_qty'];?></a></td>
															<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo date("d/m/Y", strtotime($row['created_dt']));?></a></td>
															<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $row['user_name'];?></a></td>
															<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $bal_qty;?></a></td>
														</tr>
														<?php
													}
												}
											}
											else{
											?>
												<tr>
													<td class="text-right"><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $c;?></a></td>
													<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><input type="checkbox" id="" /></a></td>
													<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo date("d/m/Y", strtotime($row['material_issue_dt'])); ?></a></td>
													<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $row['material_issue_no']?></a></td>
													<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $row['location_name'];?></a></td>
													<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $row['item_name'];?></a></td>
													<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $row['description'];?></a></td>
													<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $row['issued_qty'];?></a></td>
													<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo date("d/m/Y", strtotime($row['created_dt']));?></a></td>
													<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $row['user_name'];?></a></td>
													<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_id']; ?>"><?php echo $bal_qty;?></a></td>
												</tr>
											<?php	
											}
											//print $c;
											$c++;
										}
										?>
								</tbody>
							</table>
						</div>
						<!--/Pending Material Request-->

						<!--Material Issued Voucher-->
						<div class="tab-pane fade" id="nav-receiptVoucher" role="tabpanel" aria-labelledby="nav-receiptVoucher-tab">
							<table class="table table-bordered table-sm" id="printLayoutTable">
								<thead class="thead-green">
									<tr>
										<th scope="col">#</th>
										<th scope="col">
											<input type="checkbox" id="">
										</th>
										<th scope="col">MR Date</th>
										<th scope="col">Material Receipt No</th>
										<th scope="col">Branch</th>
										<th scope="col">Item Name</th>
										<th scope="col">Item Specification</th>
										<th scope="col">Quantity</th>
										<th scope="col">Created Date</th>
										<th scope="col">Created By</th>
										<th scope="col">Balance Qty</th>
									</tr>
								</thead>
								<tbody>
									<?php
									//Display Material Issued Voucher
									$sql_fetch="SELECT mr.receipts_id ,mr.receipts_dt,mr.receipts_no,mr.material_issue_no,pl.location_name,im.item_name, im.id,im.description, mri.received_qty,mr.created_by,mr.created_dt, a.user_name from material_receipts AS mr LEFT JOIN payroll_locations AS pl ON mr.branch=pl.location_id LEFT JOIN material_receipts_items AS mri ON mri.receipts_id=mr.receipts_id LEFT JOIN item_master AS im ON im.id=mri.item LEFT JOIN admin_login AS a ON mr.created_by=a.id ORDER BY mri.receipts_items_id DESC ";
									$result_fetch=db_query($sql_fetch);
									//echo $sql_fetch;
									$d=1;
									while($row = $result_fetch->fetch_assoc()){ 
										$issued_qty_query="SELECT issued_qty from material_issue_item WHERE material_issue_id='".$row["material_issue_no"]."' and item='".$row['id']."'";
										$result_issued_qty=db_query($issued_qty_query);
										//echo $issued_qty_query;
										if(mysqli_num_rows($result_issued_qty) > 0){
											while($result_row = $result_issued_qty->fetch_assoc())
											{
												if($row['received_qty'] <= $result_row['issued_qty'])
												{
													//$bal_qty=(int)$result_row['quantity']-(int)$row['issued_qty'];
													?>
													<tr>
														<td class="text-right"><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_no']; ?>&recp_id=<?php echo $row['receipts_id']; ?>"><?php echo $d;?></a></td>
														<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_no']; ?>&recp_id=<?php echo $row['receipts_id']; ?>"><input type="checkbox" id="" /></a></td>
														<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_no']; ?>&recp_id=<?php echo $row['receipts_id']; ?>"><?php echo date("d/m/Y", strtotime($row['receipts_dt'])); ?></a></td>
														<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_no']; ?>&recp_id=<?php echo $row['receipts_id']; ?>"><?php echo $row['receipts_no']?></a></td>
														<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_no']; ?>&recp_id=<?php echo $row['receipts_id']; ?>"><?php echo $row['location_name'];?></a></td>
														<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_no']; ?>&recp_id=<?php echo $row['receipts_id']; ?>"><?php echo $row['item_name'];?></a></td>
														<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_no']; ?>&recp_id=<?php echo $row['receipts_id']; ?>"><?php echo $row['description'];?></a></td>
														<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_no']; ?>&recp_id=<?php echo $row['receipts_id']; ?>"><?php echo $row['received_qty'];?></a></td>
														<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_no']; ?>&recp_id=<?php echo $row['receipts_id']; ?>"><?php echo date("d/m/Y", strtotime($row['created_by']));?></a></td>
														<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_no']; ?>&recp_id=<?php echo $row['receipts_id']; ?>"><?php echo $row['user_name'];?></a></td>
														<td><a style="color: #333;cursor: auto;" href="procurment_transactions_add_edit_material_receipts.php?id=<?php echo $row['material_issue_no']; ?>&recp_id=<?php echo $row['receipts_id']; ?>"><?php// echo $bal_qty;?></a></td>
													</tr>
													<?php 
												}
											}
										}
										$d++;
									}
									?>
								</tbody>
							</table>
						</div>
						<!--/Material Issued Voucher-->
					</div>
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
		$('table tr').on('click', 'td', function () {
			window.location.href = "procurment_transactions_add_edit_material_receipts.php";
		})
	</script>
</body>

</html>
