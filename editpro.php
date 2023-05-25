<?php
session_start(); 
include('config.php');
$ID = $_SESSION['ID'];
  $name = $_SESSION['username'];
  $pass = $_SESSION['password'];
 	if($pass!=$_SESSION['password']){
    header("Location:login.php");  
  }  
	$sql = "SELECT * FROM users WHERE UID = $ID";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc()):
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit - Profile</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/w3.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/1011-0.js"></script>
</head>
<body>

<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:200px;" id="mySidebar">
	  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
	  <h3>&nbsp;<i class="fa fa-male"></i><?php echo $name; ?></h3>
	  <a href="main.php" class="w3-bar-item w3-button">Home</a>
	  <a href="food.php" class="w3-bar-item w3-button">ร้านค้าของฉัน</a>
	  <a href="about.php" class="w3-bar-item w3-button">ข้อมูลของฉัน</a>
	  <a href="logout.php" class="w3-bar-item w3-button">ออกจากระบบ</a>
	</div>

<div class="w3-main w3-pale-yellow" style="margin-left: 200px;">
	<div class="w3-light-grey">
		<button class="w3-button w3-light-grey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
		<div class="w3-pale-green w3-container" style="text-align: center;">
			  <h1>-แก้ไขข้อมูลส่วนตัว-</h1>
		</div>
	</div>

	<div class="w3-light-grey">
		<div class="w3-pale-green w3-container">
			<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" name="frmMain" enctype="multipart/form-data">
				<label>UID : <?php echo $row["UID"];?></label> <br>
				<label>Name : <input type="text" name="txtname" size="20" value="<?php echo $row["Full_Name"];?>"></label> <br>
				<label>Email : <input type="text" name="txtemail" size="20" value="<?php echo $row["Email"];?>"></label> <br>
				<label>Phone_Number : <input type="text" name="txtphone" size="20" value="<?php echo $row["Phone_Number"];?>"></label> <br>
				<label>Picture : <?php echo $row["Profile_Picture"];?> <input type="file" name="filUpload"></label> <br>
				<input type="submit" name="submit" value="submit" class="w3-button">
			</form>
			<a href="about.php" class="w3-button">Cancel</a>
		</div>
	</div>
</div>
<?php
endwhile;

?>
  <?php 
  if(isset($_POST['submit'])){
  //*** Update Condition ***//
			if(isset($_FILES['filUpload'])){
	        $name_file =  $_FILES['filUpload']['name'];
	        $tmp_name =  $_FILES['filUpload']['tmp_name'];
	        $locate_img ="img/";
	        move_uploaded_file($tmp_name,$locate_img.$name_file);

				$strSQL = "UPDATE users SET ";
				$strSQL .="UID = '".$ID."' ";
				$strSQL .=",Full_Name = '".$_POST["txtname"]."' ";
				$strSQL .=",Username = '".$_POST["txtuser"]."' ";
				$strSQL .=",Password = '".$_POST["txtpass"]."' ";
				$strSQL .=",Email = '".$_POST["txtemail"]."' ";
				$strSQL .=",Phone_Number = '".$_POST["txtphone"]."' ";
				$strSQL .=",Profile_Picture = '".$_FILES["filUpload"]["name"]."' ";
				$strSQL .="WHERE UID = '".$ID."' ";
				$objQuery = mysqli_query($db ,$strSQL);
				if(!$objQuery)
				{
					echo "Error Update [".mysqli_error()."]";
				}else{
					//echo "อัพเดตแล้ว";
					header("Location:about.php");
				}
				//header("location:$_SERVER[PHP_SELF]");
				//exit();
			}
		}
		

  mysqli_close($db);
  ?>
</body>
</html>