<?php 
include('includes/connection.php');
// print_r($connect);
// die();
if(isset($_POST['submit']))
		{
// 			print_r($_POST['submit']);
// die();
		$code=$connect->real_escape_string($_POST['code']);
		
		$item_name=$connect->real_escape_string($_POST['item_name']);

		$item_category=$connect->real_escape_string($_POST['item_category']);

		$level=$connect->real_escape_string($_POST['level']);

		$gst_rate=$connect->real_escape_string($_POST['gst_rate']);

		$gst=$connect->real_escape_string($_POST['gst']);

		$desc=$connect->real_escape_string($_POST['desc']);

		$purchase_unit=$connect->real_escape_string($_POST['purchase_unit']);

		$length=$connect->real_escape_string($_POST['length']);

		$height=$connect->real_escape_string($_POST['height']);

		$sale_unit =$connect->real_escape_string($_POST['sale_unit']);

		$width=$connect->real_escape_string($_POST['width']);

		$weight=$connect->real_escape_string($_POST['weight']);

		$uid=$_SESSION['id'];

	    $creation_date=date("Y-m-d");
		
		

		$check="SELECT * FROM tax_code_master WHERE code='$code'";
		$result = db_query($check);
		 $checkrows=mysqli_num_rows($result); 
		    if($checkrows>0) {
		        ?>
		         <script type="text/javascript"> 
		        alert('TAx Code already Exits');
		        window.close();
		        window.location.href='procurment_master_item_master.php';
		    </script>
		    <?php 		     
		   } else {  
		    //insert results from the form input
		      $query = "INSERT INTO `item_master`(`code`, `item_name`, `item_category`, `level`, `gst_rate`, `gst`, `description`, `purchase_unit`, `length`, `height`, `sale_unit`, `width`, `weight`, `creation_date`, `created_by`) VALUES('$code','$item_name','$item_category','$level','$gst_rate','$gst','$desc','$purchase_unit','$length','$height','$sale_unit','$width','$weight','$creation_date','$uid')";
		      // print_r($query);
		      // die(); 
		      $result = db_query($query);
		      header("location:procurment_master_item_master.php");
		      
		    }

		}

?>





<!DOCTYPE html>

<html lang="en">

 

