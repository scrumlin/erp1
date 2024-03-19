<?php
include('includes/connection.php');
session_start();
if(!isset($_SESSION['id']))
{
    header('location:index.php');
}
if(isset($_POST['submit']))
{
    $material_req_no=$connect->real_escape_string($_POST['material_req_no']); 
    $branch=$connect->real_escape_string($_POST['branch']); 
    $request_by=$connect->real_escape_string($_POST['request_by']); 
    $material_request_date=$connect->real_escape_string($_POST['material_request_date']);
    $department=$connect->real_escape_string($_POST['department']); 
    $narration=$connect->real_escape_string($_POST['narration']); 
    $uid=$_SESSION['id'];
    $creation_date=date("Y-m-d");
    //echo $material_req_no;
    //insert results from the form input
    $query = "INSERT INTO `material_request`(`material_request_no`, `material_request_dt`, `branch`, `department`, `request_by`, `narration`, `created_by`, `created_dt`) VALUES('$material_req_no','$material_request_date','$branch','$department','$request_by','$narration','$uid','$creation_date')";
    //echo $query;
    $result = db_query($query);
    $sql="SELECT material_request_id FROM material_request ORDER BY material_request_id DESC LIMIT 1 ";
    $result = db_query($sql);
    while($row=mysqli_fetch_array($result))
    {
        $material_request_id=$row['material_request_id'];
    }
    //echo $material_request_id;
    
    //$_POST['row_count']  Post no of rows in table 
    $cnt=$connect->real_escape_string($_POST['row_count']); 
    //echo $cnt;
    for($i=0;$i<=$cnt;$i++)
    {
        if($connect->real_escape_string($_POST['item'][$i]))
        {
            $item=$connect->real_escape_string($_POST['item'][$i]);
            //$connect->real_escape_string($_POST['item'][$i]);
            $quantity=$connect->real_escape_string($_POST['quantity'][$i]);
            $requiredDate=$connect->real_escape_string($_POST['requiredDate'][$i]); 
            $remarks=$connect->real_escape_string($_POST['remarks'][$i]); 
            $query = "INSERT INTO `material_request_item` (`material_request_id`, `item`, `quantity`, `required_dt`, `Remarks`) VALUES ('$material_request_id','$item','$quantity','$requiredDate','$remarks')";
            $result = db_query($query);
            //echo $query;
        }
    }

    //header("location:procurment_transactions_add_edit_material_request.php");
}
$page = "pt_material_request";
if($page=="pt_material_request"){
	$pt_material_request="active";
}

if (date('m') > 6) {
    $year = date('y')."-".(date('y') +1);
}
else {
    $year = (date('y')-1)."-".date('y');
}

