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



		



		<link rel="stylesheet" href="assets/plugins/morris/morris.css">



		



		<!-- Select2 CSS -->



		<link rel="stylesheet" href="assets/css/select2.min.css">



		



		<!-- Main CSS -->



        <link rel="stylesheet" href="assets/css/style.css">



        <style>



			.pm_box {padding-bottom:2rem; padding-top:2rem; padding-left: 10px;  padding-right: 10px; border: 1px solid #ebebeb; text-align: center;position: relative;display: block; -webkit-transition: all 0.25s ease; transition: all 0.25s ease; margin-bottom: 1rem;border-radius: 6px; background-color: #fff; -webkit-box-shadow: 0px 2px 4px rgba(126, 142, 177, 0.12); box-shadow: 0px 2px 4px rgba(126, 142, 177, 0.12); color:#000;}



			.pm_box .icon { font-size: 2.43rem; font-weight: 500; letter-spacing: 1px; line-height: 1.2; display:block; vertical-align: middle; -webkit-transition: all 0.25s ease; transition: all 0.25s ease;}



			.pm_box .labeltext{display: block; font-size: 15px; margin-top: 10px;}



			.pm_box:hover { -webkit-transform: translateY(-5px) scale(1.02); transform: translateY(-5px) scale(1.02); -webkit-box-shadow: 0px 5px 12px rgba(126, 142, 177, 0.2); box-shadow: 0px 5px 12px rgba(126, 142, 177, 0.2);}



			.pm_box:hover .icon{color: #00af50; -webkit-transform: scale(1.1) translateY(-3px); transform: scale(1.1) translateY(-3px);}



			.pm_box:hover, .pm_box:hover .labeltext{ color:#00662f;}



		</style>



		



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

            <div class="sidebar" id="sidebar">

                <div class="sidebar-inner slimscroll">

					<div id="sidebar-menu" class="sidebar-menu">

						<ul>

							<li> 

								<a href="index.html"><i class="fe fe-home"></i> <span style="color:#ff0;">Dashboard1111</span></a>

							</li>

                            <li>

                            	<a href="javascript:void(0);"><i class="fa fa-gear"></i><span>Masters</span></a>

                            </li>

                            <li class="submenu">

                            	<a href="javascript:void(0);"><i class="fa fa-cubes"></i><span>Procurement</span><span class="menu-arrow"></span></a>

                                <ul class="smenu">
                                    <li><a href="procurement_master.php" class="active"><span>Masters</span> </a></li>
                                	<!--<li class="submenu"><a href="javascript:void(0);"><span>Masters</span> <span class="menu-arrow"></span></a>

                                    	<ul class="smenu">

                                            <li><a href="procurment_master_item_master.html">Item Master</a></li>

                                            <li><a href="procurment_master_item_category_master.html">Item Category Master</a></li>

                                            <li><a href="procurment_master_tax_code_master.html">Tax Code Master</a></li>

											<li><a href="procurment_master_unit_master.html">Unit Master</a></li>

                                            <li><a href="procurment_master_ware_house_master.html">Ware House Master</a></li>

                                        </ul>

                                    </li>-->

                                    <li class="submenu"><a href="javascript:void(0);"><span>Transactions</span> <span class="menu-arrow"></span></a>

                                    	<ul class="smenu">

                                            

											<li><a href="procurment_transactions_material_request.html">Material Request</a></li>

                                            <li><a href="procurment_transactions_material_issue.html">Material Issue</a></li>

                                            <li><a href="procurment_transactions_material_receipts.html">Material Receipts</a></li>

											<li><a href="procurment_transactions_material_consumption.html">Material Consumption</a></li>

                                        </ul>

                                    </li>

                                    <li class="submenu"><a href="javascript:void(0);"><span>Reports</span> <span class="menu-arrow"></span></a>

                                    	<ul class="smenu">

                                            <li><a href="javascript:void(0);">Report 1</a></li>

                                            <li><a href="javascript:void(0);">Report 2</a></li>

                                            <li><a href="javascript:void(0);">Report 3</a></li>

                                            <li><a href="javascript:void(0);">Report 4</a></li>

                                        </ul>

                                    </li>

                                </ul>

                            </li>

                            <li class="submenu">

                            	<a href="javascript:void(0);"><i class="fa fa-bank"></i><span>Accounts</span><span class="menu-arrow"></span></a>

                                <ul class="smenu">

                                	<li><a href="account_master.html"><span>Masters</span> </a></li>

                                    <li class="submenu"><a href="javascript:void(0);"><span>Transactions</span> <span class="menu-arrow"></span></a>

                                    	<ul class="smenu">

                                            <li><a href="javascript:void(0);">Transactions 1</a></li>

                                            <li><a href="javascript:void(0);">Transactions 2</a></li>

                                            <li><a href="javascript:void(0);">Transactions 3</a></li>

                                            <li><a href="javascript:void(0);">Transactions 4</a></li>

                                        </ul>

                                    </li>

                                    <li class="submenu"><a href="javascript:void(0);"><span>Reports</span> <span class="menu-arrow"></span></a>

                                    	<ul class="smenu">

                                            <li><a href="javascript:void(0);">Report 1</a></li>

                                            <li><a href="javascript:void(0);">Report 2</a></li>

                                            <li><a href="javascript:void(0);">Report 3</a></li>

                                            <li><a href="javascript:void(0);">Report 4</a></li>

                                        </ul>

                                    </li>

                                </ul>

                            </li>

                            <li class="submenu">

                            	<a href="javascript:void(0);"><i class="fa fa-group"></i><span>HR & Payroll</span><span class="menu-arrow"></span></a>

                                <ul class="smenu">

                                	<li><a href="payroll_master.html" ><span>Masters</span></a> </li>

                                    <li class="submenu"><a href="javascript:void(0);"><span>Transactions</span> <span class="menu-arrow"></span></a>

                                    	<ul class="smenu">

                                            <li><a href="employee_detail.html"><span>Employee Detail</span></a></li>

                                            <li><a href="attendance.html"><span>Attendance</span></a></li>

                                            <li><a href="employee_earnings_deductions.html"><span>Earnings & Deductions</span></a></li>

                                            <li><a href="monthly_deductions.html"><span>Monthly Deductions</span></a></li>

                                            <li><a href="monthly_earnings.html"><span>Monthly Earnings</span></a></li>

                                            <li><a href="payroll_processing.html"><span>Payroll Processing</span></a></li>

                                        </ul>

                                    </li>

                                    <li class="submenu"><a href="javascript:void(0);"><span>Reports</span> <span class="menu-arrow"></span></a>

                                    	<ul class="smenu">

                                            <li><a href="javascript:void(0);">Report 1</a></li>

                                            <li><a href="javascript:void(0);">Report 2</a></li>

                                            <li><a href="javascript:void(0);">Report 3</a></li>

                                            <li><a href="javascript:void(0);">Report 4</a></li>

                                        </ul>

                                    </li>

                                </ul>

                            </li>

							<li class="submenu">

                            	<a href="javascript:void(0);"><i class="fa fa-gears"></i><span>Maintenance</span><span class="menu-arrow"></span></a>

                                <ul class="smenu">

                                	<li class="submenu"><a href="javascript:void(0);"><span>Masters</span> <span class="menu-arrow"></span></a>

                                    	<ul class="smenu">

                                            <li><a href="javascript:void(0);">Masters 1</a></li>

                                            <li><a href="javascript:void(0);">Masters 2</a></li>

                                            <li><a href="javascript:void(0);">Masters 3</a></li>

                                            <li><a href="javascript:void(0);">Masters 4</a></li>

                                        </ul>

                                    </li>

                                    <li class="submenu"><a href="javascript:void(0);"><span>Transactions</span> <span class="menu-arrow"></span></a>

                                    	<ul class="smenu">

                                            <li><a href="javascript:void(0);">Transactions 1</a></li>

                                            <li><a href="javascript:void(0);">Transactions 2</a></li>

                                            <li><a href="javascript:void(0);">Transactions 3</a></li>

                                            <li><a href="javascript:void(0);">Transactions 4</a></li>

                                        </ul>

                                    </li>

                                    <li class="submenu"><a href="javascript:void(0);"><span>Reports</span> <span class="menu-arrow"></span></a>

                                    	<ul class="smenu">

                                            <li><a href="javascript:void(0);">Report 1</a></li>

                                            <li><a href="javascript:void(0);">Report 2</a></li>

                                            <li><a href="javascript:void(0);">Report 3</a></li>

                                            <li><a href="javascript:void(0);">Report 4</a></li>

                                        </ul>

                                    </li>

                                </ul>

                            </li>

							<li class="submenu">

                            	<a href="javascript:void(0);"><i class="fa fa-gears"></i><span>Settings</span><span class="menu-arrow"></span></a>

                                <ul class="smenu">

									<li><a href="manageeuser.html"><i class="fe fe-users"></i> <span>Manage User</span></a></li>

									<li><a href="changepassword.html"><i class="fa fa-unlock-alt" aria-hidden="true"></i> <span>Change Password</span></a></li>

								</ul>					

							</li>

							<li><a href="login.html"><i class="fa fa-power-off" aria-hidden="true"></i> <span style="color:#ff0;">Logout</span></a>

						</ul>

					</div>

                </div>

            </div>

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



									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>



									<li class="breadcrumb-item"><a href="#null">Procurement</a></li>



									<li class="breadcrumb-item active">Master</li>



								</ul>



							</div>



						</div>



					</div>



					<!-- /Page Header -->				



					<div class="row">



						<div class="col-xl-2 text-center">



							<a href="procurment_master_unit_master.html" class="pm_box"><div class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div><span class="labeltext">Unit Master</span></a>



						</div> 



						<div class="col-xl-2 text-center">



							<a href="procurment_master_tax_code_master.html" class="pm_box"><div class="icon"><i class="fa fa-sitemap" aria-hidden="true"></i></div><span class="labeltext">Tax Code Master</span></a>



						</div>



						<div class="col-xl-2 text-center">



							<a href="procurment_master_ware_house_master.html" class="pm_box"><div class="icon"><i class="fa fa-window-restore" aria-hidden="true"></i></div><span class="labeltext">Ware House Master</span></a>



						</div>



						<div class="col-xl-2 text-center">



							<a href="procurment_master_item_master.html" class="pm_box"><div class="icon"><i class="fa fa-dashboard" aria-hidden="true"></i></div><span class="labeltext">Item Master</span></a>



						</div>



						<div class="col-xl-2 text-center">



							<a href="procurment_master_item_category_master.html" class="pm_box"><div class="icon"><i class="fa fa-bar-chart" aria-hidden="true"></i></div><span class="labeltext">Item Category Master</span></a>



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



		



		<!-- Slimscroll JS -->



        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>



		



		<script src="assets/plugins/raphael/raphael.min.js"></script>    



		<script src="assets/plugins/morris/morris.min.js"></script>  



		<script src="assets/js/chart.morris.js"></script>



		



		<!-- Select2 JS -->



		<script src="assets/js/select2.min.js"></script>



		



		<!-- Custom JS -->



		<script  src="assets/js/script.js"></script>



		<script>



		$("#add_new").click(function () { 







			$("#maintable").each(function () {



			   



				var tds = '<tr>';



				jQuery.each($('tr:last td', this), function () {



					tds += '<td>' + $(this).html() + '</td>';



				});



				tds += '</tr>';



				if ($('tbody', this).length > 0) {



					$('tbody', this).append(tds);



				} else {



					$(this).append(tds);



				}



			});



		});



		</script>



    </body>







</html>