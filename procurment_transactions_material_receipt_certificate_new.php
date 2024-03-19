<?php
include('includes/connection.php');
session_start();
if(!isset($_SESSION['id']))
{
    header('location:index.php');
}
$page = "pt_material_receipt_certificate";
if($page=="pt_material_receipt_certificate"){
	$pt_material_receipt_certificate="active";
}

if(isset($_GET['id'])){
	$po_id= $_GET['id'];
}

if(isset($_GET['cmr_id'])){
	$cmr_id= $_GET['cmr_id'];
}

if(isset($_POST['submit'])){
	if(isset($_GET['cmr_id'])){
		$cmr_no=$connect->real_escape_string($_POST['cmr_no']); 
		$vendor=$connect->real_escape_string($_POST['vendor']); 
		$type_of_purchase=$connect->real_escape_string($_POST['type_of_purchase']); 
		$invoice_dt=$connect->real_escape_string($_POST['invoice_dt']); 
		$gst_type=$connect->real_escape_string($_POST['gst_type']); 
		$is_igst=$connect->real_escape_string($_POST['is_igst']); 
		$packing_forwarding=$connect->real_escape_string($_POST['packing_forwarding']); 
		$freight=$connect->real_escape_string($_POST['freight']); 
		$mode_of_receipt=$connect->real_escape_string($_POST['mode_of_receipt']); 
		$gate_entry_dt=$connect->real_escape_string($_POST['gate_entry_dt']); 
		$reason=$connect->real_escape_string($_POST['reason']); 
		$cmr_dt=$connect->real_escape_string($_POST['cmr_dt']); 
		$branch=$connect->real_escape_string($_POST['branch']); 
		$invoice_no=$connect->real_escape_string($_POST['invoice_no']); 
		$invoice_value=$connect->real_escape_string($_POST['invoice_value']); 
		$place_of_supply=$connect->real_escape_string($_POST['place_of_supply']); 
		$price_basis=$connect->real_escape_string($_POST['price_basis']); 
		$insurance=$connect->real_escape_string($_POST['insurance']); 
		$onloading_charges=$connect->real_escape_string($_POST['onloading_charges']); 
		$gate_entry_no=$connect->real_escape_string($_POST['gate_entry_no']); 
		$narration=$connect->real_escape_string($_POST['narration']); 
		$invoice=$connect->real_escape_string($_POST['invoice']); 
		$gate_entry_proof=$connect->real_escape_string($_POST['gate_entry_proof']); 
		$rr_copy=$connect->real_escape_string($_POST['rr_copy']); 
		$stock_entry_proof=$connect->real_escape_string($_POST['stock_entry_proof']); 
		$test_report_copy=$connect->real_escape_string($_POST['test_report_copy']); 
		$po_copy=$connect->real_escape_string($_POST['po_copy']); 
		$check_list=$connect->real_escape_string($_POST['check_list']); 
		$road_permit=$connect->real_escape_string($_POST['road_permit']); 
		$weighment_proof=$connect->real_escape_string($_POST['weighment_proof']); 
		$other=$connect->real_escape_string($_POST['other']); 
		$coa=$connect->real_escape_string($_POST['coa']); 
		$transporter=$connect->real_escape_string($_POST['transporter']); 
		$vehicle_no=$connect->real_escape_string($_POST['vehicle_no']); 
		$eway_bill_no=$connect->real_escape_string($_POST['eway_bill_no']); 
		$uid=$_SESSION['id'];
		$creation_date=date("Y-m-d");

		$maxsize = 10485760;
		$allowed_extensions = array('jpeg', 'jpg','png');

		//invoice image upload
		if ($_FILES['invoice_file']['name'] != "") {
			$filenamenew = $_FILES['invoice_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);

			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['invoice_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['invoice_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$invoice_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['invoice_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$invoice_file = trim($_POST['invoice_file_nm']);
		}

		//gate_entry_proof_file image upload
		if ($_FILES['gate_entry_proof_file']['name'] != "") {
			$filenamenew = $_FILES['gate_entry_proof_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);

			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['gate_entry_proof_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['gate_entry_proof_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$gate_entry_proof_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['gate_entry_proof_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$gate_entry_proof_file = trim($_POST['gate_entry_proof_file_nm']);
		}

		//rr_copy_file image upload
		if ($_FILES['rr_copy_file']['name'] != "") {
			$filenamenew = $_FILES['rr_copy_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);

			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['rr_copy_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['rr_copy_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$rr_copy_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['rr_copy_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$rr_copy_file = trim($_POST['rr_copy_file_nm']);
		}

		//stock_entry_proof_file image upload
		if ($_FILES['stock_entry_proof_file']['name'] != "") {
			$filenamenew = $_FILES['stock_entry_proof_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);

			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['stock_entry_proof_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['stock_entry_proof_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$stock_entry_proof_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['stock_entry_proof_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$stock_entry_proof_file = trim($_POST['stock_entry_proof_file_nm']);
		}

		//test_report_copy_file image upload
		if ($_FILES['test_report_copy_file']['name'] != "") {
			$filenamenew = $_FILES['test_report_copy_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);

			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['test_report_copy_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['test_report_copy_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$test_report_copy_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['test_report_copy_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$test_report_copy_file = trim($_POST['test_report_copy_file_nm']);
		}

		//po_copy_file image upload
		if ($_FILES['po_copy_file']['name'] != "") {
			$filenamenew = $_FILES['po_copy_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);

			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['po_copy_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['po_copy_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$po_copy_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['po_copy_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$po_copy_file = trim($_POST['po_copy_file_nm']);
		}

		//check_list_file image upload
		if ($_FILES['check_list_file']['name'] != "") {
			$filenamenew = $_FILES['check_list_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);

			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['check_list_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['check_list_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$check_list_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['check_list_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$check_list_file = trim($_POST['check_list_file_nm']);
		}

		//road_permit_file image upload
		if ($_FILES['road_permit_file']['name'] != "") {
			$filenamenew = $_FILES['road_permit_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);

			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['road_permit_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['road_permit_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$road_permit_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['road_permit_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$road_permit_file = trim($_POST['road_permit_file_nm']);
		}

		//weighment_proof_file image upload
		if ($_FILES['weighment_proof_file']['name'] != "") {
			$filenamenew = $_FILES['weighment_proof_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);

			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['weighment_proof_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['weighment_proof_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$weighment_proof_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['weighment_proof_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$weighment_proof_file = trim($_POST['weighment_proof_file_nm']);
		}

		//other_file image upload
		if ($_FILES['other_file']['name'] != "") {
			$filenamenew = $_FILES['other_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);

			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['other_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['other_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$other_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['other_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$other_file = trim($_POST['other_file_nm']);
		}

		//coa_file image upload
		if ($_FILES['coa_file']['name'] != "") {
			$filenamenew = $_FILES['coa_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);

			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['coa_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['coa_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$coa_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['coa_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$coa_file = trim($_POST['coa_file_nm']);
		}

		//insert results from the form input
		$query = "UPDATE `cmr` set `po_id`='$po_id', `cmr_no`='$cmr_no', `vendor`='$vendor', `type_of_purchase`='$type_of_purchase', `invoice_dt`='$invoice_dt', `gst_type`='$gst_type', `is_igst`='$is_igst', `packing_forwarding`='$packing_forwarding', `freight`='$freight', `mode_of_receipt`='$mode_of_receipt', `gate_entry_dt`='$gate_entry_dt', `reason`='$reason', `cmr_dt`='$cmr_dt',`branch`='$branch',`invoice_no`='$invoice_no',`invoice_value`='$invoice_value',`place_of_supply`='$place_of_supply',`price_basis`='$price_basis',`insurance`='$insurance',`onloading_charges`='$onloading_charges',`gate_entry_no`='$gate_entry_no',`narration`='$narration',`invoice`='$invoice',`invoice_file`='$invoice_file',`gate_entry_proof`='$gate_entry_proof',`gate_entry_proof_file`='$gate_entry_proof_file',`rr_copy`='$rr_copy',`rr_copy_file`='$rr_copy_file',`stock_entry_proof`='$stock_entry_proof',`stock_entry_proof_file`='$stock_entry_proof_file',`test_report_copy`='$test_report_copy',`test_report_copy_file`='$test_report_copy_file',`po_copy`='$po_copy',`po_copy_file`='$po_copy_file',`check_list`='$check_list',`check_list_file`='$check_list_file',`road_permit`='$road_permit',`road_permit_file`='$road_permit_file',`weighment_proof`='$weighment_proof',`weighment_proof_file`='$weighment_proof_file',`other`='$other',`other_file`='$other_file',`coa`='$coa',`coa_file`='$coa_file',`transporter`='$transporter',`vehicle_no`='$vehicle_no',`eway_bill_no`='$eway_bill_no' WHERE cmr_id='$cmr_id'";
		//echo $query;
		//die();
		$result = db_query($query);
		$sql="SELECT cmr_id  FROM cmr ORDER BY cmr_id   DESC LIMIT 1 ";
		$result = db_query($sql);
		while($row=mysqli_fetch_array($result))
		{
			$last_cmr_id =$row['cmr_id'];
		}
		//echo $last_order_id;
		//$_POST['row_count']  Post no of rows in table 
		$cnt=$connect->real_escape_string($_POST['row_count']); 
		$cnt=$cnt-1;
		//echo $cnt;
		for($i=0;$i<=$cnt;$i++)
		{
			if($connect->real_escape_string($_POST['branch'][$i]))
			{
				$branch=$connect->real_escape_string($_POST['branch'][$i]);
				$item=$connect->real_escape_string($_POST['item'][$i]);
				$pending_po_Qty=$connect->real_escape_string($_POST['pending_po_Qty'][$i]);
				$received_qty=$connect->real_escape_string($_POST['received_qty'][$i]);
				$pending_Qty=$connect->real_escape_string($_POST['pending_Qty'][$i]);
				$discount=$connect->real_escape_string($_POST['discount'][$i]);
				$gross=$connect->real_escape_string($_POST['gross'][$i]);
				$delivery_date=$connect->real_escape_string($_POST['delivery_date'][$i]);
				$remarks=$connect->real_escape_string($_POST['remarks'][$i]);
				$insert_query = "UPDATE `cmr_item` SET `branch`='$branch', `item`='$item', `po_id`='$po_id', `pending_po_Qty`='$pending_po_Qty',`received_qty`='$received_qty',`pending_Qty`='$pending_Qty',`discount`='$discount', `gross`='$gross', `delivery_date`='$delivery_date', `remarks`='$remarks' WHERE id='$cmr_item_id'";
				$result = db_query($insert_query);
			}
			//echo $insert_query;
		}
	}
	else{
		$cmr_no=$connect->real_escape_string($_POST['cmr_no']); 
		$vendor=$connect->real_escape_string($_POST['vendor']); 
		$type_of_purchase=$connect->real_escape_string($_POST['type_of_purchase']); 
		$invoice_dt=$connect->real_escape_string($_POST['invoice_dt']); 
		$gst_type=$connect->real_escape_string($_POST['gst_type']); 
		$is_igst=$connect->real_escape_string($_POST['is_igst']); 
		$packing_forwarding=$connect->real_escape_string($_POST['packing_forwarding']); 
		$freight=$connect->real_escape_string($_POST['freight']); 
		$mode_of_receipt=$connect->real_escape_string($_POST['mode_of_receipt']); 
		$gate_entry_dt=$connect->real_escape_string($_POST['gate_entry_dt']); 
		$reason=$connect->real_escape_string($_POST['reason']); 
		$cmr_dt=$connect->real_escape_string($_POST['cmr_dt']); 
		$branch=$connect->real_escape_string($_POST['branch']); 
		$invoice_no=$connect->real_escape_string($_POST['invoice_no']); 
		$invoice_value=$connect->real_escape_string($_POST['invoice_value']); 
		$place_of_supply=$connect->real_escape_string($_POST['place_of_supply']); 
		$price_basis=$connect->real_escape_string($_POST['price_basis']); 
		$insurance=$connect->real_escape_string($_POST['insurance']); 
		$onloading_charges=$connect->real_escape_string($_POST['onloading_charges']); 
		$gate_entry_no=$connect->real_escape_string($_POST['gate_entry_no']); 
		$narration=$connect->real_escape_string($_POST['narration']); 
		$invoice=$connect->real_escape_string($_POST['invoice']); 
		$gate_entry_proof=$connect->real_escape_string($_POST['gate_entry_proof']); 
		$rr_copy=$connect->real_escape_string($_POST['rr_copy']); 
		$stock_entry_proof=$connect->real_escape_string($_POST['stock_entry_proof']); 
		$test_report_copy=$connect->real_escape_string($_POST['test_report_copy']); 
		$po_copy=$connect->real_escape_string($_POST['po_copy']); 
		$check_list=$connect->real_escape_string($_POST['check_list']); 
		$road_permit=$connect->real_escape_string($_POST['road_permit']); 
		$weighment_proof=$connect->real_escape_string($_POST['weighment_proof']); 
		$other=$connect->real_escape_string($_POST['other']); 
		$coa=$connect->real_escape_string($_POST['coa']); 
		$transporter=$connect->real_escape_string($_POST['transporter']); 
		$vehicle_no=$connect->real_escape_string($_POST['vehicle_no']); 
		$eway_bill_no=$connect->real_escape_string($_POST['eway_bill_no']); 
		$uid=$_SESSION['id'];
		$creation_date=date("Y-m-d");
	
		$maxsize = 10485760;
		$allowed_extensions = array('jpeg', 'jpg','png');
	
		//invoice image upload
		if ($_FILES['invoice_file']['name'] != "") {
			$filenamenew = $_FILES['invoice_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);
	
			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['invoice_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['invoice_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$invoice_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['invoice_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$invoice_file = trim($_POST['invoice_file_nm']);
		}
	
		//gate_entry_proof_file image upload
		if ($_FILES['gate_entry_proof_file']['name'] != "") {
			$filenamenew = $_FILES['gate_entry_proof_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);
	
			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['gate_entry_proof_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['gate_entry_proof_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$gate_entry_proof_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['gate_entry_proof_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$gate_entry_proof_file = trim($_POST['gate_entry_proof_file_nm']);
		}
	
		//rr_copy_file image upload
		if ($_FILES['rr_copy_file']['name'] != "") {
			$filenamenew = $_FILES['rr_copy_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);
	
			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['rr_copy_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['rr_copy_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$rr_copy_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['rr_copy_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$rr_copy_file = trim($_POST['rr_copy_file_nm']);
		}
	
		//stock_entry_proof_file image upload
		if ($_FILES['stock_entry_proof_file']['name'] != "") {
			$filenamenew = $_FILES['stock_entry_proof_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);
	
			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['stock_entry_proof_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['stock_entry_proof_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$stock_entry_proof_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['stock_entry_proof_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$stock_entry_proof_file = trim($_POST['stock_entry_proof_file_nm']);
		}
	
		//test_report_copy_file image upload
		if ($_FILES['test_report_copy_file']['name'] != "") {
			$filenamenew = $_FILES['test_report_copy_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);
	
			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['test_report_copy_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['test_report_copy_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$test_report_copy_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['test_report_copy_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$test_report_copy_file = trim($_POST['test_report_copy_file_nm']);
		}
	
		//po_copy_file image upload
		if ($_FILES['po_copy_file']['name'] != "") {
			$filenamenew = $_FILES['po_copy_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);
	
			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['po_copy_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['po_copy_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$po_copy_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['po_copy_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$po_copy_file = trim($_POST['po_copy_file_nm']);
		}
	
		//check_list_file image upload
		if ($_FILES['check_list_file']['name'] != "") {
			$filenamenew = $_FILES['check_list_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);
	
			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['check_list_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['check_list_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$check_list_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['check_list_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$check_list_file = trim($_POST['check_list_file_nm']);
		}
	
		//road_permit_file image upload
		if ($_FILES['road_permit_file']['name'] != "") {
			$filenamenew = $_FILES['road_permit_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);
	
			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['road_permit_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['road_permit_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$road_permit_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['road_permit_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$road_permit_file = trim($_POST['road_permit_file_nm']);
		}
	
		//weighment_proof_file image upload
		if ($_FILES['weighment_proof_file']['name'] != "") {
			$filenamenew = $_FILES['weighment_proof_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);
	
			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['weighment_proof_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['weighment_proof_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$weighment_proof_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['weighment_proof_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$weighment_proof_file = trim($_POST['weighment_proof_file_nm']);
		}
	
		//other_file image upload
		if ($_FILES['other_file']['name'] != "") {
			$filenamenew = $_FILES['other_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);
	
			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['other_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['other_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$other_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['other_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$other_file = trim($_POST['other_file_nm']);
		}
	
		//coa_file image upload
		if ($_FILES['coa_file']['name'] != "") {
			$filenamenew = $_FILES['coa_file']['name'];
			$path_info = pathinfo($filenamenew);
			$is_valid = in_array($path_info['extension'], $allowed_extensions);
	
			if (empty($is_valid)) {
				//die('File #'.$i.': Incorrect file extension.');
				$msg = "Incorrect file extension, Please upload a valid image file";
				setcookie("msg", $msg, time() + 3);
				print "<script>";
				print "self.location = 'mng_banner.php';";
				print "</script>";
				exit;
			} else {
				$path2 = "uploadimages";
				$s1 = rand();
				$realname = removeSpchar($_FILES['coa_file']['name']);
				$realname = $s1 . "_" . $realname;
				$dest = $path2 . "/" . $realname;
				move_uploaded_file($_FILES['coa_file']['tmp_name'],$dest);
				// copy($_FILES['image']['tmp_name'], $dest);
				$img_name = trim($realname);
				$coa_file = $img_name;
				$path3 = "uploadimages";
				$delpath1 = $path3 . "/" . $_POST['coa_file_nm'];
				@unlink($delpath1);
			}
		}else {
			$coa_file = trim($_POST['coa_file_nm']);
		}
	
		//insert results from the form input
		$query = "INSERT INTO `cmr` (`po_id`, `cmr_no`, `vendor`, `type_of_purchase`, `invoice_dt`, `gst_type`, `is_igst`, `packing_forwarding`, `freight`, `mode_of_receipt`, `gate_entry_dt`, `reason`, `cmr_dt`,`branch`,`invoice_no`,`invoice_value`,`place_of_supply`,`price_basis`,`insurance`,`onloading_charges`,`gate_entry_no`,`narration`,`created_by`,`created_dt`,`invoice`,`invoice_file`,`gate_entry_proof`,`gate_entry_proof_file`,`rr_copy`,`rr_copy_file`,`stock_entry_proof`,`stock_entry_proof_file`,`test_report_copy`,`test_report_copy_file`,`po_copy`,`po_copy_file`,`check_list`,`check_list_file`,`road_permit`,`road_permit_file`,`weighment_proof`,`weighment_proof_file`,`other`,`other_file`,`coa`,`coa_file`,`transporter`,`vehicle_no`,`eway_bill_no`) 
		VALUES('$po_id','$cmr_no','$vendor','$type_of_purchase','$invoice_dt','$gst_type','$is_igst','$packing_forwarding','$freight','$mode_of_receipt','$gate_entry_dt','$reason','$cmr_dt','$branch','$invoice_no','$invoice_value','$place_of_supply','$price_basis','$insurance','$onloading_charges','$gate_entry_no','$narration','$uid','$creation_date','$invoice','','$gate_entry_proof','$gate_entry_proof_file','$rr_copy','$rr_copy_file','$stock_entry_proof','$stock_entry_proof_file','$test_report_copy','$test_report_copy_file','$po_copy','$po_copy_file','$check_list','$check_list_file','$road_permit','$road_permit_file','$weighment_proof','$weighment_proof_file','$other','$other_file','$coa','$coa_file','$transporter','$vehicle_no','$eway_bill_no')";
		//echo $query;
		//die();
		$result = db_query($query);
		$sql="SELECT cmr_id  FROM cmr ORDER BY cmr_id   DESC LIMIT 1 ";
		$result = db_query($sql);
		while($row=mysqli_fetch_array($result))
		{
			$last_cmr_id =$row['cmr_id'];
		}
		//echo $last_order_id;
		//$_POST['row_count']  Post no of rows in table 
		$cnt=$connect->real_escape_string($_POST['row_count']); 
		$cnt=$cnt-1;
		//echo $cnt;
		for($i=0;$i<=$cnt;$i++)
		{
			if($connect->real_escape_string($_POST['branch'][$i]))
			{
				$branch=$connect->real_escape_string($_POST['branch'][$i]);
				$item=$connect->real_escape_string($_POST['item'][$i]);
				$pending_po_Qty=$connect->real_escape_string($_POST['pending_po_Qty'][$i]);
				$received_qty=$connect->real_escape_string($_POST['received_qty'][$i]);
				$pending_Qty=$connect->real_escape_string($_POST['pending_Qty'][$i]);
				$discount=$connect->real_escape_string($_POST['discount'][$i]);
				$gross=$connect->real_escape_string($_POST['gross'][$i]);
				$delivery_date=$connect->real_escape_string($_POST['delivery_date'][$i]);
				$remarks=$connect->real_escape_string($_POST['remarks'][$i]);
				$insert_query = "INSERT INTO `cmr_item` (`cmr_id`, `branch`, `item`, `po_id`, `pending_po_Qty`,`received_qty`,`pending_Qty`,`discount`, `gross`, `delivery_date`, `remarks`) 
										VALUES ('$last_cmr_id','$branch','$item','$po_id','$pending_po_Qty','$received_qty','$pending_Qty','$discount','$gross','$delivery_date','$remarks')";
				$result = db_query($insert_query);
			}
			//echo $insert_query;
		}
	}
	
	//die();
	header("location:procurment_transactions_material_receipt_certificate.php");
	
}
//Get get current financial year
if (date('m') > 6) {
    $year = date('y')."-".(date('y') +1);
}
else {
    $year = (date('y')-1)."-".date('y');
}

//last serial_no 
$last_no=0;
$serial_no=0; 
$seql = "SELECT * FROM cmr";
$fetch_data = db_query($seql); 
if ($fetch_data ->num_rows > 0) 
{ 
	$fetch_maxn="SELECT MAX(cmr_id) AS serial_no FROM cmr";
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

//get requisition_no
$cmr_no="CMR/".$year."/".str_pad($serial_no,4,"0",STR_PAD_LEFT);
//echo $Material_Request_No;
?>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Maxim ERP</title>	
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
        <?php include('includes/css.php');?>
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
                        document.getElementById('cmr_no').value=xmlhttp.responseText;
                    }
                }
                //alert("get_cmr_no.php?branch_id="+val);
                xmlhttp.open("GET","get_cmr_no.php?branch_id="+val,true);
                xmlhttp.send();
            }
			function show_pendingQty(val){
				var rows = document.getElementById('receiptCertificateTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (num = 0; num < rows.length; num++) {
                    rows[num].onclick = function() {
                        //alert(this.rowIndex - 1);
                        var row_num=this.rowIndex - 1;
						var poQty = document.getElementById('poQty' + row_num + '').value;
						var Pending_Qty=poQty-val;
						document.getElementById('pendingQty' + row_num + '').value=Pending_Qty;
					}
				}
			}
			function show_gross(val){
				var rows = document.getElementById('receiptCertificateTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (num = 0; num < rows.length; num++) {
                    rows[num].onclick = function() {
                        //alert(this.rowIndex - 1);
                        var row_num=this.rowIndex - 1;
						var rate = document.getElementById('rate' + row_num + '').value;
						var gross=rate-val;
						document.getElementById('gross' + row_num + '').value=gross;
					}
				}
			}
		</script>
		<style>
			.fileUpload input.upload {
				position: absolute;
				top: 0;
				right: 0;
				margin: 0;
				padding: 0;
				font-size: 20px;
				cursor: pointer;
				opacity: 0;
				filter: alpha(opacity=0);
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
							<h3 class="page-title">New Certificate of Material Receipt</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="#">Procurement</a></li>
								<li class="breadcrumb-item"><a href="#">Transactions</a></li>
								<li class="breadcrumb-item active"><a href="procurment_transactions_material_receipt_certificate.php">Certificate of Material Receipt</a></li>
							</ul>
						</div>
						<div class="col-sm-5 col">
						
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<?php 
				if(isset($_GET['cmr_id'])){
					$retrive_query="SELECT * FROM `cmr` where cmr_id='$cmr_id'";
					$retrive_result=db_query($retrive_query);
					$retrive_row=mysqli_fetch_assoc($retrive_result);
				}
				?>
				<!--Inner Page Wrapper-->
				<div class="container-fluid pl-0 pr-0 mt-0 mb-2">
					<form method="POST" enctype="multipart/form-data" action="procurment_transactions_material_receipt_certificate_new.php?id=<?php echo $po_id;?><?php if(isset($_GET['cmr_id'])){ echo "&cmr_id=".$cmr_id; }?> ">
						<div class="accordion mb-1" id="materialReceiptCertificate">
							<div class="card">
							<div class="card-header" id="headingOne">
								<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#material_receipt_certi" aria-expanded="true" aria-controls="material_receipt_certi">
									<i class="fa fa-minus-circle fa-1x float-right"></i>
								</button>
								</h2>
							</div>
						
							<div id="material_receipt_certi" class="collapse show" aria-labelledby="headingOne" data-parent="#materialReceiptCertificate">
								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-4 col-form-label">CMR No</label>
												<div class="col-md-8">
													<?php 
													if(isset($_GET['po_id'])){
														$query="SELECT order_no from purchase_order WHERE indent_id='$indent_id'";
														$query_result = db_query($query);
														while($row=mysqli_fetch_assoc($query_result))
														{
														?>
															<input type="text" readonly id="cmr_no" name="cmr_no" value="<?php echo $row['order_no'];?>"  class="form-control" placeholder="" />
														<?php
														}
													}
													else{
													?>
														<input type="text" readonly id="cmr_no" name="cmr_no" value="<?php echo $cmr_no;?>"  class="form-control" placeholder="" />
													<?php
													}	
													?>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">VendorAC</label>
												<div class="col-md-8">
													<select class="form-control" name="vendor">
													<option Selcted >Please Select VendorAC</option>
														<option value="1" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['vendor']==1){ echo "selected"; } } ?>>Admin</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Type of Purchase</label>
												<div class="col-md-8">
													<select class="form-control" name="type_of_purchase">
														<option Selcted >Please Select Type of Purchase</option>
														<option value="H" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['type_of_purchase']=="H"){ echo "selected"; } } ?>>HO Purchase</option>
														<option value="L" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['type_of_purchase']=="L"){ echo "selected"; } } ?>>Local Purchase</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label custom-text-14">Invoice Date</label>
												<div class="col-md-8">
												<input type="date" name="invoice_dt" value="<?php echo date('Y-m-d');?>" readonly class="form-control" placeholder="">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">GST Type</label>
												<div class="col-md-8">
													<select class="form-control" id="gst_type" name="gst_type">
														<option Selcted >Please Select GST Type</option>
														<option value="E" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['gst_type']=="E"){ echo "selected"; } } ?>>Exclusive </option>
														<option value="I" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['gst_type']=="I"){ echo "selected"; } } ?>>Inclusive</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Is GST</label>
												<div class="col-md-8">
													<select class="form-control" name="is_igst">
														<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['is_igst']=="Y"){ echo "selected"; } } ?>>Yes</option>
														<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['is_igst']=="N"){ echo "selected"; } } ?>>No</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Packing Forwarding</label>
												<div class="col-md-8">
													<select class="form-control" name="packing_forwarding">
														<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['packing_forwarding']=="Y"){ echo "selected"; } } ?>>Yes</option>
														<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['packing_forwarding']=="N"){ echo "selected"; } } ?>>No</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Freight</label>
												<div class="col-md-8">
													<select class="form-control" name="freight">
														<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['freight']=="Y"){ echo "selected"; } } ?>>Yes</option>
														<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['freight']=="N"){ echo "selected"; } } ?>>No</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label custom-text-14">Mode of Receipt</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="mode_of_receipt" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['mode_of_receipt']; } ?>" placeholder="">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label custom-text-14">Gate Entry Date</label>
												<div class="col-md-8">
												<input type="date" name="gate_entry_dt" value="<?php if(isset($_GET['cmr_id'])){ echo date("Y-m-d", strtotime($retrive_row['gate_entry_dt'])); } else{ echo date('Y-m-d');} ?>"  class="form-control" placeholder="">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Remarks/Reason</label>
												<div class="col-md-8">
													<textarea class="form-control" name="reason" placeholder="" rows="1"><?php if(isset($_GET['cmr_id'])){ echo $retrive_row['reason']; } ?></textarea>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-4 col-form-label custom-text-14">CMR Date</label>
												<div class="col-md-8">
												<input type="date" name="cmr_dt" value="<?php echo date('Y-m-d');?>" readonly class="form-control" placeholder="">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Branch</label>
												<div class="col-md-8">
													<select name="branch" class="form-control" onchange="display_branch(this.value)">
														<option Selcted >Please Select Branch</option>
														<?php
														$check="select location_id ,location_name from `payroll_locations`";
														$result = db_query($check);
														while($pdb=mysqli_fetch_assoc($result))
														{
														?>
															<option value="<?php echo $pdb['location_id'];?>" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['branch']== $pdb['location_id']){ echo "selected"; } } ?>><?php echo $pdb['location_name'];?></option>
														<?php
														}
														?>
													</select>
												</div>
											</div>	
											<div class="form-group row">
												<label class="col-md-4 col-form-label custom-text-14">Invoice No.</label>
												<div class="col-md-8">
													<input type="text" name="invoice_no" class="form-control" placeholder="" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['invoice_no']; } ?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label custom-text-14">Invoice Value</label>
												<div class="col-md-8">
													<input type="text" name="invoice_value" class="form-control" placeholder="" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['invoice_value']; } ?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Place of Supply</label>
												<div class="col-md-8">
													<select class="form-control" name="place_of_supply">
														<option value="1" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['place_of_supply']==1){ echo "selected"; } } ?>>Odisha</option>
													</select>
												</div>
											</div>	
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Price Basis</label>
												<div class="col-md-8">
													<select class="form-control" name="price_basis">
														<option value="E" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['price_basis']=="Y"){ echo "selected"; } } ?>>Ex Work</option>
														<option value="F" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['price_basis']=="N"){ echo "selected"; } } ?>>For Basis</option>
													</select>
												</div>
											</div>	
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Insurance</label>
												<div class="col-md-8">
													<select class="form-control" name="insurance">
														<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['insurance']=="Y"){ echo "selected"; } } ?>>Yes</option>
														<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['insurance']=="N"){ echo "selected"; } } ?>>No</option>
													</select>
												</div>
											</div>	
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Onloading Charges</label>
												<div class="col-md-8">
													<select class="form-control" name="onloading_charges">
														<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['onloading_charges']=="Y"){ echo "selected"; } } ?>>Yes</option>
														<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['onloading_charges']=="N"){ echo "selected"; } } ?>>No</option>
													</select>
												</div>
											</div>	
											<div class="form-group row">
												<label class="col-md-4 col-form-label custom-text-14">Gate Entry No.</label>
												<div class="col-md-8">
													<input type="text" name="gate_entry_no" class="form-control" placeholder="" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['gate_entry_no']; } ?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Narration</label>
												<div class="col-md-8">
													<textarea class="form-control" name="narration" placeholder="" rows="1"><?php if(isset($_GET['cmr_id'])){ echo $retrive_row['narration']; } ?></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>

						<div class="accordion mb-1" id="certificateTable">
							<div class="card">
							<div class="card-header" id="headingTwo">
								<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#certificate_table" aria-expanded="true" aria-controls="certificate_table">
									
									<i class="fa fa-minus-circle fa-1x float-right"></i>
								</button>
								</h2>
							</div>				  
							<div id="certificate_table" class="collapse" aria-labelledby="headingTwo" data-parent="#certificateTable">
								<div class="card-body horizontal-scroll" style="overflow-y: auto;">
									<table class="table table-bordered table-sm" id="receiptCertificateTable">
										<thead class="custom-thead">
											<tr>
												<th scope="col" width="1%">SL. NO.</th>
												<th scope="col">Warehouse</th>
												<th scope="col">Item Name</th>
												<th scope="col">Item Specification</th>
												<th scope="col">Unit</th>
												<th scope="col">PO No.</th>
												<th scope="col">PO Date</th>
												<th scope="col">PO Qty</th>
												<th scope="col">Pending PO Qty</th>
												<th scope="col">Received Quantity</th>
												<th scope="col">Pending Qty</th>
												<th scope="col">Rate</th>
												<th scope="col">Discount</th>
												<th scope="col">Gross</th>
												<th scope="col">Delivery Date</th>
												<th scope="col">Remarks</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if(isset($_GET['cmr_id'])){
												$query="SELECT ci.id, pl.location_name, im.item_name, im.description, im.purchase_unit, po.order_no, po.order_dt, poi.po_qty, poi.indent_qty, ci.pending_po_Qty, ci.received_qty, ci.pending_Qty, im.gst_rate ,ci.discount, ci.gross, ci.delivery_date, ci.remarks from cmr_item AS ci LEFT JOIN payroll_locations AS pl ON pl.location_id=ci.branch LEFT JOIN item_master AS im ON im.id=ci.item LEFT JOIN purchase_order AS po ON po.order_id=ci.po_id LEFT JOIN purchase_order_item AS poi ON poi.order_id=po.order_id WHERE ci.cmr_id='$cmr_id' GROUP BY ci.id";
											}
											else{
												$query="SELECT poi.branch, pl.location_name, poi.item, im.item_name, im.description, im.purchase_unit, po.order_no, po.order_dt, poi.po_qty, poi.indent_qty, im.gst_rate FROM purchase_order_item AS poi LEFT JOIN purchase_order AS po ON po.order_id=poi.order_id LEFT JOIN payroll_locations AS pl ON pl.location_id=poi.branch LEFT JOIN item_master AS im ON im.id=poi.item WHERE poi.order_id='$po_id' ";
											}
											echo $query;
											$result=db_query($query);
											$sl=1;
											$n=0;
											while($pdb=mysqli_fetch_assoc($result))
											{
												$pending_po_qty=$pdb['indent_qty']-$pdb['po_qty'];
											?>
											<tr>
												<td class="text-center" id="slNo"><?php echo $sl;?></td>
												<td>
													<input type="text" style="width: 120px;" readonly value="<?php echo $pdb['location_name'];?>" class="form-control form-control-sm" id="warehouse_name" name="warehouse_name[]" />
													<input type="text" hidden style="width: 120px;" readonly value="<?php echo $pdb['branch'];?>" class="form-control form-control-sm" id="warehouse" name="branch[]" />
												</td>
												<td>
													<input type="text" style="width: 120px;" readonly value="<?php echo $pdb['item_name'];?>" class="form-control form-control-sm" id="item" name="item_name[]" />
													<input type="text"  hidden class="form-control form-control-sm" value="<?php echo $pdb['item'];?>" id="item<?php echo $sl;?>" name="item[]" />
													<input type="text" hidden  class="form-control form-control-sm" value="<?php echo $pdb['id'];?>" name="cmr_item_id[]" />
												</td>
												<td>
													<input type="text" style="width: 120px;" readonly value="<?php echo $pdb['description'];?>" class="form-control form-control-sm" id="itemSpecification0" name="itemSpecification[]" />
												</td>
												<td>
													<input type="text" style="width: 120px;" readonly value="<?php echo $pdb['purchase_unit'];?>" class="form-control form-control-sm" id="unit" name="unit[]"/>
												</td>
												<td>
													<input type="text" style="width: 190px;" readonly value="<?php echo $pdb['order_no'];?>" class="form-control form-control-sm" id="poNo" name="poNo[]"/>
												</td>
												<td>
													<input type="text" style="width: 140px;" class="form-control" readonly value="<?php echo date("d/m/Y", strtotime($pdb['order_dt']));?>" id="poDate" name="poDate[]">
												</td>
												<td>
													<input type="text" style="width: 120px;" class="form-control" readonly value="<?php echo $pdb['po_qty']; ?>" id="poQty<?php echo $n;?>" name="poQty[]" >
												</td>
												<td>
													<input type="text" style="width: 120px;" class="form-control" readonly value="<?php echo $pending_po_qty; ?>"  id="pendingPoQty" name="pending_po_Qty[]">
												</td>
												<td>
													<input type="text" style="width: 120px;" class="form-control" id="receivedQty" name="received_qty[]" value="<?php if(isset($_GET['cmr_id'])){ echo $pdb['received_qty']; } else{ echo '0.00';} ?>" onkeyup="show_pendingQty(this.value)">
												</td>
												<td>
													<input type="text" style="width: 120px;" class="form-control" readonly id="pendingQty<?php echo $n;?>" name="pending_Qty[]" value="<?php if(isset($_GET['cmr_id'])){ echo $pdb['pending_Qty']; } else{ echo '0.00';} ?>">
												</td>
												<td>
													<input type="text" style="width: 120px;" class="form-control" readonly value="<?php echo $pdb['gst_rate']; ?>" id="rate<?php echo $n;?>" name="rate[]">
												</td>
												<td>
													<input type="text" style="width: 120px;" class="form-control" id="discount<?php echo $n;?>" name="discount[]" value="<?php if(isset($_GET['cmr_id'])){ echo $pdb['discount']; } else{ echo '0.00';} ?>" onkeyup="show_gross(this.value)">
												</td>
												<td>
													<input type="text" style="width: 120px;" class="form-control" readonly id="gross<?php echo $n;?>" name="gross[]" value="<?php if(isset($_GET['cmr_id'])){ echo $pdb['gross']; } else{ echo '0.00';} ?>">
												</td>
												<td>
													<input type="date" style="width: 140px;" class="form-control" id="deliveryDate" name="delivery_date[]" value="<?php echo date("Y-m-d", strtotime($pdb['delivery_date'])); ?>">
												</td>
												<td>
													<input type="text" style="width: 200px;" class="form-control" id="remarks" name="remarks[]" value="<?php if(isset($_GET['cmr_id'])){ echo $pdb['remarks']; } else{ echo '0.00';} ?>">
												</td>
											</tr>
											<?php
											$sl++;
											$n++;
											}
											?>
										</tbody>
									</table>	
								</div>
							</div>
							</div>
						</div>

						<div class="accordion mb-1" id="documentsEnclosed">
							<div class="card">
								<div class="card-header" id="headingThree">
									<h2 class="mb-0">
									<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#documents_enclosed" aria-expanded="true" aria-controls="documents_enclosed">
									Documents Enclosed
									<i class="fa fa-minus-circle fa-1x float-right"></i>
									</button>
									</h2>
								</div>
						
								<div id="documents_enclosed" class="collapse" aria-labelledby="headingThree" data-parent="#documentsEnclosed">
									<div class="card-body">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Invoice/Challan</label>
													<div class="col-md-8">
														<select class="form-control" name="invoice">
															<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['invoice']=="Y"){ echo "selected"; } } ?>>Yes</option>
															<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['invoice']=="N"){ echo "selected"; } } ?>>No</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Gate Entry Proof</label>
													<div class="col-md-8">
														<select class="form-control" name="gate_entry_proof">
															<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['gate_entry_proof']=="Y"){ echo "selected"; } } ?>>Yes</option>
															<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['gate_entry_proof']=="N"){ echo "selected"; } } ?>>No</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">RR/LR Copy</label>
													<div class="col-md-8">
														<select class="form-control" name="rr_copy">
															<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['rr_copy']=="Y"){ echo "selected"; } } ?>>Yes</option>
															<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['rr_copy']=="N"){ echo "selected"; } } ?>>No</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Stock Entry Proof</label>
													<div class="col-md-8">
														<select class="form-control" name="stock_entry_proof">
															<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['stock_entry_proof']=="Y"){ echo "selected"; } } ?>>Yes</option>
															<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['stock_entry_proof']=="N"){ echo "selected"; } } ?>>No</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Test Report Copy</label>
													<div class="col-md-8">
														<select class="form-control" name="test_report_copy">
															<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['test_report_copy']=="Y"){ echo "selected"; } } ?>>Yes</option>
															<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['test_report_copy']=="N"){ echo "selected"; } } ?>>No</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">PO Copy</label>
													<div class="col-md-8">
														<select class="form-control" name="po_copy">
															<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['po_copy']=="Y"){ echo "selected"; } } ?>>Yes</option>
															<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['po_copy']=="N"){ echo "selected"; } } ?>>No</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Check List</label>
													<div class="col-md-8">
														<select class="form-control" name="check_list">
															<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['check_list']=="Y"){ echo "selected"; } } ?>>Yes</option>
															<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['check_list']=="N"){ echo "selected"; } } ?>>No</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Road Permit(GST)</label>
													<div class="col-md-8">
														<select class="form-control" name="road_permit">
															<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['road_permit']=="Y"){ echo "selected"; } } ?>>Yes</option>
															<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['road_permit']=="N"){ echo "selected"; } } ?>>No</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Weighment Proof</label>
													<div class="col-md-8">
														<select class="form-control" name="weighment_proof">
															<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['weighment_proof']=="Y"){ echo "selected"; } } ?>>Yes</option>
															<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['weighment_proof']=="N"){ echo "selected"; } } ?>>No</option>	
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Other(Specify)</label>
													<div class="col-md-8">
														<select class="form-control" name="other">
															<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['other']=="Y"){ echo "selected"; } } ?>>Yes</option>
															<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['other']=="N"){ echo "selected"; } } ?>>No</option>	
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">COA</label>
													<div class="col-md-8">
														<select class="form-control" name="coa">
															<option value="Y" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['coa']=="Y"){ echo "selected"; } } ?>>Yes</option>
															<option value="N" <?php if(isset($_GET['cmr_id'])){ if($retrive_row['coa']=="N"){ echo "selected"; } } ?>>No</option>	
														</select>
													</div>
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Invoice/Challan</label>
													<div class="col-md-8">
														<div class="input-group">
															<input type="text" name="invoice_file_nm" class="form-control col-md-8" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['invoice_file']; }?>">
															<span class="fileUpload btn btn-secondary">
																<input type="file" name="invoice_file" class="upload up" id="up"  />
																<span class="upl mr-2" id="upload"><i class="fa fa-folder-open-o pt-1"></i></span>
															</span>
															<button class="btn btn-secondary">
																<span><i class="fa fa-pencil-square-o"></i></span>
															</button>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Gate Entry Proof</label>
													<div class="col-md-8">
														<div class="input-group">
															<input type="text" name="gate_entry_proof_file_nm" class="form-control col-md-8" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['gate_entry_proof_file']; }?>">
															<span class="fileUpload btn btn-secondary">
																<input type="file" name="gate_entry_proof_file" class="upload up" id="up" />
																<span class="upl mr-2" id="upload"><i class="fa fa-folder-open-o pt-1"></i></span>
															</span>
															<button class="btn btn-secondary">
																<span><i class="fa fa-pencil-square-o"></i></span>
															</button>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">RR/LR Copy</label>
													<div class="col-md-8">
														<div class="input-group">
															<input type="text" name="rr_copy_file_nm" class="form-control col-md-8" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['rr_copy_file']; }?>">
															<span class="fileUpload btn btn-secondary">
																<input type="file" name="rr_copy_file" class="upload up" id="up" onchange="readURL(this);" />
																<span class="upl mr-2" id="upload"><i class="fa fa-folder-open-o pt-1"></i></span>
															</span>
															<button class="btn btn-secondary">
																<span><i class="fa fa-pencil-square-o"></i></span>
															</button>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Stock Entry Proof</label>
													<div class="col-md-8">
														<div class="input-group">
															<input type="text" name="stock_entry_proof_file_nm" class="form-control col-md-8" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['stock_entry_proof_file']; }?>">
															<span class="fileUpload btn btn-secondary">
																<input type="file" name="stock_entry_proof_file" class="upload up" id="up" onchange="readURL(this);" />
																<span class="upl mr-2" id="upload"><i class="fa fa-folder-open-o pt-1"></i></span>
															</span>
															<button class="btn btn-secondary">
																<span><i class="fa fa-pencil-square-o"></i></span>
															</button>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Test Report Copy</label>
													<div class="col-md-8">
														<div class="input-group">
															<input type="text" name="test_report_copy_file_nm" class="form-control col-md-8" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['test_report_copy_file']; }?>">
															<span class="fileUpload btn btn-secondary">
																<input type="file" name="test_report_copy_file" class="upload up" id="up" onchange="readURL(this);" />
																<span class="upl mr-2" id="upload"><i class="fa fa-folder-open-o pt-1"></i></span>
															</span>
															<button class="btn btn-secondary">
																<span><i class="fa fa-pencil-square-o"></i></span>
															</button>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">PO Copy</label>
													<div class="col-md-8">
														<div class="input-group">
															<input type="text" name="po_copy_file_nm" class="form-control col-md-8" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['po_copy_file']; }?>">
															<span class="fileUpload btn btn-secondary">
																<input type="file" name="po_copy_file" class="upload up" id="up" onchange="readURL(this);" />
																<span class="upl mr-2" id="upload"><i class="fa fa-folder-open-o pt-1"></i></span>
															</span>
															<button class="btn btn-secondary">
																<span><i class="fa fa-pencil-square-o"></i></span>
															</button>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Check List</label>
													<div class="col-md-8">
														<div class="input-group">
															<input type="text" name="check_list_file_nm" class="form-control col-md-8" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['check_list_file']; }?>">
															<span class="fileUpload btn btn-secondary">
																<input type="file" name="check_list_file" class="upload up" id="up" onchange="readURL(this);" />
																<span class="upl mr-2" id="upload"><i class="fa fa-folder-open-o pt-1"></i></span>
															</span>
															<button class="btn btn-secondary">
																<span><i class="fa fa-pencil-square-o"></i></span>
															</button>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Road Permit(GST)</label>
													<div class="col-md-8">
														<div class="input-group">
															<input type="text" name="road_permit_file_nm" class="form-control col-md-8" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['road_permit_file']; }?>">
															<span class="fileUpload btn btn-secondary">
																<input type="file" name="road_permit_file" class="upload up" id="up" onchange="readURL(this);" />
																<span class="upl mr-2" id="upload"><i class="fa fa-folder-open-o pt-1"></i></span>
															</span>
															<button class="btn btn-secondary">
																<span><i class="fa fa-pencil-square-o"></i></span>
															</button>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Weighment Proof</label>
													<div class="col-md-8">
														<div class="input-group">
															<input type="text" name="weighment_proof_file_nm" class="form-control col-md-8" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['weighment_proof_file']; }?>">
															<span class="fileUpload btn btn-secondary">
																<input type="file" name="weighment_proof_file" class="upload up" id="up" onchange="readURL(this);" />
																<span class="upl mr-2" id="upload"><i class="fa fa-folder-open-o pt-1"></i></span>
															</span>
															<button class="btn btn-secondary">
																<span><i class="fa fa-pencil-square-o"></i></span>
															</button>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">Other(Specify)</label>
													<div class="col-md-8">
														<div class="input-group">
															<input type="text" name="other_file_nm" class="form-control col-md-8" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['other_file']; }?>">
															<span class="fileUpload btn btn-secondary">
																<input type="file" name="other_file" class="upload up" id="up" onchange="readURL(this);" />
																<span class="upl mr-2" id="upload"><i class="fa fa-folder-open-o pt-1"></i></span>
															</span>
															<button class="btn btn-secondary">
																<span><i class="fa fa-pencil-square-o"></i></span>
															</button>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-4 col-form-label">COA</label>
													<div class="col-md-8">
														<div class="input-group">
															<input type="text"  name="coa_file_nm" class="form-control col-md-8"  value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['coa_file']; }?>">
															<span class="fileUpload btn btn-secondary">
																<input type="file" name="coa_file" class="upload up" id="up" onchange="readURL(this);" />
																<span class="upl mr-2" id="upload"><i class="fa fa-folder-open-o pt-1"></i></span>
															</span>
															<button class="btn btn-secondary">
																<span><i class="fa fa-pencil-square-o"></i></span>
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="accordion mb-3" id="transportDetails">
							<div class="card">
							<div class="card-header" id="headingFour">
								<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#transport_details" aria-expanded="true" aria-controls="documents_enclosed">
								Transport Details
								<i class="fa fa-minus-circle fa-1x float-right"></i>
								</button>
								</h2>
							</div>
						
							<div id="transport_details" class="collapse" aria-labelledby="headingFour" data-parent="#transportDetails">
								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Transporter</label>
												<div class="col-md-8">
													<input type="text" name="transporter" class="form-control" id="transporter" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['transporter']; }?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">E-Way Bill No.</label>
												<div class="col-md-8">
													<input type="text" name="vehicle_no" class="form-control" id="eWayBillNo" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['vehicle_no']; }?>">
												</div>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Vehicle No.</label>
												<div class="col-md-8">
													<input type="text" name="eway_bill_no" class="form-control" id="vehicleNo" value="<?php if(isset($_GET['cmr_id'])){ echo $retrive_row['eway_bill_no']; }?>">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>
						<div class="form-group pull-right">
							<button type="reset" class="btn btn-secondary mr-2 mb-5">Cancel</button>
							<input type="hidden" id="row_count" name="row_count" value="<?php echo $n;?>">
							<button type="submit" name="submit" class="btn custom-blue-btn mb-5">Submit</button>
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
			//drawOnCanvas(file);   // see Example 6
			//displayAsImage(file); // see Example 7
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

		$(".add").on('click',function(){
			html = '<tr>'; 
			html += '<td class="text-center" id="slNo">'+i+'</td>';
			html += '<td><select class="select w-100" id="warehouse" name="warehouse[]"><option>...</option><option>Dairy</option></select></td>';
			html += '<td><select class="select w-100" id="item" name="item[]"><option>...</option><option>...</option></select></td>';
			html += '<td><select class="select w-100" id="itemSpecification" name="itemSpecification[]"><option>...</option><option>ABT-5(New)</option></select></td>';
			html += '<td><select class="select w-100" id="unit" name="unit[]"><option>...</option><option>Dairy</option></select></td>';
			html += '<td><select class="select w-100" id="poNo" name="poNo[]"><option>...</option><option>Dairy</option></select></td>';
			html += '<td><input type="date" class="form-control form-control" id="poDate" name="poDate[]"></td>';
			html += '<td><input type="text" class="form-control form-control" id="poQty" name="poQty[]" value="100.00"></td>';
			html += '<td><input type="text" class="form-control form-control" id="pendingPoQty" name="pendingPoQty[]" value="0"></td>';
			html += '<td><input type="text" class="form-control form-control" id="receivedQty" name="receivedQty[]" value="0.00"></td>';
			html += '<td><input type="text" class="form-control form-control" id="pendingQty" name="pendingQty[]" value="0.00"></td>';
			html += '<td><input type="text" class="form-control form-control" id="rate" name="rate[]" value="0.00"></td>';
			html += '<td><input type="text" class="form-control form-control" id="discount" name="discount[]" value="0"></td>';
			html += '<td><input type="text" class="form-control form-control" id="gross" name="gross[]" value="0"></td>';
			html += '<td><input type="date" class="form-control form-control" id="deliveryDate" name="deliveryDate[]"></td>';
			html += '<td><input type="text" class="form-control form-control" id="remarks" name="remarks[]" value="0.00"></td>';
			html += '<td class="text-center"><a href="javascript:void(0);" class="remove"><i class="fa fa-trash fa-1x"></i></a></td>';	 
			html += '</tr>';
			$('table').append(html);
			i++;

			$(".remove").on('click', function () {
					$(this).closest('tr').remove();
			});
		});
	</script>

	<script>
		$(document).on('change','.up', function(){
        var names = [];
        var length = $(this).get(0).files.length;
          for (var i = 0; i < $(this).get(0).files.length; ++i) {
              names.push($(this).get(0).files[i].name);
          }
          // $("input[name=file]").val(names);
        if(length>2){
          var fileName = names.join(', ');
          $(this).closest('.form-group').find('.form-control').attr("value",length+" files selected");
        }
        else{
          $(this).closest('.form-group').find('.form-control').attr("value",names);
        }
     });
	</script>
</body>

</html>
