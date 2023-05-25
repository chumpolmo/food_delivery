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
			  	<a href="food_history.php" class="w3-left w3-button w3-light-grey"><i class="fas fa-plus"> <-- </i> </a>
			</div>
		</div>
		<hr>

		<div class="w3-pale-yellow w3-container">
			<?php 
			if (!isset($_GET["OID"])) {
				$sql = "SELECT * FROM menu_items INNER JOIN food_trucks ON (menu_items.FTID = food_trucks.FTID) 
						INNER JOIN order_items ON (menu_items.MIID = order_items.MIID) INNER JOIN orders ON (order_items.OID = orders.OID) 
						INNER JOIN category ON (food_trucks.CID = category.CID)";
				}else{
					$sql = "SELECT * FROM menu_items INNER JOIN food_trucks ON (menu_items.FTID = food_trucks.FTID) 
							INNER JOIN order_items ON (menu_items.MIID = order_items.MIID) INNER JOIN orders ON (order_items.OID = orders.OID) 
							INNER JOIN category ON (food_trucks.CID = category.CID)
							WHERE order_items.OID = '".$_GET["OID"]."'";
					}
			
    	$result = $db->query($sql);
			while($row = $result->fetch_assoc()): ?>

				<div class="w3-container">
					<div class="w3-cell-row">
						<div class="w3-cell">
							<a href="food_history_menu.php?OID=<?php echo $row['OID']; ?>">
							<img src="img/<?php echo $row['Menu_Photo']; ?>" style="width:60px;cursor:zoom-in" class="w3-left w3-margin-right">
							</a>
							<p><?php echo $row['MName']; ?> - THB: <?php echo $row['Price']; ?> 
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
		<?php endwhile ?>
				<div class="w3-container">
					<h3>
								<?php 
									$result2 = $db->query($sql);
									$roww = mysqli_fetch_array($result2);
								    $total_paid = $roww['Total_Paid'];

								    echo "<h5>จำนวนเงินรวมทั้งหมด: ";
								    echo number_format($total_paid,1);
								    echo " บาท</h5>";
								?>
						</h3>
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
