<?php
include "tpls/header.php";
include "config.php";
?>
<body>
<?php
	echo "<nav class=\"navbar navbar-default bg_title_1\">";
    echo "<span>"._TITLE."</span>";
	echo "</nav>";

	if(trim($_POST["username"]) == "")
	{
		echo "<div class=\"alert alert-warning m-t-16 m-l-16 m-r-16\">";
		echo "<strong>Warning!</strong> กรุณากรอกชื่อผู้ใช้";
		echo "</div>";
		echo "<div class=\"text-center p-t-16 p-b-16\">";
		echo "กรุณากรอกข้อมูลและสมัครสมาชิกใหม่อีกครั้ง <a class=\"txt2\" href=\"register.php\">";
		echo "สมัครสมาชิกคลิกที่นี่</a>";
		echo "</div>";
		exit();	
	}

	// if(trim($_POST["name"]) == "")
	// {
	// 	echo "Please input Name!";
	// 	exit();	
	// }
	
	if(trim($_POST["password"]) == "")
	{
		echo "<div class=\"alert alert-warning m-b-16 m-l-16 m-r-16\">";
		echo "<strong>Warning!</strong> กรุณากรอกรหัสผ่าน";
		echo "</div>";
		echo "<div class=\"text-center p-t-16 p-b-16\">";
		echo "กรุณากรอกข้อมูลและสมัครสมาชิกใหม่อีกครั้ง <a class=\"txt2\" href=\"register.php\">";
		echo "สมัครสมาชิกคลิกที่นี่</a>";
		echo "</div>";
		exit();	
	}	
		
	if($_POST["password"] != $_POST["password2"])
	{
		echo "<div class=\"alert alert-warning m-t-16 m-l-16 m-r-16\">";
		echo "<strong>Warning!</strong> รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน";
		echo "</div>";
		echo "<div class=\"text-center p-t-16 p-b-16\">";
		echo "กรุณากรอกข้อมูลและสมัครสมาชิกใหม่อีกครั้ง <a class=\"txt2\" href=\"register.php\">";
		echo "สมัครสมาชิกคลิกที่นี่</a>";
		echo "</div>";
		exit();
	}
	
	if(trim($_POST["email"]) == "")
	{
		echo "<div class=\"alert alert-warning m-t-16 m-l-16 m-r-16\">";
		echo "<strong>Warning!</strong> กรุณากรอกอีเมล";
		echo "</div>";
		echo "<div class=\"text-center p-t-16 p-b-16\">";
		echo "กรุณากรอกข้อมูลและสมัครสมาชิกใหม่อีกครั้ง <a class=\"txt2\" href=\"register.php\">";
		echo "สมัครสมาชิกคลิกที่นี่</a>";
		echo "</div>";
		exit();	
	}	
	
	$strSQL = "SELECT * FROM users WHERE Username = '".trim($_POST['username'])."' ";
	$objQuery = mysqli_query($db,$strSQL);
	$objResult = mysqli_fetch_array($objQuery);
	if($objResult)
	{
		echo "<div class=\"alert alert-danger m-t-16 m-l-16 m-r-16\">";
		echo "<strong>Warning!</strong> ชื่อผู้ใช้นี้มีในระบบแล้ว";
		echo "</div>";
		echo "<div class=\"text-center p-t-16 p-b-16\">";
		echo "กรุณากรอกข้อมูลและสมัครสมาชิกใหม่อีกครั้ง <a class=\"txt2\" href=\"register.php\">";
		echo "สมัครสมาชิกคลิกที่นี่</a>";
		echo "</div>";
	}
	else
	{	
		
		$strSQL = "INSERT INTO users (Email ,Password ,Username ,Full_Name ,Phone_Number ,Profile_Picture ,isRole) VALUES ('".$_POST["email"]."', 
		'".$_POST["password"]."','".$_POST["username"]."','".$_POST["name"]."','none','default.jpg','".$_POST["ddlStatus"]."')";
		$objQuery = mysqli_query($db,$strSQL);	
	
  		echo "<div class=\"alert alert-success m-t-16 m-l-16 m-r-16\">";
		echo "<strong>Success!</strong> การลงทะเบียนสำเร็จ";
		echo "</div>";
		echo "<div class=\"text-center p-t-16 p-b-16\">";
		echo "คุณเป็นสมาชิกเรียบร้อยแล้ว? <a class=\"txt2\" href=\"login.php\">";
		echo "เข้าสู่ระบบที่นี่</a>";
		echo "</div>";
	}

	echo "<div class=\"text-center p-t-32 p-b-32\">";
	echo "<a class=\"txt2\" href=\"login.php\">";
	echo "<i class=\"fa fa-home m-l-5\" aria-hidden=\"true\"></i> ";
	echo " หน้าหลัก"; 
	echo "</a>";
	echo "</div>";

	mysqli_close($db);
?>
</body>
</html>
