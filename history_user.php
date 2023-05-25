<?php session_start(); 
include('config.php');

  $ID = $_SESSION['ID'];
  $name = $_SESSION['username'];
  $pass = $_SESSION['password'];
 	if ($_SESSION['status'] !='20'){  //check session

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
	<link rel="stylesheet" href="css/main.css">
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
  	<?php endwhile ?>
	  <h3>&nbsp;<?php echo $name; ?></h3>
	  <a href="main_user.php" class="w3-bar-item w3-button">Home</a>
	  <a href="cart.php" class="w3-bar-item w3-button">ตะกร้าออเดอร์</a>
	  <a href="history_user.php" class="w3-bar-item w3-button">ประวัติสั่งซื้อ</a>
	  <a href="about_user.php" class="w3-bar-item w3-button">ข้อมูลของฉัน</a>
	  <a href="logout.php" class="w3-bar-item w3-button">ออกจากระบบ</a>
	</div>

	<!-- Page Content -->
	<div class="w3-main w3-pale-yellow" style="margin-left: 200px;">
		<div class="w3-light-grey">
			<button class="w3-button w3-light-grey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
			<div class="w3-pale-green w3-container" style="text-align: center;">
			  	<h1>-ประวัติสั่งซื้อ-</h1>
			</div>
		</div>

		<div class="w3-bar w3-container w3-border w3-round-xlarge w3-panel w3-pale-blue">
			<a href="history_user.php?Status=0" class="w3-bar-item w3-button">กำลังดำเนินการ</a>
			<a href="history_user.php?Status=4" class="w3-bar-item w3-button">เสร็จสิ้น</a>
			<a href="history_user.php?Status=5" class="w3-bar-item w3-button">ยกเลิก/ล้มเหลว</a>
		</div>
		<hr>
		<?php
			if (!isset($_GET["Status"])) {
				$sql =  "SELECT * FROM orders";
			} else {
				if ($_GET["Status"] == "0") {
					$sql =  "SELECT * FROM orders WHERE UID = $ID AND Status = '0' OR Status = '1' OR Status = '2' OR Status = '3' ";
				} else {
				$sql =  "SELECT * FROM orders WHERE UID = $ID AND Status = '".$_GET["Status"]."'";
			}
			} 
				
				$result = $db->query($sql);
				while($row = $result->fetch_assoc()):
		?>
		<div class="w3-container">
			<div class="w3-cell-row">
				<div class="w3-cell">
					<a href="status_food_user.php?OID=<?php echo $row['OID']; ?>">
						<img src="img/food-truck.jpg" style="width:60px" class="w3-left w3-circle w3-margin-right">
					</a>
					<p><?php echo $row['OName']; ?> - THB: <?php echo $row['Total_Paid']; ?><br>
					การจัดส่ง: <?php 
						    		if ($row['Delivery'] == "1") {
						    			echo "ลูกค้ามารับที่ร้านเอง";
						    		}else {
						    			echo "ร้านค้าไปส่งออเดอร์ให้";
						    		}
						    ?> เวลาการสั่งออเดอร์: <?php echo $row['Pick_Up_Time']; ?></p>
				</div>
			</div>
	</div>
	<br>
<?php endwhile ?>
	<hr>
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