<html>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot your password</title>
  <link rel="stylesheet" href="css/w3.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/1011-0.js"></script>
</head>
<body>
  <div class="w3-container w3-main w3-pale-yellow">
    <h3>ต้องการขอรหัสผ่าน? (กรอก ชื่อผู้ใช้งาน(username) และ อีเมล)</h3>
    <hr>
    <form name="form1" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
      ชื่อผู้ใช้งาน : <input name="username" type="text" id="txtUsername"><br>
      อีเมล : <input name="email" type="text" id="txtEmail"><br><br>
      <input type="submit" name="btnSubmit" value="ยืนยันการขอรหัสผ่าน" class="w3-button w3-lime">
      <a href="login.php" class="w3-button w3-light-grey ">กลับหน้าเข้าสู่ระบบ</a>
    </form>
  </div>
<?php
  include('config.php');
  ini_set('SMTP','localhost');
  ini_set('smtp_port',25);
  if (isset($_POST['btnSubmit'])) {
    $strSQL = "SELECT * FROM users WHERE Email = '".trim($_POST['email'])."'  
  OR Username = '".trim($_POST['username'])."' ";
  $objQuery = mysqli_query($db ,$strSQL);
  $objResult = mysqli_fetch_array($objQuery);
  if(!$objResult)
  {
      echo "Not Found Username or Email!";
  }
  else
  {
      echo "Your password send successful.<br>Send to mail : ".$objResult["Email"];   

      $strTo = $objResult["Email"];
      $strSubject = "Your Account information username and password.";
      $strHeader = "Content-type: text/html; charset=windows-874\n"; // or UTF-8 //
      $strHeader .= "From: admin@foodtruck.com\nReply-To: admin@foodtruck.com";
      $strMessage = "";
      $strMessage .= "Welcome : ".$objResult["Full_Name"]."<br>";
      $strMessage .= "Username : ".$objResult["Username"]."<br>";
      $strMessage .= "Password : ".$objResult["Password"]."<br>";
      $strMessage .= "=================================<br>";
      $strMessage .= "ThaiCreate.Com<br>";
      $flgSend = mail($strTo,$strSubject,$strMessage,$strHeader); 

  }

  }
  
  mysqli_close($db);
?>
</body>
</html>