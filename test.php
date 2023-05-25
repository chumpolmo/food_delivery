<html>
<head>
<title>ThaiCreate.Com PHP & MySQL Tutorial</title>
</head>
<body>
<?php
include('config.php');

//*** Add Condition ***//
if($_POST["hdnCmd"] == "Add")
{
	$strSQL = "INSERT INTO users ";
	$strSQL .="(UID,Full_Name,Email,Phone_Number) ";
	$strSQL .="VALUES ";
	$strSQL .="('".$_POST["txtAddName"]."' ";
	$strSQL .=",'".$_POST["txtAddEmail"]."' ";
	$strSQL .=",'".$_POST["txtAddCountryCode"]."' ";
	$objQuery = mysqli_query($db, $strSQL);
	if(!$objQuery)
	{
		echo "Error Save [".mysqli_error()."]";
	}
	//header("location:$_SERVER[PHP_SELF]");
	//exit();
}

//*** Update Condition ***//
if($_POST["hdnCmd"] == "Update")
{
	$strSQL = "UPDATE users SET ";
	$strSQL .="UID = '".$_POST["txtEditCustomerID"]."' ";
	$strSQL .=",Full_Name = '".$_POST["txtEditName"]."' ";
	$strSQL .=",Email = '".$_POST["txtEditEmail"]."' ";
	$strSQL .=",Phone_Number = '".$_POST["txtEditCountryCode"]."' ";
	$strSQL .="WHERE UID = '".$_POST["hdnEditCustomerID"]."' ";
	$objQuery = mysqli_query($db ,$strSQL);
	if(!$objQuery)
	{
		echo "Error Update [".mysqli_error()."]";
	}
	//header("location:$_SERVER[PHP_SELF]");
	//exit();
}

//*** Delete Condition ***//
if($_GET["Action"] == "Del")
{
	$strSQL = "DELETE FROM users ";
	$strSQL .="WHERE UID = '".$_GET["UID"]."' ";
	$objQuery = mysqli_query($db ,$strSQL);
	if(!$objQuery)
	{
		echo "Error Delete [".mysqli_error()."]";
	}
	//header("location:$_SERVER[PHP_SELF]");
	//exit();
}

$strSQL = "SELECT * FROM users";
$objQuery = mysqli_query($db, $strSQL) or die ("Error Query [".$strSQL."]");
?>
<form name="frmMain" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
<input type="hidden" name="hdnCmd" value="">
<table width="600" border="1">
  <tr>
    <th width="91"> <div align="center">CustomerID </div></th>
    <th width="98"> <div align="center">Full_Name </div></th>
    <th width="198"> <div align="center">Email </div></th>
    <th width="97"> <div align="center">Phone_Number </div></th>
    <th width="30"> <div align="center">Edit </div></th>
    <th width="30"> <div align="center">Delete </div></th>
  </tr>
<?php
while($objResult = mysqli_fetch_array($objQuery))
{
?>

  <?php
	if($objResult["UID"] == $_GET["UID"] and $_GET["Action"] == "Edit")
	{
  ?>
  <tr>
    <td><div align="center">
		<input type="text" name="txtEditCustomerID" size="5" value="<?php echo $objResult["UID"];?>">
		<input type="hidden" name="hdnEditCustomerID" size="5" value="<?php echo $objResult["UID"];?>">
	</div></td>
    <td><input type="text" name="txtEditName" size="20" value="<?php echo $objResult["Full_Name"];?>"></td>
    <td><input type="text" name="txtEditEmail" size="20" value="<?php echo $objResult["Email"];?>"></td>
    <td><div align="center"><input type="text" name="txtEditCountryCode" size="20" value="<?php echo $objResult["Phone_Number"];?>"></div></td>
    <td colspan="2" align="right"><div align="center">
      <input name="btnAdd" type="button" id="btnUpdate" value="Update" OnClick="frmMain.hdnCmd.value='Update';frmMain.submit();">
	  <input name="btnAdd" type="button" id="btnCancel" value="Cancel" OnClick="window.location='<?php echo $_SERVER["PHP_SELF"];?>';">
    </div></td>
  </tr>
  <?php
	}
  else
	{
  ?>
  <tr>
    <td><div align="center"><?php echo $objResult["UID"];?></div></td>
    <td><?php echo $objResult["Full_Name"];?></td>
    <td><?php echo $objResult["Email"];?></td>
    <td><div align="center"><?php echo $objResult["Phone_Number"];?></div></td>
    <td align="center"><a href="<?php echo $_SERVER["PHP_SELF"];?>?Action=Edit&UID=<?php echo $objResult["UID"];?>">Edit</a></td>
	<td align="center"><a href="JavaScript:if(confirm('Confirm Delete?')==true){window.location='<?php echo $_SERVER["PHP_SELF"];?>?Action=Del&UID=<?php echo $objResult["UID"];?>';}">Delete</a></td>
  </tr>
  <?php
	}
  ?>
<?php
}
?>
  <tr>
    <td><div align="center"><input type="text" name="txtAddCustomerID" size="5"></div></td>
    <td><input type="text" name="txtAddName" size="20"></td>
    <td><input type="text" name="txtAddEmail" size="20"></td>
    <td><div align="center"><input type="text" name="txtAddCountryCode" size="20"></div></td>
    <td colspan="2" align="right"><div align="center">
      <input name="btnAdd" type="button" id="btnAdd" value="Add" OnClick="frmMain.hdnCmd.value='Add';frmMain.submit();">
    </div></td>
  </tr>
</table>
</form>
<?php
mysqli_close($db);
?>
</body>
</html>