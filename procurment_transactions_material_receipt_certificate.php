<?php
include('includes/connection.php');
session_start();
if(!isset($_SESSION['id']))
{
    header('location:index.php');
}
$page = "pt_material_receipt_certificate";
if($page=="pt_material_receipt_certificate"){
	$pt_material_receipt_certificate="active";
}
?>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Maxim ERP</title>	
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
        <?php include('includes/css.php');?>
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
							<h3 class="page-title">Certificate of Material Receipt</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="#">Procurement</a></li>
								<li class="breadcrumb-item"><a href="#">Transactions</a></li>
								<li class="breadcrumb-item active">Certificate of Material Receipt</li>
							</ul>
						</div>
						<div class="col-sm-5 col">
						
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<!-- Inner Page Header 2 -->
				<nav class="inner-navbar2">
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-link active" id="nav-purchaseOrder-tab" data-toggle="tab" href="#nav-purchaseOrder" role="tab"
							aria-controls="nav-purchaseOrder" aria-selected="true">Pending Purchase Order</a>
						<a class="nav-link" id="nav-allVouchers-tab" data-toggle="tab" href="#nav-allVouchers" role="tab"
							aria-controls="nav-allVouchers" aria-selected="false">All Vouchers</a>
					</div>
				</nav><!-- /Inner Page Header 2 -->

				<!--Inner Page Wrapper-->
				<div class="container-fluid pl-0 pr-0">
					<div class="tab-content" id="nav-tabContent">
						<!--Pending Purchase Indent-->
						<div class="tab-pane fade show active" id="nav-purchaseOrder" role="tabpanel" aria-labelledby="nav-purchaseOrder-tab">
							<table class="table table-bordered table-sm" id="pendingpurchaseOrder">
								<thead class="thead-green">
									<tr>
										<th scope="col">#</th>
										<th scope="col">
											<input type="checkbox" id="">
										</th>
										<th scope="col">Date</th>
										<th scope="col">Order No</th>
										<th scope="col">Purchase Type</th>
										<th scope="col">Branch</th>
										<th scope="col">Vendor</th>
										<th scope="col">Item Name</th>
										<th scope="col">Item Specification</th>
										<th scope="col">PO Qty</th>
										<th scope="col">Created Date</th>
										<th scope="col">Created By</th>
										<th scope="col">Pending Po Qty</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    $query="SELECT po.order_id , po.order_dt, po.order_no,po.type_of_purchase, pl.location_name, im.item_name, im.description, poi.po_qty, poi.indent_qty, po.created_dt FROM `purchase_order` AS po LEFT JOIN purchase_order_item AS poi ON poi.order_id=po.order_id LEFT JOIN payroll_locations AS pl ON poi.branch=pl.location_id LEFT JOIN item_master AS im ON im.id=poi.item LEFT JOIN admin_login AS a ON a.id=po.created_by ORDER BY poi.order_item_id DESC ";
                                    $result=db_query($query);
                                    $sl=1;
                                    while($row=$result->fetch_assoc()){
										$pending_po_Qty=$row['po_qty'];
										if($row['indent_qty'] > $row['po_qty']){
											$pending_po_Qty=$row['indent_qty']-$row['po_qty'];
										?>
											<tr>
												<td class="text-right">
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $sl;?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<input type="checkbox" id="">
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo date("d/m/Y", strtotime($row['order_dt'])); ?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $row['order_no'];?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php 
														if($row['type_of_purchase']=="H"){
															echo "HO Purchase";
														}
														elseif($row['type_of_purchase']=="L"){
															echo "Local Purchase";
														}
														?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $row['location_name'];?>
													</a>
												</td>
												<td>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $row['item_name'];?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $row['description'];?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $row['po_qty'];?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo date("d/m/Y", strtotime($row['created_dt'])); ?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $row['user_name']; ?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $pending_po_Qty;?>
													</a>
												</td>
											</tr>
										<?php
										}
										else
										{
										?>
											<tr>
												<td class="text-right">
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $sl;?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<input type="checkbox" id="">
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo date("d/m/Y", strtotime($row['order_dt'])); ?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $row['order_no'];?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php 
														if($row['type_of_purchase']=="H"){
															echo "HO Purchase";
														}
														elseif($row['type_of_purchase']=="L"){
															echo "Local Purchase";
														}
														?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $row['location_name'];?>
													</a>
												</td>
												<td>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $row['item_name'];?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $row['description'];?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $row['po_qty'];?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo date("d/m/Y", strtotime($row['created_dt'])); ?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $row['user_name']; ?>
													</a>
												</td>
												<td>
													<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['order_id']?>">
														<?php echo $pending_po_Qty;?>
													</a>
												</td>
											</tr>
                                    	<?php
										}
                                    $sl++;
                                    }
                                    ?>
								</tbody>
							</table>
						</div>
						<!--/Pending Purchase Indent-->

						<!--All Voucher-->
						<div class="tab-pane fade" id="nav-allVouchers" role="tabpanel" aria-labelledby="nav-allVouchers-tab">
							<div class="table-responsive-sm">
								<table class="table table-bordered table-sm" id="allVoucher">
									<thead class="thead-green">
										<tr>
											<th scope="col">#</th>
											<th scope="col">
												<input type="checkbox" id="">
											</th>
											<th scope="col">Date</th>
											<th scope="col">CMR No.</th>
											<th scope="col">Branch</th>
											<th scope="col">Item Name</th>
											<th scope="col">Item Specification</th>
											<th scope="col">VenderAC</th>
											<th scope="col">Quantity</th>
											<th scope="col">Created Date</th>
											<th scope="col">Created By</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$query="SELECT c.cmr_id, c.po_id, c.cmr_dt, c.cmr_no, pl.location_name, im.item_name, im.description, ci.received_qty, c.created_dt, a.user_name FROM cmr AS c LEFT JOIN cmr_item AS ci ON ci.cmr_id= c.cmr_id LEFT JOIN payroll_locations AS pl ON pl.location_id = ci.branch LEFT JOIN item_master AS im ON im.id=ci.item LEFT JOIN admin_login AS a ON a.id=c.created_by ORDER BY ci.id ";
										$result=db_query($query);
										$n=1;
										while($row=mysqli_fetch_assoc($result))
										{
										?>
										<tr>
											<td class="text-right">
												<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['po_id']?>&cmr_id=<?php echo $row['cmr_id']?>">
													<?php echo $n; ?>
												</a>
											</td>
											<td>
												<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['po_id']?>&cmr_id=<?php echo $row['cmr_id']?>">
													<input type="checkbox" id="">
												</a>
											</td>
											<td>
												<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['po_id']?>&cmr_id=<?php echo $row['cmr_id']?>">
													<?php echo date("d/m/Y", strtotime($row['cmr_dt'])); ?>
												</a>
											</td>
											<td>
												<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['po_id']?>&cmr_id=<?php echo $row['cmr_id']?>">
													<?php echo $row['cmr_no']?>
												</a>
											</td>
											<td>
												<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['po_id']?>&cmr_id=<?php echo $row['cmr_id']?>">
													<?php echo $row['location_name']?>
												</a>
											</td>
											<td>
												<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['po_id']?>&cmr_id=<?php echo $row['cmr_id']?>">
													<?php echo $row['item_name']?>
												</a>
											</td>
											<td>
												<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['po_id']?>&cmr_id=<?php echo $row['cmr_id']?>">
													<?php echo $row['description']?>
												</a>
											</td>
											<td>
												<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['po_id']?>&cmr_id=<?php echo $row['cmr_id']?>">
													<?php echo $row['description']?>
												</a>
											</td>
											<td>
												<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['po_id']?>&cmr_id=<?php echo $row['cmr_id']?>">
													<?php echo $row['received_qty']?>
												</a>
											</td>
											<td>
												<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['po_id']?>&cmr_id=<?php echo $row['cmr_id']?>">
													<?php echo date("d/m/Y", strtotime($row['created_dt'])); ?>
												</a>
											</td>
											<td>
												<a style="color: #333;cursor: auto;" href="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $row['po_id']?>&cmr_id=<?php echo $row['cmr_id']?>">
													<?php echo $row['user_name']?>
												</a>
											</td>
										</tr>
										<?php
										$n++;
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<!--/All Voucher-->
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
			window.location.href = "procurment_transactions_material_receipt_certificate_new.php";
		})
	</script>
</body>

</html>
