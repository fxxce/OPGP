<?php
include('includes/config.php');
error_reporting(0);
if (isset($_POST['submit'])) {
	$fullname = $_POST['fullname'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$contactno = $_POST['contactno'];
	$status = 1;
	$query = mysqli_query($con, "insert into users(fullName,userEmail,password,contactNo,status) values('$fullname','$email','$password','$contactno','$status')");
	$msg = "Registration successfull. Now You can login !";
}

$recaptcha = $_POST['g-recaptcha-response'];
$res = reCaptcha($recaptcha);
if(!$res['success']){
  // Error
}

function reCaptcha($recaptcha){
	$secret = "YOUR SECRET KEY";
	$ip = $_SERVER['REMOTE_ADDR'];
  
	$postvars = array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
	$url = "https://www.google.com/recaptcha/api/siteverify";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
	$data = curl_exec($ch);
	curl_close($ch);
  
	return json_decode($data, true);
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Dashboard">
	<meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

	<title>Public Grievance Portal | User Registration</title>
	<link rel="shortcut icon" type="image/png" href="../cms/img/favicon.png"/>

	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/style-responsive.css" rel="stylesheet">

	<script src="https://www.google.com/recaptcha/api.js"></script>

	<script>
		function userAvailability() {
			$("#loaderIcon").show();
			jQuery.ajax({
				url: "check_availability.php",
				data: 'email=' + $("#email").val(),
				type: "POST",
				success: function(data) {
					$("#user-availability-status1").html(data);
					$("#loaderIcon").hide();
				},
				error: function() {}
			});
		}
	</script>
</head>

<body>
	<div id="login-page">
		<div class="container" style="padding-bottom:10rem">
			<h3 align="center"><a href="../index.html"> ←  Public Grievance Portal</a></h3>
			<hr />
			<form class="form-login" method="post" style="margin-top:4%;">
				<h2 class="form-login-heading">User Registration</h2>
				<p style="padding-left: 1%; color: green">
					<?php if ($msg) {
						echo htmlentities($msg);
					} ?>


				</p>
				<div class="login-wrap">
					<input type="text" class="form-control" placeholder="Full Name" name="fullname" required="required" autofocus>
					<br>
					<input type="email" class="form-control" placeholder="Email ID" id="email" onBlur="userAvailability()" name="email" required="required">
					<span id="user-availability-status1" style="font-size:12px;"></span>
					<br>
					<input type="password" class="form-control" placeholder="Password" required="required" name="password"><br>
					<input type="text" class="form-control" maxlength="10" name="contactno" placeholder="Contact no" required="required" autofocus>
					<br>

					<button class="btn btn-theme btn-block" type="submit" name="submit" id="submit"><i class="fa fa-user"></i> Register</button>
					<hr>

					<div class="g-recaptcha brochure__form__captcha" data-sitekey="6LcDOIMaAAAAAD0c9ew0Ixy-uNjic7iwxQpjc08A"></div>
					
					<div class="registration" style="padding-top: 6%;">
						Already Registered?<br />
						<a class="" href="index.php">
							Sign in
						</a>
					</div>

				</div>



			</form>

		</div>
	</div>
	<footer style="position: fixed; margin-bottom: 0%; bottom: 0; left: 0; background-color: black; padding: 10px; color: grey; width: 100%; margin-top: 10px; text-align: center; border-top: rgb(175, 45, 28) 3px solid; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif">
            <div class="row">
                <div class="col-lg-12">
                    <p style="padding-top: 2px;">Copyright &copy; <a>kmbhasan</a> | Public Grievance Portal 2020</p>
                </div>
            </div>
	</footer>

	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

</body>

</html>