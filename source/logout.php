<?php
include("includes/connection.php");
session_start();
if (isset($_SESSION['id'])):
    session_regenerate_id();
    unset($_SESSION['id]']);
    
    session_unset();
endif;
print "<script>";
$msg = "You have logged out  successfully.";
print "self.location='index.php?strmsg=$msg';";
print "</script>";
?>