<head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

        <title>Maxim ERP</title>

		

		<!-- Favicon -->

        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

		

		<!-- Bootstrap CSS -->

        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

		

		<!-- Fontawesome CSS -->

        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

		

		<!-- Feathericon CSS -->

        <link rel="stylesheet" href="assets/css/feathericon.min.css">

		

		<!-- Datatables CSS -->

		<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">

		

		<!-- Select2 CSS -->

		<link rel="stylesheet" href="assets/css/select2.min.css">



		<!-- Main CSS -->

        <link rel="stylesheet" href="assets/css/style.css">

		

		<!-- Custom Common CSS -->

		<link rel="stylesheet" href="assets/css/custom_common.css">

		

		<!--[if lt IE 9]>

			<script src="assets/js/html5shiv.min.js"></script>

			<script src="assets/js/respond.min.js"></script>

		<![endif]-->

		

    </head>

    <body>

	

		<!-- Main Wrapper -->

        <div class="main-wrapper">		

			<!-- Header -->

            <div class="header">			

				<!-- Logo -->

                <div class="header-left">

                    <a href="index.html" class="logo">

						<img src="assets/img/maxim_logo.png" alt="Logo">

					</a>

					<a href="index.html" class="logo logo-small">

						<img src="assets/img/logo-small.png" alt="Logo" width="30" height="30">

					</a>

                </div>

				<!-- /Logo -->

				

				<a href="javascript:void(0);" id="toggle_btn">

					<i class="fe fe-text-align-left"></i>

				</a>

				

				<!-- Mobile Menu Toggle -->

				<a class="mobile_btn" id="mobile_btn">

					<i class="fa fa-bars"></i>

				</a>

				<!-- /Mobile Menu Toggle -->				

            </div>

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

								<h3 class="page-title">Add Item</h3>

								<!-- <h3 class="page-title">Edit Item</h3> -->

								<ul class="breadcrumb">

									<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>

									<li class="breadcrumb-item"><a href="#">Master</a></li>

									<li class="breadcrumb-item active">Add Item</li>

									<!-- <li class="breadcrumb-item active">Edit Item</li> -->

								</ul>

							</div>

							<div class="col-sm-5 col">

								<a href="procurment_master_item_master.php" data-toggle="modal" class="btn top-right-button float-right mt-2">Back</a>

							</div>

						</div>

					</div>

					<!-- /Page Header -->

					<div class="row">

						<div class="col-sm-12">							
							<form method="POST" action="procurment_master_add_edit_item.php">
							<div class="accordion" id="accordionItem">						

								<div class="card">

									<div class="card-header no_bb" id="addItemGeneral" role="tab" >

										<h4 class="mb-0" data-toggle="collapse" data-target="#itemGeneral">General Information	<i class="fa fa-plus"></i></h4>

									</div>

									<div id="itemGeneral" class="collapse in show" aria-labelledby="addItemGeneral" data-parent="#accordionItem">

										<div class="card-body">

											<div class="row">

												<div class="col-md-6">

													<div class="form-group row required">

														<label class="col-md-4 col-form-label control-label">Item Code </label>

														<div class="col-md-8">

															<input type="text" class="form-control"  name="code" readonly="readonly" value="<?php $last_no=0;
												$serial_no=0; 
												$seql = "SELECT * FROM item_master";
												$fetch_data = db_query($seql); 
										        if ($fetch_data ->num_rows > 0) 
										        { 
											        $fetch_maxn="SELECT MAX(id) AS serial_no FROM item_master";
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
										        $string_name="ITEM";
										        echo $string_name.str_pad($serial_no,5,'0',STR_PAD_LEFT);
										        ?>">

														</div>

													</div>

													<div class="form-group row required">

														<label class="col-md-4 col-form-label control-label">Item Name </label>

														<div class="col-md-8">

															<input type="text" class="form-control" placeholder="Enter Item Name" name="item_name">

														</div>

													</div>

													<div class="form-group row required">

														<label class="col-md-4 col-form-label control-label">Item Category </label>

														<div class="col-md-8">

																<div class="form-group">
																				

											<select  class="form-control" name="item_category" required>

												<option value="">Select Item Category</option>
												<?php 
		$cat_query="select * from item_category_master";

		$result = db_query($cat_query);
while ($cat_row= $result->fetch_assoc()) {
?>
<option value="<?php echo $cat_row['id'];?>"><?php echo $cat_row['name'];?></option>
												<?php echo $cat_row['name'];?>
												
											<?php

											 }?>
											
											</select>

										</div>

														</div>

													</div>

												</div>



												<div class="col-md-6">

													<div class="form-group row required">

														<label class="col-md-4 col-form-label control-label">Reorder Level </label>

														<div class="col-md-8">

															<input type="text" class="form-control" placeholder="Enter Reorder Level" name="level">

														</div>

													</div>

													<div class="form-group row required">

														<label class="col-md-4 col-form-label control-label">GST Rate </label>

														<div class="col-md-8">

															<input type="text" class="form-control" placeholder="Enter GST Rate" name="gst_rate">

														</div>

													</div>

													<div class="form-group row required">

														<label class="col-md-4 col-form-label control-label">GST Category </label>

														<div class="col-md-8">

															<select class="select" name="gst">

																<option selected>...</option>

																<option value="CGST">CGST</option>

																<option value="SGST">SGST</option>

															</select>

														</div>

													</div>

												</div>

												<div class="col-md-12">

													<div class="form-group row required">

														<label class="col-md-2 col-form-label control-label">Description</label>

														<div class="col-md-10">

															<textarea class="form-control" placeholder="Enter Description" name="desc" rows="1"></textarea>

														</div>

													</div>	

												</div>

											</div>

										</div>

									</div>

								</div>

								<div class="card">

									<div class="card-header no_bb" id="addItemUnit" role="tab" >

										<h4 class="mb-0" data-toggle="collapse" data-target="#itemUnit">Unit Information	<i class="fa fa-plus"></i></h4>

									</div>

									<div id="itemUnit" class="collapse" aria-labelledby="addItemUnit" data-parent="#accordionItem">

										<div class="card-body">

											<div class="row">												

												<div class="col-md-6">

													<div class="form-group row required">

														<label class="col-md-4 col-form-label control-label custom-text-14">Default Purchase Unit</label>

														<div class="col-md-8">

															<input type="text" class="form-control" placeholder="Enter Default Purchase Unit" name="purchase_unit">

														</div>

													</div>

													<div class="form-group row required">

														<label class="col-md-4 col-form-label control-label">Length</label>

														<div class="col-md-8">

															<input type="text" class="form-control" placeholder="Enter Length" name="length">

														</div>

													</div>

													<div class="form-group row required">

														<label class="col-md-4 col-form-label control-label">Height</label>

														<div class="col-md-8">

															<input type="text" class="form-control" placeholder="Enter Height" name="height">

														</div>

													</div>

												</div>



												<div class="col-md-6">

													<div class="form-group row required">

														<label class="col-md-4 col-form-label control-label">Default Sales Unit</label>

														<div class="col-md-8">

															<input type="text" class="form-control" placeholder="Enter Default Sales Unit" name="sale_unit">

														</div>

													</div>

													<div class="form-group row required">

														<label class="col-md-4 col-form-label control-label">Width</label>

														<div class="col-md-8">

															<input type="text" class="form-control" name="width" placeholder="Enter Width">

														</div>

													</div>

													<div class="form-group row required">

														<label class="col-md-4 col-form-label control-label">Weight</label>

														<div class="col-md-8">

															<input type="text" class="form-control" name="weight" placeholder="Enter Weight">

														</div>

													</div>

												</div>

											</div>

										</div>

									</div>

								</div>

							</div>
							<div class="col-12">	
								<div class="col-4">
								</div>
								<div class="col-4">
							<button type="submit" name="submit" class="btn btn-info btn-block">Save</button>
						</div>
						<div class="col-4">
								</div>
						</div>
						</form>
						</div>			

					</div>

				</div>			

			</div>

			<!-- /Page Wrapper -->

			

			

			

        </div>

		<!-- /Main Wrapper -->

		

		<!-- jQuery -->

        <script src="assets/js/jquery-3.2.1.min.js"></script>

		

		<!-- Bootstrap Core JS -->

        <script src="assets/js/popper.min.js"></script>

        <script src="assets/js/bootstrap.min.js"></script>

		

		<!--Select2 js-->

		<script src="assets/js/select2.min.js"></script>



		<!-- Slimscroll JS -->

        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

		

		<!-- Datatables JS -->

		<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>

		<script src="assets/plugins/datatables/datatables.min.js"></script>

		

		<!-- Custom JS -->

		<script  src="assets/js/script.js"></script>

		<script>

			$(document).ready(function(){

				// Add minus icon for collapse element which is open by default

				$(".collapse.show").each(function(){

					$(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");

				});

				

				// Toggle plus minus icon on show hide of collapse element

				$(".collapse").on('show.bs.collapse', function(){

					$(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");

				}).on('hide.bs.collapse', function(){

					$(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");

				});

				$(".collapse.show").each(function(){

					$(this).prev(".card-header").addClass("bb").removeClass("no_bb");

				});

				

				// Toggle plus minus icon on show hide of collapse element

				$(".collapse").on('show.bs.collapse', function(){

					$(this).prev(".card-header").removeClass("no_bb").addClass("bb");

				}).on('hide.bs.collapse', function(){

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



				img.onload = function() {

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



			  img.onload = function() {

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