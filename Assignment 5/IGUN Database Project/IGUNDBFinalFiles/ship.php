<?php
session_start();
$shipId = $_POST['ships'];
$rName = $_SESSION['rName'];
$uName = $_SESSION['uName'];
$pWord = $_SESSION['pWord'];
$dbName = $_SESSION['dbName'];
$milFleetId = $_SESSION['MilFleetId'];
$_SESSION['uName'] = $uName;
$_SESSION['pWord'] = $pWord;
$_SESSION['dbName'] = $dbName;
$mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);
	if($mysqli->connect_errno)
	{

	echo "Failed to connect to mysql: (" . $myqli->	connect_errno . ") " . $mysqli->conect_error . $mysqli->	host_info;

	}

	$query="select * from `FlShips` inner join `Captain` using(FlShipsId) inner join Vehicle using(VehicleId) where `FlShipsId` =$shipId";
	$result = $mysqli->query($query) or die ($mysqli->error.	__LINE__);
	$row=$result->fetch_assoc();
	$shipName = $row['ShipName'];
	$capFName = $row['CapFirstName'];
	$capLName = $row['CapLastName'];
	$class = $row['Classification'];
	$tier = $row['Tier'];
	$size = $row['Size'];
	$arm = $row['Armament'];
?>
<html>
<title><?php echo $shipName;?></title>
<body bgcolor ="e5e5ff">
<h1>Ship <?php echo $shipName;?></h1>
<table bgcolor = "ccccff">
<tr>
<td>Admiral Name:</td>
<td><?php echo $capFName." ".$capLName;?></td>
</tr>
<tr>
<td>Classification:</td>
<td><?php echo $class;?></td>
</tr>
<tr>
<td>Tier:</td>
<td><?php echo $tier;?></td>
</tr>
<tr>
<td>Size:</td>
<td><?php echo $size;?></td>
</tr>
<tr>
<td>Armament:</td>
<td><?php echo $arm;?></td>
</tr>
<tr>
<td>
<script>
function method()
{
window.location.href="fleet.php";
return false;
}
function backToMain()
{
window.location.href="main.php";
return false;
}
</script>
<input type = "button" value = "Back To Fleet" onclick = "method()">
<input type = "button" value = "Back to Main" onclick = "backToMain()">
</td>
</tr>
</table>
</body>
</html>

