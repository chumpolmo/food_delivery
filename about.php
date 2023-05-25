<?php session_start(); 
include('config.php');

  $ID = $_SESSION['ID'];
  $name = $_SESSION['username'];
  $pass = $_SESSION['password'];
 	if ($_SESSION['status'] !='10'){  //check session

	  Header("Location: login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form 
}  

  $sql = "SELECT * FROM users WHERE UID = $ID";
    $result = $db->query($sql);


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>About</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/w3.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/1011-0.js"></script>
</head>
<body>
	<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:200px;" id="mySidebar">
	  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
	  <?php while($row = $result->fetch_assoc()): ?>
	  <div class="w3-padding w3-center">
    <img class="w3-circle" src="img/<?php echo $row['Profile_Picture']; ?>" alt="avatar" style="width:75%">
  	</div>
	  <h3>&nbsp;<?php echo $name; ?></h3>
	  <a href="main.php" class="w3-bar-item w3-button">Home</a>
	  <a href="food.php" class="w3-bar-item w3-button">ร้านค้าของฉัน</a>
	  <a href="food_order.php" class="w3-bar-item w3-button">รายการออเดอร์</a>
	  <a href="food_history.php" class="w3-bar-item w3-button">ประวัติการสั่งซื้อ</a>
	  <a href="about.php" class="w3-bar-item w3-button">ข้อมูลของฉัน</a>
	  <a href="logout.php" class="w3-bar-item w3-button">ออกจากระบบ</a>
	</div>

	<!-- Page Content -->
	<div class="w3-main w3-pale-yellow" style="margin-left: 200px;">
		<div class="w3-light-grey">
			<button class="w3-button w3-light-grey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
			<div class="w3-pale-green w3-container" style="text-align: center;">
			  	<h1>-ข้อมูลส่วนตัว-</h1>
			</div>
		</div>

		<div class="w3-container">
	        
			<div class="w3-row-padding w3-margin-top" style="text-align: center;">
				<div class="w3-third">
					<div class="w3-card">
						<img src="img/<?php echo $row['Profile_Picture']; ?>" style="width:100%" onclick="document.getElementById('img01').style.display='block';">
						<div class="w3-container">
							<h4>ข้อมูลประจำตัว</h4>
							<p>
								<label hidden><?php echo $row['UID']; ?></label>
								ผู้ใช้งาน : <?php echo $row['Username']; ?><br>
								ชื่อ : <?php echo $row['Full_Name'];?><br>
								อีเมล : <?php echo $row['Email'];?><br>
								เบอร์โทรศัพท์ : <?php echo $row['Phone_Number'];?>
							</p>
						</div>
					</div>
				</div>
			</div>

			<div id="img01" class="w3-modal">
		    <div class="w3-modal-content">
		        <div class="w3-container ">
		            <span onclick="document.getElementById('img01').style.display='none';" class="w3-button w3-display-topright">&times;</span>
		            <img src="img/<?php echo $row['Profile_Picture']; ?>" style="width:100%">
		            <div class="w3-pale-green w3-container">
									<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
										<label>ไอดี : <?php echo $row["UID"];?></label> <br>
										<label>ชื่อ : <input type="text" name="txtname" size="20" value="<?php echo $row["Full_Name"];?>"></label> <br>
										<label>อีเมล : <input type="text" name="txtemail" size="20" value="<?php echo $row["Email"];?>"></label> <br>
										<label>เบอร์โทรศัพท์ : <input type="text" name="txtphone" size="20" value="<?php echo $row["Phone_Number"];?>"></label> <br>
										<label>รูปโปรไฟล์ : <?php echo $row["Profile_Picture"];?> <input type="file" name="filUpload"></label> <br>
										<input type="submit" name="submit" value="ยืนยัน" class="w3-button w3-lime">
									</form>
								</div>
		        </div>
		    </div>
	  	</div>

    </div>
<?php endwhile ?>
	</div>

<footer class="w3-container w3-theme w3-margin-top w3-light-grey">

</footer>		


		<script type="text/javascript">
		function w3_open() {
	  		document.getElementById("mySidebar").style.display = "block";
		}

		function w3_close() {
		  	document.getElementById("mySidebar").style.display = "none";
		}
	</script>

</body>
</html>
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
					header("Location:about_user.php");
				}
				//header("location:$_SERVER[PHP_SELF]");
				//exit();
			}
		}
		

  mysqli_close($db);
  ?>