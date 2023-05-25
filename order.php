<?php
session_start(); 
include('config.php');

  $ID = $_SESSION['ID'];
  $name = $_SESSION['name'];
  $pass = $_SESSION['password'];
 	if ($_SESSION['status'] !='20'){  //check session

	  Header("Location: login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form 
}
$action = isset($_GET['a']) ? $_GET['a'] : "";
$itemCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
//$_SESSION['formid'] = sha1('itoffside.com' . microtime());
if (isset($_SESSION['qty'])) {
$meQty = 0;
foreach ($_SESSION['qty'] as $meItem) {
$var = is_int($meItem);
$meQty = $meQty + $var;
}
} else {
$meQty = 0;
}
if (isset($_SESSION['cart']) and $itemCount > 0) {
$itemIds = "";
foreach ($_SESSION['cart'] as $itemId) {
$itemIds = $itemIds . $itemId . ",";
}
$inputItems = rtrim($itemIds, ",");
$meSql = "SELECT * FROM menu_items INNER JOIN food_trucks ON (menu_items.FTID = food_trucks.FTID) 
INNER JOIN category ON (food_trucks.CID = category.CID) WHERE MIID in ({$inputItems})";
$meQuery = mysqli_query($db,$meSql);
$meCount = mysqli_num_rows($meQuery);
} else {
$meCount = 0;
}

	$sql = "SELECT * FROM users WHERE UID = $ID";
    $result = $db->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ตรวจสอบรายการสั่งซื้อ</title>
<!-- Bootstrap -->
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap/css/nava.css" rel="stylesheet">
<link rel="stylesheet" href="css/w3.css">
<script src="js/jquery.min.js"></script>
<script src="js/1011-0.js"></script>
</head>
<body>
<div class="container">
<?php while($row = $result->fetch_assoc()): ?>
	<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:200px;" id="mySidebar">
	  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
	  <div class="w3-padding w3-center">
    <img class="w3-circle" src="img/<?php echo $row['Profile_Picture']; ?>" alt="avatar" style="width:75%">
  	</div>
  	
	  <h3><?php echo $name; ?></h3>
	  <a href="main_user.php" class="w3-bar-item w3-button">Home</a>
	  <a href="cart.php" class="w3-bar-item w3-button">ตะกร้าออเดอร์ </a>
	  <a href="history_user.php" class="w3-bar-item w3-button">ประวัติสั่งซื้อ</a>
	  <a href="about_user.php" class="w3-bar-item w3-button">ข้อมูลของฉัน</a>
	  <a href="logout.php" class="w3-bar-item w3-button">ออกจากระบบ</a>
	</div>


<div class="w3-main w3-pale-yellow" style="margin-left: 200px;">
		<div class="w3-light-grey">
			<button class="w3-button w3-light-grey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
			<div class="w3-pale-green w3-container">
			  	<h1>ตรวจสอบรายการสั่งซื้อ</h1>
			  	<p>ตรวจสอบความถูกต้องของรายการสั่งซื้อ</p>
			</div>
		</div>
<!-- Main component for a primary marketing message or call to action -->
<?php
if ($action == 'removed')
{
echo "<div class=\"alert alert-warning\">ลบสินค้าเรียบร้อยแล้ว</div>";
}
if ($meCount == 0)
{
echo "<div class=\"alert alert-warning\">ไม่มีสินค้าอยู่ในตะกร้า</div>";
} else
{

$total_price = 0;
$num = 0;
while ($meResult = mysqli_fetch_assoc($meQuery))
{
$key = array_search($meResult['MIID'], $_SESSION['cart']);
$total_price = $total_price + ($meResult['Price'] * $_SESSION['qty'][$key]);
?>
<div class="w3-container" style="text-align: center;">
	    <div class="w3-cell-row">
	    	<form action="updateorder.php" method="post" name="formupdate" role="form" 
	    	id="formupdate" enctype="multipart/form-data">
			<label hidden><input type="text" name="name" value="<?php echo $name; ?>"></label>
			<label hidden><input type="text" name="id" value="<?php echo $ID; ?>"></label>
			<input type="hidden" name="ftid" value="<?php echo $meResult['FTID']; ?>">
			<div class="w3-cell" style="width:30%">
				<img src="img/<?php echo $meResult['Menu_Photo']; ?>" style="width:100%">
			</div>
			<div class="w3-cell w3-container">
				<h3>ชื่อ: <?php echo $meResult['MName']; ?></h3>
				<input type="hidden" name="mname[]" value="<?php echo $meResult['MName']; ?>">
				<p>	<?php echo $meResult['Description']; ?> 
					จำนวน: <?php echo $_SESSION['qty'][$key]; ?>
					<input type="hidden" name="qty[]" value="<?php echo $_SESSION['qty'][$key]; ?>" />
					<input type="hidden" name="miid[]" value="<?php echo $meResult['MIID']; ?>" />
					<input type="hidden" name="price[]" value="<?php echo $meResult['Price']; ?>" /> <br>
					ราคา: <?php echo number_format($meResult['Price'],2); ?><br>
					รายละเอียด: <input type="text" name="note[]" size="15">
				</p>
				
				<a class="btn btn-danger btn-lg" href="removecart.php?itemId=<?php echo $meResult['MIID']; ?>" role="button">
				<span class="glyphicon glyphicon-trash"></span>ลบทิ้ง</a>
			</div>
			<?php
				$num++;
				}
				?>
				</div>
				<h4>จำนวนเงินรวมทั้งหมด <?php echo number_format($total_price,2); ?> บาท</h4>
				<input type="text" name="total" value="<?php echo number_format($total_price,2); ?>" hidden>
				<select name="Delivery" id="Delivery">
		        	<option value="1">มารับที่ร้าน</option>
					<option value="2">ร้านค้าไปส่ง</option>
		        </select> <br><br>
		        
				<a href="cart.php" type="button" class="btn btn-danger btn-lg w3-button w3-grey">ย้อนกลับ</a>
				<button type="submit" class="btn btn-primary btn-lg w3-button w3-lime" name="submit">บันทึกการสั่งซื้อสินค้า</button>
		</form>
		<hr>
    </div>

<?php
}
?>
<?php endwhile ?>
</div> <!-- /container -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="bootstrap/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
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
mysqli_close($db);
?>