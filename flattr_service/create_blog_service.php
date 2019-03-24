<?php

/*
* Flattr Service File - To create blogposts
* Created By - Avinash Barik
*/

function create_blog_post($form_content, $blog_url, $blog_status) 
{
	if (!file_exists(PATH_TO_POSTS)) 
	{
		try 
		{
			mkdir(PATH_TO_POSTS, 0777, true);  
    		file_put_contents(PATH_TO_POSTS . ".htaccess", APP_HTACCESS);
    		file_put_contents(PATH_TO_POSTS . "page_not_found.php", file_get_contents($_SERVER[DOCUMENT_ROOT] .'/../flattr_service/flattr_404.php'));
    		file_put_contents(PATH_TO_POSTS . "index.php", file_get_contents($_SERVER[DOCUMENT_ROOT] .'/../flattr_service/post_index.php')); 
		}
		catch (Exception $e)
		{
			echo "Something went wrong while creating directories. Error - " . $e->getMessage();
			exit();
		}
    	   	
	}

	$blog_list = file_get_contents(PATH_TO_POSTS . POST_FILENAME);
	$blog_arr  = json_decode($blog_list); 
	
	if (sizeof($blog_arr) != 0)
	{
		array_push($blog_arr, array("blogURL" => $blog_url, "blogStatus" => $blog_status, "content" => $form_content[0]));
	}
	else
	{
		$blog_arr = array();
		array_push($blog_arr, array("blogURL" => $blog_url, "blogStatus"=> $blog_status, "content" => $form_content[0]));
	}
	
	file_put_contents(PATH_TO_POSTS . POST_FILENAME, json_encode($blog_arr));	
	return true;
}




?>