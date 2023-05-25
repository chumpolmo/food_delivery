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
			  	<p>รายการออเดอร์</p>
			  	<a href="main.php" class="w3-left w3-button w3-light-grey"><i class="fas fa-plus"> <-- </i> </a>
			</div>
		</div>

		<div class="w3-pale-yellow w3-container">
			<?php 
			$sql = "SELECT *
			FROM orders INNER JOIN food_trucks ON (orders.FTID = food_trucks.FTID)
			WHERE food_trucks.UID = $ID";
    	$result = $db->query($sql);
			while($row = $result->fetch_assoc()): 
				if ($row['Status'] <= "3") { ?>

				<div class="w3-container">
					<div class="w3-cell-row">
						<div class="w3-cell">
								<img src="img/food-truck.jpg" style="width:60px;cursor:zoom-in" class="w3-left w3-circle w3-margin-right" 
								onclick="document.getElementById('<?php echo $row['OID']; ?>').style.display='block'">
							<p><?php echo $row['OName']; ?> - THB: <?php echo $row['Total_Paid']; ?> 
							<br>
							สถานะ: <?php 
								if ($row['Status'] == "0") {
									echo "รอรับออเดอร์";
								} elseif ($row['Status'] == "1") {
									echo "ร้านกำลังทำอาหาร</p>";
								} elseif ($row['Status'] == "2") {
									echo "ร้านทำอาหารเสร็จแล้ว";
								} elseif ($row['Status'] == "3") {
									echo "ออเดอร์พร้อมส่งแล้ว/รอชำระเงิน";
								} elseif ($row['Status'] == "4") {
									echo "ลูกค้าได้รับออเดอร์แล้ว";
								} else {
									echo "ออเดอร์โดนยกเลิก/ล้มเหลว";
								}
							
								?>
							</p>
						</div>
					</div>
				</div>
		<?php 
		}
	endwhile ?>

		<?php 
				$sql = "SELECT *
			FROM orders INNER JOIN food_trucks ON (orders.FTID = food_trucks.FTID)
			WHERE food_trucks.UID = $ID";
    	$result = $db->query($sql);
			while($row = $result->fetch_assoc()): ?>
			<div id="<?php echo $row['OID']; ?>" class="w3-modal">
		    <span  onclick="document.getElementById('<?php echo $row['OID']; ?>').style.display='none'" class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
		    <div class="w3-modal-content w3-animate-zoom">
		    	<div style="text-align: center;">
					<h3>
						ลูกค้า: <?php echo $row['OName']; ?><hr>
						<?php 
						if ($row['Status'] == "0") {
							echo "<img src='img/food.png' style='width:60px'>";
							echo "<p>รอรับออเดอร์</p>";
						} elseif ($row['Status'] == "1") {
							echo "<img src='img/cooking.png' style='width:60px'>";
							echo "<p>ร้านกำลังทำอาหาร</p>";
						} elseif ($row['Status'] == "2") {
							echo "<img src='img/receised-food.png' style='width:60px'>";
							echo "<p>ร้านทำอาหารเสร็จแล้ว</p>";
						} elseif ($row['Status'] == "3") {
							echo "<img src='img/bank.png' style='width:60px'>";
							echo "<p>ออเดอร์พร้อมส่งแล้ว/รอชำระเงิน</p>";
						} elseif ($row['Status'] == "4") {
							echo "<img src='img/food-finish.png' style='width:60px'>";
							echo "<p>ลูกค้าได้รับออเดอร์แล้ว</p>";
						} else {
							echo "<img src='img/food-finish.png' style='width:60px'>";
							echo "<p>ออเดอร์โดนยกเลิก/ล้มเหลว</p>";
						}
						?>
					</h3>
						<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="oid" value="<?php echo $row['OID']; ?>">
							<?php if ($row['Status'] == "0") {
							echo "<input type='hidden' name='status' value='1'>";
							echo "<input type='submit' name='submit' value='รับออเดอร์' class='w3-button w3-lime'>";
						} elseif ($row['Status'] == "1") {
							echo "<input type='hidden' name='status' value='2'>";
							echo "<input type='submit' name='submit' value='ร้านทำอาหารเสร็จแล้ว' class='w3-button w3-lime'>";
						} elseif ($row['Status'] == "2") {
							echo "<input type='hidden' name='status' value='3'>";
							echo "<input type='submit' name='submit' value='ออเดอร์พร้อมส่งแล้ว/รอชำระเงิน' class='w3-button w3-lime'>";
						} elseif ($row['Status'] == "3") {
							echo "<input type='hidden' name='status' value='4'>";
							echo "<input type='submit' name='submit' value='ลูกค้าได้รับออเดอร์แล้ว' class='w3-button w3-lime'>";
						} 
						?>
						</form>
						<hr>
					</div>
		    </div>
		  </div>
		  <?php endwhile ?>

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
		if(isset($_POST['submit'])){
				$strSQL = "UPDATE orders SET ";
				$strSQL .="Status = '".$_POST["status"]."' ";
				$strSQL .="WHERE OID = '".$_POST["oid"]."' ";
				$objQuery = mysqli_query($db ,$strSQL);
				if(!$objQuery)
				{
					echo "Error Update [".mysqli_error()."]";
				}else{
					//echo "อัพเดตแล้ว";
					//header("Location:food_order.php");
				}
		}
?>