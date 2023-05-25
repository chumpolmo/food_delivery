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
		<hr>
		<?php
				$sql =  "SELECT * FROM orders WHERE orders.OID = '".$_GET["OID"]."'";
				$result = $db->query($sql);
				$row = mysqli_fetch_array($result);
				echo $sql;
		?>
		<div style="text-align: center;">
			<h3>
				<?php if ($row['Status'] == "0") {
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
		</div>
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
					    
							while($row = $result->fetch_assoc()):
						?>
						<div class="w3-container">
							<div class="w3-cell-row">
								<div class="w3-cell">
							    	<h4><?php echo $row['MName']; ?></h4>
							    	<p style="font-size: 18px;" >ราคา : <?php echo $row['Price']; ?> บาท</p>
								</div>
							</div>	
						</div>
					<?php endwhile ?>
					<div class="w3-container">
						<?php 
							$result2 = $db->query($sql);
							$roww = mysqli_fetch_array($result2);
						    $total_paid = $roww['Total_Paid'];

						    echo "<h5>จำนวนเงินรวมทั้งหมด: ";
						    echo number_format($total_paid,1);
						    echo " บาท</h5>";
						if ($roww["Status"] == "3") {
						?>
						<div class="w3-container" style="text-align: center;">
							<img src="img/<?php echo $roww['qrCode']; ?>" style="width: 50%;">
							<p style="color: red;">* กรุณาสแกนเพื่อชำระเงินตอนที่ออเดอร์พร้อมส่ง</p>
						</div>
						<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
						    <input type="hidden" name="OID" value="<?php echo $_GET["OID"]; ?>">
							<label>อัพสลิปการชำระเงิน : <?php 
							
							
							if (!$roww["Money_Slip"] == "") {
								echo "อัพโหลดสลิปการชำระเงินแล้ว";
								echo "<a href='history_user.php' class='w3-button w3-lime'>";
								echo "ย้อนกลับ";
								echo "</a>";
							} else {
							?> <input type="file" name="filUpload"></label> <br>
							<input type="submit" name="submitfile" value="ยืนยัน" class="w3-button w3-lime">			
						<?php }} ?>
						<a href="history_user.php" class="w3-button w3-light-grey">ย้อนกลับ</a>
						</form>
					</div>
					

	</div>
	<hr>
	<footer class="w3-container w3-theme w3-margin-top w3-light-grey">
		<h3></h3>
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
  if(isset($_POST['submitfile'])){
  //*** Update Condition ***//
			if(isset($_FILES['filUpload'])){
	        $name_file =  $_FILES['filUpload']['name'];
	        $tmp_name =  $_FILES['filUpload']['tmp_name'];
	        $locate_img ="img/";
	        move_uploaded_file($tmp_name,$locate_img.$name_file);

				$strSQL = "UPDATE orders SET ";
				$strSQL .="Money_Slip = '".$_FILES["filUpload"]["name"]."' ";
				$strSQL .="WHERE OID = '".$_POST["OID"]."' ";
				$objQuery = mysqli_query($db ,$strSQL);
				echo $strSQL;
				if(!$objQuery)
				{
					echo "Error Update [".mysqli_error()."]";
				}else{
					//echo "อัพเดตแล้ว";
					//header("Location:status_food_user.php?OID=".$_POST['OID']);
					echo "<meta http-equiv='refresh' content='0;url=status_food_user.php?OID=".$_POST['OID']."'>";
				}
				//header("location:$_SERVER[PHP_SELF]");
				//exit();
			}
		}
		

  mysqli_close($db);
  ?>