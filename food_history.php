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
			  	<p>ประวัติออเดอร์</p>
			  	<a href="main.php" class="w3-left w3-button w3-light-grey"><i class="fas fa-plus"> <-- </i> </a>
			</div>
		</div>

		<div class="w3-bar w3-container w3-border w3-round-xlarge w3-panel w3-pale-blue" style="text-align: center;">
			<a href="food_history.php?Status=4" class="w3-bar-item w3-button">เสร็จสิ้น</a>
			<a href="food_history.php?Status=5" class="w3-bar-item w3-button">ยกเลิก/ล้มเหลว</a>
		</div>
		<hr>

		<div class="w3-pale-yellow w3-container">
			<?php 
			if (!isset($_GET['Status'])) {
				$sql = "SELECT *
			FROM orders INNER JOIN food_trucks ON (orders.FTID = food_trucks.FTID)";
			} else {
				$sql = "SELECT *
			FROM orders INNER JOIN food_trucks ON (orders.FTID = food_trucks.FTID)
			WHERE food_trucks.UID = $ID AND orders.Status = '".$_GET["Status"]."' ";
			}
			
    	$result = $db->query($sql);
			while($row = $result->fetch_assoc()): 
				if ($row["Status"] >= "4") {
				
				?>

				<div class="w3-container">
					<div class="w3-cell-row">
						<div class="w3-cell">
							<a href="food_history_menu.php?OID=<?php echo $row['OID']; ?>">
							<img src="img/food-truck.jpg" style="width:60px;cursor:zoom-in" class="w3-left w3-circle w3-margin-right">
							</a>
							<p><?php echo $row['OName']; ?> - THB: <?php echo $row['Total_Paid']; ?> 
							<br>
							สถานะ: <?php if ($row['Status'] == "0") {
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
