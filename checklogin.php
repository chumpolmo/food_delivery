<?php 
session_start();
        if(isset($_POST['username'])){
                  include("config.php");
                  $username = $_POST['username'];
                  $password = $_POST['password'];

                  $sql="SELECT * FROM users 
                  WHERE  Username='".$username."' 
                  AND  Password='".$password."' ";
                  $result = mysqli_query($db,$sql);
        
                  if(mysqli_num_rows($result)==1){
                      $row = mysqli_fetch_array($result);

                      $_SESSION["ID"] = $row["UID"];
                      $_SESSION["username"] = $row["Username"];
                      $_SESSION["password"] = $row["Password"];
                      $_SESSION["name"] = $row["Full_Name"];
                      $_SESSION["status"] = $row["isRole"];

                  if($_SESSION["status"]=="10"){ //ถ้าเป็น admin ให้กระโดดไปหน้า admin_page.php

                        Header("Location: main.php");

                      }

                      else if ($_SESSION["status"]=="20"){  //ถ้าเป็น member ให้กระโดดไปหน้า user_page.php

                        header("Location: main_user.php");

                      }else{
                        echo "<script>";
                            echo "alert(\" Username หรือ  Password ไม่ถูกต้อง\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                      }

                  }else{
                    echo "<script>";
                        echo "alert(\" Username หรือ  Password ไม่ถูกต้อง\");"; 
                        echo "window.history.back()";
                    echo "</script>";

                  }

        }else{
             Header("Location: login.php"); //user & password incorrect back to login again
        }
?>