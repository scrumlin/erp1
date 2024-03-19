<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('location:index.php');
}
$page = "pt_purchase_requisition";
if($page=="pt_purchase_requisition"){
	$pt_purchase_requisition="active";
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
							<h3 class="page-title">Purchase Requisition</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="#">Procurement</a></li>
								<li class="breadcrumb-item"><a href="#">Transactions</a></li>
								<li class="breadcrumb-item active">Purchase Requisition</li>
							</ul>
						</div>
						<div class="col-sm-5 col">
							<a href="procurment_transactions_add_edit_purchase_requisition.php" class="btn custom-blue-btn float-right mt-2">New Purchase Requisition</a>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<!-- Inner Page Header 2 -->
				<nav class="inner-navbar2 bg-success">
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-link active" id="nav-pendingRequest-tab" data-toggle="tab" href="#nav-pendingRequest" role="tab" aria-controls="nav-pendingRequest" aria-selected="true">Purchase Requisition Vouchers</a>
						
					</div>
				</nav><!-- /Inner Page Header 2 -->

				<!--Inner Page Wrapper-->
				<div class="container-fluid pl-0 pr-0">
					<div class="tab-content" id="nav-tabContent">
						<!--Pending Material Request-->
						<div class="tab-pane fade show active" id="nav-pendingRequest" role="tabpanel" aria-labelledby="nav-pendingRequest-tab">
							<table class="table table-bordered table-sm" id="printLayoutTable">
								<thead class="thead-green">
									<tr>
										<th scope="col">#</th>
										<th scope="col">
											<input type="checkbox" id="">
										</th>
										<th scope="col">Date</th>
										<th scope="col">Purchase Requisition No</th>
										<th scope="col">Branch</th>
										<th scope="col">Item Name</th>
										<th scope="col">Quantity</th>
										<th scope="col">Created Date</th>
										<th scope="col">Created By</th>
										<th scope="col">Pending	PR Qty</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql_fetch="SELECT pri.requisition_item_id , pr.requisition_id, pr.requisition_dt, pr.requisition_no, pl.location_name, im.item_name, im.description, pri.quantity, a.user_name, pr.created_dt,pii.indent_qty FROM purchase_requisition AS pr LEFT JOIN payroll_locations AS pl ON pl.location_id=pr.branch LEFT JOIN purchase_requisition_item AS pri ON pri.requisition_id=pr.requisition_id LEFT JOIN item_master AS im ON im.id=pri.item LEFT JOIN admin_login AS a ON a.id=pr.created_by LEFT JOIN purchase_indent AS pi ON pi.requisition_id=pr.requisition_id LEFT JOIN purchase_indent_item AS pii ON pii.indent_id=pi.indent_id GROUP BY pri.requisition_item_id ORDER BY pri.requisition_item_id DESC";
									$result_fetch=db_query($sql_fetch);
									$c=1;
									while($row = $result_fetch->fetch_assoc()){ 
										$bal_qty=$row['quantity']-$row['indent_qty'];?>
                                        <tr>
                                            <td class="text-right"><?php echo $c;?></td>
                                            <td><input type="checkbox" id="" /></td>
                                            <td><?php echo date("d/m/Y", strtotime($row['requisition_dt'])); ?></td>
                                            <td><?php echo $row['requisition_no']?></td>
                                            <td><?php echo $row['location_name'];?></td>
                                            <td><?php echo $row['item_name'];?></td>
                                            <td><?php echo $row['quantity'];?></td>
                                            <td><?php echo date("d/m/Y", strtotime($row['created_dt']));?></td>
                                            <td><?php echo $row['user_name'];?></td>
											<td><?php echo $bal_qty;?></td>
                                        </tr>
                                    <?php 
									$c++;
									}
									?>
								</tbody>
							</table>
						</div>
						<!--/Pending Material Request-->

						
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

</body>

</html>
