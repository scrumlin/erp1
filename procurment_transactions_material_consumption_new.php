<?php
include('includes/connection.php');
$page = "pt_material_consumption";
if($page=="pt_material_consumption"){
	$pt_material_consumption="active";
}

session_start();
if(!isset($_SESSION['id']))
{
    header('location:index.php');
}
if(isset($_GET['id'])){
	$id=$_GET['id'];
}
if(isset($_POST['submit']))
{
    if(isset($_GET['id'])){
        //$_POST['row_count']  Post no of rows in table 
        $query1="SELECT COUNT(consumption_item_id) AS cnt FROM material_consumption_item where consumption_id='$id'";
		$result1= db_query($query1);
		//echo $query1;
		while($row1=mysqli_fetch_assoc($result1))
		{
            $cnt=$row1[cnt];
        }
        
        //echo $cnt;
        for($i=0;$i<=$cnt;$i++)
        {
            if($connect->real_escape_string($_POST['wareHouse'][$i]))
            {
                $wareHouse=$connect->real_escape_string($_POST['wareHouse'][$i]);
                $item=$connect->real_escape_string($_POST['item'][$i]);
                $quantity=$connect->real_escape_string($_POST['quantity'][$i]);
                $subSection=$connect->real_escape_string($_POST['subSection'][$i]); 
                $purposeOfUtilization=$connect->real_escape_string($_POST['purposeOfUtilization'][$i]); 
                $consumption_item_id=$connect->real_escape_string($_POST['consumption_item_id'][$i]); 
                $query = "UPDATE `material_consumption_item` set `warehouse`='$wareHouse', `item`='$item', `qty`='$quantity', `sub_section`='$subSection',`purpose`='$purposeOfUtilization' where consumption_item_id ='$consumption_item_id' ";
                $result = db_query($query);
            }
            //echo $query;
        }
        
        //die();
    }
    else{
        $Material_Consumption_No=$connect->real_escape_string($_POST['Material_Consumption_No']); 
        $branch=$connect->real_escape_string($_POST['branch']); 
        //$request_by=$connect->real_escape_string($_POST['request_by']); 
        $material_consumption_date=$connect->real_escape_string($_POST['material_consumption_date']);
        $department=$connect->real_escape_string($_POST['department']); 
        $narration=$connect->real_escape_string($_POST['narration']); 
        $uid=$_SESSION['id'];
        $creation_date=date("Y-m-d");
        //echo $material_req_no;
        //insert results from the form input
        $query = "INSERT INTO `material_consumption`(`consumption_no`, `consumption_dt`, `branch`, `department`, `narration`, `created_by`, `created_dt`) 
        VALUES('$Material_Consumption_No','$material_consumption_date','$branch','$department','$narration','$uid','$creation_date')";
        //echo $query;
        $result = db_query($query);
        $sql="SELECT consumption_id  FROM material_consumption ORDER BY consumption_id  DESC LIMIT 1 ";
        $result = db_query($sql);
        while($row=mysqli_fetch_array($result))
        {
            $consumption_id=$row['consumption_id'];
        }
        //echo $material_request_id;
        
        //$_POST['row_count']  Post no of rows in table 
        $cnt=$connect->real_escape_string($_POST['row_count']); 
        //echo $cnt;
        for($i=0;$i<=$cnt;$i++)
        {
            if($connect->real_escape_string($_POST['item'][$i]))
            {
                $wareHouse=$connect->real_escape_string($_POST['wareHouse'][$i]);
                $item=$connect->real_escape_string($_POST['item'][$i]);
                $quantity=$connect->real_escape_string($_POST['quantity'][$i]);
                $subSection=$connect->real_escape_string($_POST['subSection'][$i]); 
                $purposeOfUtilization=$connect->real_escape_string($_POST['purposeOfUtilization'][$i]); 
                $query = "INSERT INTO `material_consumption_item` (`consumption_id`, `warehouse`, `item`, `qty`, `sub_section`,`purpose`)  VALUES ('$consumption_id','$wareHouse','$item','$quantity','$subSection','$purposeOfUtilization')";
                $result = db_query($query);
                //echo $query;
            }
        }
    }
    
    //die();
    header("location:procurment_transactions_material_consumption.php");
}
if (date('m') > 6) {
    $year = date('y')."-".(date('y') +1);
}
else {
    $year = (date('y')-1)."-".date('y');
}

