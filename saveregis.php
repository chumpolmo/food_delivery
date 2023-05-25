<?php
	include('config.php');
	
	if(trim($_POST["username"]) == "")
	{
		echo "Please input Username!";
		exit();	
	}

	if(trim($_POST["name"]) == "")
	{
		echo "Please input Name!";
		exit();	
	}
	
	if(trim($_POST["password"]) == "")
	{
		echo "Please input Password!";
		exit();	
	}	
		
	if($_POST["password"] != $_POST["password2"])
	{
		echo "Password not Match!";
		exit();
	}
	
	if(trim($_POST["email"]) == "")
	{
		echo "Please input Email!";
		exit();	
	}	
	
	$strSQL = "SELECT * FROM users WHERE Username = '".trim($_POST['username'])."' ";
	$objQuery = mysqli_query($db,$strSQL);
	$objResult = mysqli_fetch_array($objQuery);
	if($objResult)
	{
			echo "Username already exists!";
	}
	else
	{	
		
		$strSQL = "INSERT INTO users (Email ,Password ,Username ,Full_Name ,Phone_Number ,Profile_Picture ,isRole) VALUES ('".$_POST["email"]."', 
		'".$_POST["password"]."','".$_POST["username"]."','".$_POST["name"]."','none','default.jpg','".$_POST["ddlStatus"]."')";
		$objQuery = mysqli_query($db,$strSQL);
		
		echo "Register Completed!<br>" ;		
	
		echo "<br> Go to <a href='login.php'>Login page</a>";
		
	}

	mysqli_close();
?>