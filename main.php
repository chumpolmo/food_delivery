<?php session_start(); 
include('config.php');

  $ID = $_SESSION['ID'];
  $name = $_SESSION['name'];
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
	<title>Food - Delivery</title>
	<link rel="stylesheet" href="css/w3.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/1011-0.js"></script>
</head>
<body>
	<!-- Sidebar -->
	<?php while($row = $result->fetch_assoc()): ?>
	<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:200px;" id="mySidebar">
	  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
	  <div class="w3-padding w3-center">
    <img class="w3-circle" src="img/<?php echo $row['Profile_Picture']; ?>" alt="avatar" style="width:75%">
  	</div>
  	<?php endwhile ?>
	  <h3><?php echo $name; ?></h3>
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
			<div class="w3-pale-green w3-container">
			  	<h1>Food - Delivery</h1>
			  	<p>แหล่งรวมร้านอาหารและเครื่องดื่ม ที่มีขายในมหาวิทยาลัยของเรา</p>
			</div>
		</div>

		<div class="w3-bar w3-container w3-border w3-round-xlarge w3-panel w3-pale-blue">
			<a href="main.php?CID=1" class="w3-bar-item w3-button">ส้มตำ</a>
			<a href="main.php?CID=2" class="w3-bar-item w3-button">ปิ้ง/ย่าง</a>
			<a href="main.php?CID=3" class="w3-bar-item w3-button">ของทอด</a>
			<a href="main.php?CID=4" class="w3-bar-item w3-button">ผลไม้สด</a>
		</div>

		<?php 
							if (!isset($_GET["CID"])) {
								$sql = "SELECT * FROM menu_items INNER JOIN food_trucks ON (menu_items.FTID = food_trucks.FTID) 
							INNER JOIN category ON (food_trucks.CID = category.CID)
							WHERE food_trucks.UID = '$ID'";
							}else{
								$sql = "SELECT * FROM menu_items INNER JOIN food_trucks ON (menu_items.FTID = food_trucks.FTID) 
							INNER JOIN category ON (food_trucks.CID = category.CID)
							WHERE category.CID = '".$_GET["CID"]."' AND food_trucks.UID = '$ID'" ;
							}
							
					    $result = $db->query($sql);
							while($row = $result->fetch_assoc()):
						?>
				<div class="w3-container">
				  <ul class="w3-ul w3-card-4">
				    <li class="w3-display-container">
				    	<img src="img/<?php echo $row['Menu_Photo']; ?>" style="width:100%">
				    	<h4><?php echo $row['MName']; ?></h4>
				    	<p>ราคา : <?php echo $row['Price']; ?> บาท
				    		<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
				    			<input type="hidden" name="MIID" value="<?php echo $row['MIID']; ?>">
				    			<?php 
							  		if($row['MI_Status'] == "0"){
							  			echo "<p>ของหมด</p>";
							  			echo "<input type='hidden' name='status' value='1'>";
											echo "<input type='submit' name='submit' value='มีของอยู่' class='w3-button w3-light-grey'>";
							  		} else {
							  			echo "<p>มีของอยู่</p>";
							  			echo "<input type='hidden' name='status' value='0'>";
											echo "<input type='submit' name='submit' value='ของหมด' class='w3-button w3-light-grey'>";
							  		}
							  ?>
				    		</form>
						</p>
						</li>
				  </ul>
				</div>
		<?php endwhile ?>

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
				$strSQL = "UPDATE menu_items SET ";
				$strSQL .="MI_Status = '".$_POST["status"]."' ";
				$strSQL .="WHERE MIID = '".$_POST["MIID"]."' ";
				$objQuery = mysqli_query($db ,$strSQL);
				if(!$objQuery)
				{
					echo "Error Update [".mysqli_error()."]";
				}else{
					//echo "อัพเดตแล้ว";
					echo "<script>";
					echo "alert(\"อัพเดตแล้ว\");"; 
					echo "window.history.back()";
					echo "</script>";
				}
		}
?>