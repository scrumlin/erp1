<?php 
include('includes/connection.php');

if (isset($_SESSION['nm'])):
    header("location:dashboard.php");
endif;

if(isset($_POST['submit']))
{

$uname=$connect->real_escape_string($_POST["uname"]);
$pwd=$connect->real_escape_string($_POST['pwd']);

$sql = "SELECT * FROM admin_login WHERE user_name='$uname' AND password='$pwd'";

	$result = db_query($sql);
	if ($result->num_rows > 0) 
	{
    	while($row = $result->fetch_assoc())
    	{ 
    		//echo "Login Successfully";
    		
    		
    		$_SESSION['id']=$row["id"];
            
    		header("location:dashboard.php");
    	}
    }
    
    else {
    	$msg="incorrect Username or Password";
    	print "<script>";
                        print "self.location = 'index.php?strmsg=$msg';";
                        print "</script>";
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Scrumlin ERP - Login</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->


     <script>
   function onSubmit(token) {
     document.getElementById("demo-form").submit();
   }
 </script>
    </head>
    <body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                    	<div class="login-left">
							<img class="img-fluid" src="assets/img/sl1.png" alt="Logo">
                        </div>
                        <div class="login-right">
							<div class="login-right-wrap">
								<h1>Login</h1>
								<p class="account-subtitle">Access to our dashboard</p>
								
						<?php if (isset($_GET['strmsg'])) { ?><center><span style="color:red;"><?php echo $_GET['strmsg']; ?></span></center><?php } ?>
								<!-- Form -->
								<form action="index.php" method="post" name="form1">
									<input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Username" name="uname" required>
									</div>
									<div class="form-group">
										<input class="form-control" type="password" placeholder="Password" name="pwd" required>
									</div>
									<div class="form-group">
										
										<button class="btn btn-primary btn-block" type="submit" name="submit">Login</button>
									</div>
								</form>
								<!-- /Form -->								
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="assets/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
	
<script src="https://www.google.com/recaptcha/api.js?render=<?php print $sitekey; ?>"></script>
<script>
grecaptcha.ready(function () {
	grecaptcha.execute('<?php print $sitekey; ?>',{action:'login'}).then(function(token){
		var recaptchaResponse = document.getElementById('recaptchaResponse');
		recaptchaResponse.value = token;
	});
});
</script>
    </body>

</html>