<?php
$page = "procurment_master";
if($page=="procurment_master"){
	$procurment_master="active";
}
include('includes/connection.php');

?>



<!DOCTYPE html>

<html lang="en">

 

<head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

        <title>Maxim ERP</title>

		
		<?php include('includes/css.php');?>

		<!--[if lt IE 9]>

			<script src="assets/js/html5shiv.min.js"></script>

			<script src="assets/js/respond.min.js"></script>

		<![endif]-->

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

								<h3 class="page-title">Item Master</h3>

								<ul class="breadcrumb">

									<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>

									<li class="breadcrumb-item"><a href="procurement_master.php">Master</a></li>

									<li class="breadcrumb-item active">Item Master</li>

								</ul>

							</div>

							<div class="col-sm-5 col">

								<a href="procurment_master_add_edit_item.php" class="btn top-right-button float-right mt-2">Add Item</a>

							</div>

						</div>

					</div>

					<!-- /Page Header -->

					<div class="row">

						<div class="col-sm-12">

							<div class="card">

								<div class="card-body">

									<div class="table-responsive">

										<table class="datatable table table-hover table-center mb-0">

											<thead>

												<tr>

													<th>#</th>

													<th>Item Code</th>

													<th>Item Name</th>

													<th>Item Category</th>

													<th>GST Rate</th>

													<th>GST Category</th>

													<th>Reorder Level</th>

													<th>Description</th>

													<th>Default Purchase Unit</th>

													<th>Default Sales Unit</th>

													<th>Length</th>

													<th>Width</th>

													<th>Height</th>

													<th>Weight</th>

													<th class="text-right">Actions</th>

												</tr>

											</thead>

											<tbody>
												<?php
													$sql_fetch="SELECT * FROM item_master ORDER BY code DESC";
													$result_fetch=db_query($sql_fetch);
													$c=1;
													while($row = $result_fetch->fetch_assoc()){

											      	$id=$row['id']; 

											      	$id1 = $row['item_category'];
											      	$sql_cat="SELECT name from item_category_master WHERE id='$id1'";
											      	$result_cat=db_query($sql_cat);
											      	$row22 = $result_cat->fetch_assoc();
												?>
												<tr>

													<td><?php echo $c;?></td>													

													<td><?php echo $row['code']?></td>	

													<td><?php echo $row['item_name']?></td>						

													<td><?php echo $row22['name']?></td>								
													<td><?php echo $row['level']?></td>		

													<td><?php echo $row['gst_rate']?></td>							
													<td><?php echo $row['gst']?></td>

													<td><?php echo $row['description']?></td>								
													<td><?php echo $row['purchase_unit']?></td>								
													<td><?php echo $row['sale_unit']?></td>							
													<td><?php echo $row['length']?></td>							
													<td><?php echo $row['width']?></td>		

													<td><?php echo $row['height']?></td>							
													<td><?php echo $row['weight']?></td>								
															

													<td class="text-right">

														<div class="actions">

															<a class="btn btn-sm bg-info-light" href="edit_items.php?id=<?php echo $id;?>">

																<i class="fe fe-pencil"></i> Edit

															</a>

															<a  data-toggle="modal" href="#delete_item" class="btn btn-sm bg-danger-light">

																<i class="fe fe-trash"></i> Delete

															</a>

														</div>

													</td>

												</tr>
												<?php $c++;}?>
											</tbody>

										</table>

									</div>

								</div>

							</div>

						</div>			

					</div>

				</div>			

			</div>

			<!-- /Page Wrapper -->

			

			

			<!-- Add Modal -->

			<div class="modal fade" id="add_unit" aria-hidden="true" role="dialog">

				<div class="modal-dialog modal-dialog-centered" role="document" >

					<div class="modal-content">

						<div class="modal-header">

							<h5 class="modal-title">Add Item</h5>

							<button type="button" class="close" data-dismiss="modal" aria-label="Close">

								<span aria-hidden="true">&times;</span>

							</button>

						</div>

						<div class="modal-body">

							<form>

								<div class="row form-row">

									<div class="col-12 col-sm-12">

										<div class="form-group required">

											<label class="control-label">Unit Code</label>											

											<input type="text" class="form-control" id="uCode" name="uCode" value="" placeholder="Enter Unit Code(Ex:- EMPST00002)">

										</div>

									</div>

									<div class="col-12 col-sm-12">

										<div class="form-group required">

											<label class="control-label">Unit Name</label>

											<input type="text" class="form-control" id="uName" name="uName" value="" placeholder="Enter Unit Name">

										</div>

									</div>									

								</div>	

								<button type="submit" class="btn btn-info btn-block">Save</button>

							</form>

						</div>

					</div>

				</div>

			</div>

			<!-- /ADD Modal -->

			

			

			<?php

    $sql1="SELECT * FROM item_master";
    // print_r($sql1);
    // die();
    $result = db_query($sql1);
    

  	if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()){
 $id=$row['id'];
?>


			<!-- Delete Modal -->

			<div class="modal fade" id="delete_modal<?php echo $row['id'];?>" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">

						<div class="modal-body">
							<div class="form-content p-2">
								<form action="delete_item_master.php?id=<?php echo $id?>" method="post">
								<center><h4 class="modal-title">Delete</h4><center>
								<center><p class="mb-4">Are you sure to delete?</p><center>
								<button type="submit" class="btn btn-success">Yes </button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
								</form>
							</div>
						</div>
					
					</div>
				</div>
			</div>

			<!-- /Delete Modal -->
<?php } }?>
        </div>

			<!-- /Delete Modal -->

        </div>

		<!-- /Main Wrapper -->

		

		<!-- jQuery -->

        <?php include('js.php');?>