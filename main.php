<?php
include "tpls/header.php";
include('config.php');

$ID = $_SESSION['ID'];
$name = $_SESSION['name'];
$pass = $_SESSION['password'];

if ($_SESSION['status'] !='10'){  // Validate session
	header("Location: login.php");
	die();
}  

$sql = "SELECT * FROM users WHERE UID = $ID";
$result = $db->query($sql);
$row = $result->fetch_assoc();
?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<body>
	<!-- Start: Navbar -->
	<nav class="navbar navbar-default" style="background-color:#9053c7;">
		<div class="container-fluid">
			<div class="navbar-header p-b-24">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar" style="color:#ffffff;"></span>
					<span class="icon-bar" style="color:#ffffff;"></span>
					<span class="icon-bar" style="color:#ffffff;"></span>
				</button>
				<a class="navbar-brand" href="#" style="color:#ffffff;"><?=_HEADING?></a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li><a href="main.php" style="color:#ffffff;"><span class="fa fa-home"></span> หน้าแรก</a></li>
					<li><a href="food.php" style="color:#ffffff;">ร้านค้าของฉัน</a></li>
					<li><a href="food_order.php" style="color:#ffffff;">รายการสั่งซื้อ</a></li>
					<li><a href="food_history.php" style="color:#ffffff;">ประวัติการสั่งซื้อ</a></li>
					<!-- <li><a href="about.php" style="color:#ffffff;">ข้อมูลของฉัน</a></li> -->
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="about.php" style="color:#ffffff;">
							<!-- <img class="img-circle" src="img/<?php echo $row['Profile_Picture']; ?>" alt="avatar" style="width:15%"> -->
							<span class="fa fa-user-circle-o"></span> <?php echo $row['Full_Name']; ?></a>
					</li>
					<li><a href="logout.php" style="color:#ffffff;"><span class="fa fa-sign-out"></span> ออกจากระบบ</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- Start: Navbar -->

	<!-- Page Content -->
	<div class="container">
		<div class="w3-bar w3-container w3-border w3-round-xlarge w3-panel w3-pale-blue">
		<a href="main.php" class="btn" style="margin:3px;background-color:#F1C3FD;color:#000000;">ทั้งหมด</a>
		<?php
		$sql_c = "SELECT * FROM category ORDER BY CName";
		$result_c = $db->query($sql_c);
		while($row_c = $result_c->fetch_assoc()):
		?>
			<a href="main.php?CID=<?=$row_c['CID']?>" class="btn" style="margin:3px;background-color:#F1C3FD;color:#000000;"><?=$row_c['CName']?></a>
		<?php endwhile ?>
	</div>

		<?php 
		if (!isset($_GET["CID"])) {
			$sql = "SELECT * FROM menu_items INNER JOIN food_trucks ON (menu_items.FTID = food_trucks.FTID) ";
			$sql.= "INNER JOIN category ON (food_trucks.CID = category.CID) WHERE food_trucks.UID = '$ID'";
		}else{
			$sql = "SELECT * FROM menu_items INNER JOIN food_trucks ON (menu_items.FTID = food_trucks.FTID) ";
			$sql.= "INNER JOIN category ON (food_trucks.CID = category.CID) ";
			$sql.= "WHERE category.CID = '".$_GET["CID"]."' AND food_trucks.UID = '$ID'" ;
		}					
		$result = $db->query($sql);
		while($row = $result->fetch_assoc()):
		?>
			<div class="container p-t-24">
				<div class="panel panel-default">
					<img src="img/<?php echo $row['Menu_Photo']; ?>" class="img-thumbnail" style="width:100%">
					<p class="text-center p-t-16" style="font-size:14pt;"><?=$row['MName']?>
						<div class="p-l-16 p-r-16 p-b-16">
							<p><?php
							echo $row['Description'];
							echo " ราคา ".$row['Price']." บาท";
							?></p>
						</div>
					</p>
					<form action="<?=$_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="MIID" value="<?php echo $row['MIID']; ?>">
				    <?php 
						echo "<p>";
						if($row['MI_Status'] == 0){
							echo "<div class=\"alert alert-danger text-center m-l-16 m-r-16\">Sold Out ";
							echo "<input type='hidden' name='status' value='1'>";
							echo "<input type='submit' name='submit' value='ปรับปรุงคลังสินค้าพร้อมขาย' class='btn btn-success txt4'></div>";
										
						} else {
							echo "<div class=\"alert alert-success text-center m-l-16 m-r-16\">In Stock ";
							echo "<input type='hidden' name='status' value='0'>";
							echo "<input type='submit' name='submit' value='ปรับปรุงคลังสินค้าหมด' class='btn btn-danger txt4'></div>";
						}
						echo "</p>";
					?>
					</form>
				</div>
			</div>
		<?php endwhile ?>
		<div class="panel panel-default">
			<div class="panel-footer text-center"><p><?=_FOOTER_TEXT?></p></div>
		</div>
</body>
</html>
<?php
	// ???
	if(isset($_POST['submit'])){
		$strSQL = "UPDATE menu_items SET ";
		$strSQL .="MI_Status = '".$_POST["status"]."' ";
		$strSQL .="WHERE MIID = '".$_POST["MIID"]."' ";
		$objQuery = mysqli_query($db ,$strSQL);
		if(!$objQuery)
		{
			echo "Error Update [".mysqli_error()."]";
		}else{
			echo "<script>";
			echo "alert(\"Info! อัพเดตรายการสินค้าสำเร็จ\");"; 
			echo "window.history.back()";
			echo "</script>";
		}
	}
?>