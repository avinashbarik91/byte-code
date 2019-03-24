<?php 

/*
* Flattr Index File - To render blogs
* Created By - Avinash Barik
*/

include '../../flattr_service/config/config.php';
include '../../flattr_service/read_blog_service.php';

//Render Single Blog/Blog List
render_post_index_html($request_url, $full_path, $blog, $blogs, $prev_blog, $next_blog);

?>
