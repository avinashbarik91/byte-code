<?php 

/*
* Flattr 404
* Created By - Avinash Barik
*/

include '../../flattr_service/config/config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equip="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie-edge">
	<link rel="stylesheet" href="../flattr/css/bootstrap.min.css">
	<link rel="stylesheet" href="../flattr/css/custom_styles.css">
	<link href="https://fonts.googleapis.com/css?family=Merriweather:400,700|PT+Serif|Nunito" rel="stylesheet">
	<title>404 | Page not found</title>
</head>
<body>

	<nav class="navbar navbar-light bg-light navbar-expand-sm fixed-top">
		<div class="container">	
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
					<a class="nav-item nav-link" href="../index.php">Home</a>
					<a class="nav-item nav-link" href="post_list.php">Blogs</a>
				</div>
			</div>
		</div>
	</nav>
	
	<div class= "container p-5 p-md-5 mt-5" style="height: 90vh;">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<section class="post-blog-header-wrapper mb-3">
					<h1 class="post-blog-title mb-3">404 Error</h1>						
				</section>			
				<section class="post-blog-content mb-5">
					<h2>Sorry, we can’t seem to find what you’re looking for.</h2>
					<p>You've landed on a URL that doesn't seem to exist. 
					<p>Here's some options:</p>

					<li>If you think this is an error on our part, <a href="mailto:<?php echo OFFICIAL_EMAIL; ?>">please let us know. </a></li>					
					<li>Click <a href="../index.php">here</a> to go to the home page.</li>				
				</section>
				<hr/>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>

	<div class="post-footer bg-dark" style="height: 50px;">
		<p class="footer-text text-center mb-0 text-light"><a href="https://github.com/avinashbarik91/flattr-cms">&#9400; Flattr CMS <?php echo date('Y');?></a></p>
	</div>

	<script src="../flattr/js/jquery.slim.min.js"></script>
	<script src="../flattr/js/jquery.min.js"></script>	
	<script src="../flattr/js/popper.js"></script>	
	<script src="../flattr/js/custom.js"></script>
	<script src="../flattr/js/bootstrap.min.js"></script>

</body>
</html>