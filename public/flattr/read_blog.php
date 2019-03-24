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
	//Read Blog
	if (isset($_POST['blogURL']))
	{	
		//Add Blog URL
		$blogURL = $_POST['blogURL'];		

		if (isset($_POST['functionType']))
		{
			if ($_POST['functionType'] == "read_blog")
			{
				//Read Blog	
				$blogObj = read_blog_post($blogURL);

				//Return
				echo json_encode(array('blogObj' => $blogObj->blog));
			}			
		}
		else
		{
			throw new Exception("functionType can't be null");
		}		
	}
	else
	{
		throw new Exception("Form content can't be null");
	}	
}
catch (Exception $e)
{
	echo json_encode(array('error' => 'Error while reading blog.' . $e->getMessage()));
}

?>