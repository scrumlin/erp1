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
							<h3 class="page-title">Purchase Indent</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="#">Procurement</a></li>
								<li class="breadcrumb-item"><a href="#">Transactions</a></li>
								<li class="breadcrumb-item active">Purchase Indent</li>
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
						<a class="nav-link active" id="nav-purchaseRequisition-tab" data-toggle="tab" href="#nav-purchaseRequisition" role="tab"
							aria-controls="nav-purchaseRequisition" aria-selected="true">Pending Purchase Requisition</a>
						<a class="nav-link" id="nav-allVouchers-tab" data-toggle="tab" href="#nav-allVouchers" role="tab"
							aria-controls="nav-allVouchers" aria-selected="false">All Vouchers</a>
					</div>
				</nav><!-- /Inner Page Header 2 -->

				<!--Inner Page Wrapper-->
				<div class="container-fluid pl-0 pr-0">
					<div class="tab-content" id="nav-tabContent">
						<!--Pending Purchase Requisition-->
						<div class="tab-pane fade show active" id="nav-purchaseRequisition" role="tabpanel" aria-labelledby="nav-purchaseRequisition-tab">
							<table class="table table-bordered table-sm" id="pendingPurchaseRequisition">
								<thead class="thead-green">
									<tr>
										<th scope="col">#</th>
										<th scope="col">
											<input type="checkbox" id="">
										</th>
										<th scope="col">Date</th>
										<th scope="col">Purchase Requisition No</th>
										<th scope="col">Item Name</th>
										<th scope="col">Item Specification</th>
										<th scope="col">Quantity</th>
										<th scope="col">Created By</th>
										<th scope="col">Created Date</th>
										<th scope="col">Pending PR Qty</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql_fetch="SELECT pri.requisition_item_id , pr.requisition_id, pr.requisition_dt, pr.requisition_no, pl.location_name, im.item_name, im.description, pri.quantity, a.user_name, pr.created_dt,pii.indent_qty FROM purchase_requisition AS pr LEFT JOIN payroll_locations AS pl ON pl.location_id=pr.branch LEFT JOIN purchase_requisition_item AS pri ON pri.requisition_id=pr.requisition_id LEFT JOIN item_master AS im ON im.id=pri.item LEFT JOIN admin_login AS a ON a.id=pr.created_by LEFT JOIN purchase_indent AS pi ON pi.requisition_id=pr.requisition_id LEFT JOIN purchase_indent_item AS pii ON pii.indent_id=pi.indent_id GROUP BY pri.requisition_item_id ORDER BY pri.requisition_item_id DESC";
									$result_fetch=db_query($sql_fetch);
									$c=1;
									while($row = $result_fetch->fetch_assoc())
									{ 
										$bal_qty=$row['quantity'];
										if($row['quantity'] > $row['indent_qty']){
											$bal_qty=$row['quantity']-$row['indent_qty'];
										?>
											<tr>
												<td class="text-right"><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $c;?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><input type="checkbox" id="" /></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo date("d/m/Y", strtotime($row['requisition_dt'])); ?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $row['requisition_no']?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $row['item_name'];?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $row['description'];?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $row['quantity'];?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $row['user_name'];?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo date("d/m/Y", strtotime($row['created_dt']));?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $bal_qty;?></a></td>
											</tr>
										<?php
										}
										else{
										?>
											<tr>
												<td class="text-right"><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $c;?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><input type="checkbox" id="" /></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo date("d/m/Y", strtotime($row['requisition_dt'])); ?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $row['requisition_no']?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $row['item_name'];?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $row['description'];?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $row['quantity'];?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $row['user_name'];?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo date("d/m/Y", strtotime($row['created_dt']));?></a></td>
												<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>"><?php echo $bal_qty;?></a></td>
											</tr>
										<?php	
										}
									$c++;
									}
									?>
								</tbody>
								<tfoot>
										<tr class="text-info">
											<td></td>
											<td></td>
											<td>Total</td>
											<td></td>
											<td></td>
											<td></td>
											<td>200.00</td>
										</tr>
									</tfoot>
							</table>
						</div>
						<!--/Pending Purchase Requisition-->

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
											<th scope="col">Purchase Indent No.</th>
											<th scope="col">Item Name</th>
											<th scope="col">Item Specification</th>
											<th scope="col">Quantity</th>
											<th scope="col">Type of Purchase</th>
											<th scope="col">Created By</th>
											<th scope="col">Indent Status</th>
											<th scope="col">Balance Qty</th>
											<th scope="col">Authorization Status</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$query="SELECT pi.indent_id, pi.requisition_id,pi.indent_dt,pi.indent_no,im.item_name,im.description,pii.indent_qty,pii.purchase_req_qty , pi.type_of_purchase, a.user_name, pi.indent_status from purchase_indent_item AS pii LEFT JOIN purchase_indent AS pi ON pi.indent_id=pii.indent_id LEFT JOIN item_master AS im ON im.id=pii.item LEFT JOIN admin_login AS a ON a.id=pi.created_by ORDER BY pi.indent_id DESC  ";
										$result=db_query($query);
										$sl=1;
										while($row=mysqli_fetch_assoc($result)){
											$bal_qty=$row['purchase_req_qty']-$row['indent_qty'];
										?>
										<tr>
											<td class="text-right"><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>&indent_id=<?php echo $row['indent_id'];?>"><?php echo $sl;?></a></td>
											<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>&indent_id=<?php echo $row['indent_id'];?>"><input type="checkbox" id="" /></a></td>
											<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>&indent_id=<?php echo $row['indent_id'];?>"><?php echo date("d/m/Y", strtotime($row['indent_dt'])); ?></a></td>
											<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>&indent_id=<?php echo $row['indent_id'];?>"><?php echo $row['indent_no']?></a></td>
											<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>&indent_id=<?php echo $row['indent_id'];?>"><?php echo $row['item_name'];?></a></td>
											<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>&indent_id=<?php echo $row['indent_id'];?>"><?php echo $row['description'];?></a></td>
											<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>&indent_id=<?php echo $row['indent_id'];?>"><?php echo $row['indent_qty'];?></a></td>
											<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>&indent_id=<?php echo $row['indent_id'];?>"><?php if($row['type_of_purchase']=="H"){ echo "HO Purchase"; } elseif($row['type_of_purchase']=="L"){ echo "Local Purchase"; } ?></a></td>
											<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>&indent_id=<?php echo $row['indent_id'];?>"><?php echo $row['user_name'];?></a></td>
											<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>&indent_id=<?php echo $row['indent_id'];?>"><?php if($row['indent_status'] == "W") { echo "Waiting"; } elseif($row['indent_status'] == "A"){ echo "Approved"; } elseif($row['indent_status'] == "N"){ echo "Not Approved"; } ?></a></td>
											<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>&indent_id=<?php echo $row['indent_id'];?>"><?php echo $bal_qty;?></a></td>
											<td><a style="color: #333;cursor: auto;" href="procurment_transactions_purchase_indent_new.php?id=<?php echo $row['requisition_id']; ?>&indent_id=<?php echo $row['indent_id'];?>"><?php if($row['indent_status'] == "W") { echo "Waiting"; } elseif($row['indent_status'] == "A"){ echo "Approved"; } elseif($row['indent_status'] == "N"){ echo "Not Approved"; } ?></a></td>
										</tr>
										<?php
										$sl++;
										}
										?>
									</tbody>
									<tfoot>
										<tr class="text-info">
											<td></td>
											<td></td>
											<td>Total</td>
											<td></td>
											<td></td>
											<td></td>
											<td>100.00</td>
										</tr>
									</tfoot>
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
			window.location.href = "procurment_transactions_purchase_indent_new.php";
		})
	</script>
</body>

</html>
