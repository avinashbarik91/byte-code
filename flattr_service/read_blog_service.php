<?php

/*
* Flattr Service File - To read blogposts
* Created By - Avinash Barik
*/

function read_blog_post($request_url) 
{
	$blog_arr  		= read_active_blog_posts();
	$blog_index 	= 0;
	$blog  			= null;
	$next_blog 		= null;
	$prev_blog 		= null;

	foreach ($blog_arr as $entry) 
	{		
		if ($entry->blogURL == $request_url)
		{
			$blog = $entry;
			break;
		}

		$blog_index++;
	}

	if (($blog_index + 1) <= sizeof($blog_arr))
	{
		$next_blog = $blog_arr[($blog_index + 1)];
	}

	if (($blog_index - 1) >= 0)
	{
		$prev_blog = $blog_arr[($blog_index - 1)];
	}
	
	return (object) array("blog" => $blog, "prev_blog" => $prev_blog, "next_blog" => $next_blog);
}

function read_all_blog_posts() 
{
	$blog_list 		= file_get_contents(PATH_TO_POSTS . POST_FILENAME);
	$blog_arr  		= json_decode($blog_list);	

	if (sizeof($blog_arr) > 0)
	{
		return array_reverse($blog_arr);
	}

	return null;
}

function read_active_blog_posts()
{
	$blog_arr = read_all_blog_posts();
	$blogs_active = array();

	usort($blog_arr, "compare_dates");

	foreach ($blog_arr as $entry) 
	{		
		if ($entry->blogStatus == "active")
		{
			array_push($blogs_active, $entry);			
		}		
	}

	return $blogs_active;

}

function compare_dates($a, $b)
{
    if (strtotime($a->content->blogDate) == strtotime($b->content->blogDate)) {
        return 0;
    }
   
    return (strtotime($a->content->blogDate) < strtotime($b->content->blogDate) ? 1 : -1);
}

function read_blog_image($content)
{	
	$src = "";
	$blog_image_div_html = "";
	
	if (strpos($content, "<img ") !== false)
	{
		$parts = explode("<img ", $content);
		$end = explode("/>", $parts[1]); 
		$end = explode("src=", $end[0]);
		$src = explode('"', $end[1]);	

		if ($src[1] != "") 
		{	
			$blog_image_div_html = '<div 	class="blog-image col-md-4 d-none d-md-inline-block float-right" 
									 		style="background:url(' . $src[1] . '); height: 160px;
							    			background-position: center;
							    			background-size: cover;">				 	
									</div>';
		}


	}
	
	return $blog_image_div_html;
								
}


