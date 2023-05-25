<?php session_start(); 
include('config.php');

  $ID = $_SESSION['ID'];
  $name = $_SESSION['username'];
  $pass = $_SESSION['password'];
 	if($pass!=$_SESSION['password']){
    Header("Location: login.php");  
  }  
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add - Food</title>
	<link rel="stylesheet" href="css/w3.css">
	<script src="js/jquery.min.js"></script>
</head>
<body>
	<!-- Sidebar -->
	<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:200px;" id="mySidebar">
	  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
	  <h3><?php echo $name; ?></h3>
	  <a href="main.php" class="w3-bar-item w3-button">Home</a>
	  <a href="food.php" class="w3-bar-item w3-button">ร้านค้าของฉัน</a>
	  <a href="about.php" class="w3-bar-item w3-button">ข้อมูลของฉัน</a>
	  <a href="logout.php" class="w3-bar-item w3-button">ออกจากระบบ</a>
	</div>

	<!-- Page Content -->
	<div class="w3-main w3-pale-yellow" style="margin-left: 200px;">
		<div class="w3-light-grey">
			<button class="w3-button w3-light-grey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
			<div class="w3-pale-green w3-container">
			  	<h1>Food - Delivery</h1>
			  	<p>ร้านอาหารฉัน</p>
			</div>
		</div>
		<hr>

		<div class="w3-pale-yellow w3-container">
			  	<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
			  		ชื่อร้าน : <input type="text" name="Name" size="20"> <br>
			  		รายละเอียดร้าน : <input type="text" name="Description" size="30"> <br>
			  		ที่อยู่ร้าน : <input type="textarea" name="Location"> <br>
			  		เวลาเปิด : <input type="text" name="Hours"> <br>
			  		รูปร้าน : <input type="file" name="filUpload1"> <br>
			  		รูปอาหารของร้าน : <input type="file" name="filUpload2"> <br>
			  		คิวอาร์โค้ด : <input type="file" name="filUpload3"> <br>
			  		ประเภท : <select name="cid" id="cid">
											<option value="1">ส้มตำ</option>
											<option value="2">ปิ้ง/ย่าง</option>
											<option value="3">ทอด</option>
											<option value="4">ผลไม้สด</option>
										</select>
						<hr>
			  		<input name="hdnLine" type="hidden" value="3">
			  		<input type="submit" name="submit" value="submit" class="w3-button w3-lime">
			  		<a href="food.php" class="w3-button w3-grey ">ย้อนกลับ</a>
			  	</form>
		</div>
	</div>

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

/*for($i=1;$i<=(int)($_POST["hdnLine"]);$i++)
		{
			if($_FILES["fileUpload".$i]["name"] != "")
			{
				if(move_uploaded_file($_FILES["fileUpload".$i]["tmp_name"],"img/".$_FILES["fileUpload".$i]["name"]))
				{
					
					echo "Copy/Upload ".$_FILES["fileUpload".$i]["name"]." completed.<br>";
				}
			}
		}
	
	
//สร้างตัวแปร
$name = isset($_POST['Name']);
$des = isset($_POST['Description']);
$loca = isset($_POST['Location']);
$tp = isset($_POST['filUpload1']);
$fp = isset($_POST['filUpload2']);
$qr = isset($_POST['filUpload3']);*/
if(isset($_POST['submit'])){
	if(isset($_FILES['filUpload1'])){
	        $name_file =  $_FILES['filUpload1']['name'];
	        $tmp_name =  $_FILES['filUpload1']['tmp_name'];
	        $locate_img ="img/";
	        move_uploaded_file($tmp_name,$locate_img.$name_file);
	      }
	if(isset($_FILES['filUpload2'])){
	        $name_file =  $_FILES['filUpload2']['name'];
	        $tmp_name =  $_FILES['filUpload2']['tmp_name'];
	        $locate_img ="img/";
	        move_uploaded_file($tmp_name,$locate_img.$name_file);
	      }
	if(isset($_FILES['filUpload3'])){
	        $name_file =  $_FILES['filUpload3']['name'];
	        $tmp_name =  $_FILES['filUpload3']['tmp_name'];
	        $locate_img ="img/";
	        move_uploaded_file($tmp_name,$locate_img.$name_file);
	      }


	//เพิ่มข้อมูล
	$sql = " INSERT INTO food_trucks
	( FTName, Description, Truck_Picture, Food_Picture, Location, Hours, qrCode, UID ,CID) VALUES 
	('".$_POST["Name"]."', '".$_POST["Description"]."', '".$_FILES["filUpload1"]["name"]."', '".$_FILES["filUpload2"]["name"]."', '".$_POST["Location"]."',
	 '".$_POST["Hours"]."','".$_FILES["filUpload3"]["name"]."', '$ID', '".$_POST['cid']."')";
	
	$result = mysqli_query($db ,$sql)or die ("Error in query: $sql " . mysqli_error());
	}
	//ปิดการเชื่อมต่อ database
	mysqli_close($db);

						
				
	/*if (!$result){
		//กำหนดเงื่อนไขว่าถ้าไม่สำเร็จให้ขึ้นข้อความและกลับไปหน้าเพิ่ม		
				echo "<script type='text/javascript'>";
				echo "alert('error!');";
				echo"window.location = 'addfood.php'; ";
				echo"</script>";
		}
		else {
			//ถ้าสำเร็จให้ขึ้นอะไร
			echo "<script type='text/javascript'>";
		echo"alert('Register Success');";
	    echo"window.location = 'food.php';";
		echo "</script>";
	}*/

  ?>