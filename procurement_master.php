<?php
$page = "procurment_master";
if($page=="procurment_master"){
	$procurment_master="active";
}
include('includes/connection.php');
$sql="SELECT  MAX(material_request_id) FROM material_request";
$result = db_query($sql);
if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) { $last_material_request_id=$row["material_request_id"]; } } $last_material_request_id=$last_material_request_id+1; if (date('m') > 6) { $year = date('y')."-".(date('y') +1);
} else { $year = (date('y')-1)."-".date('y'); } $Material_Request_No="MRQ/".$year."/".str_pad($last_material_request_id,4,"0",STR_PAD_LEFT); ?>
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
            .pm_box {
                padding-bottom: 2rem;
                padding-top: 2rem;
                padding-left: 10px;
                padding-right: 10px;
                border: 1px solid #ebebeb;
                text-align: center;
                position: relative;
                display: block;
                -webkit-transition: all 0.25s ease;
                transition: all 0.25s ease;
                margin-bottom: 1rem;
                border-radius: 6px;
                background-color: #fff;
                -webkit-box-shadow: 0px 2px 4px rgba(126, 142, 177, 0.12);
                box-shadow: 0px 2px 4px rgba(126, 142, 177, 0.12);
                color: #000;
            }
            .pm_box .icon {
                font-size: 2.43rem;
                font-weight: 500;
                letter-spacing: 1px;
                line-height: 1.2;
                display: block;
                vertical-align: middle;
                -webkit-transition: all 0.25s ease;
                transition: all 0.25s ease;
            }
            .pm_box .labeltext {
                display: block;
                font-size: 15px;
                margin-top: 10px;
            }
            .pm_box:hover {
                -webkit-transform: translateY(-5px) scale(1.02);
                transform: translateY(-5px) scale(1.02);
                -webkit-box-shadow: 0px 5px 12px rgba(126, 142, 177, 0.2);
                box-shadow: 0px 5px 12px rgba(126, 142, 177, 0.2);
            }
            .pm_box:hover .icon {
                color: #ff0000;
                -webkit-transform: scale(1.1) translateY(-3px);
                transform: scale(1.1) translateY(-3px);
            }
            .pm_box:hover,
            .pm_box:hover .labeltext {
                color: #ff0000;
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
                            <div class="col-sm-12">
                                <h3 class="page-title">Procurement</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="#null">Procurement</a></li>
                                    <li class="breadcrumb-item active">Master</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->
                    <div class="row">
                        <div class="col-xl-2 text-center">
                            <a href="procurment_master_unit_master.php" class="pm_box">
                                <div class="icon"><i class="fa fa-balance-scale" aria-hidden="true"></i></div>
                                <span class="labeltext">Unit</span>
                            </a>
                        </div>
                        <div class="col-xl-2 text-center">
                            <a href="procurment_master_tax_code_master.php" class="pm_box">
                                <div class="icon"><i class="fa fa-codepen" aria-hidden="true"></i></div>
                                <span class="labeltext">Tax Code</span>
                            </a>
                        </div>
                        <div class="col-xl-2 text-center">
                            <a href="procurment_master_ware_house_master.php" class="pm_box">
                                <div class="icon"><i class="fa fa-window-restore" aria-hidden="true"></i></div>
                                <span class="labeltext">Ware House</span>
                            </a>
                        </div>
                        <div class="col-xl-2 text-center">
                            <a href="procurment_master_item_category_master.php" class="pm_box">
                                <div class="icon"><i class="fa fa-cubes" aria-hidden="true"></i></div>
                                <span class="labeltext">Item Category</span>
                            </a>
                        </div>
                        <div class="col-xl-2 text-center">
                            <a href="procurment_master_item_master.php" class="pm_box">
                                <div class="icon"><i class="fa fa-cube" aria-hidden="true"></i></div>
                                <span class="labeltext">Item</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /Page Wrapper -->
        </div>

        <!-- /Main Wrapper -->

        <!-- jQuery -->
        <?php include('js.php');?>
    </body>
</html>
