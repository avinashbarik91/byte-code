<?php 

/*
* Flattr Service File - To update blogposts
* Created By - Avinash Barik
*/


function update_blog_post($form_content, $blog_url, $blog_status) 
{
	$blog_list 	= file_get_contents(PATH_TO_POSTS . POST_FILENAME);
	$blog_arr  	= json_decode($blog_list); 

	foreach ($blog_arr as &$entry) 
	{		
		if ($entry->blogURL == $blog_url && $entry->blogStatus == "active")
		{
			$entry->content = $form_content[0];			
			break;
		}		
	}	
	
	file_put_contents(PATH_TO_POSTS . POST_FILENAME, json_encode($blog_arr));	
	return true;
}

function delete_blog_post($blog_url, $blog_status) 
{
	$blog_list 	= file_get_contents(PATH_TO_POSTS . POST_FILENAME);
	$blog_arr  	= json_decode($blog_list); 

	foreach ($blog_arr as &$entry) 
	{		
		if ($entry->blogURL == $blog_url && $entry->blogStatus == "active")
		{
			$entry->blogStatus = $blog_status;		
			break;
		}		
	}	
	
	file_put_contents(PATH_TO_POSTS . POST_FILENAME, json_encode($blog_arr));	
	return true;
}


?>