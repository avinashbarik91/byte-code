<?php 

/*
* Flattr CMS Admin File - To create blogposts
* Created By - Avinash Barik
*/

include '../../flattr_service/services.php';

session_start();

if (!$_SESSION['is_logged_in'])
{
	header('Location: admin_login.php');
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
	<link href="https://fonts.googleapis.com/css?family=Nunito|Roboto" rel="stylesheet">
	<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
	<link rel="icon" href="images/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<title>Create Blog | Flattr CMS</title>
</head>
<body class="admin-page-wrapper">

	<nav class="navbar navbar-dark bg-dark navbar-expand-sm mb-5">
		<div class="container">	
			<span><img class="flattr-logo" src="images/flattr_main.png"/></span>
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
					<a class="nav-item nav-link" href="/flattr/admin_login.php">Admin</a>
					<a class="nav-item nav-link" href="../posts/all">Blogs</a>
				</div>
			</div>
		</div>
	</nav>
	
	<div class= "container create-form-wrapper mb-5">
		<div class="row">			
			<section class="col-md-8">
				<i class="fas fa-pen-nib"></i>
				<h1 id="admin-title">Create Blog</h1>
				<form id="create-blog-form">
					<input id="blog-url" name="blog-url" type="text" class="form-control blog-items" placeholder="Blog URL" value=""/>				
					<input id="blog-title" name="blog-title" type="text" class="form-control blog-items" placeholder="Blog Title" value=""/>
					<input id="blog-author" name="blog-author" type="text" class="form-control blog-items" placeholder="Author" value=""/>
					<input id="blog-tags" name="blog-tags" type="text" class="form-control blog-items" placeholder="Tag 1, Tag 2" value=""/>

					<!-- The Editor -->
					<textarea id="flattr-cms-editor" class="blog-items" style="height:475px; width: 100%;"></textarea>

					<input type="submit" id="create-blog-submit-btn" class=" btn btn-primary blog-items" value="Create" />

					<!-- Delete Button Modal -->
					<div class="modal fade" tabindex="-1" id="delete-btn-modal" role="dialog">
					  	<div class="modal-dialog modal-dialog-centered" role="document">
					    	<div class="modal-content">
					      		<div class="modal-header">
						        	<h5 class="modal-title">Delete Blog</h5>
						        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          	<span aria-hidden="true">&times;</span>
						        	</button>
					      		</div>
					    		<div class="modal-body">
					        		<p>Are you sure you want to delete this blog?</p>
					    		</div>
							    <div class="modal-footer">
							        <button type="button" class="btn btn-danger delete-btn-blog-final" data-dismiss="modal" data-attribute="">Delete</button>
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							    </div>
					    	</div>
					 	</div>
					</div>
				</form>				
			</section>	
			<section class="col-md-4">				
				<?php 

				$blogs 		= read_active_blog_posts(); ?>
					<div class="">
						<div class="row mb-2 admin-right-nav-wrapper mt-5">
							<div class="offset-md-1 col-md-11 admin-right-nav">
								<i class="fas fa-user"></i>
								<span class="text-dark font-weight-bold">Hi, Admin</span>
								<hr/>
								<span class="text-dark admin-logout"><a href="admin_login.php?action=logout"><i class="fas fa-sign-out-alt pr-2"></i>Logout</a></span>	
								<span class="text-dark version-span"><i class="fas fa-code-branch pr-2"></i>Version <?php echo APP_VERSION_NO;?></span>
								<hr/>							
								<span class="text-dark font-weight-bold">Manage Posts</span>
								
							</div>
						</div>
						<div class="admin-all-posts-bg-wrapper">
							<?php 

							if (sizeof($blogs) == 0)
							{
								echo "<p class='pl-1 text-muted'><em>No blogs here</em></p>";
							}

							foreach($blogs as $blog) { ?>						
								<div class="row pl-2 pl-md-3 admin post-all-wrapper">	
									<div class="offset-md-1 col-md-11 single-post-wrapper mb-2">										
										<a class="single-post-link" class="d-md-block" href="../posts/<?php echo $blog->blogURL; ?>">
											<div class="col-md-10 all-post-headers d-inline-block">
												<span class="single-post-title py-3"><?php echo $blog->content->blogTitle; ?></span>
												<!-- <span class="single-post-author">By <?php echo $blog->content->blogAuthor; ?></span>
												<span class="single-post-date"><?php echo date('d M Y', strtotime($blog->content->blogDate)); ?></span> -->
											</div>
											<!-- <?php echo read_blog_image($blog->content->blogContent); ?> -->
										</a>										
										<i class="fas fa-edit px-3 blog-edit-btn blog-btns" data-toggle="modal" data-attribute="<?php echo $blog->blogURL; ?>"></i>	
										<i class="fas fa-trash-alt px-3 blog-delete-btn blog-btns" data-toggle="modal" data-target="#delete-btn-modal" data-attribute="<?php echo $blog->blogURL; ?>"></i>									
									</div>									
								</div>
							<?php } ?>	
						</div>
					</div>
			</section>
		</div>	
	</div>

	<div class="post-footer bg-dark" style="height: 50px;">
		<p class="footer-text text-center mb-0 text-light"><a href="https://github.com/avinashbarik91/flattr-cms">&#9400; Flattr CMS <?php echo date('Y');?> By Avinash Barik</a></p>
	</div>

	<script src="js/jquery.slim.min.js"></script>
	<script src="js/jquery.min.js"></script>	
	<script src="js/popper.js"></script>
	<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=<?php echo TINY_MCE_API_KEY; ?>"></script>
	<script src="js/admin.js"></script>
	<script src="js/bootstrap.min.js"></script>

</body>
</html>

