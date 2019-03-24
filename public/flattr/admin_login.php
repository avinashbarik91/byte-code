<?php 

/*
* Flattr Admin Login
* Created By - Avinash Barik
*/

include '../../flattr_service/services.php';
session_start();

$redirec_url = '';

if(!empty($_GET['destination']))
{
    $redirec_url = explode('destination=', $_SERVER['REDIRECT_QUERY_STRING']);
    $redirec_url = urlencode($redirec_url[1]);
}

if (isset($_GET['action']))
{
	if ($_GET['action'] == "login")
	{
		if ((isset($_POST['username']) && $_POST['username'] != "") && (isset($_POST['password']) && $_POST['password'] != ""))
		{
			if ($_POST['username'] == ADMIN_ID && $_POST['password'] == ADMIN_PASSWORD)
			{
				$_SESSION['is_logged_in'] = true;
				header('Location: admin.php');
			}
			else
			{
				$login_err = "Incorrect Username or Password. Please try again.";
			}
		}
		else
		{
			if ($_POST['username'] == "")
			{
				$login_err = "Username is required";
			}
			else if ($_POST['password'] == "")
			{
				$login_err = "Password is required";
			}
		}
	}
	else if ($_GET['action'] == 'logout')
	{
		session_destroy();
		header('Location: admin_login.php');
	}
}

if ($_SESSION['is_logged_in'])
{
	header('Location: admin.php');
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equip="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie-edge">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/custom_styles.css">
	<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
	<link rel="icon" href="images/favicon.png" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Nunito|Roboto" rel="stylesheet">
	<title>Admin Login | Flattr CMS</title>
</head>
<body class="admin-login-page">

	<nav class="navbar navbar-dark bg-dark navbar-expand-sm mb-5">
		<div class="container">	
			<span><img class="flattr-logo" src="../flattr/images/flattr_main.png"/></span>
			<span class="navbar-brand"><a href="../index.php">
				<?php echo NAVBAR_BRAND; ?>
			</a></span>
			<button class="navbar-toggler" type="button"
				data-toggle="collapse" data-target="#myTogglerNav" aria-controls="myTogglerNav" 
				aria-expanded="false" 
				aria-label="Toggle Navigation">
					<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="myTogglerNav">
				<div class="navbar-nav ml-auto">
					<a class="nav-item nav-link" href="/flattr/admin.php">Admin</a>
					<a class="nav-item nav-link" href="/posts/all">Blogs</a>
					<a class="nav-item nav-link" href="#">About</a>
				</div>
			</div>
		</div>
	</nav>
	
	<div class= "container admin-login-wrapper p-5 bg-white">
		<div class="row admin-section-wrapper">			
			<h4 class="offset-4 col-md-4 pl-0 mb-3 login-text text-center"><img class="flattr-logo" src="../flattr/images/flattr_main.png"/>Flattr CMS Admin Login</h4>
			<div class="col-md-4"></div>			
			<section class="pl-0 offset-4 col-md-4 login-form-wrapper">				
				<form method="post" action="admin_login.php?action=login&destination=<?php echo $redirec_url; ?>">
					<div class="form-group">						
						<input id="username" name="username" type="text" class="form-control admin-login-fields" placeholder="Username" value=""/>	 
					</div>
					<div class="form-group">						
						<input id="password" name="password" type="password" class="form-control admin-login-fields" placeholder="Password" value=""/>	
					</div> 
					<div class="text-danger login-err mb-3"><?php echo $login_err ?></div>
					<input class="btn btn-secondary" type="submit" style="width:100%;" value="Login"/>
				</form>
			</section>
		</div>		
	</div>	

	<div class="post-footer bg-dark" style="height: 50px;">
		<p class="footer-text text-center mb-0 text-light"><a href="https://github.com/avinashbarik91/flattr-cms">&#9400; Flattr CMS <?php echo date('Y');?> By Avinash Barik  </a></p>
	</div>

	<script src="js/jquery.slim.min.js"></script>
	<script src="js/jquery.min.js"></script>	
	<script src="js/popper.js"></script>	
	<script src="js/admin.js"></script>
	<script src="js/bootstrap.min.js"></script>

</body>
</html>

