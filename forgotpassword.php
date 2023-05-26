<?php
include "tpls/header.php";
?>
<body>
<nav class="navbar navbar-default bg_title_1">
    <span>
      <?=_TITLE?>
    </span>
</nav>
<div class="limiter">
  <form class="form-horizontal" name="form1" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
  <div class="container-fluid">
    <div class="panel panel-default bg_subtitle_1">
      <h4>ถ้าคุณลืมรหัสผ่าน (Password)?</h4>
      กรุณากรอกชื่อผู้ใช้งาน (Username) และ อีเมล (E-mail)
    </div>
  </div>
  <hr>
  <div class="form-group">
    <label for="inputEmail2" class="col-sm-2 control-label">ชื่อผู้ใช้งาน</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEmail2" name="username" placeholder="ชื่อผู้ใช้งาน" required>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">อีเมล</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="อีเมล" required>
    </div>
  </div>
  <div class="form-group text-center">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" name="btnSubmit" class="btn btn-success btn-lg btn-block txt4">ยืนยันการขอข้อมูล</button>
      <button type="reset" name="btnReset" class="btn btn-default btn-lg btn-block txt3">เคลียร์</button>
    </div>
  </div>

  <div class="text-center p-t-32 p-b-32">
    <a class="txt2" href="login.php">
    <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
    ย้อนกลับ  
    </a>
  </div>
</form>
<?php
  include('config.php');

  // E-mail Configuration settings
  ini_set('SMTP','localhost');
  ini_set('smtp_port',25);
  
  if (isset($_POST['btnSubmit'])) {
    $strSQL = "SELECT * FROM users WHERE Email = '".trim($_POST['email'])."' OR Username = '".trim($_POST['username'])."' ";
    $objQuery = mysqli_query($db ,$strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    if(!$objResult){
      echo "Not Found Username or Email!";
    }else{
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
</div>
</body>
</html>