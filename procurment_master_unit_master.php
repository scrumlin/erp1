<?php 
$page = "procurment_master";
if($page=="procurment_master"){
	$procurment_master="active";
}
include('includes/connection.php');
// print_r($connect);
// die();
if(isset($_POST['submit']))
		{
// 			print_r($_POST['submit']);
// die();
		$code=$connect->real_escape_string($_POST['code']);
		$name=$connect->real_escape_string($_POST['name']);
		
		$uid=$_SESSION['id'];
	    $creation_date=date("Y-m-d");
		
		

		$check="SELECT * FROM unit_master WHERE code='$code'";
		$result = db_query($check);
		 $checkrows=mysqli_num_rows($result); 
		    if($checkrows>0) {
		        ?>
		         <script type="text/javascript"> 
		        alert('Ware House Code already Exits');
		        window.close();
		        window.location.href='procurment_master_unit_master.php';
		    </script>
		    <?php 		     
		   } else {  
		    //insert results from the form input
		      $query = "INSERT INTO `unit_master`(`code`, `name`, `creation_date`, `created_by`) VALUES('$code','$name','$creation_date','$uid')";
		      // print_r($query);
		      // die(); 
		      $result = db_query($query);
		      header("location:procurment_master_unit_master.php");
		      
		    }

		}

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

		<style>

		</style>

    </head>

    <body>

	

		<!-- Main Wrapper -->

        <div class="main-wrapper">		

			<!-- Header -->

            <?php include('includes/top_header.php');?>

            <?php include('includes/sidebar.php');?>
			<!-- /Sidebar -->						

			<!-- Page Wrapper -->

            <div class="page-wrapper">

                <div class="content container-fluid">				

					<!-- Page Header -->

					<div class="page-header">

						<div class="row">

							<div class="col-sm-7 col-auto">

								<h3 class="page-title">Unit Master</h3>

								<ul class="breadcrumb">

									<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>

									<li class="breadcrumb-item"><a href="procurement_master.php">Master</a></li>

									<li class="breadcrumb-item active">Unit Master</li>

								</ul>

							</div>

							<div class="col-sm-5 col">

								<a href="#add_unit" data-toggle="modal" class="btn top-right-button float-right mt-2">Add Unit</a>

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

													<th>Unit Code</th>

													<th>Unit Name</th>

													<th class="text-right">Actions</th>

												</tr>

											</thead>

											<tbody>
												<?php
													$sql_fetch="SELECT * FROM unit_master ORDER BY code DESC";
													$result_fetch=db_query($sql_fetch);
													$c=1;
													while($row = $result_fetch->fetch_assoc()){

											      	$id=$row['id']; 
												?>
												<tr>

													<td><?php echo $c;?></td>		

													<td><?php echo $row['code']?></td>

													<td><?php echo $row['name']?></td>

													<td class="text-right">

														<div class="actions">

															<a data-id="<?php echo $id;?>" class="btn btn-sm bg-success-light edit-btn" 
																onclick="show_unitmodal('<?php echo $id;?>')" ><i class="fe fe-pencil"></i> Edit</a>
															<a  data-toggle="modal" href="#delete_modal<?php echo $row["id"];?>" class="btn btn-sm bg-danger-light">
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

							<h5 class="modal-title">Add Unit</h5>

							<button type="button" class="close" data-dismiss="modal" aria-label="Close">

								<span aria-hidden="true">&times;</span>

							</button>

						</div>

						<div class="modal-body">

							<form action="procurment_master_unit_master.php" method="POST">

								<div class="row form-row">

									<div class="col-12 col-sm-12">

										<div class="form-group required">

											<label class="control-label">Unit Code</label>									<input type="text" class="form-control" placeholder="Enter  unit Code" name="code" readonly="readonly" value="<?php $last_no=0;
												$serial_no=0; 
												$seql = "SELECT * FROM unit_master";
												$fetch_data = db_query($seql); 
										        if ($fetch_data ->num_rows > 0) 
										        { 
											        $fetch_maxn="SELECT MAX(id) AS serial_no FROM unit_master";
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
										        $string_name="UNIT";
										        echo $string_name.str_pad($serial_no,5,'0',STR_PAD_LEFT);
										        ?>">
										</div>

									</div>

									<div class="col-12 col-sm-12">

										<div class="form-group required">

											<label class="control-label">Unit Name</label>

											<input type="text" class="form-control" id="uName" name="name" value="" placeholder="Enter Unit Name">

										</div>

									</div>									

								</div>	

								<button type="submit" name="submit" class="btn btn-info btn-block">Save</button>

							</form>

						</div>

					</div>

				</div>

			</div>

			<!-- /ADD Modal -->

			

			<!-- Edit Modal -->

			<div class="modal fade" id="edit_unit" aria-hidden="true" role="dialog">

				<div class="modal-dialog modal-dialog-centered" role="document" >

					<div class="modal-content">

						<div class="modal-header">

							<h5 class="modal-title">Edit Unit</h5>

							<button type="button" class="close" data-dismiss="modal" aria-label="Close">

								<span aria-hidden="true">&times;</span>

							</button>

						</div>

						<div class="modal-body">

							<form action="" id="edit_unit1" name="edit_unit1">

								<div class="row form-row">

									<div class="col-12 col-sm-12">

										<div class="form-group required">

											<label class="control-label">Unit Code</label>											

											<input type="text" class="form-control"  name="code" id="code">

										</div>

									</div>

									<div class="col-12 col-sm-12">

										<div class="form-group required">

											<label class="control-label">Unit Name</label>

											<input type="text" class="form-control" id="name" name="name" >

										</div>

									</div>									

								</div>	

								<input type="hidden" name="unit_id" value="" id="unit_id">
								<button type="submit" class="btn btn-success btn-edit">Save Changes</button>
							</form>

						</div>

					</div>

				</div>

			</div>

			<!-- /Edit Modal -->

			<?php

    $sql1="SELECT * FROM unit_master";
    // print_r($sql1);
    // die();
    $result = db_query($sql1);
    

  	if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()){
 $id=$row['id'];
?>


			<!-- Delete Modal -->

			<div class="modal fade" id="delete_modal<?php echo $row["id"];?>" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">

						<div class="modal-body">
							<div class="form-content p-2">
								<form action="delete_unit.php?id=<?php echo $id?>" method="post">
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