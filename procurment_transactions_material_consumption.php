<?php
include('includes/connection.php');
$page = "pt_material_consumption";
if($page=="pt_material_consumption"){
	$pt_material_consumption="active";
}
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
								<h3 class="page-title">Material Consumption</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item"><a href="#">Transactions</a></li>
									<li class="breadcrumb-item active">Material Consumption</li>
								</ul>
							</div>
							<div class="col-sm-5 col">
								<a style="background-color: #334f9a;color: #fff;" href="procurment_transactions_material_consumption_new.php" class="btn custom-blue-btn float-right mt-2">New Voucher</a>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<!-- Inner Page Header 2 -->
					<nav class="inner-navbar2">
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
							<!-- <a class="nav-link active" id="nav-purchaseOrder-tab" data-toggle="tab" href="#nav-purchaseOrder" role="tab"
								aria-controls="nav-purchaseOrder" aria-selected="true">Pending Purchase Order</a> -->
							<a class="nav-link active" id="nav-allVouchers-tab" data-toggle="tab" href="#nav-allVouchers" role="tab"
								aria-controls="nav-allVouchers" aria-selected="false">All Vouchers</a>
						</div>
					</nav><!-- /Inner Page Header 2 -->

					<!--Inner Page Wrapper-->
					<div class="container-fluid pl-0 pr-0">
						<div class="tab-content" id="nav-tabContent">
						
							<!--All Vouchers-->
							<div class="tab-pane fade show active" id="nav-allVouchers" role="tabpanel" aria-labelledby="nav-allVouchers-tab">
								<div class="table-responsive">
									<table class="datatable table table-hover table-center mb-0">
										<thead>
											<tr>
												<th>#</th>
												<th> <input type="checkbox"></th>
												<th>MC Date</th>
												<th>Material Consumption No</th>
												<th>Branch</th>
												<th>Item Name</th>
												<th>Quantity</th>
												<th>Created By</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sql_fetch="SELECT mc.consumption_id,mc.consumption_dt,mc.consumption_no, pl.location_name, im.item_name, mci.qty, mci.consumption_item_id , a.user_name FROM `material_consumption` AS mc LEFT JOIN material_consumption_item AS mci ON mci.consumption_id=mc.consumption_id LEFT JOIN payroll_locations AS pl ON pl.location_id=mc.branch LEFT JOIN item_master AS im ON im.id=mci.item LEFT JOIN admin_login AS a ON a.id=mc.created_by  ORDER BY mci.consumption_item_id  DESC ";
											$result_fetch=db_query($sql_fetch);
											$c=1;
											//echo $sql_fetch;
											while($row = $result_fetch->fetch_assoc()){ 
											?>
											<tr>
												<td><?php echo $c;?></td>													
												<td> <input type="checkbox"> </td>	
												<td><?php echo date("d/m/Y", strtotime($row['consumption_dt'])); ?></td>																									
												<td><?php echo $row['consumption_no'];?></td>																									
												<td><?php echo $row['location_name'];?></td>																									
												<td><?php echo $row['item_name'];?></td>																									
												<td><?php echo $row['qty'];?></td>																									
												<td><?php echo $row['user_name'];?></td>																									
												<td class="text-right">
													<div class="actions">
														<a class="btn btn-sm bg-info-light" href="procurment_transactions_material_consumption_new.php?id=<?php echo $row['consumption_id'] ?>">
															<i class="fe fe-pencil"></i> Edit
														</a>
														<a  data-toggle="modal" href="#delete_item<?php echo $c;?>" class="btn btn-sm bg-danger-light">
															<i class="fe fe-trash"></i> Delete
														</a>
													</div>
												</td>
												<!-- Delete Modal -->
												<div class="modal fade" id="delete_item<?php echo $c;?>" aria-hidden="true" role="dialog">
													<div class="modal-dialog modal-dialog-centered" role="document" >
														<div class="modal-content">
														<!--	<div class="modal-header">
																<h5 class="modal-title">Delete</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>-->
															<div class="modal-body">
																<div class="form-content p-2">
																	<form action="delete_consumption_item.php?id=<?php echo $row["consumption_id"]?>&id1=<?php echo $row["consumption_item_id"]?>" method="post">
																		<h4 class="modal-title">Delete</h4> 
																		<p class="mb-4">Are you sure want to delete?</p>
																		<button type="button" class="btn btn-info" data-dismiss="modal">No</button>
																		<button type="submit" class="btn btn-danger">Yes</button>
																	</form>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- /Delete Modal -->
											</tr>
											<?php
											$c++;
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Page Wrapper -->
						
			
        </div>
		<!-- /Main Wrapper -->
		<?php include("js.php"); ?>
		
    </body>

</html>