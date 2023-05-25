<?php session_start(); 
include('config.php');

  $ID = $_SESSION['ID'];
  $name = $_SESSION['name'];
  $pass = $_SESSION['password'];
 	if ($_SESSION['status'] !='20'){  //check session

	  Header("Location: login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form 
}  
$action = isset($_GET['a']) ? $_GET['a'] : "";
$itemCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
if(isset($_SESSION['qty'])){
$meQty = 0;
foreach($_SESSION['qty'] as $meItem){
$var = is_int($meItem);
$meQty = $meQty + $var;
}
}else{
$meQty=0;
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
	<?php
if($action == 'exists'){
echo "<script>";
echo "alert(\"เพิ่มจำนวนสินค้าแล้ว\");"; 
echo "window.history.back()";
echo "</script>";
}
if($action == 'add'){
echo "<script>";
echo "alert(\"เพิ่มสินค้าลงในตะกร้าเรียบร้อยแล้ว\");"; 
echo "window.history.back()";
echo "</script>";
}
if($action == 'order'){
echo "<script>";
echo "alert(\"สั่งซื้อสินค้าเรียบร้อยแล้ว\");"; 
echo "window.history.back()";
echo "</script>";
}
if($action == 'orderfail'){
echo "<script>";
echo "alert(\"สั่งซื้อสินค้าไม่สำเร็จ มีข้อผิดพลาดเกิดขึ้นกรุณาลองใหม่อีกครั้ง\");"; 
echo "window.history.back()";
echo "</script>";
}
?>
	<!-- Sidebar -->
    <?php while($row = $result->fetch_assoc()): ?>
	<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:200px;" id="mySidebar">
	  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
	  <div class="w3-padding w3-center">
    <img class="w3-circle" src="img/<?php echo $row['Profile_Picture']; ?>" alt="avatar" style="width:75%">
  	</div>
  	<?php endwhile ?>
	  <h3><?php echo $name; ?></h3>
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
			<div class="w3-pale-green w3-container">
			  	<h1>Food - Delivery</h1>
			  	<p>แหล่งรวมร้านอาหารและเครื่องดื่ม ที่มีขายในมหาวิทยาลัยของเรา</p>
			  	<a href="cart.php" class="w3-button w3-light-grey">ตะกร้าสินค้าของฉัน <span class="badge"><?php echo $meQty; ?></span></a>
			</div>
		</div>
		<hr>
		
						<?php 

								if (!isset($_GET['FTID'])) {
									$sql = "SELECT * FROM menu_items INNER JOIN food_trucks ON (menu_items.FTID = food_trucks.FTID)";
							}else {
											$sql = "SELECT * FROM menu_items INNER JOIN food_trucks ON (menu_items.FTID = food_trucks.FTID) 
														WHERE food_trucks.FTID = '".$_GET['FTID']."' AND menu_items.MI_Status = 1";
										
									}
							
					    $result2 = $db->query($sql);
							while($row2 = $result2->fetch_assoc()):

						?>
				<div class="w3-container">
				  <ul class="w3-ul w3-card-4">
				    <li class="w3-display-container">
				    	<img src="img/<?php echo $row2['Menu_Photo']; ?>" style="width:100%">
				    	<h4><?php echo $row2['MName']; ?></h4>
				    	<p>ราคา : <?php echo $row2['Price']; ?> บาท</p>
				    	<a href="updatecart.php?itemId=<?php echo $row2['MIID']; ?>" class="w3-button w3-circle w3-black w3-right w3-display-bottomright">+</a>
						</li>
				  </ul>
				</div>
				<?php endwhile ?>
		

		<div class="w3-container">
			<div class="w3-panel w3-pale-blue w3-leftbar w3-rightbar w3-border-blue">
				<a name="me"></a>
				<footer>
					<h3></h3>
				</footer>
			</div>
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