$last_no=0;
$serial_no=0; 
$seql = "SELECT * FROM material_consumption";
$fetch_data = db_query($seql); 
if ($fetch_data ->num_rows > 0) 
{ 
	$fetch_maxn="SELECT MAX(consumption_id) AS serial_no FROM material_consumption";
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
$Material_Consumption_No="MC/".$year."/".str_pad($serial_no,4,"0",STR_PAD_LEFT);
//echo $Material_Request_No;
?>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Maxim ERP</title>	
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
        <?php include("includes/css.php"); ?>
        <style>
            .custom-blue-btn {
                background-color: #334f9a;
                color: #fff;
            }
            .custom-blue-btn:hover{
                color: #fff;
            }
        </style>
        <script>
            function display_branch(val){
                //alert(val);
                var xmlhttp;
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function()
                {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    {
                        //alert(xmlhttp.responseText);
                        document.getElementById('Material_Consumption_No').value=xmlhttp.responseText;
                    }
                }
                //alert("get_branch_code.php?branch_id="+val);
                xmlhttp.open("GET","get_consumption_branch_code.php?branch_id="+val,true);
                xmlhttp.send();
            }
            function display_item(val){
                var rows = document.getElementById('materialCnsmptnTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (num = 0; num < rows.length; num++) {
                    rows[num].onclick = function() {
                        //alert(this.rowIndex - 1);
                        var row_num=this.rowIndex - 1;
                        var xmlhttp;
                        if (window.XMLHttpRequest)
                        {// code for IE7+, Firefox, Chrome, Opera, Safari
                            xmlhttp=new XMLHttpRequest();
                        }
                        else
                        {// code for IE6, IE5
                            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange=function()
                        {
                            if (xmlhttp.readyState==4 && xmlhttp.status==200)
                            {
                                //alert(xmlhttp.responseText);
                                str=xmlhttp.responseText;
                                result=str.split('/');
                                document.getElementById('itemSpecification' + row_num + '').value=result[0];
                                document.getElementById('unit' + row_num + '').value=result[1];
                            }
                        }
                        //alert("get_branch_code.php?branch_id="+val);
                        xmlhttp.open("GET","get_item_dlts.php?item_id="+val,true);
                        xmlhttp.send();
                    }
                }
                
            }
        </script>
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
							<h3 class="page-title">New Voucher</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="#">Procurement</a></li>
								<li class="breadcrumb-item"><a href="#">Transactions</a></li>
								<li class="breadcrumb-item active"><a href="procurment_transactions_material_consumption.php">Material Consumption</a></li>
							</ul>
						</div>
						<div class="col-sm-5 col">
						
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<!--Inner Page Wrapper-->
				<div class="container-fluid pl-0 pr-0 mt-0 mb-2">
                    <form method="POST" action="procurment_transactions_material_consumption_new.php?id=<?php echo $id; ?>">
                        <div class="accordion mb-1" id="materialConsumption">
                            <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#material_consumption" aria-expanded="true" aria-controls="material_consumption">
                                    <i class="fa fa-minus-circle fa-1x float-right"></i>
                                </button>
                                </h2>
                            </div>
                        
                            <div id="material_consumption" class="collapse show" aria-labelledby="headingOne" data-parent="#materialConsumption">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Material Consumption No</label>
                                                <div class="col-md-7">
                                                    <?php 
													if(isset($_GET['id'])){
														$query="select consumption_no from `material_consumption` where consumption_id ='$id' ";
														$query_result = db_query($query);
														while($row=mysqli_fetch_assoc($query_result))
														{
														?>
															<input type="text" readonly id="Material_Consumption_No" name="Material_Consumption_No" value="<?php echo $row['consumption_no'];?>"  class="form-control" placeholder="" />
														<?php
														}
													}
													else{
													?>
														<input type="text" readonly id="Material_Consumption_No" name="Material_Consumption_No" value="<?php echo $Material_Consumption_No;?>"  class="form-control" placeholder="" />
													<?php
													}
													?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Branch</label>
                                                <div class="col-md-7">
                                                    <select name="branch" class="form-control" onchange="display_branch(this.value)">
                                                        <option Selcted >Please Select Branch</option>
                                                        <?php
                                                        $check="select location_id ,location_name from `payroll_locations`";
                                                        $result = db_query($check);
                                                        while($pdb=mysqli_fetch_assoc($result))
                                                        {
                                                        ?>
                                                            <option value="<?php echo $pdb['location_id'];?>"><?php echo $pdb['location_name'];?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Narration</label>
                                                <div class="col-md-7">
                                                    <textarea class="form-control" name="narration" placeholder="" rows="1"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label custom-text-14">Material Consumption Date</label>
                                                <div class="col-md-7">
                                                    <input type="date" name="material_consumption_date" value="<?php echo date('Y-m-d');?>" readonly class="form-control" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Department</label>
                                                <div class="col-md-7">
                                                    <select class="form-control" name="department">
                                                        <option Selcted >Please Select Department</option>
                                                        <?php
                                                        $check="select dept_id ,  dept_name from `payroll_department`";
                                                        $result = db_query($check);
                                                        while($pdb=mysqli_fetch_assoc($result))
                                                        {
                                                        ?>
                                                            <option value="<?php echo $pdb['dept_id'];?>"><?php echo $pdb['dept_name'];?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>	
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="accordion mb-3" id="materialConsumptionTable">
                            <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#materialConsumption_table" aria-expanded="true" aria-controls="materialConsumption_table">
                                    
                                    <i class="fa fa-minus-circle fa-1x float-right"></i>
                                </button>
                                </h2>
                            </div>
                        
                            <div id="materialConsumption_table" class="collapse show" aria-labelledby="headingTwo" data-parent="#materialConsumptionTable">
                                <div class="card-body">
                                    <table class="table table-bordered table-sm" id="materialCnsmptnTable">
                                        <thead class="thead-green">
                                            <tr>
                                                <th scope="col" width="1%">SL. NO.</th>
                                                <th scope="col" width="15%">Warehouse</th>
                                                <th scope="col" width="15%">Item Name</th>
                                                <th scope="col" width="15%">Item Specification</th>
                                                <th scope="col" width="10%">Unit</th>
                                                <th scope="col" width="9%">Quantity</th>
                                                <th scope="col" width="15%">Sub Section</th>
                                                <th scope="col" width="20%">Purpose of Utilization</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($_GET['id'])){
												$query="SELECT mci.warehouse, mci.consumption_item_id ,im.item_name,im.id,im.description,im.purchase_unit,mci.qty,mci.sub_section,mci.purpose from material_consumption_item AS mci LEFT JOIN item_master AS im ON im.id=mci.item where mci.consumption_id='$id'";
                                                $result = db_query($query);
                                                //echo $query;
                                                $sl=1;
                                                while($row=mysqli_fetch_assoc($result))
											    {
                                                ?>
                                                    <tr>
                                                    <td class="text-center" id="slNo"><?php echo $sl;?></td>
                                                    <td>
                                                        <select class="form-control" id="wareHouse" name="wareHouse[]" style="width: 200px;">
                                                            <option Selcted >Please Select WareHouse</option>
                                                            <?php
                                                            $query1="select id ,name from `warehouse_master`";
                                                            $result1 = db_query($query1);
                                                            while($row1=mysqli_fetch_assoc($result1))
                                                            {
                                                            ?>
                                                                <option value="<?php echo $row1['id'];?>"><?php echo $row1['name'];?></option>
                                                            <?php	
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" readonly value="<?php echo $row['item_name'];?>" class="form-control form-control-sm" id="item_name" name="item_name[]" />
                                                        <input type="text" hidden readonly value="<?php echo $row['id'];?>" class="form-control form-control-sm" id="item" name="item[]" />
                                                        <input type="text" hidden readonly value="<?php echo $row['consumption_item_id'];?>" class="form-control form-control-sm" id="consumption_item_id " name="consumption_item_id[]" />
                                                    </td>
                                                    <td>
                                                        <input type="text" readonly value="<?php echo $row['description'];?>" class="form-control form-control-sm" id="itemSpecification0" name="itemSpecification[]" />
                                                    </td>
                                                    <td>
                                                        <input type="text" readonly value="<?php echo $row['purchase_unit'];?>" class="form-control form-control-sm" id="unit0" name="unit[]" />
                                                    </td>
                                                    <td>
                                                        <input type="text" value="<?php echo $row['qty'];?>" class="form-control form-control" id="quantity" name="quantity[]">
                                                    </td>
                                                    <td>
                                                        <input type="text" value="<?php echo $row['qsub_sectionty'];?>" class="form-control form-control" id="subSection" name="subSection[]">
                                                    </td>
                                                    <td>
                                                        <input type="text" value="<?php echo $row['purpose'];?>" class="form-control form-control" id="purposeOfUtilization" name="purposeOfUtilization[]">
                                                    </td>
                                                </tr>
                                                <?php
                                                $sl++;
                                                }
											}
                                            else{
                                            ?>
                                                <tr>
                                                    <td class="text-center" id="slNo">1</td>
                                                    <td>
                                                        <select class="form-control" id="wareHouse" name="wareHouse[]" style="width: 200px;">
                                                            <option Selcted >Please Select WareHouse</option>
                                                            <?php
                                                            $query1="select id ,name from `warehouse_master`";
                                                            $result1 = db_query($query1);
                                                            while($row1=mysqli_fetch_assoc($result1))
                                                            {
                                                            ?>
                                                                <option value="<?php echo $row1['id'];?>"><?php echo $row1['name'];?></option>
                                                            <?php	
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="item[]" style="width: 160px;" class="form-control" onchange="display_item(this.value)">
                                                            <option Selcted >Please Select Item</option>
                                                            <?php
                                                            $check="select id  ,item_name from `item_master`";
                                                            $result = db_query($check);
                                                            while($pdb=mysqli_fetch_assoc($result))
                                                            {
                                                            ?>
                                                                <option value="<?php echo $pdb['id'];?>"><?php echo $pdb['item_name'];?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" readonly class="form-control form-control-sm" id="itemSpecification0" name="itemSpecification[]" />
                                                    </td>
                                                    <td>
                                                        <input type="text" readonly class="form-control form-control-sm" id="unit0" name="unit[]" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control" id="quantity" name="quantity[]">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control" id="subSection" name="subSection[]">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control" id="purposeOfUtilization" name="purposeOfUtilization[]">
                                                    </td>
                                                    <td class="text-center"><a href="javascript:void(0);" class="add"><i class="fa fa-plus fa-1x"></i></a></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            
                                        </tbody>
                                    </table>	
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <button type="reset" class="btn btn-secondary mr-2 mb-5">Cancel</button>
                            <button type="submit" name="submit" class="btn custom-blue-btn mb-5">Submit</button>
                            <input type="hidden" id="row_count" name="row_count" value="1">
                        </div> 
                    </form>
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
		var i=$('table tr').length;
        var j= 1;

		$(".add").on('click',function(){
			html = '<tr>'; 
			html += '<td class="text-center" id="slNo">'+i+'</td>';
			html += '<td><select class="form-control" id="wareHouse" name="wareHouse[]" style="width: 200px;"><option Selcted >Please Select WareHouse</option> <?php $query1="select id ,name from `warehouse_master`";$result1 = db_query($query1);while($row1=mysqli_fetch_assoc($result1)){?><option value="<?php echo $row1['id'];?>"><?php echo $row1['name'];?></option><?php	} ?></select></td>';
			html += '<td><select name="item[]" style="width: 160px;" class="form-control" onchange="display_item(this.value)"><option Selcted >Please Select Item</option><?php $check="select id  ,item_name from `item_master`";$result = db_query($check);while($pdb=mysqli_fetch_assoc($result)){ ?><option value="<?php echo $pdb['id'];?>"><?php echo $pdb['item_name'];?></option><?php }?></select></td>';
			html += '<td><input type="text" readonly class="form-control form-control-sm" id="itemSpecification' + j + '" name="itemSpecification[]" /></td>';
			html += '<td><input type="text" readonly class="form-control form-control-sm" id="unit' + j + '" name="unit[]" /></td>';
			html += '<td><input type="text" class="form-control form-control-sm" id="quantity" name="quantity[]"></td>';
			html += '<td><input type="text" class="form-control form-control-sm" id="subSection" name="subSection[]"></td>';
			html += '<td><input type="text" class="form-control form-control-sm" id="purposeOfUtilization" name="purposeOfUtilization[]"></td>';
			html += '<td class="text-center"><a href="javascript:void(0);" class="remove"><i class="fa fa-trash fa-1x"></i></a></td>';	 
			html += '</tr>';
			$('table').append(html);
            var rowCount = $('#materialCnsmptnTable tr').length;
            $('#row_count').val(rowCount);
			i++;
            j++;
			$(".remove").on('click', function () {
					$(this).closest('tr').remove();
			});
		});
	</script>

</body>

</html>
