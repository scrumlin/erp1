<?php 
session_start();
if(!isset($_SESSION['id']))
{
    header('location:index.php');
}
$page = "pt_material_request";
if($page=="pt_material_request"){
	$pt_material_request="active";
}
include('includes/connection.php');

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />

        <title>Maxim ERP</title>

        <?php include('includes/css.php');?>
        <!--[if lt IE 9]>
            <script src="assets/js/html5shiv.min.js"></script>

            <script src="assets/js/respond.min.js"></script>
        <![endif]-->

        <style>
            .custom-blue-btn {
                background-color: #334f9a;
                color: #fff;
            }
            .custom-blue-btn:hover {
                color: #fff;
            }
        </style>
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
                                <h3 class="page-title">Material Request</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="#">Procurement</a></li>
                                    <li class="breadcrumb-item"><a href="#">Transactions</a></li>
                                    <li class="breadcrumb-item active">Material Request</li>
                                </ul>
                            </div>
                            <div class="col-sm-5 col">
                                <a href="procurment_transactions_add_edit_material_request.php" class="btn custom-blue-btn float-right mt-2">New Material Request</a>
                            </div>
                        </div>
                    </div>

                    <!-- /Page Header -->
                    <!-- Inner Page Header 2 -->
                    <nav class="inner-navbar2 bg-success">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-link active" id="nav-pendingRequest-tab" data-toggle="tab" href="#nav-pendingRequest" role="tab" aria-controls="nav-pendingRequest" aria-selected="true">Material Request Vouchers</a>
                        </div>
                    </nav>
                    <!-- /Inner Page Header 2 -->
                    <!--Inner Page Wrapper-->
                    <div class="container-fluid pl-0 pr-0">
                        <div class="tab-content" id="nav-tabContent">
                            <!--Pending Material Request-->
                            <div class="tab-pane fade show active" id="nav-pendingRequest" role="tabpanel" aria-labelledby="nav-pendingRequest-tab">
                                <table class="datatable table table-hover table-center mb-0">
                                    <thead class="thead-green">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">
                                                <input type="checkbox" id="" />
                                            </th>
                                            <th scope="col">MR Date</th>
                                            <th scope="col">Material Request No</th>
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
										$sql_fetch="SELECT mr.material_request_dt, mr.material_request_no, pl.location_name, im.item_name, im.description, mri.quantity, mr.created_dt, mr.created_by, a.user_name FROM material_request AS mr LEFT JOIN payroll_locations AS pl ON mr.branch=pl.location_id LEFT JOIN material_request_item AS mri ON mri.material_request_id=mr.material_request_id LEFT JOIN item_master AS im ON im.id=mri.item LEFT JOIN admin_login AS a ON mr.created_by=a.id ORDER BY mr.created_dt ASC ";
										$result_fetch=db_query($sql_fetch);
										$c=1;
										while($row = $result_fetch->fetch_assoc()){ ?>
                                        <tr>
                                            <td class="text-right"><?php echo $c;?></td>
                                            <td><input type="checkbox" id="" /></td>
                                            <td><?php echo date("d/m/Y", strtotime($row['material_request_dt'])); ?></td>
                                            <td><?php echo $row['material_request_no']?></td>
                                            <td><?php echo $row['location_name'];?></td>
                                            <td><?php echo $row['item_name'];?></td>
                                            <td><?php echo $row['description'];?></td>
                                            <td><?php echo $row['quantity'];?></td>
                                            <td><?php echo date("d/m/Y", strtotime($row['created_dt']));?></td>
                                            <td><?php echo $row['user_name'];?></td>
                                            <td></td>
                                        </tr>
                                        <?php $c++;}?>
                                    </tbody>
                                </table>
                            </div>
                            <!--/Pending Material Request-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /Page Wrapper -->

        <!-- jQuery -->

        <?php include('js.php');?>
    </body>
</html>
