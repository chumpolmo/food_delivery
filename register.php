<?php
include "tpls/header.php";
?>
<body>
    <nav class="navbar navbar-default bg_title_1">
        <span>
        <?=_TITLE?>
        </span>
    </nav>
    <form action="saveregis.php" method="post">
        <div class="container-fluid">
            <div class="panel panel-default bg_subtitle_1">
            <h4 class="text-center"><?=_SIGN_UP?></h4></div>
        </div>
        <hr>
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">ชื่อผู้ใช้งาน (Username): <span class="warn">*</span></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputUsername" name="username" placeholder="ชื่อผู้ใช้" required>
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">อีเมล (E-mail): <span class="warn">*</span></label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail" name="email" placeholder="อีเมล" required>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">ชื่อ (Name):</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" name="name" placeholder="ชื่อ">
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">รหัสผ่าน (Password): <span class="warn">*</span></label>
            <div class="col-sm-10">
                <input type="password" name="password" id="password" class="form-control" placeholder="รหัสผ่าน" required>
            </div>
        </div>
        <div class="form-group">
            <label for="password2" class="col-sm-2 control-label">ยืนยันรหัสผ่าน (Password Again): <span class="warn">*</span></label>
            <div class="col-sm-10">
                <input type="password" name="password2" id="password2" class="form-control" placeholder="ยืนยันรหัสผ่าน" required>
            </div>
        </div>
        <div class="form-group">
            <label for="type" class="col-sm-2 control-label">ประเภทสมาชิก (Type): <span class="warn">*</span></label>
            <div class="col-sm-10">
                <select name="ddlStatus" id="ddlStatus" required>
                <option value="10">ร้านค้า</option>
                <option value="20">บุคคลทั่วไป/ลูกค้า</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 text-center">
                <button type="submit" class="btn btn-success btn-lg btn-block txt4">ลงทะเบียน</button>
                <button type="reset" name="btnReset" class="btn btn-default btn-lg btn-block txt3">เคลียร์</button>
            </div>
        </div>
        <div class="container">
            <span class="warn_2">หมายเหตุ * กรุณากรอกข้อมูล</span>
        </div>
        <div class="text-center p-t-32 p-b-32">
            <!-- <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i> -->
            คุณเป็นสมาชิกเรียบร้อยแล้ว? <a class="txt2" href="login.php">
            เข้าสู่ระบบที่นี่</a>
        </div>
    </form>
</body>
</html>