function render_post_index_html($request_url, $full_path, $blog, $blogs, $prev_blog, $next_blog)
{

	$full_path 		= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];
	$full_path 		= htmlspecialchars($full_path, ENT_QUOTES, 'UTF-8' );
	$parts 			= explode("/", $_SERVER['REQUEST_URI']);
	$request_url 	= $parts[sizeof($parts) - 1];

	if (strtolower($request_url) == "blog_directory.json")
	{
		include "page_not_found.php";
		exit();
	}

	if ($request_url == "all" || $request_url == "")
	{
		$blogs 		= read_active_blog_posts();
	}
	else
	{
		$blog 		= read_blog_post($request_url)->blog;
		$prev_blog 	= read_blog_post($request_url)->prev_blog;
		$next_blog 	= read_blog_post($request_url)->next_blog;
	}

	if (is_null($blog) && is_null($blogs))
	{
		include "page_not_found.php";
		exit();
	}

	$index_html = '
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equip="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie-edge">
		<meta property="og:title" content="' . $blog->content->blogTitle . '"/>		
		<meta property="og:description" content="' . $blog->content->blogTitle . '"/>
		<meta property="og:url" content="' . $full_path . '"/>
		<meta property="og:type" content="Blog"/>
		<link rel="shortcut icon" href="' . FAVICON_PATH . '" type="image/x-icon">
		<link rel="icon" href="' . FAVICON_PATH . '" type="image/x-icon">
		<link rel="stylesheet" href="../flattr/css/bootstrap.min.css">
		<link rel="stylesheet" href="../flattr/css/custom_styles.css">
		<link href="https://fonts.googleapis.com/css?family=Merriweather:400,700|PT+Serif|Nunito" rel="stylesheet">
		<title>';

		if (!is_null($blog)) 
		{ 
			$index_html .= $blog->content->blogTitle; 
		} 
		else if (!is_null($blogs)) 
		{ 
			$index_html .= "All Blog Posts";
		}

		$index_html .= '</title>	
	</head>
	<body>

		<nav class="navbar navbar-light bg-light navbar-expand-sm fixed-top">
			<div class="container">	
				<span class="navbar-brand"><a href="../index.php">
					 ' . NAVBAR_BRAND . '
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
						<a class="nav-item nav-link" href="all">Blogs</a>
					</div>
				</div>
			</div>
		</nav>';
		
		if (!is_null($blog)) 
		{ 
			$index_html .= 
			'<!-- Single Blog Section -->
			<div class="posts-body-wrapper container p-5 p-md-5 mt-5">
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<section class="post-blog-header-wrapper mb-3">
							<h1 class="post-blog-title mb-3">' . $blog->content->blogTitle . '</h1>					
							<span class="d-none d-md-block col-1"><img src="../flattr/images/authored.png" class="post-blog-author-icon"/></span>
							<div class="px-md-5">
								<span class="text-muted post-blog-author d-block">' . $blog->content->blogAuthor . '</span>
								<span class="text-muted post-blog-date d-block">' . date("d M Y", strtotime($blog->content->blogDate)) . '</span>	
							</div>
						</section>			
						<section class="post-blog-content mb-5">
							 ' . $blog->content->blogContent . '					
						</section>
						<hr/>
					</div>
					<div class="col-md-2"></div>
				</div>
				<div class="row mb-3">
					<div class="post-share-btns pt-2">
						<p class="text-center">SHARE</p>
							<!-- Twitter -->
							<a alt="Share on Twitter" title="Share on Twitter" href="https://twitter.com/intent/tweet?text="Read my latest blog - ' . $blog->content->blogTitle . '&url=' . $full_path . '&via=' . TWITTER_HANDLE . '" target="_blank" class="twitter-share-btn"></a>

							<!-- Facebook -->
							<a alt="Share on Facebook" title="Share on Facebook" href="https://www.facebook.com/sharer/sharer.php?u=' . $full_path .'" target="_blank" class="facebook-share-btn"></a>

							<!-- LinkedIn -->
							<a alt="Share on LinkedIn" title="Share on LinkedIn" href="https://www.linkedin.com/shareArticle?mini=true&url=' . $full_path . '&title=' . $blog->content->blogTitle . '&source='. $_SERVER["HTTP_HOST"] .'>&summary=Read my latest blog" target="_blank" class="linked-in-share-btn"></a>
					</div>			
				</div>

				<hr class="mb-5"/>';

				if (!is_null($prev_blog) || !is_null($next_blog))
				{
					$index_html .=  
					'<div class="blog-nav-btns mb-3">';			
						if (!is_null($prev_blog)) 
						{
							$index_html .= '<a alt="Previous Blog" title="Previous Blog" href="' . $prev_blog->blogURL . '" class="btn btn-dark post-prev-blog">&#171; Previous Blog</a>';
						}

						if (!is_null($next_blog)) 
						{
							$index_html .= '<a alt="Next Blog" title="Next Blog" href="' . $next_blog->blogURL . '" class="btn btn-dark post-next-blog">Next Blog &#187;</a>';
						}						
					$index_html .=  '</div>';
				}

				$index_html .= 
				'<!-- DISQUS SECTION -->';
						if (SHOW_COMMENTS_SECTION) 
						{ 				
							$index_html .= '
							<h5 class="mb-2">Share your thoughts</h5>
							<hr/>
							<div id="disqus_thread"></div>
							<script>					
								var disqus_config = function () {
								this.page.url = "' . $full_path . '"
								this.page.identifier = "' . $full_path . '"; 
								};
								
								(function() {
									var d = document, s = d.createElement("script");
									s.src = "https://'.DISQUS_SITE_NAME.'.disqus.com/embed.js";
									s.setAttribute("data-timestamp", +new Date());
									(d.head || d.body).appendChild(s);
								})();
							</script>
							<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>';

				}

			$index_html .= '</div>
			<!-- Single Blog Section END-->';
		}

		if (!is_null($blogs))
		{
		
			$index_html .= 

			'<!-- All Blogs Section -->
			<div class= "all-posts-wrapper container p-5 p-md-5 mt-5" style="min-height: 90vh;">	
				<div class="row mb-2">
					<div class="col-md-2"></div>
					<div><h1>All Blogs</h1></div>				
				</div>
				<hr class="mb-4"/>
				
				<div class="all-post-internal-wrapper">';
					
					if (sizeof($blogs) == 0)
					{
						$index_html .=  "<p class='text-muted'><em>Sorry, no blogs here</em></p>";
					}

					foreach($blogs as $blog) 
					{
						$index_html .=  

						'<div class="row post-all-wrapper mb-2">
							
							<div class="col-md-2"></div>
							<div class="single-post-wrapper col-md-8 mb-2">

								<div class="row">
									<a class="single-post-link" class="d-md-block" href="' . $blog->blogURL .'">
										<div class="col-md-8 all-post-headers d-inline-block">
											<span class="single-post-title py-3">' . $blog->content->blogTitle . '</span>
											<span class="single-post-author">By ' . $blog->content->blogAuthor . '</span>
											<span class="single-post-date">' . date('d M Y', strtotime($blog->content->blogDate)) . '</span>
										</div>';

										$index_html .= read_blog_image($blog->content->blogContent);

									$index_html .=  '
									</a>
								</div>
							</div>
							<div class="col-md-2"></div>
						</div>';
					}		
				$index_html .= '</div>	<!--End internal wrapper -->
				<hr class="my-5"/>
			</div> <!--End All post wrapper -->';

		}
		
		$index_html .= 
		'<div class="post-footer bg-dark" style="height: 50px;">
			<p class="footer-text text-center mb-0 text-light"><a href="https://github.com/avinashbarik91/flattr-cms">&#9400; Created Using Flattr CMS ' . date('Y') . '</a></p>
		</div>

		<script src="../flattr/js/jquery.slim.min.js"></script>
		<script src="../flattr/js/jquery.min.js"></script>	
		<script src="../flattr/js/popper.js"></script>	
		<script src="../flattr/js/post.js"></script>
		<script src="../flattr/js/bootstrap.min.js"></script>

	</body>
	</html>';

	echo $index_html;			
}

?>