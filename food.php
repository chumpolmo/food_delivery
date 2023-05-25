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
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
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
			  	<p>ร้านอาหารฉัน</p>
			  	<a href="addfood.php" class="w3-right w3-button w3-lime">เพิ่มร้านค้า<i class="fas fa-plus">+</i> </a>
			</div>
		</div>

		<div class="w3-pale-yellow w3-container">
			<?php 
			$sql = "SELECT * FROM food_trucks WHERE UID = $ID";
    	$result = $db->query($sql);
			while($row = $result->fetch_assoc()): 
					if ($row["UID"] == "") {
						echo "<div class=\"alert alert-warning\">ยังไม่มีร้านค้า</div>";
					}
				?>

			<div class="w3-row-padding w3-margin-top" style="text-align: center;">
				<div class="w3-third">
					<div class="w3-card">
						<a href="food.php?delete=<?php echo $row['FTID']; ?>" class="w3-right w3-button w3-red">ลบร้านค้า</a>
						<a href="editfood.php?edit=<?php echo $row['FTID']; ?>.php" class="w3-right w3-button w3-light-grey">แก้ไขข้อมูลร้านค้า </a>
						<a href="menu.php?FTID=<?php echo $row['FTID']; ?>"><img src="img/<?php echo $row['Truck_Picture']; ?>" style="width:100%"></a>
						<div class="w3-container">
							<h4><?php echo $row['FTName']; ?></h4>
							<p>
								<label hidden><?php echo $row['FTID']; ?></label>
								รายละเอียด : <?php echo $row['Description']; ?><br>
							</p>
						</div>
					</div>
				</div>
			</div>
				  
				  <?php endwhile ?>
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
		if (isset($_GET["delete"])) {
			$strSQL = "DELETE food_trucks ,menu_items FROM food_trucks , menu_items 
			WHERE food_trucks.FTID = menu_items.FTID AND food_trucks.FTID = '".$_GET['delete']."'";
			$objQuery = mysqli_query($db ,$strSQL);
				if(!$objQuery)
				{
					echo "Error Update [".mysqli_error()."]";
				}else{
					//echo "อัพเดตแล้ว";
					echo "<script> alert ('ลบข้อมูล สำเร็จ !!');";
					echo "history.back()";
					echo "</script>";
				}
		}
		mysqli_close($db);
	?>