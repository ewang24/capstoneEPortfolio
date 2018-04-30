<?php
session_start();
$rId = $_SESSION['Id'];
$uName = $_SESSION['uName'];
$pWord = $_SESSION['pWord'];
$dbName = $_SESSION['dbName'];
$_SESSION['uName'] = $uName;
$_SESSION['pWord'] = $pWord;
$_SESSION['dbName']= $dbName;
$rName = $_SESSION['rName'];
?>

<html>
<head><title>Diplomacy</title></head>
	<body bgcolor = "e5e5ff">
	<h1>Diplomatic Information:<h1>
	<?php
		$sancEnfQuery = "Select `SanctionName`,`Sanction`.`SanctionId` as enf from `Sanction` inner join `SanctionEnforcer` using(`SanctionId`) where `RaceId` = $rId";
		$sancTargQuery = "Select `SanctionName`,`Sanction`.`SanctionId` as targ from `Sanction` inner join `SanctionTarget` using(`SanctionId`) where `RaceId` = $rId";
		$tradeQuery = "select * from `Trade` where `RaceId`= $rId";	
	
$mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);
if($mysqli->connect_errno)
{
echo "Failed to connect to mysql: (" . $myqli->connect_errno . ") " . $mysqli->conect_error . $mysqli->host_info . "\nYour password may be wrong";
}
	$sancEnfResult = $mysqli->query($sancEnfQuery) or die ($mysqli->error.__LINE__);	
	$sancTargResult = $mysqli->query($sancTargQuery) or die ($mysqli->error.__LINE__);
	 $tradeResult = $mysqli->query($tradeQuery) or die ($mysqli->error.__LINE__);

	?>

<form name = "f" method = "post">
<table bgcolor = "ccccff">

<tr>
<td>Sanctions the <?php echo $rName;?> enforce:</td>
<td>
<select name = "sancEnf">
	<?php
	if($sancEnfResult->num_rows>0)
	{
		while($rowEnf = $sancEnfResult->fetch_assoc())
		{
	?>
		<option value = "<?php echo $rowEnf['enf'];?>"><?php echo $rowEnf['SanctionName'];?></option>
	<?php
		}
	}
	else
	{
	?>
	<option value = "null">None</option>
	<?php
	}
	?>
</select>
</td>
<td><input type = "submit" onclick = "f.action='sanctionEnforcer.php'" value = "Submit"></td>
</tr>

<tr>
<td>Sanctions enforced against the <?php echo $rName;?>:</td>
<td>
<select name = "sancTarg">
<?php
if($sancTargResult->num_rows>0)
{
while($row = $sancTargResult->fetch_assoc())
{
?>
<option value = "<?php echo $row['targ'];?>"><?php echo $row['SanctionName']?></option>

<?php
}
}
else
{
?>
<option value = "null">None</option>
<?php
}
?>
</select>
</td>
<td><input type = "submit" onclick = "f.action='sanctionTarget.php'" value = "Submit"></td>
</tr>


<tr>
<td>Trade:</td>
<td>
<select name = "trade">
<?php
if($tradeResult->num_rows>0)
{
while($row = $tradeResult->fetch_assoc())
{
?>
<option value = "<?php echo $row['TradeId'];?>"><?php echo $row['TradeId'];?></option>
<?php
}
}
else
{
?>
<option value = "null">None</option>
<?php
}
?>
</select>
<td><input type = "submit" onclick = "f.action='trade.php'" value = "Submit"></td>
</tr>

</form>
</table>
<script>
function back()
{
window.location.href="raceMain.php";
return false;
}

function backToMain()
{
window.location.href="main.php";
return false;
}
</script>
<input type = "button" value = "Back" onclick = "back()">
<input type = "button" value = "Return to Main" onclick="backToMain()">
</body>
</html>

