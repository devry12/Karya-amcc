
<!DOCTYPE HTML>
<html>
<head>
<title>Amcc Karya Login</title>
<!-- Custom Theme files -->
<link href="<?=base_url()?>assets/theme1/login/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!-- for-mobile-apps -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Flat Login Form Widget Responsive, Login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<!-- //for-mobile-apps -->
<!--Google Fonts-->
<link href='//fonts.googleapis.com/css?family=Signika:400,600' rel='stylesheet' type='text/css'>
<!--google fonts-->
</head>
<body>
<!--header start here-->
<h1>Login</h1>
<div class="header agile">
	<div class="wrap">
		<div class="login-main wthree">
			<div class="login">
				<?php echo form_error('email'); ?>
				<?php echo form_error('password'); ?>
				<?php echo $this->session->flashdata('error_pass'); ?>
			<form action="" method="post">
				<input type="text" placeholder="Email" required="" name="email">
				<input type="password" placeholder="Password" name="password">
				<input type="submit" value="Login">
			</form>
			<div class="clear"> </div>

			</div>

		</div>
	</div>
</div>
<!--header end here-->
<!--copy rights end here-->
<div class="copy-rights w3l">
	<p>© 2016  All Rights Reserved</p>
</div>
<!--copyrights start here-->

</body>
</html>
