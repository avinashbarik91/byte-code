<?php 

include '../../flattr_service/services.php';

session_start();

if (!$_SESSION['is_logged_in'])
{
	header('Location: admin_login.php');
	exit();
}

try
{
	//Create Blog
	if (isset($_POST['formValues']) && isset($_POST['blogURL']))
	{	
		//Add Blog URL and status	
		$blogURL = strtolower(str_replace(" ", "-", trim($_POST['blogURL'])));
		$blogStatus = "active";	

		if (isset($_POST['functionType']))
		{
			if ($_POST['functionType'] == "createPost")
			{
				//Create Blog	
				create_blog_post($_POST["formValues"], $blogURL, $blogStatus);

				//Return
				echo json_encode(array('success' => 'Blog Added'));
			}
			else if ($_POST['functionType'] == "updatePost")
			{							
				//Upate Blog	
				update_blog_post($_POST["formValues"], $blogURL, $blogStatus);

				//Return
				echo json_encode(array('success' => 'Blog Updated'));
			}			
		}
		else
		{
			throw new Exception("functionType can't be null");
		}
		
	}
	else if (($_POST['functionType'] == "deletePost") && (isset($_POST['blogURL'])))
	{
		$blogURL = $_POST['blogURL'];
		$blogStatus = "deleted";	
		//Delete Blog	
		delete_blog_post($blogURL, $blogStatus);

		//Return
		echo json_encode(array('success' => 'Blog Deleted'));
			
	}
	else
	{
		throw new Exception("Invalid request params");
	}
	
}
catch (Exception $e)
{
	echo json_encode(array('error' => 'Error while creating blog.' . $e->getMessage()));
}

?>