$last_no=0;
$serial_no=0; 
$seql = "SELECT * FROM material_request";
$fetch_data = db_query($seql); 
if ($fetch_data ->num_rows > 0) 
{ 
	$fetch_maxn="SELECT MAX(material_request_id) AS serial_no FROM material_request";
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
$Material_Request_No="MRQ/".$year."/".str_pad($serial_no,4,"0",STR_PAD_LEFT);
//echo $Material_Request_No;


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
                        document.getElementById('Material_Request_No').value=xmlhttp.responseText;
                    }
                }
                //alert("get_branch_code.php?branch_id="+val);
                xmlhttp.open("GET","get_branch_code.php?branch_id="+val,true);
                xmlhttp.send();
            }

            function display_item(val){
                var rows = document.getElementById('materialRequestTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
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
            function isNumberKey(evt) 
            {      
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                return true;
            }
        </script>
        <style>
            .custom-blue-btn {
                background-color: #334f9a;
                color: #fff;
            }
            .custom-blue-btn:hover{
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

                            <div class="col-sm-5 col"></div>
                        </div>
                    </div>

                    <!-- /Page Header -->

                    <!--Inner Page Wrapper-->

                    <div class="container-fluid pl-0 pr-0 mt-2 mb-2">
                        <form method="POST" action="procurment_transactions_add_edit_material_request.php">
                            <div class="accordion mb-1" id="materialRequest">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#material_request" aria-expanded="true" aria-controls="material_request">
                                                <i class="fa fa-minus-circle fa-1x float-right"></i>
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="material_request" class="collapse show" aria-labelledby="headingOne" data-parent="#materialRequest">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-5 col-form-label">Material Request No</label>

                                                        <div class="col-md-7">
                                                            <input type="text" readonly id="Material_Request_No" name="material_req_no" value="<?php echo $Material_Request_No;?>"  class="form-control" placeholder="" />
                                                        
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
                                                        <label class="col-md-5 col-form-label">Request By</label>

                                                        <div class="col-md-7">
                                                            <input type="text" name="request_by" class="form-control" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-5 col-form-label custom-text-14">Material Request Date</label>

                                                        <div class="col-md-7">
                                                            <input type="date" name="material_request_date" value="<?php echo date('Y-m-d');?>" readonly class="form-control" placeholder="" />
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

                                                    <div class="form-group row">
                                                        <label class="col-md-5 col-form-label">Narration</label>

                                                        <div class="col-md-7">
                                                            <textarea class="form-control" name="narration" placeholder="" rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion" id="materialTable">
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#material_table" aria-expanded="true" aria-controls="material_table">
                                                <i class="fa fa-minus-circle fa-1x float-right"></i>
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="material_table" class="collapse show" aria-labelledby="headingTwo" data-parent="#materialTable">
                                        <div class="card-body">
                                            <table class="table table-bordered table-sm" id="materialRequestTable">
                                                <thead class="thead-green">
                                                    <tr>
                                                        <th scope="col">SL. NO.</th>

                                                        <th scope="col">Item</th>

                                                        <th scope="col">Item Specification</th>

                                                        <th scope="col">Unit</th>

                                                        <th scope="col">Quantity</th>

                                                        <th scope="col">Required Date</th>

                                                        <th scope="col">Remarks</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td class="text-center" id="slNo">1</td>

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
                                                            <input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="quantity" name="quantity[]" />
                                                        </td>

                                                        <td>
                                                            <input type="date" class="form-control form-control-sm" id="requiredDate" name="requiredDate[]" />
                                                        </td>

                                                        <td>
                                                            <input type="text" class="form-control form-control-sm" id="remarks" name="remarks[]" />
                                                        </td>

                                                        <td class="text-center">
                                                            <a href="javascript:void(0);" class="add"><i class="fa fa-plus fa-1x"></i></a>
                                                        </td>
                                                    </tr>
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
                        </form>
                    </div> 
                    </div>
                </div>
            </div>

            <!-- /Page Wrapper -->
        </div>

        <!-- /Main Wrapper -->

        <?php include('js.php');?>

        <script>
            $(document).ready(function () {
                // Add minus icon for collapse element which is open by default

                $(".collapse.show").each(function () {
                    $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
                });

                // Toggle plus minus icon on show hide of collapse element

                $(".collapse")
                    .on("show.bs.collapse", function () {
                        $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
                    })
                    .on("hide.bs.collapse", function () {
                        $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
                    });

                $(".collapse.show").each(function () {
                    $(this).prev(".card-header").addClass("bb").removeClass("no_bb");
                });

                // Toggle plus minus icon on show hide of collapse element

                $(".collapse")
                    .on("show.bs.collapse", function () {
                        $(this).prev(".card-header").removeClass("no_bb").addClass("bb");
                    })
                    .on("hide.bs.collapse", function () {
                        $(this).prev(".card-header").removeClass("bb").addClass("no_bb");
                    });
            });

            var input = document.querySelector("input[type=file]"); // see Example 4

            input.onchange = function () {
                var file = input.files[0];

                drawOnCanvas(file); // see Example 6

                displayAsImage(file); // see Example 7
            };

            function drawOnCanvas(file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var dataURL = e.target.result,
                        c = document.querySelector("canvas"), // see Example 4
                        ctx = c.getContext("2d"),
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
                    img = document.createElement("img");

                img.onload = function () {
                    URL.revokeObjectURL(imgURL);
                };

                img.src = imgURL;

                document.body.appendChild(img);
            }

            $("#upfile1").click(function () {
                $("#file1").trigger("click");
            });

            $("#upfile2").click(function () {
                $("#file2").trigger("click");
            });

            $("#upfile3").click(function () {
                $("#file3").trigger("click");
            });
        </script>

        <script>
            var i = $("table tr").length;
            var j= 1;

            $(".add").on("click", function () {
                html = "<tr>";

                html += '<td class="text-center" id="slNo">' + i + "</td>";

                html += '<td><select style="width: 160px;" class="select w-100 form-control form-control-sm" onchange="display_item(this.value)" id="item" name="item[]"><option Selcted >Please Select Item</option><?php $check="select id  ,item_name from `item_master`"; $result = db_query($check); while($pdb=mysqli_fetch_assoc($result)){?><option value="<?php echo $pdb['id'];?>"><?php echo $pdb['item_name'];?></option> <?php }?></select>';

                html += '<td><input type="text" readonly class="form-control form-control-sm" id="itemSpecification' + j + '" name="itemSpecification[]"></td>';

                html += '<td><input type="text" readonly class="form-control form-control-sm" id="unit' + j + '" name="unit[]"></td>';

                html += '<td><input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="quantity" name="quantity[]"></td>';

                html += '<td><input type="date" class="form-control form-control-sm" id="requiredDate" name="requiredDate[]"></td>';

                html += '<td><input type="text" class="form-control form-control-sm" id="remarks" name="remarks[]"></td>';

                html += '<td class="text-center"><a href="javascript:void(0);" class="remove"><i class="fa fa-trash fa-1x"></i></a></td>';

                html += "</tr>";

                $("table").append(html);
                var rowCount = $('#materialRequestTable tr').length;
                //alert();
                $('#row_count').val(rowCount);
                i++;
                j++;
                $(".remove").on("click", function () {
                    $(this).closest("tr").remove();
                });
            });
        </script>
    </body>
</html>
