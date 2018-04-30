<?php
session_start();
$uName = $_SESSION['uName'];
$pWord = $_SESSION['pWord'];
$dbName = $_SESSION['dbName'];
$milId = $_SESSION['milId'];
$_SESSION['uName'] = $uName;
$_SESSION['pWord'] = $pWord;
$_SESSION['dbName']= $dbName;
if(empty($_POST['fleet']))
{
$fleetId=$_SESSION['fleet'];
}
else
{
$fleetId = $_POST['fleet'];
}
$_SESSION['fleet'] = $fleetId;
$fleetQuery = "select * from MilFleet inner join Admiral using(MilFleetId) where MilitaryId = $milId";
$mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);
if($mysqli->connect_errno)
{
echo "Failed to connect to mysql: (" . $myqli->connect_errno . ") " . $mysqli->conect_error . $mysqli->host_info . "\nYour password may be wrong";
}
$result = $mysqli->query($fleetQuery) or die ($mysqli->error.__LINE__);
$row = $result->fetch_assoc();
$fleetName = $row['FleetName'];
$numShips = $row['NumShips'];
$numPers = $row['NumPersonnel'];
$adFName = $row['AdFirstname'];
$adLName = $row['AdLastName'];
$milFleetId = $row['MilFleetId'];
$_SESSION['MilFleetId']=$milFleetId;
?>
<html>
<title><?php echo $fleetName;?></title>
<body bgcolor = "e5e5ff">
<h1><?php echo $fleetName?></h1>
<table bgcolor = "ccccff">
<tr>
<td>Admiral:</td>
<td><?php echo $adFName." ".$adLName;?></td>
<td>
<script>
function method()
{
        window.location.href="militaryMain.php";
        return false;
}
function backToMain()
{
	window.location.href="main.php";
	return false;
}
</script>

<input type = "button" value = "Back to Military" onclick = "method()">
</td>
</tr>
<tr>
<td>Number of Vehicles:</td>
<td><?php echo $numShips;?></td>
<td><input type = "button" value = "Back to Main" onclick = "backToMain()"></td>
</tr>
<form bgcolor = "ccccff" method = "post" action = "ship.php">

<tr>
<td>Number of Personnel:</td>
<td><?php echo $numPers;?></td>
</tr>
<tr>
<td><?php echo $fleetName;?> has <?php
$shipQuery = "select count(FlShipsId) from FlShips inner join Vehicle using(VehicleId) where MilFleetId = $milId";
$result = $mysqli->query($shipQuery) or die ($mysqli->error.__LINE__);
$row = $result->fetch_assoc();

if($result->num_rows>0)
{
	echo $row['count(FlShipsId)'];
}
else
{
	echo "no";
}
 ?> ships:</td>
<td align = "center"><select name = "ships"><?php
$shipQuery = "select ShipName,FlShipsId from FlShips inner join Vehicle using(VehicleId) where MilFleetId = $milFleetId";
$result = $mysqli->query($shipQuery) or die ($mysqli->error.__LINE__);
while($row = $result->fetch_assoc())
{
?>
<option value = "<?php echo $row['FlShipsId'];?>"><?php echo $row['ShipName'];?></option>
<?php
}

?></select></td>
<td><input type = "submit" value = "Explore Ship" name = "ship"></td>
</tr>
<tr bgcolor = "b3b3ff">
<td colspan = "3"><?php echo $fleetName?> has <?php 

$craft = "select count(FlcraftId) from Flcraft inner join Vehicle using(VehicleId) where MilFleetId = $milFleetId";
$ground = "select count(FlgroundId) from Flground inner join Vehicle using(VehicleId) where MilFleetId = $milFleetId";

$resultCraft = $mysqli->query($craft) or die ($mysqli->error.__LINE__);
$rowCraft = $resultCraft->fetch_assoc();

$resultGround = $mysqli->query($ground) or die ($mysqli->error.__LINE__);
$rowGround = $resultGround->fetch_assoc();

$numGround = $rowGround['count(FlgroundId)'];
$numCraft = $rowCraft['count(FlcraftId)'];

echo $numGround." ground vehicles and ".$numCraft." flight crafts.";
?>
</td>
</tr>
<tr bgcolor = "9999ff">
<td colspan = "3">
<?php
$craft = "select * from Flcraft inner join Vehicle using(VehicleId) where MilFleetId = $milFleetId";
$ground = "select * from Flground inner join Vehicle using(VehicleId) where MilFleetId = $milFleetId";

$resultCraft = $mysqli->query($craft) or die ($mysqli->error.__LINE__);

$resultGround = $mysqli->query($ground) or die ($mysqli->error.__LINE__);

if($numGround>0)
{
	while($row=$resultGround->fetch_assoc())
	{
		echo "Ground Vehicle: ". $row['FlgroundId'].". Structure: ".$row['Structure'].". Main weapon: ".$row['MainWeapon'].". Speed: ".$row['Speed'].". Crew capacity: ".$row['CrewCap'].".<br>";
}
}
if($numCraft>0)
{

 while($row=$resultCraft->fetch_assoc())
        {
                echo "Flight Craft: ". $row['FlcraftId'].". Type: ".$row['Type'].". Size: ".$row['Size'].". Armement: ".$row['Armament'].". Speed: ".$row['Speed'].". Crew capacity: ".$row['CrewCap'].".<br>";
}

}


?>
</td>
</tr>
</table>
</form>
</body>
</html>


