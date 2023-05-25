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
          <p>แก้ไขข้อมูลร้าน</p>
      </div>
    </div>

    <div class="w3-pale-yellow w3-container">
      <?php 
          if (!isset($_GET['edit'])) {
            $sql = "SELECT * FROM food_trucks";
          } else {
            $sql = "SELECT * FROM food_trucks WHERE UID = $ID AND FTID = '".$_GET["edit"]."'";
          }
      
      $result = $db->query($sql);
      while($row = $result->fetch_assoc()): 
        ?>

      <div class="w3-light-grey">
        <div class="w3-pale-green w3-container">
          <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" name="frmMain" enctype="multipart/form-data">
            <label>FTID : <input type="text" name="ftid" value="<?php echo $row["FTID"];?>" hidden><?php echo $row["FTID"];?></label> <br>
            <label>ชื่อร้าน : <input type="text" name="ftname" size="20" value="<?php echo $row["FTName"];?>"></label> <br>
            <label>รายละเอียดร้าน : <input type="text" name="des" size="20" value="<?php echo $row["Description"];?>"></label> <br>
            <label>ที่อยู่ร้าน : <input type="text" name="loca" size="20" value="<?php echo $row["Location"];?>"></label> <br>
            <label>เวลาเปิด : <input type="text" name="hours" size="20" value="<?php echo $row["Hours"];?>"></label> <br>
            <label>รูปร้าน : <img src="img/<?php echo $row["Truck_Picture"];?>" class="w3-padding w3-center" style="width:100%">
              <input type="file" name="filUpload1">
            </label> <br>
            <label>รูปอาหารของร้าน : <img src="img/<?php echo $row["Food_Picture"];?>" class="w3-padding w3-center" style="width:100%">
              <input type="file" name="filUpload2">
            </label> <br>
            <label>คิวอาร์โค้ด : <img src="img/<?php echo $row["qrCode"];?>" class="w3-padding w3-center" style="width:100%">
              <input type="file" name="filUpload3">
            </label> <br>
            <label>ประเภท : <select name="cid" id="cid">
                              <option value="1">ส้มตำ</option>
                              <option value="2">ปิ้ง/ย่าง</option>
                              <option value="3">ทอด</option>
                              <option value="4">ผลไม้สด</option>
                            </select>
            </label> <hr>

            <input type="submit" name="submit" value="submit" class="w3-button w3-lime">
            <a href="food.php" class="w3-button w3-grey">ย้อนกลับ</a>
          </form>
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
  if(isset($_POST['submit'])){
    if(isset($_FILES['filUpload1'])){
            $name_file =  $_FILES['filUpload1']['name'];
            $tmp_name =  $_FILES['filUpload1']['tmp_name'];
            $locate_img ="img/";
            move_uploaded_file($tmp_name,$locate_img.$name_file);
          }
    if(isset($_FILES['filUpload2'])){
            $name_file =  $_FILES['filUpload2']['name'];
            $tmp_name =  $_FILES['filUpload2']['tmp_name'];
            $locate_img ="img/";
            move_uploaded_file($tmp_name,$locate_img.$name_file);
          }
    if(isset($_FILES['filUpload3'])){
            $name_file =  $_FILES['filUpload3']['name'];
            $tmp_name =  $_FILES['filUpload3']['tmp_name'];
            $locate_img ="img/";
            move_uploaded_file($tmp_name,$locate_img.$name_file);
          }

        $sqli = "UPDATE food_trucks SET ";
        $sqli .="FTName = '".$_POST["ftname"]."' ";
        $sqli .=",Description = '".$_POST["des"]."' ";
        $sqli .=",Truck_Picture = '".$_FILES["filUpload1"]["name"]."' ";
        $sqli .=",Food_Picture = '".$_FILES["filUpload2"]["name"]."' ";
        $sqli .=",Location = '".$_POST["loca"]."' ";
        $sqli .=",Hours = '".$_POST["hours"]."' ";
        $sqli .=",qrCode = '".$_FILES["filUpload3"]["name"]."' ";
        $sqli .=",CID = '".$_POST["cid"]."' ";
        $sqli .="WHERE FTID = '".$_POST["ftid"]."' ";
        $objQuery = mysqli_query($db ,$sqli);
        if(!$objQuery)
        {
          echo "Error Update [".mysqli_error()."]";
        }else{
          //echo "อัพเดตแล้ว";
          header("Location:food.php");
          echo "<script type='text/javascript'>window.location.href='food.php'</script>";
            exit;
        }
      }
        mysqli_close($db);
?>